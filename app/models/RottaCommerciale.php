<?php

class RottaCommerciale extends Eloquent {

	protected $table = 'RotteCommerciali';
	public $timestamps = false;
	protected $primaryKey = 'ID';

	public function PG() {
		return $this->belongsTo('PG', 'IDPG','ID');
		}
		
	public function Gruppo(){
		return $this->belongsTo('RottaComercialeGruppo', 'Evento','ID');
	}
	/*
	public function Evento(){
		return $this->belongsTo('Evento', 'Evento','ID');
	}
	*/
	public function Materiale() {
		return $this->belongsTo('Materiale','IDMateriale','ID');
		}
}
