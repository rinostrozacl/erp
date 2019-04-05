<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Inventario extends Model
{
	protected $table = 'inventario';
	public function familia() 
	{
		return $this->belongsTo('App\Models\Familia', 'familia_id');
	}
	public function linea() 
	{
		return $this->belongsTo('App\Models\Linea', 'linea_id');
	}
	public function producto() 
	{
		return $this->belongsTo('App\Models\Producto', 'producto_id');
	}
	public function ubicacion() 
	{
		return $this->belongsTo('App\Models\Ubicacion', 'ubicacion_id');
	}
	public function inventario_unidad() 
	{
		return $this->hasMany('App\Models\InventarioUnidad', 'inventario_id');
	}
    public function usuario()
    {
        return $this->belongsTo('App\Models\Auth\User', 'user_id');
    }
}
