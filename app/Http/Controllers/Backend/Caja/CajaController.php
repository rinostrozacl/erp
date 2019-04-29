<?php

namespace App\Http\Controllers\Backend\Caja;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Producto;
use App\Models\Marca;
use App\Models\Ubicacion;
use App\Models\ProductoUbicacion;
use App\Models\UnidadMedida;
use App\Models\Linea;
use App\Models\Familia;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class CajaController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.bodega.producto.index');
    }

}


