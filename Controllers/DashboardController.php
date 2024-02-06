<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TopUp;
use App\Models\Produk;
use App\Models\Wallet;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function bankIndex()
    {
        $title = 'Dashboard';
        $siswas = User::where('role', 'customer')->get();
        $topups = TopUp::all();
        $withdrawals = Withdrawal::all();

        $requestTopups = TopUp::all();
        $requestWithdrawals = Withdrawal::all();
        $total_topup = TopUp::all()->sum('nominal');
        $total_wd = Withdrawal::all()->sum('nominal');
        return view('bank.index', compact('title','siswas','total_wd','total_topup','requestTopups','requestWithdrawals', 'topups', 'withdrawals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function siswaIndex()
    {
        $title = 'Dashboard';
        $produks = Produk::all();
        $wallets = Wallet::where('id_user', auth()->user()->id)->first();

        return view('siswa.index', compact('title', 'produks', 'wallets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function kantinIndex()
    {
        $title = 'Dashboard';
        $produks = Produk::all();
        $kategoris = Kategori::all();
        $total_pemasukan = Transaksi::all()->sum('total_harga');
        $total_perhari = Transaksi::whereDate('tgl_transaksi', today())->sum('total_harga');

        return view('kantin.index', compact('title', 'produks', 'kategoris', 'total_pemasukan','total_perhari'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
