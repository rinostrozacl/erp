<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Venta extends Model
{
	protected $table = 'venta';
	public function cliente() 
	{
		return $this->belongsTo('App\Cliente', 'cliente_id'); 
	}
	public function movimiento() 
	{
		return $this->belongsTo('App\Movimiento', 'movimiento_id'); 
	}
	public function venta_estado() 
	{
		return $this->belongsTo('App\VentaEstado', 'venta_estado_id'); 
	}
	public function venta_detalle() 
	{
		return $this->hasMany('App\VentaDetalle', 'venta_id'); 
	}
}
