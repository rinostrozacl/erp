<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Compra extends Model
{
	protected $table = 'compra';
	public function doc_tipo_compra() 
	{
		return $this->belongsTo('App\Models\DocTipoCompra', 'doc_tipo_compra_id');
	}
	public function movimiento() 
	{
		return $this->belongsTo('App\Models\Movimiento', 'movimiento_id');
	}
	public function proveedor() 
	{
		return $this->belongsTo('App\Models\Proveedor', 'proveedor_id');
	}
	public function compra_detalle() 
	{
		return $this->hasMany('App\Models\CompraDetalle', 'compra_id');
	}
}
