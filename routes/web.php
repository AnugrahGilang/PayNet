<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->name('dashboard');
Route::resource('pelanggan', PelangganController::class);

Route::resource('tagihan', TagihanController::class);
Route::get('/tagihan/{id}/print', [TagihanController::class, 'print'])->name('tagihan.print');



Route::get('/laporan/tagihan', [LaporanController::class, 'tagihan'])->name('laporan.tagihan');
Route::get('/laporan/pembayaran', [LaporanController::class, 'pembayaran'])->name('laporan.pembayaran');

