<?php

class Materiale extends Eloquent {

	protected $table = 'Materiali';
	public $timestamps = false;
	protected $primaryKey = 'ID';
	//protected $appends = array('cat','cd','stg','RL','RO','RN');
	protected $appends = array('stg');

	public function PG() {
		return $this->belongsToMany('PG', 'RotteCommerciali', 'IDPG', 'IDMateriale');
		}

	public function Rotte() {
		return $this->hasMany('RotteCommerciali','ID','IDMateriale');
		}

	public function RaritaLoc(){
		return $this->hasOne('RaritaMateriale','ID','RaritàLoc');
	}

	public function rl(){
		return $this->hasOne('RaritaMateriale','ID','RaritàLoc');
	}

	public function RaritaOM(){
		return $this->hasOne('RaritaMateriale','ID','RaritaOM');
	}

	public function ro(){
		return $this->hasOne('RaritaMateriale','ID','RaritaOM');
	}

	public function RaritaMN(){
		return $this->hasOne('RaritaMateriale','ID','RaritaMN');
	}

	public function rn(){
		return $this->hasOne('RaritaMateriale','ID','RaritaMN');
	}

	public function Categoria(){
		return $this->hasOne('CategorieMateriali','ID','Categoria');
	}

	public function cat(){
		return $this->hasOne('CategorieMateriali','ID','Categoria');
	}

	public function Sostanze(){
		return $this->belongsToMany('Sostanze','SostanzeMateriali','ID','id_sostanza');//->withPivot('quantita');
	}

	public function cd(){
		return $this->hasOne('SostanzeCromodinamica','ID','id_cromodinamica');
	}

	public function Estratto(){
		return $this->hasOne('Materiale','ID','id_estratto');
	}
/*
	public function getCdAttribute() {
		$cromodinamica = $this->Cromodinamica()->first();
		$cd = '';
		if($cromodinamica){
				$cd = $cromodinamica->DESC;
		}
		return $cd;
	}
*/
	public function getCatAttribute() {
		$categoria = $this->Categoria()->first();
		$cat = '';
		if($categoria){
				$cat = $categoria->DESC;
		}

		return $cat;
	}

	public function getStgAttribute() {
		$stg = "Nessuna";
		if ($this->Stagione == "1"){
			$stg = "Inverno";
		}elseif($this->Stagione == "2"){
			$stg = "Primavera";
		}elseif($this->Stagione == "3"){
			$stg = "Estate";
		}elseif($this->Stagione == "4"){
			$stg = "Autunno";
		}

		return $stg;
	}
}
?>
