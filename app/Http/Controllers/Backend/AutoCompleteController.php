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
                ->where('nombre', 'LIKE', "%{$query}%")
                ->limit(30)
                ->get();

            /*$output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            if($data->count()){
                foreach($data as $row)
                {
                    $output .= '<li data-producto_id="'.$row->id.'"><a href="#">'.$row->nombre.'</a></li>';
                }
            }else{
                $output .= '<li>No encontrado</li>';
            }
            $output .= '</ul>';*/
            echo $data->toJson();
        }
    }

}


