<?php

namespace App\Http\Controllers\Backend\Informe;


use App\Models\Auth\User;
use App\Models\MovimientoTipo;
use App\Models\Ubicacion;
use App\Models\Unidad;
use App\Models\UnidadMovimiento;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Movimiento;
use App\Models\Producto;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class MovimientoController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $movimiento_tipo = MovimientoTipo::all();
        return view('backend.informe.movimiento.list', ['movimiento_tipo' => $movimiento_tipo]);
    }
    public function getTabla(Request $request)
    {
        $movimientos = Movimiento::all();


        if ($request->movimiento_tipo_id >0) {

            $movimientos=$movimientos->where('movimiento_tipo_id', $request->movimiento_tipo_id);
        }

        if ($request->fecha_inicio != "") {

            $movimientos=$movimientos->where('created_at', ">" , $request->fecha_inicio);
        }

        if ($request->fecha_fin != "") {

            $movimientos=$movimientos->where('movimiento_tipo_id', "<", $request->fecha_fin);
        }

        if ($request->fecha_inicio != "" && $request->fecha_fin != "") {

            $movimientos=$movimientos->where('created_at', ">" , $request->fecha_inicio)->where('movimiento_tipo_id', "<", $request->fecha_fin);
        }

        return Datatables::of($movimientos)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.informe.movimiento.form',$item->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Ver detalles</a> ';

                return $bt;
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->addColumn('movimiento_tipo_id', function ($item) {
                return $item->movimiento_tipo->nombre;
            })
            ->addColumn('ubicacion_origen_id', function ($item) {
                $id = $item->ubicacion_origen_id;
                $ubicacion = Ubicacion::find($id);
                if($ubicacion){
                    return $ubicacion->nombre;
                }else{
                    return "";
                }
            })
            ->addColumn('ubicacion_destino_id', function ($item) {
                $id = $item->ubicacion_destino_id;
                $ubicacion = Ubicacion::find($id);
                if($ubicacion){
                    return $ubicacion->nombre;
                }else{
                    return "";
                }
                
            })
            ->addColumn('user_id', function ($item) {
                return $item->usuario->first_name .  " " . $item->usuario->last_name;
            })

            ->make(true);
    }




    public function getEdit($id=0)
    {
        $movimiento = Movimiento::find($id);

        return view('backend.informe.movimiento.form')->with('movimiento',$movimiento);
    }

    public function deleteUnidad(Request $request)
    {
         
         $unidad_movimiento = UnidadMovimiento::find($request->unidad_movimiento_id);
        // dd($unidad_movimiento);
        $unidad_movimiento->delete();

 
      //  UnidadMovimiento::destroy($request->unidad_movimiento_id);

        $unidad = Unidad::find($request->unidad_id);
        $unidad->delete(); 
        
 


        $producto = Producto::find($request->producto_id);
        $producto->stock_disponible =  $producto->stock_disponible -1;
        $producto->save();

        
        return 1;
    }

    public function deletaProducto(Request $request)
    {


        $unidad_movimiento = UnidadMovimiento::find($request->unidad_movimiento_id);
        // dd($unidad_movimiento);
        $unidad_movimiento->delete();

        UnidadMovimiento::where('movimiento_id', $request->movimiento_id)->where('unidad.producto_id', $request->producto_id)->delete();


        $unidad = Unidad::where('movimiento_id', $request->movimiento_id)->where('unidad.producto_id', $request->producto_id)->delete();
        $unidad->delete(); 


        $producto = Producto::find($request->producto_id);
        $producto->stock_disponible =  $producto->stock_disponible -1;
        $producto->save();


        return 1;
    }
}


