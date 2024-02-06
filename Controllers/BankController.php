<?php

namespace App\Http\Controllers;

use App\Models\TopUp;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function topupIndex()
    {
        $title = 'Konfirmasi Topup';
        $topups = TopUp::where('status', 'menunggu')->get();

        return view('bank.topup', compact('title', 'topups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function withdrawalIndex()
    {
        $title = 'Konfirmasi Withdrawal';
        $withdrawals = Withdrawal::where('status', 'menunggu')->get();

        return view('bank.withdrawal', compact('title', 'withdrawals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function topup(Request $request)
    {
        $request->validate([
            'nominal'=> 'required|integer',
            'rekening'=> 'required|string|exists:wallets,rekening',
        ]);
        if(auth()->user()->role === 'bank'){
            $status = 'dikonfirmasi';
            $wallet = Wallet::where('rekening', $request->rekening)->first();
            $wallet->saldo += $request->nominal;
            $wallet->save();
        }else{
            $status = 'menunggu';
        }

        $kodeUnik = 'TU' . auth()->user()->id . now()->format('dmYhis');
        $request = TopUp::create([
            'rekening'=> $request->rekening,
            'nominal'=> $request->nominal,
            'kode_unik'=> $kodeUnik,
            'status'=> $status,  
        ]);
        return redirect()->back()->with('success', 'Topup Berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function konfirmasiTopup($id)
    {
        $topup = TopUp::findOrfail($id);

        $topup->status = 'dikonfirmasi';
        $topup->save();

        $wallet = Wallet::where('rekening', $topup->rekening)->first();
        $wallet->saldo += $topup->nominal;
        $wallet->save();

        return redirect()->route('bank.topup')->with('success', 'Topup Berhasil');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function tolakTopup( $id)
    {
        $topup = TopUp::findOrfail($id);

        $topup->status = 'ditolak';
        $topup->save();

        return redirect()->route('bank.topup')->with('success', 'Topup Berhasil');
    }

    /**
     * Update the specified resource in storage.
     */
    public function withdrawal(Request $request)
    {
        $request->validate([
            'nominal'=> 'required|integer',
            'rekening'=> 'required|string|exists:wallets,rekening',
        ]);
        $wallet = Wallet::where('rekening', $request->rekening)->first();
        if($wallet->saldo < $request->nominal){
            return redirect()->back()->with('error', 'Saldo tidak cukup');
        }
        if(auth()->user()->role === 'bank'){
            $status = 'dikonfirmasi';
            $wallet = Wallet::where('rekening', $request->rekening)->first();
            $wallet->saldo -= $request->nominal;
            $wallet->save();
        }else{
            $status = 'menunggu';
        }

        $kodeUnik = 'WD' . auth()->user()->id . now()->format('dmYhis');
        $withdrawals = Withdrawal::create([
            'rekening'=> $request->rekening,
            'nominal'=> $request->nominal,
            'kode_unik'=> $kodeUnik,
            'status'=> $status,
        ]);
        return redirect()->back()->with('success','WIthdrawal berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function konfirmasiWithdrawal($id)
    {
        $withdrawal = Withdrawal::findOrfail($id);

        $withdrawal->status = 'dikonfirmasi';
        $withdrawal->save();

        $wallet = Wallet::where('rekening', $withdrawal->rekening)->first();
        $wallet->saldo -= $withdrawal->nominal;
        $wallet->save();

        return redirect()->route('bank.withdrawal')->with('success', 'Withdrawal Berhasil');
    }

    public function toalkWithdrawal($id){
        $withdrawal = Withdrawal::findOrfail($id);

        $withdrawal->status = 'ditolak';
        $withdrawal->save();

        return redirect()->route('bank.withdrawal')->with('success', 'Withdrawal Berhasil');
    }

    public function laporanTopupHarian(){
        $title = 'Laporan Topup Harian';

        // $wallet = Wallet::where('id_user', auth()->user()->id)->first();
        $topups = TopUp::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(nominal) as nominal'))
        // ->where('rekening', $wallet->rekening)
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'desc')
        ->get();
        $totalNominal = $topups->sum('nominal');
        return view('bank.laporan.topup-harian', compact('title', 'topups', 'totalNominal'));
    }

    public function laporanTopup($tanggal){
        $title = 'Laporan Topup';

        $tanggal = date('Y-m-d', strtotime($tanggal));
        $topups = TopUp::where(DB::raw('DATE(created_at)'), $tanggal)->get();
        $totalNominal = $topups->sum('nominal');

        return view('bank.laporan.topup-detail', compact('title', 'topups', 'tanggal', 'totalNominal'));
    }

    public function laporanWithdrawalHarian(){
        $title = 'Laporan Topup Harian';

        // $wallet = Wallet::where('id_user', auth()->id())->first();
        $withdrawals = Withdrawal::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(nominal) as nominal'))
        // ->where('rekening', $wallet->rekening)
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'desc')
        ->get();
        $totalNominal = $withdrawals->sum('nominal');
        return view('bank.laporan.withdrawal-harian', compact('title', 'withdrawals', 'totalNominal',));
    }

    public function laporanWithdrawal($tanggal){
    $title = 'Laporan withdrawal';

    $tanggal = date('Y-m-d', strtotime($tanggal));
    $withdrawals = Withdrawal::where(DB::raw('DATE(created_at)'), $tanggal,)
    ->get();
    $totalNominal = $withdrawals->sum('nominal');

    return view('bank.laporan.withdrawal-detail', compact('title', 'withdrawals', 'tanggal', 'totalNominal'));
    }
    public function cetakTopup($tanggal){

    $tanggal = date('Y-m-d', strtotime($tanggal));
    $topups = TopUp::where(DB::raw('DATE(created_at)'), $tanggal,)
    ->get();
    $totalNominal = $topups->sum('nominal');

    return view('cetak.cetak-topup', compact('topups', 'tanggal', 'totalNominal'));
    }
    public function cetakTopupAll(){
        $topups = TopUp::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(nominal) as nominal'))
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'desc')
        ->get();
        $totalNominal = $topups->sum('nominal');
        return view('cetak.cetak-topup-all', compact('topups', 'totalNominal'));
    }
    public function cetakWithdrawalAll(){
        $withdrawals = Withdrawal::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(nominal) as nominal'))
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'desc')
        ->get();
        $totalNominal = $withdrawals->sum('nominal');
        return view('cetak.cetak-withdrawal-all', compact('withdrawals', 'totalNominal'));
    }

    public function cetakWithdrawal($tanggal){

        $tanggal = date('Y-m-d', strtotime($tanggal));
        $withdrawals = Withdrawal::where(DB::raw('DATE(created_at)'), $tanggal,)
        ->get();
        $totalNominal = $withdrawals->sum('nominal');
    
        return view('cetak.cetak-withdrawal', compact('withdrawals', 'tanggal', 'totalNominal'));
        }


    // Untuk Siswa
    public function riwayatTopup(){
        $title = 'Riwayat Topup';

        $wallet = Wallet::where('id_user', auth()->id())->first();
        $topups = TopUp::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(nominal) as nominal'))
        ->where('rekening', $wallet->rekening)
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'desc')
        ->get();
        $totalNominal = $topups->sum('nominal');
        return view('siswa.riwayat.topup', compact('title', 'topups', 'wallet', 'totalNominal'));
    }

    public function riwayatWithdrawal(){
    $title = 'Riwayat withdrawal';

    $wallet = Wallet::where('id_user', auth()->id())->first();
    $withdrawals = Withdrawal::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(nominal) as nominal'))
    ->where('rekening', $wallet->rekening)
    ->groupBy('tanggal')
    ->orderBy('tanggal', 'desc')
    ->get();
    $totalNominal = $withdrawals->sum('nominal');

    return view('siswa.riwayat.withdrawal', compact('title', 'withdrawals', 'wallet', 'totalNominal'));
    }
}
