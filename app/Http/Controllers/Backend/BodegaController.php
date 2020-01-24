<?php

namespace App\Http\Controllers\Backend;


use App\Models\Unidad;
use App\Models\UnidadMovimiento;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Compra;
use App\Models\DocTipoCompra;
use App\Models\Movimiento;
use App\Models\MovimientoTipo;
use App\Models\Producto;
use App\Models\Ubicacion;

use App\Models\ProductoUbicacion;
use App\Models\VentaDetalle;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Models\System\Session;

/**
 * Class DashboardController.
 */
class BodegaController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function producto_index()
    {

        return view('backend.bodega.lista');
    }
    public function entrada_index()
    {
        $bag=[];
        if(Auth::user()->is_entrega_global== 1){
            $bag['tipos_movimiento']= MovimientoTipo::all();
        }else if(Auth::user()->is_entrega== 1){
            $bag['tipos_movimiento']= MovimientoTipo::where("is_venta",1)->get();
        }

      


        $bag['doc_tipo_compra']= DocTipoCompra::all();
        $bag['proveedor']= Proveedor::all();


        
        $ventas =Venta::with('user')->where("venta_estado_id",2)->orWhere("venta_estado_id",4)->orderBy('id', 'desc')->get();

        $mermas =Venta::with('user')->where("venta_estado_id",7)->orderBy('id', 'desc')->get();


        if(Auth::user()->is_entrega_global== 1){
           
          
            $bag['ventas'] = $ventas
                                ->where("user.sucursal_id",Auth::user()->sucursal_id)
                                ->where("is_entregado",0);
           $bag['mermas'] = $mermas;

        }else if(Auth::user()->is_entrega== 1){
             
            $bag['ventas'] = $ventas
                                ->where("user.sucursal_id",Auth::user()->sucursal_id)
                                ->where("is_entregado",0)
                                ->where("user_id",Auth::user()->id);
            //dd($bag['ventas'] );
            $bag['mermas'] = [];

        }


        
        

        //dd($request);
        return view('backend.bodega.entrada', ['bag' => $bag]);

    }

    public function entrada_item(Request $request)
    {
        if ( $request->codigoproducto){
            $producto = Producto::where("codigo_ean13", $request->codigoproducto)->first();
        }else if($request->producto_id_add){
            $producto = Producto::find($request->producto_id_add);
        }
        $cantidad_producto_add = $request->cantidad_producto_add;
        if ($producto) {
            $respuesta['item'] = $producto;
            $respuesta['producto_id'] = $producto->id;
            $respuesta['cantidad'] = $cantidad_producto_add;
                $respuesta["tr"] = '
                   <tr>
                        <td>' . $producto->codigo_ean13 . ' <input type="hidden"  id="productos_id_' . $producto->id . '" name="productos_id['.$producto->id.']" value="' . $producto->id . '" /> </td>
                        <td>' . $producto->nombre . '  </td>
                        <td>' . $producto->familia->nombre . '</td>
                        <td>' . $producto->familia->linea->nombre . '</td>
                        <td><input class="form-control" id="cantidad" type="text" name="cantidad['.$producto->id.']" value="'.$cantidad_producto_add.'"></td>
                        <td><input class="form-control" id="valor_neto_compra" type="text" name="valor_neto_compra['.$producto->id.']" value="0"></td>
                        <td><button class="btn btn-danger bt-eliminar" data-producto_id="'.$producto->id.'"> [X] </button></td>
                   </tr>
               ';
                $respuesta["correcto"] = 1;
        } else {
            $respuesta["mensaje"] = "No se ha encontrado el producto";
            $respuesta["correcto"] = 0;
        }//else
        return json_encode($respuesta);

    }




    public function nuevoMovimiento(Request $request)
    {


        $respuesta["correcto"]=0;



       if($request->movimiento_tipo_id==1 || $request->movimiento_tipo_id==3 || $request->movimiento_tipo_id==4){
            // Registra el movimiento
            $movimiento = new Movimiento();
            $movimiento->cantidad =  count($request->productos_id);
            $movimiento->user_id = Auth::id();
            $movimiento->movimiento_tipo_id = $request->movimiento_tipo_id;
            $movimiento->ubicacion_origen_id = $request->ubicacion_origen_id;
            $movimiento->ubicacion_destino_id = $request->ubicacion_destino_id;
            $movimiento->save();
       }
        

        if($request->ubicacion_destino_id == 7){
            $venta_id =$request->merma_venta_id;
        }else{
            $venta_id =$request->venta_id;
        }
        


        //dd($movimiento);
        $list_cantidades= $request->cantidad;
        $list_productos_id = $request->productos_id;
        $list_valor_neto_compra = $request->valor_neto_compra;

            if($request->movimiento_tipo_id==1){ // compra productos
                foreach ($list_productos_id as $clave => $valor) {

                    $producto = Producto::find($valor);
                    if($producto->is_fungible==0){
                        for ($i = 1; $i <= $list_cantidades[$clave]; $i++) {
                            $unidad = new Unidad();
                            $unidad->ubicacion_id = $request->ubicacion_destino_id;
                            $unidad->producto_id = $valor;
                            $unidad->valor_neto_venta = 0;
                            $unidad->valor_neto_compra = $list_valor_neto_compra[$clave];
                            $unidad->save();

                            $unidad_movimiento = new UnidadMovimiento();
                            $unidad_movimiento->movimiento_id= $movimiento->id;
                            $unidad_movimiento->unidad_id= $unidad->id;
                            $unidad_movimiento->save();
                        }
                    }
                    

                    
                    $producto->stock_disponible=$producto->stock_disponible + $list_cantidades[$clave];
                    $producto->save();

                    $producto_ubicacion = ProductoUbicacion::where("producto_id",$producto->id)->where("ubicacion_id",$request->ubicacion_destino_id)->first();
                    if(!$producto_ubicacion){
                        $producto_ubicacion = new ProductoUbicacion();
                        $producto_ubicacion->producto_id = $producto->id;
                        $producto_ubicacion->ubicacion_id =  $request->ubicacion_destino_id;
                        $producto_ubicacion->stock_disponible=0;

                    }
                    //dd($producto_ubicacion);
                    $producto_ubicacion->stock_disponible =  $producto_ubicacion->stock_disponible + $list_cantidades[$clave];
                    $producto_ubicacion->save();

                }




                $compra = new Compra();
                $compra->proveedor_id = $request->proveedor_id;
                $compra->valor_neto = $request->compra_valor_neto;
                $compra->valor_iva = $request->compra_valor_neto * 0.19;
                $compra->valor_total = $request->compra_valor_neto * 1.19;
                $compra->is_pagado = isset($request->is_pagado)? 1:0;
                $compra->movimiento_id = $movimiento->id;
                $compra->doc_tipo_compra_id = $request->doc_tipo_compra_id;
                $compra->nro_documento = $request->nro_documento;
                $compra->save();

            } else if($request->movimiento_tipo_id==2){ //salida traslado

                $venta = Venta::find($request->salida_venta_id);
                $venta->sucursal_id2 =  $request->ubicacion_destino_id;
                $venta->venta_estado_id = 9;
                $venta->save();
                 
                 
            } else if($request->movimiento_tipo_id==3){ //salida cliente
                $list_productos_entregado_id = $request->entregado;
                foreach ($list_productos_entregado_id as $clave => $valor) {
                    //if(is_entregado)
                    $producto = Producto::find($valor);
                    if($producto->stock_disponible>=$list_cantidades[$clave]){
                        if($producto->is_fungible==0){

                            for ($i = 1; $i <= $list_cantidades[$clave]; $i++) {
                                $unidad = Unidad::where('is_vendido',0)->where('producto_id',$valor)->where('ubicacion_id',$request->ubicacion_origen_id)->first();
                                $unidad->ubicacion_id = $request->ubicacion_destino_id;
                                $unidad->is_vendido = 1;
                                $unidad->save();

                                $unidad_movimiento = new UnidadMovimiento();
                                $unidad_movimiento->movimiento_id= $movimiento->id;
                                $unidad_movimiento->unidad_id= $unidad->id;
                                $unidad_movimiento->save();
                            }
                        }
                        $producto->stock_disponible=$producto->stock_disponible  - $list_cantidades[$clave];

                        $p_u = ProductoUbicacion::where('producto_id',$producto->id)->where('ubicacion_id',$request->ubicacion_origen_id)->first();
                        $p_u->stock_disponible=$p_u->stock_disponible  - $list_cantidades[$clave];
                        $p_u->save();

                    }
                    $producto->save();
                }
                $venta = Venta::find($venta_id);

                //dd($list_productos_entregado_id);
                // deja como entregado los productos
                foreach($list_productos_entregado_id as $producto_id ){
                
                    $detalle= VentaDetalle::where("venta_id", $venta->id)->where("producto_id", $producto_id)->first();
                    $detalle->is_entregado = 1; 
                    $detalle->save();
                }

                if (!$request->ubicacion_destino_id == 4 ){

                    if(count($list_productos_entregado_id) == $venta->venta_detalle->count()){
                        $venta->venta_estado_id = 3;
                    }else{
                        $detalle_buscar= VentaDetalle::where("venta_id", $venta->id)->where("is_entregado", 0)->first();
                        if(!$detalle_buscar){
                            $venta->venta_estado_id = 3;
                        }else{
                            $venta->venta_estado_id = 4;
                        } 
                    }
                }
                $venta->movimiento_id=$movimiento->id;
                $venta->save();
            } else if($request->movimiento_tipo_id==4){ //Entrada traslado
                //TODO Entrada traslado


                $venta = Venta::find($request->entrada_venta_id); 
                $venta->venta_estado_id = 10;
                $venta->save();

                foreach ($list_productos_id as $clave => $valor) {

                    
                    $producto = Producto::find($valor);
                    $producto_ubicacion = ProductoUbicacion::where("producto_id",$producto->id)->where("ubicacion_id",$request->ubicacion_destino_id)->first();
                    if(!$producto_ubicacion){
                        $producto_ubicacion = new ProductoUbicacion();
                        $producto_ubicacion->producto_id = $producto->id;
                        $producto_ubicacion->ubicacion_id =  $request->ubicacion_destino_id;
                        $producto_ubicacion->stock_disponible=0;

                    }
                    //dd($producto_ubicacion);
                    $producto_ubicacion->stock_disponible =  $producto_ubicacion->stock_disponible + $list_cantidades[$clave];
                    $producto_ubicacion->save();



                    $p_u = ProductoUbicacion::where('producto_id',$producto->id)->where('ubicacion_id',$request->ubicacion_origen_id)->first();
                    $p_u->stock_disponible=$p_u->stock_disponible  - $list_cantidades[$clave];
                    $p_u->save();


                }

            }else{


            }

         $respuesta["correcto"]=1;




        return  json_encode($respuesta);
    }

    public function salida_index()
    {
        return view('backend.bodega.lista');
    }
    public function inventario_index()
    {
        return view('backend.bodega.lista');
    }
}


