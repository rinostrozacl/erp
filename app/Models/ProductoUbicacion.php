<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class ProductoUbicacion extends Model
{
    protected $table = 'producto_ubicacion';

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto', 'producto_id');
    }
    public function ubicacion()
    {
        return $this->belongsTo('App\Models\Ubicacion', 'ubicacion_id');
    }
    
}