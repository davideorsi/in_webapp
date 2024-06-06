<?php

class Malattia extends Eloquent {

	protected $table = 'Malattie';
	public $timestamps = false;
	protected $primaryKey = 'ID';

	public function Stadi(){
		return $this->hasMany('Stadio','Malattia','ID');
	}

	public function Cure(){
		return $this->hasMany('Cura','Malattia','ID');
	}

	public function Categoria(){
		return $this->hasOne('MalattiaCategorie','ID','Categoria');
	}

	public function Cromodinamica(){
		return $this->hasOne('SostanzeCromodinamica','ID','IdCromodinamica');
	}
}
?>
