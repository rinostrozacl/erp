<?php

namespace App\Http\Controllers\Backend\General;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\DocTipoCompra;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class DocTipoCompraController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.general.doctipocompra.list');
    }
    public function getTabla()
    {
        $doctipocompras = DocTipoCompra::all();
        return Datatables::of($doctipocompras)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.general.doctipocompra.form',$item->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Editar</a> ';
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
        $doctipocompra = DocTipoCompra::find($id);
        return view('backend.general.doctipocompra.form')->with('doctipocompra',$doctipocompra);
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
                $doctipocompra = DocTipoCompra::findOrFail($request->id);
                $msg='Registro modificado';
            }else{
                $doctipocompra = new DocTipoCompra();
                $msg='Registro Ingresado';
            }

            $doctipocompra->nombre=$request->nombre;
            $activo=($request->activo==1)? 1:0;
            $doctipocompra->activo=$activo;
            $doctipocompra->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg]);

        }
    }

    public function postActivar(Request $request)
    {
        $resp=[];
        $doctipocompra = DocTipoCompra::findOrFail($request->id);
        $resp['estado']=0;
        if($doctipocompra->activo==1){
            $doctipocompra->activo=0;
            $resp['msg']="Se ha desactivado";
            $resp['estado']=1;
        }else{
            $doctipocompra->activo=1;
            $resp['msg']="Se ha activado";
            $resp['estado']=1;
        }
        $doctipocompra->save();
        return $resp;
    }
    public function postEliminar(Request $request)
    {
        $resp=[];
        $doctipocompra = DocTipoCompra::findOrFail($request->id);
        $doctipocompra->delete();
        $resp['msg']="Registro eliminado";
        $resp['estado']=1;
        $doctipocompra->save();
        return $resp;
    }
}


