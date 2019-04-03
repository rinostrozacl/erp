<?php

namespace App\Http\Controllers\Backend\General;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Cliente;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class MovimientoController extends Controller
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
            $activo=($request->activo==1)? 1:0;
            $cliente->activo=$activo;
            $cliente->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg]);

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
}


