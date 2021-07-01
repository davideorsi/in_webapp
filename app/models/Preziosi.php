<?php

class Preziosi extends Eloquent {

	protected $table = 'Preziosi';
	public $timestamps = false;
	protected $primaryKey = 'ID';
	
	public function Offerte(){
		return $this->hasMany('PreziosiOfferte','ID_Prezioso','ID');
	}
}
