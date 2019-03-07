<?php

use App\Http\Controllers\Backend\DashboardController;

/*
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('bodega/producto', [DashboardController::class, 'index'])->name('bodega.producto');
Route::get('bodega/entrada', [DashboardController::class, 'index'])->name('bodega.entrada');
Route::get('bodega/salida', [DashboardController::class, 'index'])->name('bodega.salida');
Route::get('bodega/inventario', [DashboardController::class, 'index'])->name('bodega.inventario');