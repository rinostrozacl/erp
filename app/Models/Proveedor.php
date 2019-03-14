<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Proveedor extends Model
{
	protected $table = 'proveedor';
	public function compra() 
	{
		return $this->hasMany('App\Models\Compra', 'proveedor_id');
	}
}
