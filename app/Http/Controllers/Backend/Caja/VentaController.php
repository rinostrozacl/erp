<?php

namespace App\Http\Controllers\Backend\Caja;


use App\Models\Impresion;
use App\Models\ImpresionDetalle;
use App\Models\Venta;
use App\Models\VentaPagoTipo;
use App\Models\PagoTipo;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Impresora;
use App\Models\Cliente;
use App\Models\Marca;
use App\Models\Ubicacion;
use App\Models\Sucursal;
use App\Models\Producto;
use App\Models\UnidadMedida;
use App\Models\Linea;
use App\Models\Familia;
use App\Models\PeriodoContable;
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
        $pago_tipos = PagoTipo::where('activo',1)->get();
        $marcas = Marca::where('activo',1)->get();
        $ubicacion = Ubicacion::where('activo',1)->where('is_inventariable',1)->get();
        $familias = Familia::where('activo',1)->where('linea_id',0)->get();
        $lineas = Linea::where('activo',1)->get();
        $clientes= DB::table('cliente')->select('id',DB::raw("CONCAT(rut,' => ',nombre) AS nombre"))
            ->get();


        //Cliente::all();
        return view('backend.caja.venta.index')
            ->with("clientes", $clientes)
            ->with('ubicacion',$ubicacion)
            ->with('lineas',$lineas)
            ->with('marcas',$marcas)
            ->with('familias',$familias)
            ->with('pago_tipos',$pago_tipos);
    }


    public function postTablaBusqueda()
    {
        $request= Request();
        $busqueda=$request['search']['value'];
        $busqueda_p=explode(" ", $busqueda);
        $array_b=array();
        foreach( $busqueda_p as $palabra ){
            if($palabra!= "" ){
                array_push($array_b , ['producto.nombre','like', "%$palabra%"]);
            }


        }
        //dd($array_b);

        //dd($array_b );
        //  ->where('goals.jurisdiction_id', '=', 9)
        $productos = DB::table('producto')
            ->join('marca', 'marca.id', '=', 'producto.marca_id')
            ->join('familia', 'familia.id', '=', 'producto.familia_id')
            ->join('unidad_medida', 'unidad_medida.id', '=', 'producto.unidad_medida_id')
            ->when($_GET['marca_id'], function ($query, $role) {
                return $query->where('producto.marca_id', '=', $_GET['marca_id']);
            })
            ->when($_GET['linea_id'], function ($query, $role) {
                return $query->where('familia.linea_id', '=', $_GET['linea_id']);
            })
            ->when($_GET['familia_id'], function ($query, $role) {
                return $query->where('producto.familia_id', '=', $_GET['familia_id']);
            })
            ->Where($array_b)
            ->where('producto.activo',1)
            ->limit(100)
            ->select('producto.id','producto.stock_disponible','producto.nombre',
                'producto.codigo_ean13', 'producto.codigo_erp', 'producto.descripcion',
                'producto.valor_neto_venta',
                'marca.nombre as marca', 'unidad_medida.nombre as unidad_medida')
            ->get();


        /* $productos = DB::table('producto')
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
            ->get();*/

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
            )->addColumn('stock', function ($item) {
                return  $item->stock_disponible ;
            })->addColumn('descuento', function ($item) {
                return  0 ;
            })->editColumn('nombre', function ($item) {
                return  $item->nombre  . ' '. ' <br> '  . $item->descripcion . "[".$item->codigo_erp."]" .
                    $item->descripcion . ' [' . $item->marca  . ']'. ' [' . $item->unidad_medida  . ']' ;
                    $item->descripcion . ' [' . $item->marca  . ']'. ' [' . $item->unidad_medida  . ']' ;
            })->addColumn('valor_total_venta', function ($item) {
                return round($item->valor_neto_venta*1.19);
            })->addColumn('valor_iva', function ($item) {
                return round($item->valor_neto_venta*0.19);
            })->addColumn('valor_neto_venta', function ($item) {
                //return floatval($item->valor_neto_venta );
                return '<div class="input-group">
                            <input class="form-control"  type="number"   id="valor_neto_'.$item->id.'" name="input2-group2"  value="'. $item->valor_neto_venta .'">
                            <span class="input-group-append">
                                <button class="btn btn-primary bt-guardar-precio btn-secondary" type="button"    data-producto_id="'.$item->id.'"> >> </button>
                            </span>
                        </div> ';
            })->rawColumns(['action','nombre','valor_neto_venta'])
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
        $respuesta["preventa"]=0;

        //dd($movimiento);
        $list_cantidad_vendida= $request->cantidad;
        $list_productos_id = $request->productos_id;
        $list_valor_neto = $request->valor_neto;
        $list_sub_total_neto = $request->sub_total_neto;
        $list_iva = $request->iva;
        $list_total = $request->total;
        $tipo_venta=0;

        if($request->cliente_id==0 && $request->cliente_nuevo == ""){
            $respuesta["mensaje"]="Debe seleccionar un cliente";
        }else if(count($list_cantidad_vendida) == 0){
            $respuesta["mensaje"]="Debe ingresar productos para venta o preventa";
        }else if(!$request->tipo_venta){
            $respuesta["mensaje"]="Debe seleccionar tipo de venta";
        }else{


            $impresora_bodega = Impresora::find(Auth::user()->sucursal->impresora_id);

            if($request->tipo_venta == 2 || $request->tipo_venta == 3 ||  $request->tipo_venta == 4   ){
                $tipo_venta=2;
            }else{
                $tipo_venta=$request->tipo_venta;
            }

            $venta = new Venta();


            $venta->venta_estado_id= $tipo_venta;
            if($request->cliente_nuevo != ""){
                $venta->cliente_id = $request->cliente_nuevo;
            }else{
                $venta->cliente_id = $request->cliente_id;
            }
            

            $venta->suma_neto = $request->total_subtotal_neto;
            $venta->iva = $request->total_iva;
            $venta->total = $request->total_total;
 
 
            if($tipo_venta == "6"){
                $venta->pagado = "0";
                $venta->pendiente_pago = $request->total_total;
                $respuesta["preventa"]=1;
            }else{
                $venta->pagado = $request->pagado;
                $venta->pendiente_pago = $request->pendiente_pago;
            }
 
            $venta->is_pagado = ($request->pendiente_pago == 0) ?  1: 0;
            $venta->user_id = Auth::user()->id;
            $venta->sucursal_id = Auth::user()->sucursal_id;
            $venta->periodo_contable_id = PeriodoContable::where("is_activo",1)->first()->id;
            $venta->save();

            //$2y$12$ShzXqI.b7N1mkNjr7kLcQuGD5MqGTBfnUBsugEU/kqPqnI83.VJsC
            //Venta tipo pago 

            if($tipo_venta != "6"){
            
                $comprobantes = $request->comprobantes;
                $pagos = $request->pagos;

                foreach ($pagos as $clave => $valor) {
                    if($valor != ""){
                        $venta_pago_tipo = new VentaPagoTipo();
                        $venta_pago_tipo->venta_id = $venta->id;
                        $venta_pago_tipo->pago_tipo_id = $clave;
                        $venta_pago_tipo->monto = $valor;
                        $venta_pago_tipo->user_id = Auth::user()->id;
                        if($clave == 1){
                            $venta_pago_tipo->comprobante = 0;
                        }else{
                            $venta_pago_tipo->comprobante = $comprobantes[$clave];
                        }
                        $venta_pago_tipo->save();

                        //actualizo la venta anterior, para añadir nro. de comprobantes y valores
                        $actualizar_venta = Venta::find($venta->id);
                        if($clave == 1){
                            $actualizar_venta->pago_efectivo = $valor;
                        }
                        elseif($clave == 2){
                            $actualizar_venta->pago_tarjeta = $valor;
                            $actualizar_venta->pago_tarjeta_nro = $comprobantes[$clave];
                        }
                        elseif($clave == 3){
                            $actualizar_venta->pago_transferencia = $valor;
                            $actualizar_venta->pago_transferencia_nro = $comprobantes[$clave];
                        }
                        elseif($clave == 4){
                            $actualizar_venta->pago_cheque = $valor;
                            $actualizar_venta->pago_cheque_nro = $comprobantes[$clave];
                        }
                        //se añade campo pago_cheque_nro en BD
                        else{
                            $actualizar_venta->pago_credito = $valor;
                        }

                        $actualizar_venta->save();
                            
                    

                    }
                }

            } //end si no es preventa
           
            //fin tipo pago

            $respuesta["venta_id"]=$venta->id;

            if($tipo_venta==2){
                $impresion = new Impresion();
                $impresion->nombre="Salida por venta: ". $venta->id;
                $impresion->save();
                $impresora_bodega->impresiones()->attach($impresion);
                $respuesta["imprimir"]=1;
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

        return $pdf->stream($nombre_archivo);

    }
    public function guardarPrecio(Request $request)
    {
        $producto = Producto::find($request->producto_id);
        $producto->valor_neto_venta= $request->valor_neto_venta;
        $producto->save();

        return 1;

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


