<?php

class CategorieMateriali extends Eloquent {

	protected $table = 'Materiali-Categorie';
	public $timestamps = false;
	protected $primaryKey = 'ID';

	public function Materiale() {
		return $this->hasMany('Materiale','Categoria','ID');
		}
}
?>
