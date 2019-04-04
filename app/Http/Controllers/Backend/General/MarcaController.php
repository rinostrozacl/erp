<?php

namespace App\Http\Controllers\Backend\General;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Marca;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class MarcaController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.general.marca.list');
    }
    public function getTabla()
    {
        $marcas = Marca::all();
        return Datatables::of($marcas)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.general.marca.form',$item->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Editar</a> ';
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
        $marca = Marca::find($id);
        return view('backend.general.marca.form')->with('marca',$marca);
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
                $marca = Marca::findOrFail($request->id);
                $msg='Registro modificado';
            }else{
                $marca = new Marca();
                $msg='Registro Ingresado';
            }

            $marca->nombre=$request->nombre;
            $activo=($request->activo==1)? 1:0;
            $marca->activo=$activo;
            $marca->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg]);

        }
    }

    public function postActivar(Request $request)
    {
        $resp=[];
        $marca = Marca::findOrFail($request->id);
        $resp['estado']=0;
        if($marca->activo==1){
            $marca->activo=0;
            $resp['msg']="Se ha desactivado";
            $resp['estado']=1;
        }else{
            $marca->activo=1;
            $resp['msg']="Se ha activado";
            $resp['estado']=1;
        }
        $marca->save();
        return $resp;
    }
    public function postEliminar(Request $request)
    {
        $resp=[];
        $marca = Marca::findOrFail($request->id);
        $marca->delete();
        $resp['msg']="Registro eliminado";
        $resp['estado']=1;
        $marca->save();
        return $resp;
    }
}


