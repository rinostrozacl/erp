<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class InventarioUnidad extends Model
{
	protected $table = 'inventario_unidad';
	public function inventario() 
	{
		return $this->belongsTo('App\Inventario', 'inventario_id'); 
	}
	public function unidad() 
	{
		return $this->belongsTo('App\Unidad', 'unidad_id'); 
	}
}
