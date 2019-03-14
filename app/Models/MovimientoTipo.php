<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class MovimientoTipo extends Model
{
	protected $table = 'movimiento_tipo';
	public function movimiento() 
	{
		return $this->hasMany('App\Models\Movimiento', 'movimiento_tipo_id');
	}
}
