<?php

use App\Http\Controllers\AbstrakController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\UserController;
use App\Models\Abstrak;
use App\Models\Fakultas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware(['auth:web'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //grafik
    Route::get('/grafik', [HomeController::class, 'grafik'])->name('grafik');
    //abstrak managemen
    Route::post('/abstrak/store', [AbstrakController::class, 'store'])->name('abstrak.store');
    Route::post('/abstrak/upload-revisi', [AbstrakController::class, 'uploadRevisi'])->name('abstrak.upload-revisi');
    //akun managemen
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
Route::middleware(['auth:web', 'role:UPT'])->group(function () {
    //pembayaran
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');
    Route::get('/pembayaran/terima/{id}', [PembayaranController::class, 'terima'])->name('pembayaran.terima');
    Route::get('/pembayaran/tolak/{id}', [PembayaranController::class, 'tolak'])->name('pembayaran.tolak');
    Route::get('/pembayaran-datatable', [PembayaranController::class, 'getPembayaranDataTable']);
    //pengajuan abstrak 
    Route::get('/abstrak', [AbstrakController::class, 'index'])->name('abstrak');
    Route::get('/abstrak/periksa/{id}', [AbstrakController::class, 'periksa'])->name('abstrak.periksa');
    Route::post('/abstrak/hasil-periksa', [AbstrakController::class, 'hasilPeriksa'])->name('abstrak.hasil-periksa');
    Route::get('/abstrak-datatable', [AbstrakController::class, 'getAbstrakDataTable']);
  
});
Route::middleware(['auth:web', 'role:Mahasiswa'])->group(function () {
    //riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/riwayat-datatable', [RiwayatController::class, 'getRiwayatDataTable']);
    //pembayaran managemen
    Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
});
Route::middleware(['auth:web', 'role:Admin'])->group(function () {
    Route::get('/fakultas', [FakultasController::class, 'index'])->name('fakultas');
    Route::get('/fakultas-datatable', [FakultasController::class, 'getFakultasDataTable']);
    Route::post('/fakultas/store',  [FakultasController::class, 'store'])->name('fakultas.store');
    Route::get('/fakultas/edit/{id}',  [FakultasController::class, 'edit'])->name('fakultas.edit');
    Route::delete('/fakultas/delete/{id}',  [FakultasController::class, 'destroy'])->name('fakultas.delete');
    //user managemen
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/admin', [UserController::class, 'admin'])->name('admin');
    Route::get('/upt', [UserController::class, 'upt'])->name('upt');
    Route::get('/mahasiswa', [UserController::class, 'mahasiswa'])->name('mahasiswa');
    Route::post('/users/store',  [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}',  [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/users/delete/{id}',  [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/users-datatable/{role}', [UserController::class, 'getUsersDataTable']);
});
