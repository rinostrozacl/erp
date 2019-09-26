<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocTipoCompra extends Model
{
    use SoftDeletes;

    protected $table = 'doc_tipo_compra';
	public function compra() 
	{
		return $this->hasMany('App\Models\Compra', 'doc_tipo_compra_id');
	}
	
}
