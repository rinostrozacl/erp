<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Compra extends Model
{
	protected $table = 'compra';
	public function doc_tipo_compra() 
	{
		return $this->belongsTo('App\DocTipoCompra', 'doc_tipo_compra_id'); 
	}
	public function movimiento() 
	{
		return $this->belongsTo('App\Movimiento', 'ingreso_id'); 
	}
	public function proveedor() 
	{
		return $this->belongsTo('App\Proveedor', 'proveedor_id'); 
	}
	public function compra_detalle() 
	{
		return $this->hasMany('App\CompraDetalle', 'compra_id'); 
	}
}
