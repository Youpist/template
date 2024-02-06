<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Auth
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class,'store']);
Route::get('/register', [AuthController::class, 'regist']);
Route::post('/register', [AuthController::class, 'register'])->name('regist');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/cetak/transaksi', [TransaksiController::class, 'cetakInvoice'])->name('cetak.transaksi');
Route::post('/topup', [BankController::class, 'topup'])->name('topup');
Route::post('/withdrawal', [BankController::class, 'withdrawal'])->name('withdrawal');

// Bank
Route::middleware(['auth','userAkses:bank'] )->group(function(){
    Route::get('/bank', [DashboardController::class, 'bankIndex'])->name('bank.index');
    Route::get('/bank/topup', [BankController::class, 'topupIndex'])->name('bank.topup');
    Route::get('/bank/withdrawal', [BankController::class, 'withdrawalIndex'])->name('bank.withdrawal');
    // Konfirmasi bank
    Route::put('/bank/konfirmasi/topup/{id}', [BankController::class, 'konfirmasiTopup'])->name('konfirmasi.topup');
    Route::put('/bank/tolak/topup/{id}', [BankController::class, 'tolakTopup'])->name('tolak.topup');
    Route::put('/bank/konfirmasi/withdrawal/{id}', [BankController::class, 'konfirmasiWithdrawal'])->name('konfirmasi.withdrawal');
    Route::put('/bank/tolak/withdrawal/{id}', [BankController::class, 'tolak'])->name('tolak.withdrawal');

    // Laporan
    Route::get('/bank/laporan/topup', [BankController::class, 'laporanTopupHarian'])->name('bank.laporan.topup');
    Route::get('/bank/laporan/topup/{tanggal}', [BankController::class, 'laporanTopup'])->name('topup.detail');
    Route::get('/bank/laporan/withdrawal', [BankController::class, 'laporanWithdrawalHarian'])->name('bank.laporan.withdrawal');
    Route::get('/bank/laporan/withdrawal/{tanggal}', [BankController::class, 'laporanWithdrawal'])->name('withdrawal.detail');

    // Cetak Bank
    // Route::get('/bank/cetak/topup', [BankController::class, 'cetakTopup'])->name('bank.cetak.topup');
});

// Siswa
Route::middleware(['auth','userAkses:customer'] )->group(function(){
    Route::get('/siswa', [DashboardController::class, 'siswaIndex'])->name('siswa.index');

    Route::get('/siswa/kantin', [TransaksiController::class, 'customerKantinIndex'])->name('siswa.kantin');
    Route::post('/siswa/tambahKeranjang/{id}', [TransaksiController::class, 'addTocart'])->name('addToCart');
    Route::get('/siswa/keranjang', [TransaksiController::class, 'keranjangIndex'])->name('siswa.keranjang');
    Route::post('/siswa/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
    Route::delete('/siswa/keranjang/destroy/{id}', [TransaksiController::class, 'keranjangDestroy'])->name('keranjang.destroy');

    // Riwayat
    Route::get('/siswa/riwayat/transaksi', [TransaksiController::class, 'riwayatTransaksi'])->name('riwayat.transaksi');
    Route::get('/siswa/riwayat/topup', [BankController::class, 'riwayatTopup'])->name('riwayat.topup');
    Route::get('/laporan/topup/{tanggal}', [BankController::class, 'cetakTopup'])->name('cetak.topup');
    Route::get('/laporan/withdrawal/{tanggal}', [BankController::class, 'cetakWithdrawal'])->name('cetak.withdrawal');
    Route::get('/laporan/topupAll', [BankController::class, 'cetakTopupAll'])->name('cetak.topup.all');
    Route::get('/laporan/withdrawalAll', [BankController::class, 'cetakWithdrawalAll'])->name('cetak.withdrawal.all');
    Route::get('/siswa/riwayat/withdrawal', [BankController::class, 'riwayatWithdrawal'])->name('riwayat.withdrawal');
    Route::get('/siswa/riwayat/transaksi/{invoice}', [TransaksiController::class, 'detailRiwayatTransaksi'])->name('riwayat.detail');
});

// Kantin
Route::middleware(['auth','userAkses:kantin'] )->group(function(){
    Route::get('/kantin', [DashboardController::class, 'kantinIndex'])->name('kantin.index');

    Route::resource('/kantin/produk', ProdukController::class);
    Route::resource('/kantin/kategori', KategoriController::class);
    Route::get('/kantin/transaksi', [TransaksiController::class, 'laporanTransaksiHarian'])->name('kantin.transaksi');
    Route::get('/kantin/transaksi/{invoice}', [TransaksiController::class, 'laporanTransaksi'])->name('kantin.detail');
});
