<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Familia extends Model
{
    use SoftDeletes;
    protected $table = 'familia';
	public function linea() 
	{
		return $this->belongsTo('App\Models\Linea', 'linea_id');
	}
	public function inventario() 
	{
		return $this->hasMany('App\Models\Inventario', 'familia_id');
	}
	public function producto() 
	{
		return $this->hasMany('App\Models\Producto', 'familia_id');
	}
}
