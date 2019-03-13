<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class UnidadMedida extends Model
{
	protected $table = 'unidad_medida';
	public function producto() 
	{
		return $this->hasMany('App\Producto', 'unidad_medida_id'); 
	}
}
