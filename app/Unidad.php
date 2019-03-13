<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Unidad extends Model
{
	protected $table = 'unidad';
	public function ubicacion() 
	{
		return $this->belongsTo('App\Ubicacion', 'ubicacion_id'); 
	}
	public function producto() 
	{
		return $this->belongsTo('App\Producto', 'producto_id'); 
	}
	public function inventario_unidad() 
	{
		return $this->hasMany('App\InventarioUnidad', 'unidad_id'); 
	}
	public function unidad_movimiento() 
	{
		return $this->hasMany('App\UnidadMovimiento', 'unidad_id'); 
	}
}
