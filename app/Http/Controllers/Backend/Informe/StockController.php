<?php

namespace App\Http\Controllers\Backend\Informe;


use App\Models\Auth\User;
use App\Models\MovimientoTipo;
use App\Models\Producto;
use App\Models\Ubicacion;
use App\Models\Unidad;
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
        return view('backend.informe.stock.list')->with('producto',$producto)->with('ubicacion',$ubicacion);
    }
    public function getTabla(Request $request)
    {
        $producto = Producto::all();

        if ($request->ubicacion_id >0) {

            $producto = Producto::whereHas('producto_ubicacion', function($q) use ($request)
            {
                $q->where('ubicacion_id', '=', $request->ubicacion_id);

            })->get();
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


