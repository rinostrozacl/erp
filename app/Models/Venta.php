<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Venta extends Model
{
	protected $table = 'venta';
	public function cliente() 
	{
		return $this->belongsTo('App\Models\Cliente', 'cliente_id');
	}
	public function movimiento() 
	{
		return $this->belongsTo('App\Models\Movimiento', 'movimiento_id');
	}
	public function venta_estado() 
	{
		return $this->belongsTo('App\Models\VentaEstado', 'venta_estado_id');
	}
	public function venta_detalle() 
	{
		return $this->hasMany('App\Models\VentaDetalle', 'venta_id');
	}

	public function venta_pago_tipo() 
	{
		return $this->hasMany('App\Models\VentaPagoTipo', 'venta_id');
	}
}
