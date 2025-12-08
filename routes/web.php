<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/inventory', [\App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/{id}/edit', [\App\Http\Controllers\InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [\App\Http\Controllers\InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [\App\Http\Controllers\InventoryController::class, 'destroy'])->name('inventory.destroy');
    
    // Transaksi Obat Masuk
    Route::get('/obat-masuk', [\App\Http\Controllers\IncomingMedicineController::class, 'create'])->name('transaction.incoming.create');
    Route::post('/obat-masuk', [\App\Http\Controllers\IncomingMedicineController::class, 'store'])->name('transaction.incoming.store');

    // Transaksi Obat Keluar
    Route::get('/obat-keluar', [\App\Http\Controllers\OutgoingMedicineController::class, 'create'])->name('transaction.outgoing.create');
    Route::post('/obat-keluar', [\App\Http\Controllers\OutgoingMedicineController::class, 'store'])->name('transaction.outgoing.store');

    // Laporan
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

    // Peringatan Kedaluwarsa
    Route::get('/alerts', [\App\Http\Controllers\AlertController::class, 'index'])->name('alerts.index');
    Route::resource('medicines', \App\Http\Controllers\MedicineController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
