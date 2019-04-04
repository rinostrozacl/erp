<?php

namespace App\Http\Controllers\Backend\General;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class ProveedorController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.general.proveedor.list');
    }
    public function getTabla()
    {
        $proveedores = Proveedor::all();
        return Datatables::of($proveedores)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.general.proveedor.form',$item->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Editar</a> ';
                $bt.='<button  class="btn btn-xs btn-danger bt-eliminar" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit"></i><span> Eliminar</span></button> ';
                if($item->activo==1){
                    $bt.='<button class="btn btn-xs btn-primary  bt-desactivar" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit" ></i><span>  Desactivar</span></button> ';
                }else{
                    $bt.='<button class="btn btn-xs btn-secondary bt-desactivar" data-id="'.$item->id.'"><i class="glyphicon glyphicon-edit" ></i><span>  Activar</span></button> ';
                }
                return $bt;
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }




    public function getEdit($id=0)
    {
        $proveedor = Proveedor::find($id);
        return view('backend.general.proveedor.form')->with('proveedor',$proveedor);
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
                $proveedor = Proveedor::findOrFail($request->id);
                $msg='Registro modificado';
            }else{
                $proveedor = new Proveedor();
                $msg='Registro Ingresado';
            }

            $proveedor->nombre=$request->nombre;
            $proveedor->rut=$request->rut;
            $proveedor->giro=$request->giro;
            $proveedor->telefono=$request->telefono;
            $proveedor->mail=$request->mail;

            $activo=($request->activo==1)? 1:0;
            $proveedor->activo=$activo;
            $proveedor->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg]);

        }
    }

    public function postActivar(Request $request)
    {
        $resp=[];
        $proveedor = Proveedor::findOrFail($request->id);
        $resp['estado']=0;
        if($proveedor->activo==1){
            $proveedor->activo=0;
            $resp['msg']="Se ha desactivado";
            $resp['estado']=1;
        }else{
            $proveedor->activo=1;
            $resp['msg']="Se ha activado";
            $resp['estado']=1;
        }
        $proveedor->save();
        return $resp;
    }
    public function postEliminar(Request $request)
    {
        $resp=[];
        $proveedor = Proveedor::findOrFail($request->id);
        $proveedor->delete();
        $resp['msg']="Registro eliminado";
        $resp['estado']=1;
        $proveedor->save();
        return $resp;
    }
}


