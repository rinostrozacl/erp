<?php

namespace App\Http\Controllers\Backend\General;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\DocTipoVenta;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class DocTipoVentaController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.general.doctipoventa.list');
    }
    public function getTabla()
    {
        $doctipoventas = DocTipoVenta::all();
        return Datatables::of($doctipoventas)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.general.doctipoventa.form',$item->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Editar</a> ';
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
        $doctipoventa = DocTipoVenta::find($id);
        return view('backend.general.doctipoventa.form')->with('doctipoventa',$doctipoventa);
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
                $doctipoventa = DocTipoVenta::findOrFail($request->id);
                $msg='Registro modificado';
            }else{
                $doctipoventa = new DocTipoVenta();
                $msg='Registro Ingresado';
            }

            $doctipoventa->nombre=$request->nombre;
            $activo=($request->activo==1)? 1:0;
            $doctipoventa->activo=$activo;
            $doctipoventa->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg]);

        }
    }

    public function postActivar(Request $request)
    {
        $resp=[];
        $doctipoventa = DocTipoVenta::findOrFail($request->id);
        $resp['estado']=0;
        if($doctipoventa->activo==1){
            $doctipoventa->activo=0;
            $resp['msg']="Se ha desactivado";
            $resp['estado']=1;
        }else{
            $doctipoventa->activo=1;
            $resp['msg']="Se ha activado";
            $resp['estado']=1;
        }
        $doctipoventa->save();
        return $resp;
    }
    public function postEliminar(Request $request)
    {
        $resp=[];
        $doctipoventa = DocTipoVenta::findOrFail($request->id);
        $doctipoventa->delete();
        $resp['msg']="Registro eliminado";
        $resp['estado']=1;
        $doctipoventa->save();
        return $resp;
    }
}


