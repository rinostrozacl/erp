<?php

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Impresora;
use App\Models\Impresion;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::get('venta-bodega', function() {
    // If the Content-Type and Accept headers are set to 'application/json',
    // this will return a JSON structure. This will be cleaned up later.
    $venta=Venta::where("venta_estado_id",2)->first();
    return $venta;
});
Route::get('impresora/{key}', function($key) {
    // If the Content-Type and Accept headers are set to 'application/json',
    // this will return a JSON structure. This will be cleaned up later.

    $resp=Impresora::where("key",$key)->first();
    return $resp;
});

Route::get('impresion/{id}', function($id) {
    // If the Content-Type and Accept headers are set to 'application/json',
    // this will return a JSON structure. This will be cleaned up later.

    $impresora=Impresora::find($id);
    $impresion= $impresora->impresiones()->where('pendiente',1)->first();
    if($impresion){
        $impresion->pendiente=0;
        $impresion->save();
        return [
            'impresion' => $impresion,
            'impresion_detalle' =>$impresion->impresion_detalle()->get()
        ];
    }else{
        $impresion= new Impresion();
        return $impresion;
    }

});