<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PesananController;

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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/report', [DashboardController::class, 'report'])->name('dashboard.report');

// Resource routes
Route::resource('pelanggan', PelangganController::class);
Route::resource('admin', AdminController::class);
Route::resource('pesanan', PesananController::class);

// Additional route for updating order status
Route::patch('pesanan/{pesanan}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
