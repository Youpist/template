<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Dashboard';
        $produks = Produk::with('kategori')->get();
        $kategoris = Kategori::all();
        $total_pemasukan = Transaksi::all()->sum('nominal');
        return view('kantin.produk', compact('title', 'produks', 'kategoris', 'total_pemasukan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ignore = Produk::onlyTrashed()->where('nama_produk', $request->nama_produk)->first();
        if($ignore){
            $foto = $request->file('foto');
            $foto->storeAs('public/produk', $foto->hashName());

            $ignore->restore();
            $ignore->harga = $request->harga;
            $ignore->stok = $request->stok;
            $ignore->desc = $request->desc;
            $ignore->id_kategori = $request->id_kategori;
            $ignore->foto = $foto->hashName();
            $ignore->save();
        }
        $request->validate([
            'nama_produk'=> [
                'required',
                'string',
                'max:255',
                Rule::unique('produks', 'nama_produk')->ignore($ignore->id ?? 0),
            ],
            'id_kategori'=> 'required|exists:kategoris,id',
            'harga'=>'required|numeric',
            'stok'=>'required|numeric',
            'desc'=>'required',
        ]);

        $existsProduk = Produk::where('nama_produk', $request->nama_produk)->first();

        if($existsProduk){
            $existsProduk->stok += $request->stok;
            $existsProduk->save();
        }else{
            $foto = $request->file('foto');
            $foto->storeAs('public/produk', $foto->hashName());
        }

        $produk = Produk::create([
            'nama_produk'=>$request->nama_produk,
            'harga'=>$request->harga,
            'stok'=>$request->stok,
            'foto'=>$foto->hashName(),
            'desc'=>$request->desc,
            'id_kategori'=>$request->id_kategori,
        ]);
        return redirect()->back()->with('success','Berhasil menambah data produk');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'nama_produk'=> [
                'required',
                'string',
                'max:255',
                Rule::unique('produks', 'nama_produk')->ignore($id),
            ],
            'id_kategori'=> 'required|exists:kategoris,id',
            'harga'=>'required|numeric',
            'stok'=>'required|numeric',
            'desc'=>'required',
        ]);

        $produk = Produk::find($id);

        if(!$produk){
            return redirect()->back()->with('error', 'Data produk tidak ditemukan');
        }
        if($request->hasFile('foto')){
            $request->validate([
                'foto'=> 'required|image|mimes:jpeg,jpg,png|max:2048',
            ]);
            $foto = $request->file('foto');
            if($produk->foto !== 'default.png'){
                Storage::delete('public/produk/'.$produk->foto);
            }
            $foto->storeAs('public/produk', $foto->hashName());
            
            Storage::delete('public/produk/'.$produk->foto);
            $produk->foto = $foto->hashName();
        }
        $produk->nama_produk = $request->nama_produk;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;
        $produk->desc = $request->desc;
        $produk->id_kategori = $request->id_kategori;
        $produk->save();

        return redirect()->back()->with('success','Berhasil mengubah data produk');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrfail($id);

        $keranjangs = Keranjang::where('id_produk', $id)->get();
        
        foreach($keranjangs as $keranjang){
            $keranjang->delete();
        }
        Storage::delete('public/produk/' . $produk->image);
        $produk->delete();

        return redirect()->back()->with('success','Berhasil menghapus data produk');
    }
}
