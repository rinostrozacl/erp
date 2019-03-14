<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Producto extends Model
{
	protected $table = 'producto';
	public function familia() 
	{
		return $this->belongsTo('App\Models\Familia', 'familia_id');
	}
	public function marca() 
	{
		return $this->belongsTo('App\Models\Marca', 'marca_id');
	}
	public function unidad_medida() 
	{
		return $this->belongsTo('App\Models\UnidadMedida', 'unidad_medida_id');
	}
	public function compra_detalle() 
	{
		return $this->hasMany('App\Models\CompraDetalle', 'producto_id');
	}
	public function inventario() 
	{
		return $this->hasMany('App\Models\Inventario', 'producto_id');
	}
	public function unidad() 
	{
		return $this->hasMany('App\Models\Unidad', 'producto_id');
	}
	public function venta_detalle() 
	{
		return $this->hasMany('App\Models\VentaDetalle', 'producto_id');
	}
}
