<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class VentaPagoTipo extends Model
{
    use SoftDeletes;
    protected $table = 'venta_pago_tipo';
    
    public function venta() 
	{
		return $this->belongsTo('App\Models\Venta', 'venta_id');
    }
    
    public function pago_tipo() 
	{
		return $this->belongsTo('App\Models\PagoTipo', 'pago_tipo_id');
	}
	public function user() 
	{
		return $this->belongsTo('App\Models\Auth\User', 'user_id');
	}
	
}