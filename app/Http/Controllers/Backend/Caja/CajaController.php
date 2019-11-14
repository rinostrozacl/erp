<?php

namespace App\Http\Controllers\Backend\Caja;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Producto;
use App\Models\Marca;
use App\Models\Ubicacion;
use App\Models\ProductoUbicacion;
use App\Models\UnidadMedida;
use App\Models\Linea;
use App\Models\Venta;
use App\Models\CierreCaja;
use App\Models\PagoTipo;;
use App\Models\VentaPagoTipo;
use Illuminate\Http\Request;

use PDF;

use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class CajaController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.bodega.producto.index');
    }

    public function cambioTurno()
    {
        $ventas_pago = VentaPagoTipo::where('is_rendido',0)->where('user_id',Auth::user()->id)->get();
       //Cliente::all();
       //dd($ventas);
        return view('backend.caja.generar-cierre')
            ->with("ventas_pago", $ventas_pago);
    }
    public function cambioTurnoGuardar(Request $request)
    {
        $user_id = Auth::user()->id;
        $cierre_caja = new CierreCaja();
        $cierre_caja->user_id = Auth::user()->id;
        $cierre_caja->save();

        //$ventas = Venta::where('is_rendido',0)->get(); 
        $ventas = Venta::where('is_rendido',0)->where('sucursal_id',Auth::user()->sucursal_id)->get();

        //dd($ventas);

        $ventas->each(function ($venta) use ($cierre_caja,  $user_id) {
            //dd($venta->venta_pago_tipo);
            $pagos = $venta->venta_pago_tipo->where("user_id", $user_id);

            $pagos->each(function ($pago) use ($cierre_caja,  $user_id) {

                $pago->cierre_caja_id = $cierre_caja->id;
                $pago->is_rendido = 1;
                $pago->save();
            });

          
            
        });


        $ventas2 = Venta::where('is_rendido',0)->where('sucursal_id',Auth::user()->sucursal_id)->get();

        $ventas2->each(function ($venta) use ($cierre_caja,  $user_id) {
            //dd($venta->venta_pago_tipo);
       
            if($venta->venta_pago_tipo->where("user_id", $user_id)->count() > 0){
                $pagos_pendiente = $venta->venta_pago_tipo->where("user_id", $user_id)->where("is_rendido",0)->count();

                if( $pagos_pendiente == 0 ){
                    $venta->cierre_caja_id = $cierre_caja->id;
                    $venta->is_rendido = 1;
                    $venta->save();
                }
            }
            
            
        });


       //Cliente::all();
        return  $cierre_caja->id;
    }


    public function imprimirCierre($id)
    {
        $ventas = Venta::where('cierre_caja_id',$id)->get();
        $cierre_caja = CierreCaja::find($id);

        $tipo= "cierre_caja";

        $timbre_fecha = date('Ymdhis', time());
        $nombre_archivo = $timbre_fecha ."_".$tipo."_". $id .".pdf";
        $data = ['ventas' => $ventas ,
            'titulo' => $nombre_archivo,
            'cierre_caja' => $cierre_caja];
        $pdf = PDF::loadView('backend/pdf/cierre', $data);

        return $pdf->stream($nombre_archivo);

    }


    public function getRendicion()
    {
        $cierres = CierreCaja::where('is_cerrado',0)->get();
       //Cliente::all();
        return view('backend.caja.realizar-cierre')
            ->with("cierres", $cierres);
    }



    public function rendicionCerrar(Request $request)
    {
        $cierre = CierreCaja::find($request->cierre_id);
        $cierre->is_cerrado = 1;
        $cierre->save();
       //Cliente::all();
      //  return view('backend.caja.realizar-cierre')
       //     ->with("cierres", $cierres);
    }


    public function recibirPago()
    {
        $ventas = Venta::where('is_pagado',0)->where('sucursal_id',Auth::user()->sucursal_id)->orderBy("id", "desc")->get();
        //dd($ventas);
        return view('backend.caja.recibir-pago')
            ->with("ventas", $ventas);
    }



    

    public function recibirPagoPagar($id)
    {
        $venta = Venta::find($id); 
        $pago_tipos = PagoTipo::where('activo',1)->get();

        return view('backend.caja.recibir-pago-detalle')
        ->with("venta", $venta)
        ->with('pago_tipos',$pago_tipos);

    }

     


    

    public function recibirPagoPagarProcesar(Request $request)
    {

        $respuesta["correcto"]=0;
        $respuesta["imprimir"]=0;
        $respuesta["venta_id"]=0;

      

            //$impresora_bodega = Impresora::find(Auth::user()->sucursal->impresora_id);

            $venta = Venta::find($request->venta_id);
            $venta->pagado =  $venta->pagado + $request->pagado;
            $venta->pendiente_pago = $request->pendiente_pago;
            $venta->is_pagado = ($request->pendiente_pago == 0) ?  1: 0;
            $venta->venta_estado_id = 2;
            //$venta->user_id = Auth::user()->id; 
            //$venta->periodo_contable_id = PeriodoContable::where("is_activo",1)->first()->id;
            $venta->save();

            //Venta tipo pago 
            
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
                   /* $actualizar_venta = Venta::find($venta->id);
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
                      */  
                   

                }
            }
           
            //fin tipo pago

            $respuesta["venta_id"]=$venta->id;

            /*
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
            */

            $respuesta["mensaje"]="Registrado!";
            $respuesta["correcto"]=1;// camniado a 0 para debug




            $respuesta["imprimir"]=1;


            return  json_encode($respuesta);
        
       
    }



}


