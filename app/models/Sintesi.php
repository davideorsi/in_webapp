<?php

class Sintesi extends Eloquent {

	protected $table = 'Sintesi';
	public $timestamps = false;
	protected $appends = array('nomePG','componenti');
	protected $primaryKey = 'id_sintesi';

	public function Materiali(){
		return $this->hasManyThrough('Materiale','SintesiMateriali','id_sintesi','ID');
	}

	public function mat(){
		return $this->belongsToMany('Materiale','Sintesi-Materiali','id_sintesi','id_materiale')->withPivot('quantita');;
	}

	public function Sostanza(){
		return $this->hasOne('Sostanze','id_sostanza','id_sostanza');
	}

	public function Cromodinamica(){
		return $this->hasOne('SostanzeCromodinamica','ID','id_cromodinamica');
	}

	public function PG(){
		return $this->hasOne('PG','ID','id_pg');
	}

	public function getNomepgAttribute() {
		$pg = $this->PG()->first();
		$nome = 'Master';
		if($pg){
			$nome = $pg->Nome;
		}
		return $nome;
	}

	public function getComponentiAttribute() {
		$comp = $this->mat()->get();

		return $comp;
	}
}
?>
