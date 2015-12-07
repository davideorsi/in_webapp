<?php

class Evento extends Eloquent {

	protected $table = 'Eventi';
	public $timestamps = false;
	protected $primaryKey = 'ID';

	public function PG() {
		return $this->belongsToMany('PG', 'Eventi-PG', 'Evento', 'PG')
			->withPivot('Arrivo', 'Pernotto','Cena','Note','Pagato');
	}

	public function Informatori() {
		return $this->hasMany('Informatori', 'IDEvento', 'ID');
	}

	public function Vicende() {
		return $this->hasMany('Vicenda', 'live', 'ID');
	}

}
?>
