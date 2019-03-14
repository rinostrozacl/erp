<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BodegaController;
/*
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
 * Inicio sub menu bodega
 */
Route::get('bodega/producto', 'BodegaController@producto_index')->name('bodega.producto');
Route::get('bodega/entrada', [BodegaController::class, 'entrada_index'])->name('bodega.entrada');
Route::get('bodega/salida', [BodegaController::class, 'salida_index'])->name('bodega.salida');
Route::get('bodega/inventario', [BodegaController::class, 'inventario_index'])->name('bodega.inventario');

/*
 * Fin sub menu bodega
 */



/*
 * Inicio sub menu Sala de ventas
 */

/*
 * Fin sub menu Sala de ventas
 */



/*
 * Inicio sub menu Informes
 */

/*
 * Fin sub menu Informes
 */