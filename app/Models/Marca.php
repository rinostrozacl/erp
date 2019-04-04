<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class Marca extends Model
{
    use SoftDeletes;
	protected $table = 'marca';
	public function producto() 
	{
		return $this->hasMany('App\Models\Producto', 'marca_id');
	}
}
