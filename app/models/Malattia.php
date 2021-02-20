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
}
?>
