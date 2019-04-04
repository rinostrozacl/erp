<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BodegaController;
use App\Http\Controllers\Backend\General\MarcaController;
use App\Http\Controllers\Backend\Bodega\ProductoController;
use App\Http\Controllers\Backend\Bodega\InventarioController;
use App\Http\Controllers\Backend\ComboController;
/*
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
 * Inicio sub menu bodega
 */
Route::get('bodega/producto', [ProductoController::class, 'index'])->name('bodega.producto');
Route::get('bodega/producto/tabla', [ProductoController::class, 'getTabla'])->name('bodega.producto.tabla');
Route::get('bodega/producto/tabla/detalle/{id?}', [ProductoController::class, 'getDetailsData'])->name('bodega.producto.tabla.detalle');
Route::post('bodega/producto/activar', [ProductoController::class, 'postActivar'])->name('bodega.producto.activar');
Route::post('bodega/producto/eliminar', [ProductoController::class, 'postEliminar'])->name('bodega.producto.eliminar');
Route::get('general/producto/form/{id?}', [ProductoController::class, 'getForm'])->name('bodega.producto.form');
Route::post('general/producto/form', [ProductoController::class, 'postUpdate'])->name('bodega.producto.form.update');


Route::get('bodega/entrada', [BodegaController::class, 'entrada_index'])->name('bodega.entrada');
Route::post('bodega/entrada', [BodegaController::class, 'entrada_item'])->name('bodega.entrada.item');
Route::post('bodega/entrada/guardar', [BodegaController::class, 'nuevoMovimiento'])->name('bodega.entrada.guardar');
Route::get('bodega/salida', [BodegaController::class, 'salida_index'])->name('bodega.salida');


Route::get('bodega/inventario', [InventarioController::class, 'index'])->name('bodega.inventario');
Route::get('bodega/inventario/tabla', [InventarioController::class, 'getTabla'])->name('bodega.inventario.tabla');

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
 * Inicio Funciones globales
 */

Route::get('global/combo/FamiliaByLinea/{id?}', [ComboController::class, 'getFamiliaByLinea'])->name('global.combo.familiabylinea');
/*
 * Fin Funciones globales
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