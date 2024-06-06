<?php

class SintesiEstratti extends Eloquent {

	protected $table = 'Sintesi-Estratti';
	public $timestamps = false;
	protected $primaryKey = 'id_estrazione';

	public function Materiale(){
		return $this->hasONe('Materiale','ID','id_materiale');
	}

	public function Estratto(){
		return $this->hasONe('Materiale','ID','id_estratto');
	}

	public function PG(){
		return $this->hasONe('PG','ID','id_pg');
	}

	public function Evento(){
		return $this->hasONe('Evento','ID','id_evento');
	}
}
?>
