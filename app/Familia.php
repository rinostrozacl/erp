<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Familia extends Model
{
	protected $table = 'familia';
	public function linea() 
	{
		return $this->belongsTo('App\Linea', 'linea_id'); 
	}
	public function inventario() 
	{
		return $this->hasMany('App\Inventario', 'familia_id'); 
	}
	public function producto() 
	{
		return $this->hasMany('App\Producto', 'familia_id'); 
	}
}
