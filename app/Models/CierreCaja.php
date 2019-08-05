<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class CierreCaja extends Model
{
	protected $table = 'cierre_caja';

	public function venta()
	{
		return $this->hasMany('App\Models\Venta', 'cierre_caja_id');
    }
    public function usuario()
    {
        return $this->belongsTo('App\Models\Auth\User', 'user_id');
    }
}
