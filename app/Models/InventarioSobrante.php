<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class InventarioSobrante extends Model
{
	protected $table = 'inventario_sobrante';
	public function inventario() 
	{
		return $this->belongsTo('App\Models\Inventario', 'inventario_id');
	}
    public function producto()
    {
        return $this->belongsTo('App\Models\Producto', 'producto_id');
    }
}
