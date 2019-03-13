<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class UnidadMovimiento extends Model
{
	protected $table = 'unidad_movimiento';
	public function movimiento() 
	{
		return $this->belongsTo('App\Movimiento', 'movimiento_id'); 
	}
	public function unidad() 
	{
		return $this->belongsTo('App\Unidad', 'unidad_id'); 
	}
}
