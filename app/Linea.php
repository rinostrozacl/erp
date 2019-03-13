<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Linea extends Model
{
	protected $table = 'linea';
	public function familia() 
	{
		return $this->hasMany('App\Familia', 'linea_id'); 
	}
	public function inventario() 
	{
		return $this->hasMany('App\Inventario', 'linea_id'); 
	}
}
