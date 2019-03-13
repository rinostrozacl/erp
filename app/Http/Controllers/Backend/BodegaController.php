<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

/**
 * Class DashboardController.
 */
class BodegaController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function producto_index()
    {

        return view('backend.bodega.lista');
    }
    public function entrada_index()
    {
        return view('backend.bodega.lista');
    }
    public function salida_index()
    {
        return view('backend.bodega.lista');
    }
    public function inventario_index()
    {
        return view('backend.bodega.lista');
    }
}


