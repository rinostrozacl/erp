<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});




Breadcrumbs::for('admin.bodega.producto', function ($trail) {
    $trail->push(__('Administrador de productos'), route('admin.bodega.producto'));
});
Breadcrumbs::for('admin.bodega.producto.form', function ($trail) {
    $trail->push(__('Administrador de productos'), route('admin.bodega.producto.form'));
});



Breadcrumbs::for('admin.bodega.entrada', function ($trail) {
    $trail->push(__('Movimientos'), route('admin.bodega.entrada'));
});

Breadcrumbs::for('admin.bodega.salida', function ($trail) {
    $trail->push(__('Salida de productos de bodega'), route('admin.bodega.salida'));
});

Breadcrumbs::for('admin.bodega.inventario.realizar', function ($trail) {
    $trail->push(__('Ejecutar inventario'), route('admin.bodega.inventario.realizar'));
});


Breadcrumbs::for('admin.bodega.inventario.nuevo', function ($trail) {
    $trail->push(__('Realizacion nuevo Inventario'), route('admin.bodega.inventario.nuevo'));
});

Breadcrumbs::for('admin.bodega.inventario', function ($trail) {
    $trail->push(__('Realizacion de Inventario'), route('admin.bodega.inventario'));
});
Breadcrumbs::for('admin.bodega.inventario.resultado', function ($trail) {
    $trail->push(__('Resultado de Inventario'), route('admin.bodega.inventario.resultado'));
});

Breadcrumbs::for('admin.general.marca', function ($trail) {
    $trail->push(__('Marcas'), route('admin.general.marca'));
});

Breadcrumbs::for('admin.general.marca.form', function ($trail) {
    $trail->push(__('Marcas'), route('admin.general.marca.form'));
});

Breadcrumbs::for('admin.general.familia', function ($trail) {
    $trail->push(__('Familias'), route('admin.general.familia'));
});

Breadcrumbs::for('admin.general.familia.form', function ($trail) {
    $trail->push(__('Familias'), route('admin.general.familia.form'));
});

Breadcrumbs::for('admin.general.linea', function ($trail) {
    $trail->push(__('Líneas'), route('admin.general.linea'));
});

Breadcrumbs::for('admin.general.linea.form', function ($trail) {
    $trail->push(__('Líneas'), route('admin.general.linea.form'));
});


Breadcrumbs::for('admin.general.ubicacion', function ($trail) {
    $trail->push(__('Ubicaciones'), route('admin.general.ubicacion'));
});

Breadcrumbs::for('admin.general.ubicacion.form', function ($trail) {
    $trail->push(__('Ubicaciones'), route('admin.general.ubicacion.form'));
});

Breadcrumbs::for('admin.general.impresora', function ($trail) {
    $trail->push(__('Impresoras'), route('admin.general.impresora'));
});

Breadcrumbs::for('admin.general.impresora.form', function ($trail) {
    $trail->push(__('Impresoras'), route('admin.general.impresora.form'));
});

Breadcrumbs::for('admin.general.sucursal', function ($trail) {
    $trail->push(__('Sucursales'), route('admin.general.sucursal'));
});

Breadcrumbs::for('admin.general.sucursal.form', function ($trail) {
    $trail->push(__('Sucursales'), route('admin.general.sucursal.form'));
});

Breadcrumbs::for('admin.general.proveedor', function ($trail) {
    $trail->push(__('Proveedores'), route('admin.general.proveedor'));
});

Breadcrumbs::for('admin.general.proveedor.form', function ($trail) {
    $trail->push(__('Proveedores'), route('admin.general.proveedor.form'));
});


Breadcrumbs::for('admin.general.doctipocompra', function ($trail) {
    $trail->push(__('Tipos de documento de compra'), route('admin.general.doctipocompra'));
});

Breadcrumbs::for('admin.general.doctipocompra.form', function ($trail) {
    $trail->push(__('Tipos de documento de compra'), route('admin.general.doctipocompra.form'));
});

Breadcrumbs::for('admin.general.doctipoventa', function ($trail) {
    $trail->push(__('Tipos de documento de venta'), route('admin.general.doctipoventa'));
});

Breadcrumbs::for('admin.general.doctipoventa.form', function ($trail) {
    $trail->push(__('Tipos de documento de venta'), route('admin.general.doctipoventa.form'));
});

Breadcrumbs::for('admin.general.cliente', function ($trail) {
    $trail->push(__('Clientes'), route('admin.general.cliente'));
});

Breadcrumbs::for('admin.general.cliente.form', function ($trail) {
    $trail->push(__('Clientes'), route('admin.general.cliente.form'));
});

Breadcrumbs::for('admin.informe.movimiento', function ($trail) {
    $trail->push(__('Movimientos'), route('admin.informe.movimiento'));
});

Breadcrumbs::for('admin.informe.movimiento.form', function ($trail) {
    $trail->push(__('Movimientos'), route('admin.informe.movimiento.form'));
});

Breadcrumbs::for('admin.informe.stock', function ($trail) {
    $trail->push(__('Informe de stock'), route('admin.informe.stock'));
});

Breadcrumbs::for('admin.informe.stock.form', function ($trail) {
    $trail->push(__('Informe de stock'), route('admin.informe.stock.form'));
});

Breadcrumbs::for('admin.informe.stockcritico', function ($trail) {
    $trail->push(__('Informe de stock crítico'), route('admin.informe.stockcritico'));
});

Breadcrumbs::for('admin.informe.stockcritico.form', function ($trail) {
    $trail->push(__('Informe de stock crítico'), route('admin.informe.stockcritico.form'));
});

Breadcrumbs::for('admin.caja.venta.nuevo', function ($trail) {
    $trail->push(__('Nueva venta'), route('admin.caja.venta.nuevo'));
});

Breadcrumbs::for('admin.caja.pago.recibir', function ($trail) {
    $trail->push(__('Recibir pago'), route('admin.caja.pago.recibir'));
});

Breadcrumbs::for('admin.caja.turno', function ($trail) {
    $trail->push(__('Cambio de turno'), route('admin.caja.turno'));
});


Breadcrumbs::for('admin.caja.rendir', function ($trail) {
    $trail->push(__('Rendir caja'), route('admin.caja.rendir'));
});

Breadcrumbs::for('admin.general.cliente.indexDescuentos', function ($trail) {
    $trail->push(__('Descuentos'), route('admin.general.cliente.indexDescuentos'));
});

Breadcrumbs::for('admin.general.cliente.descuento.nuevo.linea', function ($trail) {
    $trail->push(__('Descuentos'), route('admin.general.cliente.descuento.nuevo.linea'));
});
Breadcrumbs::for('admin.general.cliente.descuento.nuevo.familia', function ($trail) {
    $trail->push(__('Descuentos'), route('admin.general.cliente.descuento.nuevo.familia'));
});
Breadcrumbs::for('admin.general.cliente.descuento.nuevo.producto', function ($trail) {
    $trail->push(__('Descuentos'), route('admin.general.cliente.descuento.nuevo.producto'));
});


Breadcrumbs::for('admin.informe.ventas', function ($trail) {
    $trail->push(__('Ventas'), route('admin.informe.ventas'));
});

Breadcrumbs::for('admin.informe.cliente', function ($trail) {
    $trail->push(__('Estado de cuenta Cliente '), route('admin.informe.cliente'));
});

Breadcrumbs::for('admin.informe.cliente.form', function ($trail) {
    $trail->push(__('Estado de cuenta Cliente'), route('admin.informe.cliente.form'));
});

require __DIR__.'/auth.php';
require __DIR__.'/log-viewer.php';
