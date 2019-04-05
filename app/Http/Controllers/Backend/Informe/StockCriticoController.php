<?php

namespace App\Http\Controllers\Backend\Informe;


use App\Models\Auth\User;
use App\Models\Linea;
use App\Models\Producto;
use App\Models\Familia;
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
class StockCriticoController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $familia = Familia::all();
        $linea = Linea::all();
        $producto = Producto::whereRaw('stock_disponible <= stock_critico')->get();
        //dd($producto);
        return view('backend.informe.stockcritico.list')->with('producto',$producto)->with('familia',$familia)->with('linea',$linea);
    }
    public function getTabla(Request $request)
    {
        $producto = Producto::whereRaw('stock_disponible <= stock_critico')->get();

        if ($request->familia_id >0) {

            $producto = Producto::whereHas('familia', function($q) use ($request)
            {
                $q->where('familia_id', '=', $request->familia_id);

            })->get();
        }

        return Datatables::of($producto)

            ->editColumn('id', 'ID: {{$id}}')

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

        return view('backend.informe.stockcritico.form')->with('producto',$producto);
    }




}


