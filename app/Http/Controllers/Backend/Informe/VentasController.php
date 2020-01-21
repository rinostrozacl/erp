<?php

namespace App\Http\Controllers\Backend\Informe;


use App\Models\Auth\User;
use App\Models\VentaEstado;
use App\Models\Ubicacion;
use App\Models\Unidad;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Movimiento;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class VentasController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $venta_estado = VentaEstado::all();
        return view('backend.informe.ventas.list')->with( 'venta_estado', $venta_estado);
    }

    public function getTabla(Request $request)
    {
        $ventas = Venta::all()->sortBy('id');

       
        if ($request->venta_estado_id >0) {

            $ventas=$ventas->where('movimiento_tipo_id', $request->venta_estado_id);
        }
      /*
        if ($request->fecha_inicio != "") {

            $movimientos=$movimientos->where('created_at', ">" , $request->fecha_inicio);
        }

        if ($request->fecha_fin != "") {

            $movimientos=$movimientos->where('movimiento_tipo_id', "<", $request->fecha_fin);
        }

        if ($request->fecha_inicio != "" && $request->fecha_fin != "") {

            $movimientos=$movimientos->where('created_at', ">" , $request->fecha_inicio)->where('movimiento_tipo_id', "<", $request->fecha_fin);
        }
   */
       
        return Datatables::of($ventas)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.caja.venta.imprimir',$item->id).'"  target="_blank" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Ver Documento</a> ';
                return $bt;
            }) 
            ->addColumn('estado', function ($item) {
                return $item->venta_estado->nombre;
            })
            ->editColumn('cliente_id', function ($item) {
                $resp="";
                if ($item->cliente){
                    if ($item->cliente_id >3){
                        $resp .= $item->cliente->nombre;
                    }else{
                        $resp .= "No especificado ";
                    }
                }              
                $resp .= " (".$item->contacto_nombre ." )"; 
                return $resp;
            })
            ->editColumn('user_id', function ($item) {
                return $item->user->first_name .  " " . $item->user->last_name;
            })

            ->make(true);
    }




    public function getEdit($id=0)
    {
        $movimiento = Movimiento::find($id);

        return view('backend.informe.movimiento.form')->with('movimiento',$movimiento);
    }




}


