<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class CompraDetalle extends Model
{
	protected $table = 'compra_detalle';
	public function compra() 
	{
		return $this->belongsTo('App\Models\Compra', 'compra_id');
	}
	public function producto() 
	{
		return $this->belongsTo('App\Models\Producto', 'producto_id');
	}
}
