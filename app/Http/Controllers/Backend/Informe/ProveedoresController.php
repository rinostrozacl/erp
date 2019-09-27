<?php

namespace App\Http\Controllers\Backend\Informe;


use App\Models\Auth\User;
use App\Models\MovimientoTipo;
use App\Models\Ubicacion;
use App\Models\Unidad;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use Carbon\Carbon;

/**
 * Class DashboardController.
 */
class ProveedoresController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.informe.proveedor.index');
    }

    public function getEdit($id=0)
    {
        $proveedor = Proveedor::find($id);
        return view('backend.informe.proveedor.list')->with('proveedor', $proveedor);
    }


    public function getTabla(Request $request)
    {
        $proveedores = Proveedor::all();
        
        return Datatables::of($proveedores)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.informe.proveedor.form',$item->id).'"  target="_blank" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Ver registros</a> ';
                return $bt;
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function getTablaGeneral(Request $request)
    {

        $compras = Compra::all();
        
        return Datatables::of($compras)
            ->addColumn('dias', function ($item) {
                $resultado = "";
                $fecha_compra = new Carbon($item->created_at);
                $ahora = Carbon::now();
                if($item->is_pagado == 1){
                    $resultado = "No aplica";
                }
                else{
                    $diferencia = ($fecha_compra->diff($ahora)->days);
                    $resultado = $diferencia;
                }
                
                return $resultado;
            })
            ->editColumn('doc_tipo_compra_id', function ($item) {
                return $item->doc_tipo_compra->nombre;
            })
            ->editColumn('is_pagado', function ($item) {
                if($item->is_pagado == "1")
                    return "Pagado";
                else
                    return "No pagado";
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function getTablaCompra($id=0, Request $request)
    {
        $compras = Compra::where('proveedor_id', $id);

        if ($request->is_pagado != "") {

            $compras=$compras->where('is_pagado', $request->is_pagado);
        }

        if ($request->fecha_inicio != "") {

            $compras=$compras->where('created_at', ">" , $request->fecha_inicio);
        }

        if ($request->fecha_fin != "") {

            $compras=$compras->where('created_at', "<", $request->fecha_fin);
        }

        if ($request->fecha_inicio != "" && $request->fecha_fin != "") {

            $compras=$compras->where('created_at', ">" , $request->fecha_inicio)->where('created_at', "<", $request->fecha_fin);
        }

        
        return Datatables::of($compras)
            ->editColumn('doc_tipo_compra_id', function ($item) {
                return $item->doc_tipo_compra->nombre;
            })
            ->editColumn('is_pagado', function ($item) {
                if($item->is_pagado == "1")
                    return "Pagado";
                else
                    return "No pagado";
            })
            ->editColumn('id', 'Compra N°: {{$id}}')
            ->make(true);
    }

    




   




}


