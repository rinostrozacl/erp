<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BodegaController;
use App\Http\Controllers\Backend\General\MarcaController;
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
Route::post('bodega/entrada', [BodegaController::class, 'entrada_item'])->name('bodega.entrada.item');
Route::post('bodega/entrada/guardar', [BodegaController::class, 'nuevoMovimiento'])->name('bodega.entrada.guardar');
Route::get('bodega/salida', [BodegaController::class, 'salida_index'])->name('bodega.salida');
Route::get('bodega/inventario', [BodegaController::class, 'inventario_index'])->name('bodega.inventario');

/*
 * Fin sub menu bodega
 */
/*
 * Inicio menu general
 */
Route::get('general/marca', [MarcaController::class, 'index'])->name('general.marca');
Route::get('general/marca/tabla', [MarcaController::class, 'getTabla'])->name('general.marca.tabla');
Route::get('general/marca/form/{id?}', [MarcaController::class, 'getEdit'])->name('general.marca.form');
Route::post('general/marca/form', [MarcaController::class, 'postUpdate'])->name('general.marca.form.update');
Route::post('general/marca/activar', [MarcaController::class, 'postActivar'])->name('general.marca.activar');
Route::post('general/marca/eliminar', [MarcaController::class, 'postEliminar'])->name('general.marca.eliminar');

/*
 * Fin sub menu general
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