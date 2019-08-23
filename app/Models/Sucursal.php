<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Sucursal extends Model
{
	protected $table = 'sucursal';
	public function ubicacion() 
	{
		return $this->belongsTo('App\Models\Ubicacion', 'bodega_id');
	}
	public function impresora() 
	{
		return $this->belongsTo('App\Models\Impresora', 'impresora_id');
	}
	
	public function usuario() 
	{
		return $this->hasMany('App\Models\Auth\User', 'sucursal_id');
	}


}
