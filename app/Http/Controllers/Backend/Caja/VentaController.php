<?php

namespace App\Http\Controllers\Backend\Caja;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Cliente;
use App\Models\Marca;
use App\Models\Ubicacion;
use App\Models\Producto;
use App\Models\UnidadMedida;
use App\Models\Linea;
use App\Models\Familia;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class VentaController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $marcas = Marca::where('activo',1)->get();
        $ubicacion = Ubicacion::where('activo',1)->where('is_inventariable',1)->get();
        $familias = Familia::where('activo',1)->where('linea_id',0)->get();
        $lineas = Linea::where('activo',1)->get();
        $clientes= Cliente::all();
        return view('backend.caja.venta.index')
            ->with("clientes", $clientes)
            ->with('ubicacion',$ubicacion)
            ->with('lineas',$lineas)
            ->with('marcas',$marcas)
            ->with('familias',$familias);
    }


    public function postTablaBusqueda()
    {
       $productos = Producto::all();
           if($_GET['marca_id']>0){
               $productos= $productos->where('marca_id',$_GET['marca_id']) ;
           }

           if($_GET['ubicacion_id']>0){
               $productos= $productos->where('ubicacion_id',$_GET['ubicacion_id']) ;
           }

           if($_GET['linea_id']>0){
               $productos= $productos->where('linea_id',$_GET['linea_id']) ;
           }
           if($_GET['familia_id']>0){
               $productos= $productos->where('familia_id',$_GET['familia_id']) ;
           }


        return Datatables::of($productos)
            ->addColumn('action', function ($item) {
                $bt='<div class="input-group">
                                    <input class="form-control"  type="number"   id="cantidad_'.$item->id.'" name="input2-group2"  value="1">
                                    <span class="input-group-append">
                                        <button class="btn btn-primary bt-agregar" type="button"   data-id="'.$item->id.'">Agregar</button>
                                    </span>
                                </div> ';
                return $bt;
            })->editColumn('id', '{{$id}}'
            )->addColumn('familia', function ($item) {
                return $item->familia->nombre;
            })->addColumn('codigo', function ($item) {
                return $item->codigo_ean13 . "[".$item->codigo_erp."]";
            })->addColumn('stock', function ($item) {
                return $item->stock_disponible ;
            })->addColumn('linea', function ($item) {
                return $item->familia->linea->nombre;
            })->addColumn('marca', function ($item) {
                return $item->marca->nombre;
            })->rawColumns(['action'])
            ->make(true);
    }
}

