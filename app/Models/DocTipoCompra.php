<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class DocTipoCompra extends Model
{
	protected $table = 'doc_tipo_compra';
	public function compra() 
	{
		return $this->hasMany('App\Models\Compra', 'doc_tipo_compra_id');
	}
}
