<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Unidad extends Model
{
	protected $table = 'unidad';
	public function ubicacion() 
	{
		return $this->belongsTo('App\Models\Ubicacion', 'ubicacion_id');
	}
	public function producto() 
	{
		return $this->belongsTo('App\Models\Producto', 'producto_id');
	}
	public function inventario_unidad() 
	{
		return $this->hasMany('App\Models\InventarioUnidad', 'unidad_id');
	}
	public function unidad_movimiento() 
	{
		return $this->hasMany('App\Models\UnidadMovimiento', 'unidad_id');
	}
}
