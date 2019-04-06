<?php

namespace App\Http\Controllers\Backend\Bodega;



use App\Models\Unidad;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\Ubicacion;
use App\Models\InventarioSobrante;
use App\Models\ProductoUbicacion;
use App\Models\UnidadMedida;
use App\Models\Linea;
use App\Models\Familia;
use App\Models\InventarioUnidad;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class InventarioController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.bodega.inventario.index');
    }



    public function getTabla()
    {
        $inventario = Inventario::where('is_abierto',1)
            ->where('is_archivado',0)
            ->get();
        return Datatables::of($inventario)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.bodega.inventario.realizar',$item->id).'" class="btn btn-sm btn-block btn-success"><i class="glyphicon glyphicon-edit"></i> Ingresar</a> ';
                $bt.='<button class="btn btn-sm btn-block btn-secondary bt-cerrar" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit" ></i><span>  Cerrar</span></button> ';
                return $bt;
            })->editColumn('id', '{{$id}}'
            )->addColumn('familia', function ($item) {
                if($item->familia_id==0){
                    return 'Todos';
                }else{
                    return $item->familia->nombre;
                }
            })->addColumn('linea', function ($item) {
                if($item->linea_id==0){
                    return 'Todos';
                }else{
                    return $item->linea->nombre;
                }
            })->addColumn('usuario', function ($item) {
                    return $item->usuario->full_name;
            })->addColumn('producto', function ($item) {
                if($item->producto_id==0){
                    return 'Todos';
                }else{
                    return $item->producto->nombre;
                }
            })->addColumn('ubicacion', function ($item) {
                if($item->ubicacion_id==0){
                    return 'Todos';
                }else{
                    return $item->ubicacion->nombre;
                }
            })->rawColumns(['action'])
            ->make(true);
    }

    public function getTabla2()
    {
        $inventario = Inventario::where('is_abierto',0)
            ->where('is_archivado',0)
            ->get();
        return Datatables::of($inventario)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.bodega.inventario.resultado',$item->id).'" class="btn btn-sm btn-block btn-success"><i class="glyphicon glyphicon-edit"></i> Ver resultado</a> ';
                $bt.='<button class="btn btn-sm btn-block btn-secondary bt-archivar" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit" ></i><span>  Archivar</span></button> ';
                $bt.='<button class="btn btn-sm btn-block btn-primary  bt-cerrar" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit" ></i><span>  Abrir</span></button> ';
                return $bt;
            })->editColumn('id', '{{$id}}'
            )->addColumn('familia', function ($item) {
                if($item->familia_id==0){
                    return 'Todos';
                }else{
                    return $item->familia->nombre;
                }
            })->addColumn('linea', function ($item) {
                if($item->linea_id==0){
                    return 'Todos';
                }else{
                    return $item->linea->nombre;
                }
            })->addColumn('usuario', function ($item) {
                return $item->usuario->full_name;
            })->addColumn('producto', function ($item) {
                if($item->producto_id==0){
                    return 'Todos';
                }else{
                    return $item->producto->nombre;
                }
            })->addColumn('ubicacion', function ($item) {
                if($item->ubicacion_id==0){
                    return 'Todos';
                }else{
                    return $item->ubicacion->nombre;
                }
            })->rawColumns(['action'])
            ->make(true);
    }

    public function getTabla3()
    {
        $inventario = Inventario::where('is_archivado',1)->get();
        return Datatables::of($inventario)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.bodega.producto.form',$item->id).'" class="btn btn-sm btn-block btn-success"><i class="glyphicon glyphicon-edit"></i> Ver detalles</a> ';
                return $bt;
            })->editColumn('id', '{{$id}}'
            )->addColumn('familia', function ($item) {
                if($item->familia_id==0){
                    return 'Todos';
                }else{
                    return $item->familia->nombre;
                }
            })->addColumn('linea', function ($item) {
                if($item->linea_id==0){
                    return 'Todos';
                }else{
                    return $item->linea->nombre;
                }
            })->addColumn('usuario', function ($item) {
                return $item->usuario->full_name;
            })->addColumn('producto', function ($item) {
                if($item->producto_id==0){
                    return 'Todos';
                }else{
                    return $item->producto->nombre;
                }
            })->addColumn('ubicacion', function ($item) {
                if($item->ubicacion_id==0){
                    return 'Todos';
                }else{
                    return $item->ubicacion->nombre;
                }
            })->rawColumns(['action'])
            ->make(true);
    }

    public function postCerrar(Request $request)
    {
        $resp=[];
        $inventario = Inventario::findOrFail($request->id);
        $resp['estado']=0;
        if($inventario->is_abierto==1){
            $inventario->is_abierto=0;
            $resp['msg']="Inventario Cerrado";
            $resp['estado']=1;
        }else{
            $inventario->is_abierto=1;
            $resp['msg']="Inventario Abierto";
            $resp['estado']=1;
        }
        $inventario->save();
        return $resp;
    }

    public function postArchivar(Request $request)
    {
        $resp=[];
        $inventario = Inventario::findOrFail($request->id);
        $resp['estado']=0;
        $inventario->is_archivado=1;
        $resp['msg']="Inventario Archivado";
        $resp['estado']=1;
        $inventario->save();
        return $resp;
    }







    public function getFormNuevo()
    {

        $productos = Producto::where('activo',1)->get();
        $marcas = Marca::where('activo',1)->get();
        $ubicacion = Ubicacion::where('activo',1)->where('is_inventariable',1)->get();
        $familias = Familia::where('activo',1)->where('linea_id',0)->get();
        $lineas = Linea::where('activo',1)->get();


        return view('backend.bodega.inventario.form-nuevo')
            ->with('productos',$productos)
            ->with('ubicacion',$ubicacion)
            ->with('lineas',$lineas)
            ->with('marcas',$marcas)
            ->with('familias',$familias);;
    }





    public function postFormNuevo(Request $request)
    {

        $inventario = new Inventario();

        $inventario->familia_id=$request->familia_id;
        $inventario->linea_id=$request->linea_id;
        $inventario->producto_id=$request->producto_id;
        $inventario->ubicacion_id=$request->ubicacion_id;
        $inventario->is_abierto=1;
        $inventario->user_id=Auth::user()->id;
        $inventario->save();
        if($request->ubicacion_id==0){
            $unidades=Unidad::all();
        }else{
            $unidades=Unidad::where('ubicacion_id',$request->ubicacion_id)->get();
        }
        if($request->producto_id>0){
            $unidades=$unidades->where('producto_id',$request->producto_id);
        }
        if($request->familia_id>0){
            $unidades=$unidades->where('producto.familia_id',$request->familia_id);
        }
        if($request->linea_id>0){
            $unidades=$unidades->where('producto.familia.linea_id',$request->linea_id);
        }
        foreach ($unidades as $unidad) {
            $inventario_unidad= new InventarioUnidad();
            $inventario_unidad->unidad_id=$unidad->id;
            $inventario_unidad->inventario_id=$inventario->id;
            $inventario_unidad->existente=0;
            $inventario_unidad->save();
        }
        //dd($unidades);
        $msg='Registro Ingresado. ' .  $unidades->count() . ' unidades encontradas.';
        return response()->json(['estado'=>1,'mensaje'=>$msg]);
    }



    public function postFormRealizarCodigo(Request $request)
    {
        $msg='';
        $ingresados=0;
        $estado=0;

        if($request->valor==''){
            $msg='Debe Ingresar el codigo';
        }else if(Producto::where('codigo_ean13',$request->valor)->count()==0) {
            $msg='No existe el codigo de producto';
        }else{
            $producto= Producto::where('codigo_ean13',$request->valor)->first();
             $inventario_unidad= InventarioUnidad::where("existente",0)->get();
             $inventario_unidad=$inventario_unidad->where("unidad.producto_id",$producto->id);
             if($inventario_unidad->count()>0){
                 //faltante
                 $unidad= $inventario_unidad->first();
                 $unidad->existente=1;
                 $unidad->save();
             }else{
                $sobrante= new InventarioSobrante();
                 $sobrante->inventario_id=$request->id;
                 $sobrante->producto_id=$producto->id;
                 $sobrante->save();
                 //sobrante
             }
            $inventario = Inventario::find($request->id);
            $inventario->ingresados++;
            $inventario->save();
            $ingresados=$inventario->ingresados;

            $estado=1;
        }
        return response()->json(['estado'=>$estado,'mensaje'=>$msg,'ingresados'=>$ingresados]);
    }


    public function postFormRealizar(Request $request)
    {
        $msg='Inventario finalizado';
        $ingresados=0;
        $estado=1;
        $inventario = Inventario::find($request->inventario_id);
        $inventario->is_abierto=0;
        $inventario->save();

        return response()->json(['estado'=>$estado,'mensaje'=>$msg]);
    }

    public function getFormRealizar($id)
    {


        $inventario = Inventario::find($id);
        return view('backend.bodega.inventario.form-ingresar')
            ->with('inventario',$inventario);
    }
    public function getResultado($id)
    {


        $inventario = Inventario::find($id);
        return view('backend.bodega.inventario.resultado')
            ->with('inventario',$inventario);
    }


    public function getTabla4($id)
    {
        $inventario = InventarioUnidad::where('inventario_id',$id)->get();
        return Datatables::of($inventario)
           ->addColumn('producto', function ($item) {
                /*if($item->linea_id==0){
                    return 'Todos';
                }else{
                    return $item->linea->nombre;
                }*/
                return $item->unidad->producto->nombre . ' - ' . $item->unidad->producto->familia->nombre. ' - ' . $item->unidad->producto->familia->linea->nombre;
            })
            ->make(true);
    }
    public function getTabla5($id)
    {
        $inventario = InventarioSobrante::where('inventario_id',$id)->get();
        return Datatables::of($inventario)
            ->addColumn('producto', function ($item) {
                return $item->producto->nombre  . ' - ' . $item->producto->familia->nombre. ' - ' . $item->producto->familia->linea->nombre;
            })
            ->make(true);
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

            $activo=($request->activo==1)? 1:0;
            $producto->activo=$activo;
            $producto->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg]);

        }
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


