<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Ubicacion extends Model
{
	protected $table = 'ubicacion';
	public function movimiento() 
	{
		return $this->hasMany('App\Movimiento', 'ubicacion_id'); 
	}
	public function inventario() 
	{
		return $this->hasMany('App\Inventario', 'ubicacion_id'); 
	}
	public function unidad() 
	{
		return $this->hasMany('App\Unidad', 'ubicacion_id'); 
	}
}
