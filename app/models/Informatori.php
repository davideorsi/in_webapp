<?php

class Informatori extends Eloquent {

	protected $table = 'Informatori';
	public $timestamps = false;
	protected $primaryKey = 'ID';

	public function Evento() {
		return $this->hasOne('Evento','ID','IDEvento');
	}


}
?>
