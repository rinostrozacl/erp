<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Linea extends Model
{
	protected $table = 'linea';
	public function familia() 
	{
		return $this->hasMany('App\Models\Familia', 'linea_id');
	}
	public function inventario() 
	{
		return $this->hasMany('App\Models\Inventario', 'linea_id');
	}
}
