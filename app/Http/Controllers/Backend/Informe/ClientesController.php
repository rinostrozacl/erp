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
use App\Models\Movimiento;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use Carbon\Carbon;

/**
 * Class DashboardController.
 */
class ClientesController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.informe.cliente.index');
    }

    public function getEdit($id=0)
    {
        $cliente = Cliente::find($id);
        return view('backend.informe.cliente.list')->with('cliente', $cliente);
    }


    public function getTabla(Request $request)
    {
        $clientes = Cliente::all();
        
        return Datatables::of($clientes)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.informe.cliente.form',$item->id).'"  target="_blank" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Ver registros</a> ';
                return $bt;
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function getTablaVenta($id=0, Request $request)
    {
        $ventas = Venta::where('cliente_id', $id);

        if ($request->fecha_inicio != "") {

            $ventas=$ventas->where('created_at', ">" , $request->fecha_inicio);
        }

        if ($request->fecha_fin != "") {

            $ventas=$ventas->where('created_at', "<", $request->fecha_fin);
        }

        if ($request->fecha_inicio != "" && $request->fecha_fin != "") {

            $ventas=$ventas->where('created_at', ">" , $request->fecha_inicio)->where('created_at', "<", $request->fecha_fin);
        }

        
        return Datatables::of($ventas)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.caja.venta.imprimir',$item->id).'"  target="_blank" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Ver Documento</a> ';
                return $bt;
            })
            ->editColumn('venta_estado_id', function ($item) {
                return $item->venta_estado->nombre;
            })
            ->editColumn('iva', function ($item) {
                $resultado = "";
                $fecha_venta = new Carbon($item->created_at);
                $ahora = Carbon::now();
                if($item->pendiente_pago == 0){
                    $resultado = "No aplica";
                }
                else{
                    $diferencia = ($fecha_venta->diff($ahora)->days);
                    $resultado = $diferencia;
                }
                
                return $resultado;
                    
            })
            ->editColumn('id', 'Venta N°: {{$id}}')
            ->make(true);
    }

    




   




}


