<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Ubicacion extends Model
{
	protected $table = 'ubicacion';
	public function movimiento() 
	{
		return $this->hasMany('App\Models\Movimiento', 'ubicacion_id');
	}
	public function inventario() 
	{
		return $this->hasMany('App\Models\Inventario', 'ubicacion_id');
	}
	public function unidad() 
	{
		return $this->hasMany('App\Models\Unidad', 'ubicacion_id');
	}
}
