<?php

class Stadio extends Eloquent {

	protected $table = 'StadiMalattie';
	public $timestamps = false;
	protected $primaryKey = 'ID';

	public function PG() {
		return $this->belongsToMany('PG', 'Malattie-PG', 'Stadio', 'PG')
			->withPivot('Aggiornato');
	}

  public function MalattiaObj() {
		return $this->hasOne('Malattia','ID','Malattia');
	}
}
?>
