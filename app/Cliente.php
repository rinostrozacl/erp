<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Cliente extends Model
{
	protected $table = 'cliente';
	public function venta() 
	{
		return $this->hasMany('App\Venta', 'cliente_id'); 
	}
}
