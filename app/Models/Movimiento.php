<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Movimiento extends Model
{
	protected $table = 'movimiento';
	public function movimiento_tipo() 
	{
		return $this->belongsTo('App\Models\MovimientoTipo', 'movimiento_tipo_id');
	}
	public function ubicacion() 
	{
		return $this->belongsTo('App\Models\Ubicacion', 'ubicacion_id');
	}
	public function compra() 
	{
		return $this->hasMany('App\Models\Compra', 'ingreso_id');
	}
	public function unidad_movimiento() 
	{
		return $this->hasMany('App\Models\UnidadMovimiento', 'movimiento_id');
	}
	public function venta() 
	{
		return $this->hasMany('App\Models\Venta', 'movimiento_id');
	}
}
