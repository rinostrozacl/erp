<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Impresora extends Model
{
    use SoftDeletes;
    protected $table = 'impresora';

    public function impresiones()
    {
        return $this->belongsToMany('App\Models\Impresion', 'impresora_impresion');
    }
}
