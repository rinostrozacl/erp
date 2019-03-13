<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class CompraDetalle extends Model
{
	protected $table = 'compra_detalle';
	public function compra() 
	{
		return $this->belongsTo('App\Compra', 'compra_id'); 
	}
	public function producto() 
	{
		return $this->belongsTo('App\Producto', 'producto_id'); 
	}
}
