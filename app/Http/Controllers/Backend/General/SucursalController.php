<?php

namespace App\Http\Controllers\Backend\General;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Impresora;
use App\Models\Ubicacion;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class SucursalController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.general.sucursal.list');
    }
    public function getTabla()
    {
        $sucursales = Sucursal::all();
        return Datatables::of($sucursales)
            ->addColumn('action', function ($item) {
                $bt='<a href="'.route('admin.general.sucursal.form',$item->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Editar</a> ';
                
                return $bt;
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->editColumn('bodega_id', function ($item) {
                return  $item->ubicacion->nombre  ;
            })
            ->editColumn('impresora_id', function ($item) {
                return  $item->impresora->nombre  ;
            })->make(true);
    }




    public function getEdit($id=0)
    {
        $sucursal = Sucursal::find($id);
        $ubicaciones = Ubicacion::all();
        $impresoras = Impresora::all();
        return view('backend.general.sucursal.form')->with('sucursal',$sucursal)->with('ubicaciones',$ubicaciones)->with('impresoras',$impresoras);
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
                $sucursal = Sucursal::findOrFail($request->id);
                $msg='Registro modificado';
            }else{
                $sucursal = new Sucursal();
                $msg='Registro Ingresado';
            }

            $sucursal->nombre=$request->nombre;
            $sucursal->bodega_id=$request->bodega_id;
            $sucursal->impresora_id=$request->impresora_id;
            $sucursal->save();
            return response()->json(['estado'=>1,'mensaje'=>$msg]);

        }
    }


}


