<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class InventarioUnidad extends Model
{
	protected $table = 'inventario_unidad';
	public function inventario() 
	{
		return $this->belongsTo('App\Models\Inventario', 'inventario_id');
	}
	public function unidad() 
	{
		return $this->belongsTo('App\Models\Unidad', 'unidad_id');
	}
}
