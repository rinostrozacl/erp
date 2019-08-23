<?php

namespace App\Http\Controllers\Backend\General;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Impresora;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class ImpresoraController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.general.impresora.list');
    }
    public function getTabla()
    {
        $impresoras = Impresora::all();
        return Datatables::of($impresoras)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.general.impresora.form',$item->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Editar</a> ';
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
        $impresora = Impresora::find($id);
        return view('backend.general.impresora.form')->with('impresora',$impresora);
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
                $impresora = Impresora::findOrFail($request->id);
                $msg='Registro modificado';
            }else{
                $impresora = new Impresora();
                $msg='Registro Ingresado';
            }

            $impresora->nombre=$request->nombre;
            $impresora->key=$request->key;
            $activo=($request->activo==1)? 1:0;
            $impresora->activo=$activo;
            $impresora->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg]);

        }
    }

    public function postActivar(Request $request)
    {
        $resp=[];
        $impresora = Impresora::findOrFail($request->id);
        $resp['estado']=0;
        if($impresora->activo==1){
            $impresora->activo=0;
            $resp['msg']="Se ha desactivado";
            $resp['estado']=1;
        }else{
            $impresora->activo=1;
            $resp['msg']="Se ha activado";
            $resp['estado']=1;
        }
        $impresora->save();
        return $resp;
    }
    public function postEliminar(Request $request)
    {
        $resp=[];
        $impresora = Impresora::findOrFail($request->id);
        $impresora->delete();
        $resp['msg']="Registro eliminado";
        $resp['estado']=1;
        $impresora->save();
        return $resp;
    }
}


