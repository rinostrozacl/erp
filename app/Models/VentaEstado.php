<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class VentaEstado extends Model
{
	protected $table = 'venta_estado';
	public function venta() 
	{
		return $this->hasMany('App\Models\Venta', 'venta_estado_id');
	}
}
