<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Producto extends Model
{
	protected $table = 'producto';
	public function familia() 
	{
		return $this->belongsTo('App\Familia', 'familia_id'); 
	}
	public function marca() 
	{
		return $this->belongsTo('App\Marca', 'marca_id'); 
	}
	public function unidad_medida() 
	{
		return $this->belongsTo('App\UnidadMedida', 'unidad_medida_id'); 
	}
	public function compra_detalle() 
	{
		return $this->hasMany('App\CompraDetalle', 'producto_id'); 
	}
	public function inventario() 
	{
		return $this->hasMany('App\Inventario', 'producto_id'); 
	}
	public function unidad() 
	{
		return $this->hasMany('App\Unidad', 'producto_id'); 
	}
	public function venta_detalle() 
	{
		return $this->hasMany('App\VentaDetalle', 'producto_id'); 
	}
}
