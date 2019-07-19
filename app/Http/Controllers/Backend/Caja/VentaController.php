<?php

namespace App\Http\Controllers\Backend\Caja;


use App\Models\Impresion;
use App\Models\ImpresionDetalle;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Impresora;
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
use Illuminate\Support\Facades\DB;
use PDF;
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
        //  ->where('goals.jurisdiction_id', '=', 9)
        $productos = DB::table('producto')
            ->join('marca', 'marca.id', '=', 'producto.marca_id')
            ->join('familia', 'familia.id', '=', 'producto.familia_id')
            ->join('linea', 'linea.id', '=', 'familia.linea_id')
            ->when($_GET['marca_id'], function ($query, $role) {
                return $query->where('producto.marca_id', '=', $_GET['marca_id']);
            })
            ->when($_GET['linea_id'], function ($query, $role) {
                return $query->where('familia.linea_id', '=', $_GET['linea_id']);
            })
            ->when($_GET['familia_id'], function ($query, $role) {
                return $query->where('producto.familia_id', '=', $_GET['familia_id']);
            })
            ->select('producto.*', 'marca.nombre as marca','familia.nombre as familia','linea.nombre as linea')
            ->get();

        return Datatables::of($productos)
            ->addColumn('action', function ($item) {
                $type_button =   $item->stock_disponible<=0 ? 'btn-secondary':"btn-primary";
                $bt='<div class="input-group">
                                    <input class="form-control"  type="number"   id="cantidad_'.$item->id.'" name="input2-group2"  value="1">
                                    <span class="input-group-append">
                                        <button class="btn btn-primary bt-agregar '. $type_button .'" type="button"    data-id="'.$item->id.'">+</button>
                                    </span>
                                </div> ';
                return $bt;
            })->editColumn('id', '{{$id}}'
            )->addColumn('codigo', function ($item) {
                return $item->codigo_ean13 . "[".$item->codigo_erp."]";
            })->addColumn('stock', function ($item) {
                return  $item->stock_disponible ;
            })->addColumn('descuento', function ($item) {
                return  0 ;
            })->addColumn('valor_total_venta', function ($item) {
                return round($item->valor_neto_venta*1.19);
            })->addColumn('valor_iva', function ($item) {
                return round($item->valor_neto_venta*0.19);
            })->addColumn('valor_neto_venta', function ($item) {
                return floatval($item->valor_neto_venta );
            })->rawColumns(['action'])
            ->make(true);


        /*
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
        */
    }



    public function guardarVenta(Request $request)
    {

        $respuesta["correcto"]=0;
        $respuesta["imprimir"]=0;
        $respuesta["venta_id"]=0;

        //dd($movimiento);
        $list_cantidad_vendida= $request->cantidad;
        $list_productos_id = $request->productos_id;
        $list_valor_neto = $request->valor_neto;
        $list_sub_total_neto = $request->sub_total_neto;
        $list_iva = $request->iva;
        $list_total = $request->total;
        $tipo_venta=0;


        if($request->cliente_id==0){
            $respuesta["mensaje"]="Debe selecciona un cliente";
        }else if(count($list_cantidad_vendida) == 0){
            $respuesta["mensaje"]="Debe ingresar productos para vender";
        }else{


            $impresora_bodega = Impresora::find(1);

            if($request->tipo_venta == 2 || $request->tipo_venta == 2 ||  $request->tipo_venta == 4   ){
                $tipo_venta=2;
            }else{
                $tipo_venta=$request->tipo_venta;
            }

            $venta = new Venta();
            $venta->venta_estado_id= $tipo_venta;
            $venta->cliente_id = $request->cliente_id;

            $venta->suma_neto = $request->total_subtotal_neto;
            $venta->iva = $request->total_iva;
            $venta->total = $request->total_total;
            $venta->pagado = $request->pagado;
            $venta->pendiente_pago = $request->pendiente_pago;
            $venta->pago_efectivo = $request->pago_efectivo;
            $venta->pago_tarjeta = $request->pago_tarjeta;
            $venta->pago_transferencia = $request->pago_transferencia;
            $venta->pago_credito = $request->pago_credito;
            $venta->user_id = Auth::user()->id;
            $venta->save();

            $respuesta["venta_id"]=$venta->id;

            if($tipo_venta==2){
                $impresion = new Impresion();
                $impresion->nombre="Salida por venta: ". $venta->id;
                $impresion->save();
                $impresora_bodega->impresiones()->attach($impresion);
            }
            foreach ($list_cantidad_vendida as $clave => $valor) {
                $venta_detalle= new VentaDetalle();
                $venta_detalle->valor_unitario = $list_valor_neto[$clave];
                $venta_detalle->cantidad_vendida = $list_cantidad_vendida[$clave];
                $venta_detalle->valor_neto = $list_sub_total_neto[$clave];
                $venta_detalle->valor_iva = $list_iva[$clave];
                $venta_detalle->valor_total = $list_total[$clave];
                $venta_detalle->venta_id = $venta->id;
                $venta_detalle->producto_id = $clave;
                $venta_detalle->save();

                $producto = Producto::find($clave);
                if($tipo_venta==2){
                    $impresion_detalle = new ImpresionDetalle();
                    $impresion_detalle->linea =  $list_cantidad_vendida[$clave] . "/". $producto->stock_disponible ."|" . $venta_detalle->producto->nombre;
                    $impresion_detalle->impresion_id = $impresion->id;
                    $impresion_detalle->save();

                }
            }


            $respuesta["mensaje"]="Registrado!";
            $respuesta["correcto"]=1;// camniado a 0 para debug



            
                $respuesta["imprimir"]=1;



        }



        return  json_encode($respuesta);
    }

    public function imprimirVenta($id)
    {
        $venta = Venta::find($id);
        $tipo= ($venta->venta_estado_id == 1)? "cotizacion":"venta";

        $timbre_fecha = date('Ymdhis', time());
        $nombre_archivo = $timbre_fecha ."_".$tipo."_". $id .".pdf";
        $data = ['titulo' => $nombre_archivo,
            'venta' => $venta ];
        $pdf = PDF::loadView('backend/pdf/venta', $data);

        return $pdf->download($nombre_archivo);

    }
    public function verVenta($id)
    {
        $nombre_archivo ="venta_". $id .".pdf";
        $venta = Venta::find($id);
        $data = ['titulo' => $nombre_archivo,
            'venta' => $venta ];
        return view('backend/pdf/venta', $data);


    }
}


