<?php

namespace App\Http\Controllers\Backend\General;


use App\Models\DescuentoFamilia;
use App\Models\DescuentoLinea;
use App\Models\DescuentoProducto;
use App\Models\Familia;
use App\Models\Linea;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Cliente;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class ClienteController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.general.cliente.list');
    }
    public function getTabla()
    {
        $clientes = Cliente::all();
        return Datatables::of($clientes)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.general.cliente.form',$item->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Editar</a> ';
                $bt.='<button  class="btn btn-xs btn-danger bt-eliminar" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit"></i><span> Eliminar</span></button> ';
                if($item->activo==1){
                    $bt.='<button class="btn btn-xs btn-primary  bt-desactivar" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit" ></i><span>  Desactivar</span></button> ';
                }else{
                    $bt.='<button class="btn btn-xs btn-secondary bt-desactivar" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit" ></i><span>  Activar</span></button> ';
                }
                $bt.='<a href="'.route('admin.general.cliente.indexDescuentos',$item->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Descuentos</a> ';
                return $bt;
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }





    public function getEdit($id=0)
    {
        $cliente = Cliente::find($id);
        return view('backend.general.cliente.form')->with('cliente',$cliente);
    }


    public function indexDescuento($id=0)
    {
        $cliente = Cliente::find($id);

        return view('backend.general.cliente.descuento')->with('cliente',$cliente);
    }


    public function getTablaDescuentoLinea($id=0)
    {
        $clientes = DescuentoLinea::where('cliente_id',$id);
        return Datatables::of($clientes)
            ->addColumn('action', function ($item) {
                $bt='<button  class="btn btn-xs btn-danger bt-eliminar-linea" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit"></i><span> Eliminar</span></button> ';
                return $bt;
            })->addColumn('linea', function ($item) {
                return $item->linea->nombre;
            })->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }
    public function getTablaDescuentoFamilia($id=0)
    {
        $clientes = DescuentoFamilia::where('cliente_id',$id);
        return Datatables::of($clientes)
            ->addColumn('action', function ($item) {
                $bt='<button  class="btn btn-xs btn-danger bt-eliminar-familia" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit"></i><span> Eliminar</span></button> ';
                return $bt;
            })->addColumn('familia', function ($item) {
                return $item->familia->linea->nombre.' - '.$item->familia->nombre;
            })->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function getTablaDescuentoProducto($id=0)
    {
        $clientes = DescuentoProducto::where('cliente_id',$id);
        return Datatables::of($clientes)
            ->addColumn('action', function ($item) {
                $bt='<button  class="btn btn-xs btn-danger bt-eliminar-producto" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit"></i><span> Eliminar</span></button> ';
                return $bt;
            })->addColumn('producto', function ($item) {
                return  $item->producto->familia->linea->nombre . ' - ' . $item->producto->familia->nombre . ' - ' .$item->producto->nombre;
            })->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function getDescuentoNuevoLinea($id=0)
    {
        $cliente = Cliente::find($id);
        $lineas = Linea::all();
        return view('backend.general.cliente.descuento.formlinea')->with('cliente',$cliente)->with('lineas',$lineas);
    }

    public function getDescuentoNuevoFamilia($id=0)
    {
        $cliente = Cliente::find($id);
        $lineas = Linea::where('activo',1)->get();
        $familias = Familia::where('activo',1)->get();

        return view('backend.general.cliente.descuento.formfamilia')
            ->with('cliente',$cliente)
            ->with('lineas',$lineas)
            ->with('familias',$familias);;
    }

    public function getDescuentoNuevoProducto($id=0)
    {
        $cliente = Cliente::find($id);
        $lineas = Linea::where('activo',1)->get();
        $familias = Familia::where('activo',1)->get();
        $productos = Producto::where('activo',1)->get();

        return view('backend.general.cliente.descuento.formproducto')
            ->with('cliente',$cliente)
            ->with('lineas',$lineas)
            ->with('familias',$familias)
            ->with('productos',$productos);
    }




    public function postDescuentoNuevoLineaSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'linea_id' => 'required',
            'porcentaje' => 'required'

        ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
            $descuento = new DescuentoLinea();
            $msg='Registro Ingresado';
            $descuento->linea_id=$request->linea_id;
            $descuento->cliente_id=$request->cliente_id;
            $descuento->porcentaje=$request->porcentaje;
            $descuento->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg]);
        }
    }

    public function postDescuentoNuevoFamiliaSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'familia_id' => 'required',
            'porcentaje' => 'required'

        ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
            $descuento = new DescuentoFamilia();
            $msg='Registro Ingresado';
            $descuento->familia_id=$request->familia_id;
            $descuento->cliente_id=$request->cliente_id;
            $descuento->porcentaje=$request->porcentaje;
            $descuento->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg]);
        }
    }


    public function postDescuentoNuevoProductoSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'producto_id' => 'required'

        ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
            $descuento = new DescuentoProducto();
            $msg='Registro Ingresado';
            $descuento->producto_id=$request->producto_id;
            $descuento->cliente_id=$request->cliente_id;
            $descuento->porcentaje=$request->porcentaje;
            $descuento->pesos=$request->pesos;
            $descuento->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg]);
        }
    }

    public function postUpdate(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'rut' => 'required'

        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
            if($request->id>0){
                $cliente = Cliente::findOrFail($request->id);
                $msg='Registro modificado';
            }else{
                $cliente = new Cliente();
                $msg='Registro Ingresado';
            }

            $cliente->nombre=$request->nombre;
            $cliente->rut=$request->rut;
            $cliente->activo= 1;
            $cliente->telefono = $request->telefono;
            $cliente->giro = $request->giro;
            $cliente->direccion = $request->direccion;
            $cliente->email = $request->email;
            $cliente->ciudad = $request->ciudad;
            $cliente->credito = $request->credito;
            $cliente->credito_maximo = $request->credito_maximo;
            $cliente->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg, 'cliente_id' => $cliente->id]);

        }
    }

    public function postActivar(Request $request)
    {
        $resp=[];
        $cliente = Cliente::findOrFail($request->id);
        $resp['estado']=0;
        if($cliente->activo==1){
            $cliente->activo=0;
            $resp['msg']="Se ha desactivado";
            $resp['estado']=1;
        }else{
            $cliente->activo=1;
            $resp['msg']="Se ha activado";
            $resp['estado']=1;
        }
        $cliente->save();
        return $resp;
    }
    public function postEliminar(Request $request)
    {
        $resp=[];
        $cliente = Cliente::findOrFail($request->id);
        $cliente->delete();
        $resp['msg']="Registro eliminado";
        $resp['estado']=1;
        $cliente->save();
        $cliente->save();
        return $resp;
    }

    public function postEliminarDescuentoLinea(Request $request)
    {
        $resp=[];
        $descuento = DescuentoLinea::findOrFail($request->id);
        $descuento->delete();
        $resp['msg']="Registro eliminado";
        $resp['estado']=1;
        $descuento->save();
        return $resp;
    }

    public function postEliminarDescuentoFamilia(Request $request)
    {
        $resp=[];
        $descuento = DescuentoFamilia::findOrFail($request->id);
        $descuento->delete();
        $resp['msg']="Registro eliminado";
        $resp['estado']=1;
        $descuento->save();
        return $resp;
    }
    public function postEliminarDescuentoProducto(Request $request)
    {
        $resp=[];
        $descuento = DescuentoProducto::findOrFail($request->id);
        $descuento->delete();
        $resp['msg']="Registro eliminado";
        $resp['estado']=1;
        $descuento->save();
        return $resp;
    }
}


