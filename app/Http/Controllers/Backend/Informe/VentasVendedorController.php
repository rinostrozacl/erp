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
        $usuarios = User::all()->sortBy('id');

  

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
       
        return Datatables::of($usuarios)
            ->addColumn('monto', function ($item) {
                return 0;
            })
            ->addColumn('vendedor', function ($item) {
                return $item->user->first_name .  " " . $item->user->last_name;
            })->make(true);
    }




    public function getEdit($id=0)
    {
        $movimiento = Movimiento::find($id);

        return view('backend.informe.movimiento.form')->with('movimiento',$movimiento);
    }




}


