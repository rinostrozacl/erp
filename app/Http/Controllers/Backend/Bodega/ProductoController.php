<?php

namespace App\Http\Controllers\Backend\Bodega;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Producto;
use App\Models\Marca;
use App\Models\Ubicacion;
use App\Models\ProductoUbicacion;
use App\Models\UnidadMedida;
use App\Models\Linea;
use App\Models\Familia;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use Illuminate\Support\Facades\DB;

/**
 * Class DashboardController.
 */
class ProductoController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.bodega.producto.index');
    }
    public function getTabla()
    {
        //$productos = Producto::all();


        $productos = DB::table('producto')
            ->join('marca', 'marca.id', '=', 'producto.marca_id')
            ->join('familia', 'familia.id', '=', 'producto.familia_id')
            ->join('linea', 'linea.id', '=', 'familia.linea_id')
            ->select('producto.*', 'marca.nombre as marca','familia.nombre as familia','linea.nombre as linea')
            ->where('producto.activo',1)
            ->get();


        return Datatables::of($productos)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.bodega.producto.form',$item->id).'" class="btn btn-sm btn-block btn-success"><i class="glyphicon glyphicon-edit"></i> Editar</a> ';
                $bt.='<button  class="btn btn-sm  btn-block btn-danger bt-eliminar" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit"></i><span> Eliminar</span></button> ';
                if($item->activo==1){
                    $bt.='<button class="btn btn-sm btn-block btn-primary  bt-desactivar" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit" ></i><span>  Desactivar</span></button> ';
                }else{
                    $bt.='<button class="btn btn-sm btn-block btn-secondary bt-desactivar" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit" ></i><span>  Activar</span></button> ';
                }
                if($item->is_fungible==1){
                    $bt.='<button class="btn btn-sm btn-block btn-primary  bt-desactivar_f" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit" ></i><span>  Desactivar Fungible</span></button> ';
                }else{
                    $bt.='<button class="btn btn-sm btn-block btn-secondary bt-desactivar_f" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit" ></i><span>  Activar Fungible</span></button> ';
                }
                return $bt;
            })->editColumn('id', '{{$id}}'
            )->addColumn('stock', function ($item) {
                $bt=$item->stock_disponible . ' / ' .$item->stock_critico ;
                return $bt;
            })->addColumn('details_url', function($item) {
                return route('admin.bodega.producto.tabla.detalle' , $item->id);
            }) ->addColumn('detalles', function ($item) {
                $bt='<button class="btn btn-sm btn-block btn-primary bt-stock" data-id="'.$item->id.'">Stock</button> ';
                return $bt;
            })->rawColumns(['detalles','action'])
            ->make(true);
    }

    public function getDetailsData($id)
    {
        $detalle = ProductoUbicacion::where('producto_id',$id);

        return Datatables::of($detalle)
            ->addColumn('ubicacion', function ($item) {
            return $item->ubicacion->nombre;
            })->addColumn('direccion', function ($item) {
                return $item->ubicacion->direccion;
            })->make(true);
    }


    public function getForm($id=0)
    {
        if($id>0){
            $producto = Producto::find($id);
        }else{
            $producto = new Producto();
        }

        $unidad_medidas = UnidadMedida::where('activo',1)->get();
        $marcas = Marca::where('activo',1)->get();
        $lineas = Linea::where('activo',1)->get();
        if($id>0){
            $familias = Familia::where('activo',1)->where('linea_id',$producto->familia->linea_id)->get();
        }else{
            $familias = Familia::where('activo',1)->get();
        }


        return view('backend.bodega.producto.form')
            ->with('producto',$producto)
            ->with('unidad_medidas',$unidad_medidas)
            ->with('lineas',$lineas)
            ->with('marcas',$marcas)
            ->with('familias',$familias);;
    }




    public function postUpdate(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'nombre' => 'required'
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
            if($request->marca_id==0){
                return response()->json(['estado'=>0,'mensaje'=>"Debe seleccionar marca"]);
            }else if($request->familia_id==0){
                return response()->json(['estado'=>0,'mensaje'=>"Debe seleccionar familia"]);
            }else if($request->unidad_medida_id==0){
                return response()->json(['estado'=>0,'mensaje'=>"Debe seleccionar Unidad de medida"]);
            }else{

                if($request->id>0){
                    $producto = Producto::findOrFail($request->id);
                    $msg='Registro modificado';
                }else{
                    $producto = new Producto();
                    $msg='Registro Ingresado';
                }
    
                $producto->nombre=$request->nombre;
                $producto->codigo_ean13=$request->codigo_ean13;
                $producto->codigo_erp=$request->codigo_erp;
                $producto->descripcion=$request->descripcion;
                $producto->unidad_medida_id=$request->unidad_medida_id;
                $producto->familia_id=$request->familia_id;
                $producto->marca_id=$request->marca_id;
                $producto->valor_neto_venta = str_replace(",", ".", $request->valor_neto_venta);
    
                $activo=($request->activo==1)? 1:0;
                $producto->activo=$activo;
                $producto->save();
                return response()->json(['estado'=>1,'mensaje'=>$msg]);
            }

            

        }
    }

    public function postActivar(Request $request)
    {
        $resp=[];
        $producto = Producto::findOrFail($request->id);
        $resp['estado']=0;
        if($producto->activo==1){
            $producto->activo=0;
            $resp['msg']="Se ha desactivado";
            $resp['estado']=1;
        }else{
            $producto->activo=1;
            $resp['msg']="Se ha activado";
            $resp['estado']=1;
        }
        $producto->save();
        return $resp;
    }



    public function postActivarFun(Request $request)
    {
        $resp=[];
        $producto = Producto::findOrFail($request->id);
        $resp['estado']=0;
        if($producto->is_fungible==1){
            $producto->is_fungible=0;
            $resp['msg']="Se ha desactivado";
            $resp['estado']=1;
        }else{
            $producto->is_fungible=1;
            $resp['msg']="Se ha activado";
            $resp['estado']=1;
        }
        $producto->save();
        return $resp;
    }



    public function postEliminar(Request $request)
    {
        $resp=[];
        $producto = Producto::findOrFail($request->id);
        $producto->delete();
        $resp['msg']="Registro eliminado";
        $resp['estado']=1;
        $producto->save();
        return $resp;
    }
}


