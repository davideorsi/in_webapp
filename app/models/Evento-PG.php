<?php

class EventiPG extends Eloquent {

	protected $table = 'Eventi-PG';
	public $timestamps = false;
	protected $primaryKey = 'ID';

	public function PG() {
		return $this->hasONe('PG', 'ID', 'PG')
	}

	public function Eventi() {
		return $this->hasOne('Eventi', 'Evento', 'ID');
	}

}
?>
