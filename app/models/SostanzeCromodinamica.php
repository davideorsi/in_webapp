<?php

class SostanzeCromodinamica extends Eloquent {

	protected $table = 'Sostanze-Cromodinamica';
	public $timestamps = false;
	protected $primaryKey = 'ID';

	public function Padre(){
		return $this->hasOne('SostanzeCromodinamica','ID','id_padre');
	}

}
?>
