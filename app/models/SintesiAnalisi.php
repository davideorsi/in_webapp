<?php

class SintesiAnalisi extends Eloquent {

	protected $table = 'Sintesi-Analisi';
	public $timestamps = false;
	protected $primaryKey = 'id_analisi';

	public function Materiale(){
		return $this->hasOne('Materiale','ID','id_materiale');
	}

		public function Cromodinamica(){
		return $this->hasOne('SostanzeCromodinamica','ID','id_cromodinamica');
	}

	public function PG(){
		return $this->hasONe('PG','ID','id_pg');
	}

	public function Evento(){
		return $this->hasONe('Evento','ID','id_evento');
	}
}
?>
