<?php

class Materiale extends Eloquent {

	protected $table = 'Materiali';
	public $timestamps = false;
	protected $primaryKey = 'ID';

	public function PG() {
		return $this->belongsToMany('PG', 'RotteCommerciali', 'IDPG', 'IDMateriale');
		}

	public function Rotte() {
		return $this->hasMany('RotteCommerciali','ID','IDMateriale');
		}
		
	public function RaritaLoc(){
		return $this->hasOne('RaritaMateriali','ID','RaritaLoc');
	}
	
	public function RaritaOM(){
		return $this->hasOne('RaritaMateriali','ID','RaritaOM');
	}
	
	public function RaritaMN(){
		return $this->hasOne('RaritaMateriali','ID','RaritaMN');
	}
	
	public function Categoria(){
		return $this->belongsTo('CategorieMateriali','ID','Categoria');
	}
}
?>
