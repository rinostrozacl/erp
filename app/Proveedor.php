<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Proveedor extends Model
{
	protected $table = 'proveedor';
	public function compra() 
	{
		return $this->hasMany('App\Compra', 'proveedor_id'); 
	}
}
