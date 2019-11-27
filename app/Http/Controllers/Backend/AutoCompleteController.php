<?php

namespace App\Http\Controllers\Backend;


use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Producto;
use App\Models\Familia;
use Illuminate\Http\Request;

/**
 * Class DashboardController.
 */
class AutoCompleteController extends Controller
{
    function fetchProducto(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = DB::table('producto', 'marca.nombre as marca')
                ->join('marca', 'producto.marca_id', '=', 'marca.id')
                ->where('nombre', 'LIKE', "%{$query}%")
                ->limit(30)
                ->get();

            echo $data->toJson();
        }
    }

}


