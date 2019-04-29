<?php

namespace App\Http\Controllers\Backend\Informe;


use App\Models\Auth\User;
use App\Models\Linea;
use App\Models\Producto;
use App\Models\Ubicacion;
use App\Models\Familia;
use App\Models\UnidadMovimiento;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Movimiento;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class StockController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $ubicacion = Ubicacion::all();
        $producto = Producto::all();
        $familia = Familia::all();
        $linea = Linea::all();
        return view('backend.informe.stock.list')->with('producto',$producto)->with('ubicacion',$ubicacion)->with('familia',$familia)->with('linea',$linea);
    }
    public function getTabla(Request $request)
    {
        $producto = Producto::all();

        if($request->ubicacion_id != 0){
            $producto = $producto->where('producto_ubicacion.ubicacion_id', $request->ubicacion_id);
        }
        if($request->familia_id>0){
            $producto = $producto->where('familia_id',$request->familia_id);
        }
        if($request->linea_id>0){
            $producto = $producto->where('familia.linea_id',$request->linea_id);
        }

        return Datatables::of($producto)

            ->editColumn('id', 'ID: {{$id}}')
            ->addColumn('ubicacion_id', function ($item) {
                $ubicacion_id = $item->producto_ubicacion->ubicacion_id;
                $ubicacion = Ubicacion::find($ubicacion_id);
                return $ubicacion->nombre;
            })
            ->addColumn('stock_disponible', function ($item) {
                return $item->producto_ubicacion->stock_disponible;
            })
            ->addColumn('stock_global', function ($item) {
                return $item->stock_disponible;
            })
            ->make(true);
    }




    public function getEdit($id=0)
    {
        $producto = Producto::find($id);

        return view('backend.informe.stock.form')->with('producto',$producto);
    }




}


