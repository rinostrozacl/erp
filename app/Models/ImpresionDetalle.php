<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImpresionDetalle extends Model
{
    use SoftDeletes;
    protected $table = 'impresion_detalle';

}
