<?php

namespace App\Http\Controllers\Backend\Caja;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Producto;
use App\Models\Marca;
use App\Models\Ubicacion;
use App\Models\ProductoUbicacion;
use App\Models\UnidadMedida;
use App\Models\Linea;
use App\Models\Venta;
use App\Models\CierreCaja;
use Illuminate\Http\Request;

use PDF;

use DataTables;
use Validator;

/**
 * Class DashboardController.
 */
class CajaController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.bodega.producto.index');
    }

    public function cambioTurno()
    {
        $ventas = Venta::where('is_rendido',0)->where('user_id',Auth::user()->id)->get();
       //Cliente::all();
        return view('backend.caja.generar-cierre')
            ->with("ventas", $ventas);
    }
    public function cambioTurnoGuardar(Request $request)
    {
        $cierre_caja = new CierreCaja();
        $cierre_caja->user_id = Auth::user()->id;
        $cierre_caja->save();

        $ventas = Venta::where('is_rendido',0)->where('user_id',Auth::user()->id)->get();

        $ventas->each(function ($venta) use ($cierre_caja) {
            $venta->cierre_caja_id = $cierre_caja->id;
            $venta->is_rendido = 1;
            $venta->save();
        });

       //Cliente::all();
        return  $cierre_caja->id;
    }


    public function imprimirCierre($id)
    {
        $ventas = Venta::where('cierre_caja_id',$id)->get();
        $cierre_caja = CierreCaja::find($id);

        $tipo= "cierre_caja";

        $timbre_fecha = date('Ymdhis', time());
        $nombre_archivo = $timbre_fecha ."_".$tipo."_". $id .".pdf";
        $data = ['ventas' => $ventas ,
            'titulo' => $nombre_archivo,
            'cierre_caja' => $cierre_caja];
        $pdf = PDF::loadView('backend/pdf/cierre', $data);

        return $pdf->stream($nombre_archivo);

    }


    public function getRendicion()
    {
        $cierres = CierreCaja::where('is_cerrado',0)->get();
       //Cliente::all();
        return view('backend.caja.realizar-cierre')
            ->with("cierres", $cierres);
    }

    public function rendicionCerrar(Request $request)
    {
        $cierre = CierreCaja::find($request->cierre_id);
        $cierre->is_cerrado = 1;
        $cierre->save();
       //Cliente::all();
      //  return view('backend.caja.realizar-cierre')
       //     ->with("cierres", $cierres);
    }


}


