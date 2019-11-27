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
            $data = DB::table('producto')
                ->join('marca', 'producto.marca_id', '=', 'marca.id')
                ->where('producto.nombre', 'LIKE', "%{$query}%")
                ->limit(30)
                ->select("producto.nombre","marca.nombre as marca")
                ->get();

            echo $data->toJson();
        }
    }

}


