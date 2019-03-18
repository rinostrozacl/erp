<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Compra;
use App\Models\DocTipoCompra;
use App\Models\Movimiento;
use App\Models\MovimientoTipo;
use App\Models\Producto;

use App\Models\ProductoUbicacion;
use App\Models\Proveedor;
use App\Models\Ubicacion;
use Illuminate\Http\Request;

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
        $bag['tipo_movimiento']= MovimientoTipo::all();
        $bag['tipo_doc']= DocTipoCompra::all();
        $bag['proveedor']= Proveedor::all();
        $bag['ubicacion']= Ubicacion::all();

        return view('backend.bodega.entrada', ['bag' => $bag]);

    }

    public function entrada_item(Request $request)
    {

        //$request->session()->flush();

        $producto = Producto::where("codigo_ean13", $request->codigoproducto)->first();

        if(!$request->session()->exists("total")){
            $request->session()->put("total", 0);
        }


        if ($producto) {

            $respuesta['item'] = $producto;

            $total = $request->session()->get('total');
            $request->session()->put("total", $total+1);

            if ($request->session()->exists($producto->id)) { //si el producto ya fue escaneado
               $cantidad_producto = $request->session()->get($producto->id);
                $cantidad_producto += 1;
                $request->session()->put($producto->id, $cantidad_producto);
                $respuesta["correcto"] = 2; //indicativo que debo sumar en la vista
                $respuesta["producto_id"]= $producto->id;



                //dd("Existe en tabla");

            } else { //el producto no fue escaneado, genero un nuevo registro con un valor 1 por defecto

                //dd("No existe ._.");
                $request->session()->put($producto->id, '1');
                $respuesta["tr"] = '
                   <tr>
                        <td>' . $producto->codigo_ean13 . ' <input type="hidden"  id="productos_id" name="productos_id['.$producto->id.']" value="' . $producto->id . '" /> </td>
                        <td>' . $producto->nombre . '  </td>
                        <td>' . $producto->familia->nombre . '</td>
                        <td>' . $producto->familia->linea->nombre . '</td>
                        <td><input class="form-control" id="cantidad" type="text" name="cantidad['.$producto->id.']" value="1"></td>
                        <td><button type="button" class="btn btn-danger btEliminar"  >Eliminar</button> </td>
                   </tr>
               ';
                $respuesta["correcto"] = 1;
            }//else
        } else {
            $respuesta["mensaje"] = "No se ha encontrado el producto";
            $respuesta["correcto"] = 0;
        }//else

        return json_encode($respuesta);

    }
    public function nuevoMovimiento(Request $request)
    {

        $respuesta["correcto"]=0;
        $movimiento = new Movimiento();
        $movimiento->cantidad = $request->session()->get('total');

        $movimiento->user_id = Auth::id();

        $cantidades = $request->cantidad;

        if($request->select_movimiento == 1){ //entrada

            //al ser entrada, se procesa una compra
            //se suma stock disponible en producto

            //$origen = $request->origen_entrada;
            //$destino = $request->destino_entrada;


            $movimiento->movimiento_tipo_id = 1;
            $movimiento->ubicacion_origen_id = 1;
            $movimiento->ubicacion_destino_id = 2;
            $movimiento->save();

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
            $compra->movimiento_id = 1;
            $compra->doc_tipo_compra_id = $request->select_tipo_documento;
            $compra->nro_documento = $request->nro_documento;
             $compra->save();



            foreach ($request->productos_id as $clave => $valor) {

                $producto = Producto::find($valor)->first();
                $stock_disponible = $producto->stock_disponible;
                $producto->stock_disponible = $stock_disponible + $cantidades[$clave]; //stock total en producto
                $producto->save();

                $stock_ubicacion = ProductoUbicacion::where("producto_id", $valor)->first();
                $stock = $stock_ubicacion->stock_disponible;
                $stock_ubicacion->stock_disponible = $stock + $cantidades[$clave]; //stock puntual en una ubicación
               $stock_ubicacion->save();


                $producto_ubicacion= ProductoUbicacion::where("ubicacion_id", $request->destino_entrada)->first();

                if(!$producto_ubicacion){
                    $producto_ubicacion = new ProductoUbicacion();
                }

                $producto_ubicacion->producto_id=$valor;
                $producto_ubicacion->ubicacion_id= $movimiento->ubicacion_destino_id;
                $producto_ubicacion->stock_disponible= $stock_ubicacion->stock_disponible;
                $producto_ubicacion->save();
            }

        }elseif ($request->select_movimiento == 2){ //traslado

            //se resta de origen y se suma a destino
            $movimiento->movimiento_tipo_id = 2;
            $movimiento->ubicacion_origen_id = $request->origen_traslado;
            $movimiento->ubicacion_destino_id = $request->destino_traslado;

            $movimiento->save();

            foreach ($request->productos_id as $clave => $valor) {

                $stock_origen = ProductoUbicacion::where("ubicacion_id", $request->origen_traslado)->where("producto_id", $valor)->first();
                $stock_origen_disponible = $stock_origen->stock_disponible;
                $stock_origen->stock_disponible = $stock_origen_disponible - $cantidades[$clave]; //stock puntual en una ubicación
                 $stock_origen->save();

                $stock_destino = ProductoUbicacion::where("ubicacion_id", $request->destino_traslado)->where("producto_id", $valor)->first();
                $stock_destino_disponible = $stock_destino->stock_disponible;
                $stock_destino->stock_disponible = $stock_destino_disponible + $cantidades[$clave]; //stock puntual en una ubicación
                 $stock_destino->save();

            }



        }else{ //salida
            //se resta stock disponible

            $movimiento->movimiento_tipo_id = 3;
            $movimiento->ubicacion_origen_id = $request->origen_salida;
            $movimiento->ubicacion_destino_id = $request->destino_salida;

            foreach ($request->productos_id as $clave => $valor) {

                $stock_origen = ProductoUbicacion::where("ubicacion_id", $request->origen_salida)->where("producto_id", $valor)->first();
                $stock_disponible = $stock_origen->stock_disponible;
                $stock_origen->stock_disponible = $stock_disponible - $cantidades[$clave]; //stock puntual en una ubicación
                $stock_origen->save();

            }

            if($destino == 6 || $destino == 7){
                $respuesta["salidas"] = "Producto utilizado en OT o Merma. Por programar";
            }



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


