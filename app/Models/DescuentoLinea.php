<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class DescuentoLinea extends Model
{
    use SoftDeletes;
	protected $table = 'descuento_linea';
    public function linea()
    {
        return $this->belongsTo('App\Models\Linea', 'linea_id');
    }
    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'cliente_id');
    }
}
