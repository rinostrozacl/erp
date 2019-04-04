<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $table = 'cliente';
	public function venta() 
	{
		return $this->hasMany('App\Models\Venta', 'cliente_id');
	}
}
