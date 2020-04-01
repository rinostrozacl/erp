<?php

namespace App\Http\Controllers\Backend\Informe;


use App\Models\Auth\User;
use App\Models\VentaEstado;
use App\Models\Ubicacion;
use App\Models\Unidad;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Movimiento; 
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class CantidadVentasController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index(){
  
        return view('backend.informe.cantidadventas.list');
    }

    public function getTabla(Request $request)
    {
        

  

      /*
        if ($request->fecha_inicio != "") {

            $movimientos=$movimientos->where('created_at', ">" , $request->fecha_inicio);
        }

        if ($request->fecha_fin != "") {

            $movimientos=$movimientos->where('movimiento_tipo_id', "<", $request->fecha_fin);
        }
 */
        if ($request->fecha_inicio != "" && $request->fecha_fin != "") {

            $usuarios = $total = DB::select("SELECT SUM(cantidad_vendida) as cantidad, producto_id as id, producto.nombre as nombre FROM `venta_detalle` 
            JOIN venta on venta.id = venta_detalle.venta_id
            JOIN producto on producto.id = venta_detalle.producto_id
            where venta.venta_estado_id = 3
            (venta_detalle.created_at BETWEEN '". $request->fecha_inicio ."' AND '". $request->fecha_fin ."')
             GROUP by producto_id order by cantidad desc ");
        }else{

            $usuarios = $total = DB::select("SELECT SUM(cantidad_vendida) as cantidad, producto_id as id, producto.nombre as nombre FROM `venta_detalle` 
            JOIN venta on venta.id = venta_detalle.venta_id
            JOIN producto on producto.id = venta_detalle.producto_id
            where venta.venta_estado_id = 3
                         GROUP by producto_id  order by cantidad desc");
        }
  
       
        return Datatables::of($usuarios)
            ->addColumn('producto', function ($item) {
                return $item->nombre ;
            })->make(true);
    }




    public function getEdit($id=0)
    {
        $movimiento = Movimiento::find($id);

        return view('backend.informe.movimiento.form')->with('movimiento',$movimiento);
    }




}


