<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class VentaDetalle extends Model
{
	protected $table = 'venta_detalle';
	public function producto() 
	{
		return $this->belongsTo('App\Producto', 'producto_id'); 
	}
	public function venta() 
	{
		return $this->belongsTo('App\Venta', 'venta_id'); 
	}
}
