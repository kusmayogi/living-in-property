<?php

use App\Http\Controllers\absensi;
use App\Http\Controllers\absensiController;
use App\Http\Controllers\AbsensiController as ControllersAbsensiController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\gajiController;
use App\Http\Controllers\kasbonController;
use App\Http\Controllers\keuangancontroller;
use App\Http\Controllers\LokasiAksesController;
use App\Http\Controllers\Pekerjacontroller;
use App\Http\Controllers\pemasukanController;
use App\Http\Controllers\pengeluaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\reportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/gaji', [Pekerjacontroller::class, 'gaji'])->name('gaji.index');
Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
Route::resource('users', AkunController::class);
Route::get('/Daftar_pegawai', [AkunController::class, 'index']);
Route::get('/create', [AkunController::class, 'Create'])->name('akun.create');
Route::get('/akun/{id}/edit', [AkunController::class, 'edit'])->name('akun.edit');
Route::delete('/akun/{id}', [AkunController::class, 'destroy'])->middleware(['auth', 'verified'])->name('akun.destroy');
Route::put('/akun/{id}', [AkunController::class, 'update'])->name('akun.update');

Route::get('/keuangan', [keuangancontroller::class, 'index'])->name('keuangan.index');
Route::get('/keuangan/kasbon', [kasbonController::class, 'index'])->name('keuangan.kasbon');
Route::get('/keuangan/pemasukan', [pemasukanController::class, 'pemasukan'])->name('keuangan.pemasukan');
Route::get('/pemasukan/create', [pemasukanController::class, 'create'])->name('pemasukan.create');
Route::post('/pemasukan/store', [pemasukanController::class, 'store'])->name('pemasukan.store');

Route::get('/proyek', [ProyekController::class, 'index'])->name('proyek.index');
Route::get('/proyek/create', [ProyekController::class, 'create'])->name('proyek.create');
Route::post('/proyek/store', [ProyekController::class, 'store'])->name('proyek.store');
Route::get('/proyek/{id_proyek}/edit', [ProyekController::class, 'edit'])->name('proyek.edit');
Route::delete('/proyek/{id_proyek}', [ProyekController::class, 'destroy'])->middleware(['auth', 'verified'])->name('proyek.destroy');
Route::get('/absensi/edit/{id_proyek}/{tanggal}', 'AbsensiController@edit')->name('absensi.edit');
Route::put('/absensi/update/{id}', 'AbsensiController@update')->name('absensi.update');
Route::put('/proyek/{id_proyek}', [ProyekController::class, 'update'])->name('proyek.update');

Route::get('/absensi', [absensiController::class, 'showKepalaTukangAndProyekLocation'])->name('absensi.index');
Route::get('/absensi/form/{id_proyek}', [absensiController::class, 'showForm']);
Route::post('/absensi/store', [absensiController::class, 'store'])->name('absensi.store');
Route::get('/report/{id_proyek}', [gajiController::class, 'index'])->name('absensi.store');
Route::post('/report/{id_proyek}', [gajiController::class, 'submitReport'])->name('report.post'); // Ubah nama route untuk metode POST

Route::get('/Data_pekerja', [Pekerjacontroller::class, 'index'])->name('Data_pekerja.index');
Route::get('/Data_pekerja/create', [Pekerjacontroller::class, 'create'])->name('Data_pekerja.create');
Route::post('/Data_pekerja/store', [Pekerjacontroller::class, 'store'])->name('Data_pekerja.store');
Route::delete('/Data_pekerja/{id_pekerja}', [PekerjaController::class, 'destroy'])->name('Data_pekerja.destroy');
Route::get('/Data_pekerja/{id_pekerja}/edit', [PekerjaController::class, 'edit'])->name('Data_pekerja.edit');
Route::put('/Data_pekerja/{pekerja}', [PekerjaController::class, 'update'])->name('Data_pekerja.update');

Route::get('/keuangan/pengeluaran', [pengeluaranController::class, 'pengeluaran'])->name('keuangan.pengeluaran');
Route::get('/pengeluaran/create', [pengeluaranController::class, 'create'])->name('pengeluaran.create');
Route::post('/pengeluaran/store', [pengeluaranController::class, 'store'])->name('pengeluaran.store');
Route::get('/Detail/{id_pengeluaran}/pengeluaran', [pengeluaranController::class, 'detail'])->name('pengeluaran.detail');
Route::put('/Detail/{id_pengeluaran}/pengeluaran', [pengeluaranController::class, 'update'])->name('pengeluaran.update');

Route::get('/pemasukan/{id_pemasukan}/edit', [pemasukanController::class, 'edit'])->name('pemasukan.edit');
Route::put('/pemasukan/{id_pemasukan}', [pemasukanController::class, 'update'])->name('pemasukan.update');

Route::get('/absensi/edit/{id_proyek}', [absensiController::class, 'edit'])->name('absensi.edit');
Route::get('/absensi/search', [absensiController::class, 'search'])->name('absensi.search');
Route::get('/form_pencarian/{id_proyek?}', [absensiController::class, 'showFormWithDateDropdown'])->name('absensi.showFormWithDateDropdown');
Route::put('/ubah-status-absensi/{id_absensi}',[absensiController::class, 'ubahStatusAbsensi']);

Route::post('/report/store', [reportController::class, 'store'])->name('report.store');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/rekap-absensi-mingguan', [AbsensiController::class, 'showWeeklyAttendance'])->name('rekap.absensi.mingguan');
require __DIR__.'/auth.php';