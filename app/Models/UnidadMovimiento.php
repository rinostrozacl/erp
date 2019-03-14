<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class UnidadMovimiento extends Model
{
	protected $table = 'unidad_movimiento';
	public function movimiento() 
	{
		return $this->belongsTo('App\Models\Movimiento', 'movimiento_id');
	}
	public function unidad() 
	{
		return $this->belongsTo('App\Models\Unidad', 'unidad_id');
	}
}
