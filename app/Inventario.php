<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Inventario extends Model
{
	protected $table = 'inventario';
	public function familia() 
	{
		return $this->belongsTo('App\Familia', 'familia_id'); 
	}
	public function linea() 
	{
		return $this->belongsTo('App\Linea', 'linea_id'); 
	}
	public function producto() 
	{
		return $this->belongsTo('App\Producto', 'producto_id'); 
	}
	public function ubicacion() 
	{
		return $this->belongsTo('App\Ubicacion', 'ubicacion_id'); 
	}
	public function inventario_unidad() 
	{
		return $this->hasMany('App\InventarioUnidad', 'inventario_id'); 
	}
}
