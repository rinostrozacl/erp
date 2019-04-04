<?php

namespace App\Http\Controllers\Backend\General;


use App\Models\Linea;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Familia;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class FamiliaController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.general.familia.list');
    }
    public function getTabla()
    {
        $familias = Familia::all();
        return Datatables::of($familias)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.general.familia.form',$item->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Editar</a> ';
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
        $familia = Familia::find($id);
        $lineas = Linea::all();
        return view('backend.general.familia.form')->with('familia',$familia)->with('lineas',$lineas);
    }




    public function postUpdate(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'linea_id' => 'required'
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
            if($request->id>0){
                $familia = Familia::findOrFail($request->id);
                $msg='Registro modificado';
            }else{
                $familia = new Familia();
                $msg='Registro Ingresado';
            }

            $familia->nombre=$request->nombre;
            $familia->linea_id = $request->linea_id;
            $activo=($request->activo==1)? 1:0;
            $familia->activo=$activo;
            $familia->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg]);

        }
    }

    public function postActivar(Request $request)
    {
        $resp=[];
        $familia = Familia::findOrFail($request->id);
        $resp['estado']=0;
        if($familia->activo==1){
            $familia->activo=0;
            $resp['msg']="Se ha desactivado";
            $resp['estado']=1;
        }else{
            $familia->activo=1;
            $resp['msg']="Se ha activado";
            $resp['estado']=1;
        }
        $familia->save();
        return $resp;
    }
    public function postEliminar(Request $request)
    {
        $resp=[];
        $familia = Familia::findOrFail($request->id);
        $familia->delete();
        $resp['msg']="Registro eliminado";
        $resp['estado']=1;
        $familia->save();
        return $resp;
    }
}


