<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class MovimientoTipo extends Model
{
	protected $table = 'movimiento_tipo';
	public function movimiento() 
	{
		return $this->hasMany('App\Movimiento', 'movimiento_tipo_id'); 
	}
}
