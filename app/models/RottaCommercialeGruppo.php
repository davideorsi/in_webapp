<?php

class RottaCommercialeGruppo extends Eloquent {

	protected $table = 'RotteCommercialiGruppo';
	public $timestamps = false;
	protected $primaryKey = 'ID';

	public function RotteCommerciali() {
		return $this->HasMany('RottaCommerciale','Evento','ID');
		}

	public function Evento(){
		return $this->belongsTo('Evento', 'id_evento','ID');
	}
}
