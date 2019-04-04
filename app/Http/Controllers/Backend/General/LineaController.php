<?php

namespace App\Http\Controllers\Backend\General;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Linea;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class LineaController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.general.linea.list');
    }
    public function getTabla()
    {
        $lineas = Linea::all();
        return Datatables::of($lineas)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.general.linea.form',$item->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Editar</a> ';
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
        $linea = Linea::find($id);
        return view('backend.general.linea.form')->with('linea',$linea);
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
                $linea = Linea::findOrFail($request->id);
                $msg='Registro modificado';
            }else{
                $linea = new Linea();
                $msg='Registro Ingresado';
            }

            $linea->nombre=$request->nombre;
            $activo=($request->activo==1)? 1:0;
            $linea->activo=$activo;
            $linea->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg]);

        }
    }

    public function postActivar(Request $request)
    {
        $resp=[];
        $linea = Linea::findOrFail($request->id);
        $resp['estado']=0;
        if($linea->activo==1){
            $linea->activo=0;
            $resp['msg']="Se ha desactivado";
            $resp['estado']=1;
        }else{
            $linea->activo=1;
            $resp['msg']="Se ha activado";
            $resp['estado']=1;
        }
        $linea->save();
        return $resp;
    }
    public function postEliminar(Request $request)
    {
        $resp=[];
        $linea = Linea::findOrFail($request->id);
        $linea->delete();
        $resp['msg']="Registro eliminado";
        $resp['estado']=1;
        $linea->save();
        return $resp;
    }
}


