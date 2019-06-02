<?php

namespace App\Http\Controllers\Backend;


use App\Models\Unidad;
use App\Models\UnidadMovimiento;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Compra;
use App\Models\DocTipoCompra;
use App\Models\Movimiento;
use App\Models\MovimientoTipo;
use App\Models\Producto;
use App\Models\Ubicacion;

use App\Models\ProductoUbicacion;
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
        $bag['tipos_movimiento']= MovimientoTipo::all();
        $bag['tipo_doc']= DocTipoCompra::all();
        $bag['proveedor']= Proveedor::all();





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




        // Registra el movimiento
        $movimiento = new Movimiento();
        $movimiento->cantidad = $request->total_productos;
        $movimiento->user_id = Auth::id();
        $movimiento->movimiento_tipo_id = $request->movimiento_tipo_id;
        $movimiento->ubicacion_origen_id = $request->ubicacion_origen_id;
        $movimiento->ubicacion_destino_id = $request->ubicacion_destino_id;
        $movimiento->save();

        //dd($movimiento);
        $list_cantidades= $request->cantidad;
        $list_productos_id = $request->productos_id;
        $list_valor_neto_compra = $request->valor_neto_compra;
        foreach ($list_productos_id as $clave => $valor) {

            if($request->movimiento_tipo_id==1){ // compra productos
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

                $producto = Producto::find($valor);
                $producto->stock_disponible=$producto->stock_disponible+$list_cantidades[$clave];
                $producto->save();
            } else if($request->movimiento_tipo_id==2){ //salida traslado
                //TODO Salida traslado
            } else if($request->movimiento_tipo_id==3){ //salida cliente
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

                $producto = Producto::find($valor);
                $producto->stock_disponible=$producto->stock_disponible  - $list_cantidades[$clave];
                $producto->save();
            } else if($request->movimiento_tipo_id==2){ //Entrada traslado
                //TODO Salida traslado
            }




            /* $stock_origen = ProductoUbicacion::where("ubicacion_id", $request->origen_traslado)->where("producto_id", $valor)->first();
             $stock_origen->stock_disponible = $stock_origen->stock_disponible - $cantidades[$clave]; //stock puntual en una ubicación
             $stock_origen->save();

             $stock_destino = ProductoUbicacion::where("ubicacion_id", $request->destino_traslado)->where("producto_id", $valor)->first();
             $stock_destino->stock_disponible = $stock_destino->stock_disponible + $cantidades[$clave]; //stock puntual en una ubicación
             $stock_destino->save();
            */

        }



        /*
        if($request->select_movimiento == 1){ //entrada

            //al ser entrada, se procesa una compra
            //se suma stock disponible en producto

            $compra = new Compra();
            $compra->proveedor_id = $request->select_proveedor;
            $compra->valor_neto = $request->neto;
            $compra->valor_iva = $request->iva;
            $compra->valor_total = $request->total;
            if (isset($request->is_pagado)) {
               $is_pagado = 1;
            }else{
                $is_pagado = 0;
            }
            $compra->is_pagado = $is_pagado;
            $compra->movimiento_id = $movimiento->id;
            $compra->doc_tipo_compra_id = $request->select_tipo_documento;
            $compra->nro_documento = $request->nro_documento;
             $compra->save();








        }






        /*elseif ($request->select_movimiento == 2){ //traslado

            //se resta de origen y se suma a destino
            $movimiento->movimiento_tipo_id = 2;
            $movimiento->ubicacion_origen_id = $request->origen_traslado;
            $movimiento->ubicacion_destino_id = $request->destino_traslado;

            $movimiento->save();

            foreach ($request->productos_id as $clave => $valor) {

                $stock_origen = ProductoUbicacion::where("ubicacion_id", $request->origen_traslado)->where("producto_id", $valor)->first();
                $stock_origen->stock_disponible = $stock_origen->stock_disponible - $cantidades[$clave]; //stock puntual en una ubicación
                $stock_origen->save();

                $stock_destino = ProductoUbicacion::where("ubicacion_id", $request->destino_traslado)->where("producto_id", $valor)->first();
                $stock_destino->stock_disponible = $stock_destino->stock_disponible + $cantidades[$clave]; //stock puntual en una ubicación
                $stock_destino->save();

            }



        }else{ //salida
            //se resta stock disponible

            $movimiento->movimiento_tipo_id = 3;
            $movimiento->ubicacion_origen_id = $request->origen_salida;
            $movimiento->ubicacion_destino_id = $request->destino_salida;

            foreach ($request->productos_id as $clave => $valor) {

                $stock_origen = ProductoUbicacion::where("ubicacion_id", $request->origen_salida)->where("producto_id", $valor)->first();
                $stock_origen->stock_disponible = $stock_origen->stock_disponible - $cantidades[$clave]; //stock puntual en una ubicación
                $stock_origen->save();

            }

            if($request->destino_salida == 6 || $request->destino_salida == 7){
                $respuesta["salidas"] = "Producto utilizado en OT o Merma. Por programar";
            }



        }

*/


       // $respuesta["correcto"]=1;


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


