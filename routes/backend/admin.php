<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BodegaController;
use App\Http\Controllers\Backend\General\MarcaController;

use App\Http\Controllers\Backend\Bodega\ProductoController;
use App\Http\Controllers\Backend\Bodega\InventarioController;
use App\Http\Controllers\Backend\ComboController;
use App\Http\Controllers\Backend\General\SucursalController;
use App\Http\Controllers\Backend\General\FamiliaController;
use App\Http\Controllers\Backend\General\LineaController;
use App\Http\Controllers\Backend\General\UbicacionController;
use App\Http\Controllers\Backend\General\ImpresoraController;
use App\Http\Controllers\Backend\General\ProveedorController;
use App\Http\Controllers\Backend\General\DocTipoCompraController;
use App\Http\Controllers\Backend\General\DocTipoVentaController;
use App\Http\Controllers\Backend\General\ClienteController;
use App\Http\Controllers\Backend\Informe\MovimientoController;
use App\Http\Controllers\Backend\Informe\StockController;
use App\Http\Controllers\Backend\Informe\StockCriticoController;
use App\Http\Controllers\Backend\Informe\ClientesController;
use App\Http\Controllers\Backend\Informe\ProveedoresController;
use App\Http\Controllers\Backend\Caja\VentaController;
use App\Http\Controllers\Backend\Caja\CajaController;
use App\Http\Controllers\Backend\AutoCompleteController;
use App\Http\Controllers\Backend\Informe\VentasController;


/*
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('refresh-csrf', function(){
    return csrf_token();
})->name('refreshcsrf');
/*
 * Inicio sub menu bodega
 */
Route::get('bodega/producto', [ProductoController::class, 'index'])->name('bodega.producto');
Route::get('bodega/producto/tabla', [ProductoController::class, 'getTabla'])->name('bodega.producto.tabla');
Route::get('bodega/producto/tabla/detalle/{id?}', [ProductoController::class, 'getDetailsData'])->name('bodega.producto.tabla.detalle');
Route::post('bodega/producto/activar', [ProductoController::class, 'postActivar'])->name('bodega.producto.activar');
Route::post('bodega/producto/activarfungible', [ProductoController::class, 'postActivarFun'])->name('bodega.producto.activar_f');
Route::post('bodega/producto/eliminar', [ProductoController::class, 'postEliminar'])->name('bodega.producto.eliminar');
Route::get('general/producto/form/{id?}', [ProductoController::class, 'getForm'])->name('bodega.producto.form');
Route::post('general/producto/form', [ProductoController::class, 'postUpdate'])->name('bodega.producto.form.update');


Route::get('bodega/entrada', [BodegaController::class, 'entrada_index'])->name('bodega.entrada');
Route::post('bodega/entrada', [BodegaController::class, 'entrada_item'])->name('bodega.entrada.item');
Route::post('bodega/entrada/guardar', [BodegaController::class, 'nuevoMovimiento'])->name('bodega.entrada.guardar');
Route::get('bodega/salida', [BodegaController::class, 'salida_index'])->name('bodega.salida');


Route::get('bodega/inventario', [InventarioController::class, 'index'])->name('bodega.inventario');
Route::get('bodega/inventario/tabla', [InventarioController::class, 'getTabla'])->name('bodega.inventario.tabla');
Route::get('bodega/inventario/tabla2', [InventarioController::class, 'getTabla2'])->name('bodega.inventario.tabla2');
Route::get('bodega/inventario/tabla3', [InventarioController::class, 'getTabla3'])->name('bodega.inventario.tabla3');
Route::post('bodega/inventario/cerrar', [InventarioController::class, 'postCerrar'])->name('bodega.inventario.cerrar');
Route::post('bodega/inventario/archivar', [InventarioController::class, 'postArchivar'])->name('bodega.inventario.archivar');
Route::get('bodega/inventario/nuevo', [InventarioController::class, 'getFormNuevo'])->name('bodega.inventario.nuevo');
Route::post('bodega/inventario/nuevo', [InventarioController::class, 'postFormNuevo'])->name('bodega.inventario.nuevo.guardar');
Route::get('bodega/inventario/realizar/{id?}', [InventarioController::class, 'getFormRealizar'])->name('bodega.inventario.realizar');
Route::post('bodega/inventario/realizar/codigo', [InventarioController::class, 'postFormRealizarCodigo'])->name('bodega.inventario.realizar.codigo');
Route::post('bodega/inventario/realizar', [InventarioController::class, 'postFormRealizar'])->name('bodega.inventario.realizar.guardar');
Route::get('bodega/inventario/resultado/{id?}', [InventarioController::class, 'getResultado'])->name('bodega.inventario.resultado');
Route::get('bodega/inventario/tabla4/{id?}', [InventarioController::class, 'getTabla4'])->name('bodega.inventario.tabla4');
Route::get('bodega/inventario/tabla5/{id?}', [InventarioController::class, 'getTabla5'])->name('bodega.inventario.tabla5');
/*
 * Fin sub menu bodega
 */




/*
 * Inicio sub menu Venta
 */
Route::get('caja/venta/nueva', [VentaController::class, 'index'])->name('caja.venta.nuevo');
Route::get('caja/venta/nueva/buscar', [VentaController::class, 'postTablaBusqueda'])->name('caja.venta.nuevo.tabla.buscar');
Route::post('caja/venta/nueva/guardar', [VentaController::class, 'guardarVenta'])->name('caja.venta.nuevo.guardar');

Route::get('caja/venta/imprimir/{id?}', [VentaController::class, 'imprimirVenta'])->name('caja.venta.imprimir');
Route::get('caja/venta/verimprimir/{id?}', [VentaController::class, 'verVenta'])->name('caja.venta.verimprimir');

Route::post('caja/venta/guardad/precio', [VentaController::class, 'guardarPrecio'])->name('caja.venta.guardar.precio');


Route::get('caja/pago/recibir', [CajaController::class, 'recibirPago'])->name('caja.pago.recibir');
Route::get('caja/pago/recibir/pagar/{id?}', [CajaController::class, 'recibirPagoPagar'])->name('caja.pago.recibir.pagar');
Route::post('caja/pago/recibir/pagar', [CajaController::class, 'recibirPagoPagarProcesar'])->name('caja.pago.recibir.pagar.procesar');

Route::get('caja/turno', [CajaController::class, 'cambioTurno'])->name('caja.turno');
Route::post('caja/turno/guardar', [CajaController::class, 'cambioTurnoGuardar'])->name('caja.turno.guardar');
Route::get('caja/turno/verimprimir/{id?}', [CajaController::class, 'imprimirCierre'])->name('caja.turno.verimprimir');


Route::get('caja/rendir', [CajaController::class, 'getRendicion'])->name('caja.rendir');
Route::post('caja/rendir/cerrar', [CajaController::class, 'rendicionCerrar'])->name('caja.rendir.cerrar');


/*
 * Fin sub menu venta
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
Route::get('general/cliente/descuento/{id?}', [ClienteController::class, 'indexDescuento'])->name('general.cliente.indexDescuentos');
Route::get('general/cliente/descuento/tabla1/{id?}', [ClienteController::class, 'getTablaDescuentoLinea'])->name('general.cliente.descuento.tabla1');
Route::get('general/cliente/descuento/tabla2/{id?}', [ClienteController::class, 'getTablaDescuentoFamilia'])->name('general.cliente.descuento.tabla2');
Route::get('general/cliente/descuento/tabla3/{id?}', [ClienteController::class, 'getTablaDescuentoProducto'])->name('general.cliente.descuento.tabla3');
Route::get('general/cliente/descuento/nuevolinea/{id?}', [ClienteController::class, 'getDescuentoNuevoLinea'])->name('general.cliente.descuento.nuevo.linea');
Route::get('general/cliente/descuento/nuevofamilia/{id?}', [ClienteController::class, 'getDescuentoNuevoFamilia'])->name('general.cliente.descuento.nuevo.familia');
Route::get('general/cliente/descuento/nuevoproducto/{id?}', [ClienteController::class, 'getDescuentoNuevoProducto'])->name('general.cliente.descuento.nuevo.producto');


Route::post('general/cliente/descuento/nuevolinea', [ClienteController::class, 'postDescuentoNuevoLineaSave'])->name('general.cliente.descuento.nuevo.linea.save');
Route::post('general/cliente/descuento/nuevofamilia', [ClienteController::class, 'postDescuentoNuevoFamiliaSave'])->name('general.cliente.descuento.nuevo.familia.save');
Route::post('general/cliente/descuento/nuevoproducto', [ClienteController::class, 'postDescuentoNuevoProductoSave'])->name('general.cliente.descuento.nuevo.producto.save');



Route::post('general/cliente/descuento/eliminar/DescuentoLinea', [ClienteController::class, 'postEliminarDescuentoLinea'])->name('general.cliente.descuento.eliminar.DescuentoLinea');
Route::post('general/cliente/descuento/eliminar/DescuentoFamilia', [ClienteController::class, 'postEliminarDescuentoFamilia'])->name('general.cliente.descuento.eliminar.DescuentoFamilia');
Route::post('general/cliente/descuento/eliminar/DescuentoProducto', [ClienteController::class, 'postEliminarDescuentoProducto'])->name('general.cliente.descuento.eliminar.DescuentoProducto');


//Impresoras

Route::get('general/impresora', [ImpresoraController::class, 'index'])->name('general.impresora');
Route::get('general/impresora/tabla', [ImpresoraController::class, 'getTabla'])->name('general.impresora.tabla');
Route::get('general/impresora/form/{id?}', [ImpresoraController::class, 'getEdit'])->name('general.impresora.form');
Route::post('general/impresora/form', [ImpresoraController::class, 'postUpdate'])->name('general.impresora.form.update');
Route::post('general/impresora/activar', [ImpresoraController::class, 'postActivar'])->name('general.impresora.activar');
Route::post('general/impresora/eliminar', [ImpresoraController::class, 'postEliminar'])->name('general.impresora.eliminar');


//Sucursal

Route::get('general/sucursal', [SucursalController::class, 'index'])->name('general.sucursal');
Route::get('general/sucursal/tabla', [SucursalController::class, 'getTabla'])->name('general.sucursal.tabla');
Route::get('general/sucursal/form/{id?}', [SucursalController::class, 'getEdit'])->name('general.sucursal.form');
Route::post('general/sucursal/form', [SucursalController::class, 'postUpdate'])->name('general.sucursal.form.update');


// Movimientos

Route::get('informe/movimiento', [MovimientoController::class, 'index'])->name('informe.movimiento');
Route::get('informe/movimiento/tabla', [MovimientoController::class, 'getTabla'])->name('informe.movimiento.tabla');
Route::get('informe/movimiento/form/{id?}', [MovimientoController::class, 'getEdit'])->name('informe.movimiento.form');
Route::post('movimiento/unidad/eliminar', [MovimientoController::class, 'deleteUnidad'])->name('informe.movimiento.eliminar.unidad');
Route::post('movimiento/producto/eliminar', [MovimientoController::class, 'deletaProducto'])->name('informe.movimiento.eliminar.producto');


// Stock

Route::get('informe/stock', [StockController::class, 'index'])->name('informe.stock');
Route::get('informe/stock/tabla', [StockController::class, 'getTabla'])->name('informe.stock.tabla');
Route::get('informe/stock/form/{id?}', [StockController::class, 'getEdit'])->name('informe.stock.form');


// Stock

Route::get('informe/stockcritico', [StockCriticoController::class, 'index'])->name('informe.stockcritico');
Route::get('informe/stockcritico/tabla', [StockCriticoController::class, 'getTabla'])->name('informe.stockcritico.tabla');
Route::get('informe/stockcritico/form/{id?}', [StockCriticoController::class, 'getEdit'])->name('informe.stockcritico.form');

/*
 * Fin sub menu general
 */

/*
 * Inicio Funciones globales
 */

Route::get('global/combo/FamiliaByLinea/{id?}', [ComboController::class, 'getFamiliaByLinea'])->name('global.combo.familiabylinea');
Route::get('global/combo/ProductosByFamilia/{id?}', [ComboController::class, 'getProductosByFamilia'])->name('global.combo.ProductosByFamilia');
Route::get('global/info/ClienteById/{id?}', [ComboController::class, 'ClienteById'])->name('global.info.ClienteById');
Route::get('global/info/ProductoById/{id?}', [ComboController::class, 'ProductoById'])->name('global.info.ProductoById');
Route::get('global/info/getUbicacionByAccion/{id?}', [ComboController::class, 'getUbicacionByAccion'])->name('global.info.getUbicacionByAccion');
Route::get('global/info/getVentaById/{id?}', [ComboController::class, 'getVentaById'])->name('global.info.getVentaById');
//Route::get('global/info/getVentaDetalleById/{id?}', [ComboController::class, 'getVentaById'])->name('global.info.getVentaById');


Route::post('global/autocomplete/fetchProducto', [AutoCompleteController::class, 'fetchProducto'])->name('global.autocomplete.fetchProducto');

Route::get('global/info/getVentasbytipo/{id?}/{origen_id?}', [ComboController::class, 'getVentasByTipo'])->name('global.autocomplete.getVentasByTipo');
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


Route::get('informe/ventas', [VentasController::class, 'index'])->name('informe.ventas');
Route::get('informe/ventas/tabla', [VentasController::class, 'getTabla'])->name('informe.ventas.tabla'); 

/* ESTADO CUENTA CLIENTE */

Route::get('informe/cliente', [ClientesController::class, 'index'])->name('informe.cliente');
Route::get('informe/cliente/tabla', [ClientesController::class, 'getTabla'])->name('informe.cliente.tabla');
Route::get('informe/cliente/form/{id?}', [ClientesController::class, 'getEdit'])->name('informe.cliente.form');
Route::get('infome/cliente/form/tabla/{id?}', [ClientesController::class, 'getTablaVenta'])->name('informe.cliente.form.tabla');


/* ESTADO CUENTA PROVEEDOR */

Route::get('informe/proveedor', [ProveedoresController::class, 'index'])->name('informe.proveedor');
Route::get('informe/proveedor/tabla', [ProveedoresController::class, 'getTabla'])->name('informe.proveedor.tabla');
Route::get('informe/proveedor/tablag', [ProveedoresController::class, 'getTablaGeneral'])->name('informe.proveedor.tablag');
Route::get('informe/proveedor/form/{id?}', [ProveedoresController::class, 'getEdit'])->name('informe.proveedor.form');
Route::get('infome/proveedor/form/tabla/{id?}', [ProveedoresController::class, 'getTablaCompra'])->name('informe.proveedor.form.tabla');

/*
 * Fin sub menu Informes
 */
