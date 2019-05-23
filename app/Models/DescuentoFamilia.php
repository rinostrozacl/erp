<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class DescuentoFamilia extends Model
{
	protected $table = 'descuento_familia';
    public function familia()
    {
        return $this->hasMany('App\Models\Familia', 'linea_id');
    }
    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'cliente_id');
    }
}
