<?php

class Cura extends Eloquent {

	protected $table = 'Cure';
	public $timestamps = false;
	protected $primaryKey = 'ID';	
	
	public function NomeMalattia()
    {
        return $this->hasOne('Malattia','ID','Malattia')->select(['Nome']);
    }	

	
}
?>
