<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class VentaDetalle extends Model
{
	protected $table = 'venta_detalle';
	public function producto() 
	{
		return $this->belongsTo('App\Models\Producto', 'producto_id');
	}
	public function venta() 
	{
		return $this->belongsTo('App\Models\Venta', 'venta_id');
	}
}
