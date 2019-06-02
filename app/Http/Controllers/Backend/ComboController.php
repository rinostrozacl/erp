<?php

namespace App\Http\Controllers\Backend;


use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Producto;
use App\Models\Familia;
use App\Models\Ubicacion;
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

    public function getProductosByFamilia($id)
    {
        $productos = Producto::where('familia_id',$id)->get();

        return $productos->toJson();
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


    public function getUbicacionByAccion($id)
    {
        if($id==1){
            $ubicacion = Ubicacion::where('is_entrada_origen',1)->get();
        }elseif ($id==2){
            $ubicacion = Ubicacion::where('is_entrada_destino',1)->get();
        }elseif ($id==3){
            $ubicacion = Ubicacion::where('is_traslado_destino',1)->get();
        }elseif ($id==4){
            $ubicacion = Ubicacion::where('is_traslado_origen',1)->get();
        }elseif ($id==5){
            $ubicacion = Ubicacion::where('is_salida_origen',1)->get();
        }elseif ($id==6){
            $ubicacion = Ubicacion::where('is_salida_destino',1)->get();
        }


        return $ubicacion->toJson();
    }

}


