<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ubicacion extends Model
{
    use SoftDeletes;

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
    public function producto_ubicacion()
    {
        return $this->hasMany('App\Models\ProductoUbicacion', 'ubicacion_id');
    }
}
