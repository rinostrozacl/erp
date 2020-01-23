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
class VentasVendedorController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index(){
  
        return view('backend.informe.ventasvendedor.list');
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

            $usuarios = $total = DB::select("SELECT SUM(total) as monto, user_id as id FROM `venta` 
            where (venta_estado_id = 2 or venta_estado_id = 3 or venta_estado_id = 4) and 
            (created_at BETWEEN '". $request->fecha_inicio ."' AND '". $request->fecha_fin ."')
             GROUP by user_id ");
        }else{

            $usuarios = $total = DB::select("SELECT SUM(total) as monto, user_id as id FROM `venta` 
            where (venta_estado_id = 2 or venta_estado_id = 3 or venta_estado_id = 4) 
             GROUP by user_id ");
        }
  
       
        return Datatables::of($usuarios)
            ->addColumn('vendedor', function ($item) {
                $user = User::find($item->id);
                
                return $user->first_name .  " " . $user->last_name;
            })->make(true);
    }




    public function getEdit($id=0)
    {
        $movimiento = Movimiento::find($id);

        return view('backend.informe.movimiento.form')->with('movimiento',$movimiento);
    }




}


