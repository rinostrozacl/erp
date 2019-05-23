<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class DescuentoFamilia extends Model
{
    use SoftDeletes;
	protected $table = 'descuento_familia';
    public function familia()
    {
        return $this->belongsTo('App\Models\Familia', 'familia_id');
    }
    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'cliente_id');
    }
}
