<?php

namespace App\Http\Controllers\Backend;


use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Producto;
use App\Models\Familia;
use Illuminate\Http\Request;

/**
 * Class DashboardController.
 */
class ComboController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function getFamiliaByLinea($id)
    {
        $familias = Familia::where('linea_id',$id)->get();

        return $familias->toJson();
    }


    public function ClienteById($id)
    {
        $cliente = Cliente::find($id);

        return $cliente->toJson();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function ProductoById($id)
    {
        $producto = Producto::find($id);


        return $producto->toJson();
    }


}


