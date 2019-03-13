<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Movimiento extends Model
{
	protected $table = 'movimiento';
	public function movimiento_tipo() 
	{
		return $this->belongsTo('App\MovimientoTipo', 'movimiento_tipo_id'); 
	}
	public function ubicacion() 
	{
		return $this->belongsTo('App\Ubicacion', 'ubicacion_id'); 
	}
	public function compra() 
	{
		return $this->hasMany('App\Compra', 'ingreso_id'); 
	}
	public function unidad_movimiento() 
	{
		return $this->hasMany('App\UnidadMovimiento', 'movimiento_id'); 
	}
	public function venta() 
	{
		return $this->hasMany('App\Venta', 'movimiento_id'); 
	}
}
