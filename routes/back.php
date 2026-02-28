<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\AuthController;
use App\Http\Controllers\Back\RoleController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Back\KapalController;
use App\Http\Controllers\Back\TujuanController;
use App\Http\Controllers\Back\CustomerController;
use App\Http\Controllers\Back\PackingListController;
use App\Http\Controllers\Back\ContainerCostController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.store');
    });

    Route::middleware('admin.auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // Profile
        Route::get('profile', [App\Http\Controllers\Back\ProfileController::class, 'show'])->name('profile.show');
        Route::get('profile/edit', [App\Http\Controllers\Back\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [App\Http\Controllers\Back\ProfileController::class, 'update'])->name('profile.update');

        // User Management
        Route::resource('users', UserController::class);

        // Role Management
        Route::resource('roles', RoleController::class);

        // Master Data
        Route::resource('kapal', KapalController::class);
        Route::resource('tujuan', TujuanController::class);
        Route::resource('customer', CustomerController::class);
        // Packing List (Invoicing) & Container Cost (Finance)
        Route::get('packing-list/{container}/print', [PackingListController::class, 'print'])->name('packing-list.print');
        Route::resource('packing-list', PackingListController::class);
        Route::get('container-cost/{container}/print', [ContainerCostController::class, 'print'])->name('container-cost.print');
        Route::resource('container-cost', ContainerCostController::class);
        Route::resource('transaksi-kategori', App\Http\Controllers\Back\TransaksiKategoriController::class);
        Route::resource('bank-rekening', App\Http\Controllers\Back\BankRekeningController::class);
        Route::resource('transaksi', App\Http\Controllers\Back\TransaksiController::class);

        // Hutang & Piutang
        Route::get('hutang', [App\Http\Controllers\Back\HutangPiutangController::class, 'hutang'])->name('hutang.index');
        Route::get('piutang', [App\Http\Controllers\Back\HutangPiutangController::class, 'piutang'])->name('piutang.index');
        Route::post('hutang-piutang', [App\Http\Controllers\Back\HutangPiutangController::class, 'store'])->name('hutang-piutang.store');
        Route::put('hutang-piutang/{id}', [App\Http\Controllers\Back\HutangPiutangController::class, 'update'])->name('hutang-piutang.update');
        Route::delete('hutang-piutang/{id}', [App\Http\Controllers\Back\HutangPiutangController::class, 'destroy'])->name('hutang-piutang.destroy');

        // Invoicing & Finance
        Route::get('invoice/{invoice}/print', [App\Http\Controllers\Back\InvoiceController::class, 'print'])->name('invoice.print');
        Route::any('invoice/preview', [App\Http\Controllers\Back\InvoiceController::class, 'preview'])->name('invoice.preview');
        Route::resource('invoice', App\Http\Controllers\Back\InvoiceController::class);
        Route::resource('finance', App\Http\Controllers\Back\FinanceController::class)->only(['index', 'edit', 'update']);

        // Laporan
        Route::get('laporan/print', [App\Http\Controllers\Back\LaporanController::class, 'print'])->name('laporan.print');
        Route::get('laporan', [App\Http\Controllers\Back\LaporanController::class, 'index'])->name('laporan.index');
    });
});
