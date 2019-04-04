<?php

namespace App\Http\Controllers\Backend\General;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class UbicacionController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.general.ubicacion.list');
    }
    public function getTabla()
    {
        $ubicaciones = Ubicacion::all();
        return Datatables::of($ubicaciones)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.general.ubicacion.form',$item->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Editar</a> ';
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
        $ubicacion = Ubicacion::find($id);
        return view('backend.general.ubicacion.form')->with('ubicacion',$ubicacion);
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
                $ubicacion = Ubicacion::findOrFail($request->id);
                $msg='Registro modificado';
            }else{
                $ubicacion = new Ubicacion();
                $msg='Registro Ingresado';
            }

            $ubicacion->nombre=$request->nombre;
            $ubicacion->direccion=$request->direccion;
            //checkboxs
            $is_entrada_origen = ($request->is_entrada_origen==1)? 1:0;
            $is_entrada_destino = ($request->is_entrada_destino==1)? 1:0;
            $is_traslado_origen = ($request->is_traslado_origen==1)? 1:0;
            $is_traslado_destino = ($request->is_traslado_destino==1)? 1:0;
            $is_salida_origen = ($request->is_salida_origen==1)? 1:0;
            $is_salida_destino = ($request->is_salida_destino==1)? 1:0;


            $activo=($request->activo==1)? 1:0;
            $ubicacion->is_entrada_origen = $is_entrada_origen;
            $ubicacion->is_entrada_destino = $is_entrada_destino;
            $ubicacion->is_traslado_origen = $is_traslado_origen;
            $ubicacion->is_traslado_destino = $is_traslado_destino;
            $ubicacion->is_salida_origen = $is_salida_origen;
            $ubicacion->is_salida_destino = $is_salida_destino;
            $ubicacion->activo=$activo;
            $ubicacion->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg]);

        }
    }

    public function postActivar(Request $request)
    {
        $resp=[];
        $ubicacion = Ubicacion::findOrFail($request->id);
        $resp['estado']=0;
        if($ubicacion->activo==1){
            $ubicacion->activo=0;
            $resp['msg']="Se ha desactivado";
            $resp['estado']=1;
        }else{
            $ubicacion->activo=1;
            $resp['msg']="Se ha activado";
            $resp['estado']=1;
        }
        $ubicacion->save();
        return $resp;
    }
    public function postEliminar(Request $request)
    {
        $resp=[];
        $ubicacion = Ubicacion::findOrFail($request->id);
        $ubicacion->delete();
        $resp['msg']="Registro eliminado";
        $resp['estado']=1;
        $ubicacion->save();
        return $resp;
    }
}


