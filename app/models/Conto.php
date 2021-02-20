<?php

class Conto extends Eloquent {

	protected $table = 'Conto';
	public $timestamps = false;
	protected $primaryKey = 'ID';
	
	public function Personaggio(){
		return $this->hasOne('PG','ID','PG');
	}

}
