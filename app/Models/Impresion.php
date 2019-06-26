<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Impresion extends Model
{
    use SoftDeletes;
    protected $table = 'impresion';

    public function impresoras()
    {
        return $this->belongsToMany('App\Models\Impresora', 'impresora_impresion');
    }
    public function impresion_detalle()
    {
        return $this->hasMany('App\Models\ImpresionDetalle');
    }
}
