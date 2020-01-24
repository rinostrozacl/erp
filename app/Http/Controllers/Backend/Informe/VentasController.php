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
class VentasController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $usuarios = User::all();
        $venta_estado = VentaEstado::all();
        return view('backend.informe.ventas.list')
            ->with('venta_estado', $venta_estado)
            ->with('usuarios', $usuarios);
    }

    public function getTabla(Request $request)
    {



        if ($request->venta_estado_id >0) {
            $whereestado = " and (venta_estado_id = ". $request->venta_estado_id ."  ) ";
            
        } else {

            $whereestado = "";
        }

        if ($request->fecha_inicio != "" && $request->fecha_fin != "") {
            $wherefecha = " and 
            (created_at BETWEEN '". $request->fecha_inicio ."' AND '". $request->fecha_fin ."') ";
            
        } else {

            $wherefecha = "";
        }

        if ($request->user_id >0) {

            $whereusuario=" and (user_id = ". $request->user_id ."  ) "; 
        } else {

            $whereusuario = "";
        }




      

        $sql = "SELECT * FROM `venta` 
        where 1  $whereestado $whereusuario $wherefecha ";



       
       
       

        



        $ventas = $total = DB::select($sql);




      /*
        if ($request->fecha_inicio != "") {

            $movimientos=$movimientos->where('created_at', ">" , $request->fecha_inicio);
        }

        if ($request->fecha_fin != "") {

            $movimientos=$movimientos->where('movimiento_tipo_id', "<", $request->fecha_fin);
        }

  
   */
       
        return Datatables::of($ventas)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.caja.venta.imprimir',$item->id).'"  target="_blank" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Ver Documento</a> ';
                return $bt;
            }) 
            ->addColumn('estado', function ($item) {
                $venta_estado = VentaEstado::find($item->venta_estado_id);
                return $venta_estado->nombre;
            })
            ->editColumn('cliente_id', function ($item) {
                $cliente= Cliente::find($item->cliente_id);

                $resp="";
                if ($cliente){
                    if ($item->cliente_id >3){
                        $resp .= $cliente->nombre;
                    }else{
                        $resp .= "No especificado ";
                    }
                }              
                $resp .= " (".$item->contacto_nombre ." )"; 
                return $resp;
            })
            ->editColumn('user_id', function ($item) {
                $user = User::find($item->user_id); 
                return $user->first_name .  " " . $user->last_name;
            })

            ->make(true);
    }




    public function getEdit($id=0)
    {
        $movimiento = Movimiento::find($id);

        return view('backend.informe.movimiento.form')->with('movimiento',$movimiento);
    }




}


