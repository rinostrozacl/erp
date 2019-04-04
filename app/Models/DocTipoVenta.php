<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocTipoVenta extends Model
{
    use SoftDeletes;

    protected $table = 'doc_tipo_venta';
//    public function venta()
//    {
//        return $this->hasMany('App\Models\Venta', 'doc_tipo_venta_id');
//    }
}
