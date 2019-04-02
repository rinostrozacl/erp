<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});




Breadcrumbs::for('admin.bodega.producto', function ($trail) {
    $trail->push(__('Administrador de productos'), route('admin.bodega.producto'));
});

Breadcrumbs::for('admin.bodega.entrada', function ($trail) {
    $trail->push(__('Movimientos'), route('admin.bodega.entrada'));
});

Breadcrumbs::for('admin.bodega.salida', function ($trail) {
    $trail->push(__('Salida de productos de bodega'), route('admin.bodega.salida'));
});


Breadcrumbs::for('admin.bodega.inventario', function ($trail) {
    $trail->push(__('Realizacion de Inventario'), route('admin.bodega.inventario'));
});


Breadcrumbs::for('admin.general.marca', function ($trail) {
    $trail->push(__('Marcas'), route('admin.general.marca'));
});

Breadcrumbs::for('admin.general.marca.form', function ($trail) {
    $trail->push(__('Marcas'), route('admin.general.marca.form'));
});




require __DIR__.'/auth.php';
require __DIR__.'/log-viewer.php';
