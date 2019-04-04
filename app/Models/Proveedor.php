<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use SoftDeletes;

    protected $table = 'proveedor';
	public function compra() 
	{
		return $this->hasMany('App\Models\Compra', 'proveedor_id');
	}
}
