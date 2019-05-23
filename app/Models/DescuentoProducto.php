<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class DescuentoProducto extends Model
{
    use SoftDeletes;
	protected $table = 'descuento_producto';
    public function producto()
    {
        return $this->belongsTo('App\Models\Producto', 'producto_id');
    }
    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'cliente_id');
    }
}
