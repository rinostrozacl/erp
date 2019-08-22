<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class PagoTipo extends Model
{
    use SoftDeletes;
    protected $table = 'pago_tipo';
    
    public function venta_pago_tipo() 
	{
		return $this->hasMany('App\Models\VentaPagoTipo', 'pago_tipo_id');
	}
	
}