<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Marca extends Model
{
	protected $table = 'marca';
	public function producto() 
	{
		return $this->hasMany('App\Producto', 'marca_id'); 
	}
}
