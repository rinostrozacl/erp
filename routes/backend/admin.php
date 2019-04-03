<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BodegaController;
use App\Http\Controllers\Backend\General\MarcaController;
use App\Http\Controllers\Backend\General\FamiliaController;
use App\Http\Controllers\Backend\General\LineaController;
use App\Http\Controllers\Backend\General\UbicacionController;
use App\Http\Controllers\Backend\General\ProveedorController;
use App\Http\Controllers\Backend\General\DocTipoCompraController;
use App\Http\Controllers\Backend\General\DocTipoVentaController;
use App\Http\Controllers\Backend\General\ClienteController;
use App\Http\Controllers\Backend\General\MovimientoController;







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


//Familia

Route::get('general/familia', [FamiliaController::class, 'index'])->name('general.familia');
Route::get('general/familia/tabla', [FamiliaController::class, 'getTabla'])->name('general.familia.tabla');
Route::get('general/familia/form/{id?}', [FamiliaController::class, 'getEdit'])->name('general.familia.form');
Route::post('general/familia/form', [FamiliaController::class, 'postUpdate'])->name('general.familia.form.update');
Route::post('general/familia/activar', [FamiliaController::class, 'postActivar'])->name('general.familia.activar');
Route::post('general/familia/eliminar', [FamiliaController::class, 'postEliminar'])->name('general.familia.eliminar');


//Línea

Route::get('general/linea', [LineaController::class, 'index'])->name('general.linea');
Route::get('general/linea/tabla', [LineaController::class, 'getTabla'])->name('general.linea.tabla');
Route::get('general/linea/form/{id?}', [LineaController::class, 'getEdit'])->name('general.linea.form');
Route::post('general/linea/form', [LineaController::class, 'postUpdate'])->name('general.linea.form.update');
Route::post('general/linea/activar', [LineaController::class, 'postActivar'])->name('general.linea.activar');
Route::post('general/linea/eliminar', [LineaController::class, 'postEliminar'])->name('general.linea.eliminar');


//Ubicacion

Route::get('general/ubicacion', [UbicacionController::class, 'index'])->name('general.ubicacion');
Route::get('general/ubicacion/tabla', [UbicacionController::class, 'getTabla'])->name('general.ubicacion.tabla');
Route::get('general/ubicacion/form/{id?}', [UbicacionController::class, 'getEdit'])->name('general.ubicacion.form');
Route::post('general/ubicacion/form', [UbicacionController::class, 'postUpdate'])->name('general.ubicacion.form.update');
Route::post('general/ubicacion/activar', [UbicacionController::class, 'postActivar'])->name('general.ubicacion.activar');
Route::post('general/ubicacion/eliminar', [UbicacionController::class, 'postEliminar'])->name('general.ubicacion.eliminar');


// Proveedor

Route::get('general/proveedor', [ProveedorController::class, 'index'])->name('general.proveedor');
Route::get('general/proveedor/tabla', [ProveedorController::class, 'getTabla'])->name('general.proveedor.tabla');
Route::get('general/proveedor/form/{id?}', [ProveedorController::class, 'getEdit'])->name('general.proveedor.form');
Route::post('general/proveedor/form', [ProveedorController::class, 'postUpdate'])->name('general.proveedor.form.update');
Route::post('general/proveedor/activar', [ProveedorController::class, 'postActivar'])->name('general.proveedor.activar');
Route::post('general/proveedor/eliminar', [ProveedorController::class, 'postEliminar'])->name('general.proveedor.eliminar');

// Doc Tipo Compra

Route::get('general/doctipocompra', [DocTipoCompraController::class, 'index'])->name('general.doctipocompra');
Route::get('general/doctipocompra/tabla', [DocTipoCompraController::class, 'getTabla'])->name('general.doctipocompra.tabla');
Route::get('general/doctipocompra/form/{id?}', [DocTipoCompraController::class, 'getEdit'])->name('general.doctipocompra.form');
Route::post('general/doctipocompra/form', [DocTipoCompraController::class, 'postUpdate'])->name('general.doctipocompra.form.update');
Route::post('general/doctipocompra/activar', [DocTipoCompraController::class, 'postActivar'])->name('general.doctipocompra.activar');
Route::post('general/doctipocompra/eliminar', [DocTipoCompraController::class, 'postEliminar'])->name('general.doctipocompra.eliminar');

// Doc Tipo Venta

Route::get('general/doctipoventa', [DocTipoVentaController::class, 'index'])->name('general.doctipoventa');
Route::get('general/doctipoventa/tabla', [DocTipoVentaController::class, 'getTabla'])->name('general.doctipoventa.tabla');
Route::get('general/doctipoventa/form/{id?}', [DocTipoVentaController::class, 'getEdit'])->name('general.doctipoventa.form');
Route::post('general/doctipoventa/form', [DocTipoVentaController::class, 'postUpdate'])->name('general.doctipoventa.form.update');
Route::post('general/doctipoventa/activar', [DocTipoVentaController::class, 'postActivar'])->name('general.doctipoventa.activar');
Route::post('general/doctipoventa/eliminar', [DocTipoVentaController::class, 'postEliminar'])->name('general.doctipoventa.eliminar');


// Cliente

Route::get('general/cliente', [ClienteController::class, 'index'])->name('general.cliente');
Route::get('general/cliente/tabla', [ClienteController::class, 'getTabla'])->name('general.cliente.tabla');
Route::get('general/cliente/form/{id?}', [ClienteController::class, 'getEdit'])->name('general.cliente.form');
Route::post('general/cliente/form', [ClienteController::class, 'postUpdate'])->name('general.cliente.form.update');
Route::post('general/cliente/activar', [ClienteController::class, 'postActivar'])->name('general.cliente.activar');
Route::post('general/cliente/eliminar', [ClienteController::class, 'postEliminar'])->name('general.cliente.eliminar');


// Movimientos

Route::get('general/movimientos', [MovimientoController::class, 'index'])->name('general.movimientos');
Route::get('general/movimientos/tabla', [MovimientoController::class, 'getTabla'])->name('general.movimientos.tabla');
Route::get('general/movimientos/form/{id?}', [MovimientoController::class, 'getEdit'])->name('general.movimientos.form');
Route::post('general/movimientos/form', [MovimientoController::class, 'postUpdate'])->name('general.movimientos.form.update');
Route::post('general/movimientos/activar', [MovimientoController::class, 'postActivar'])->name('general.movimientos.activar');
Route::post('general/movimientos/eliminar', [MovimientoController::class, 'postEliminar'])->name('general.movimientos.eliminar');

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