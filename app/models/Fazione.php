<?php

class Fazione extends Eloquent {

	protected $table = 'Fazioni';
	public $timestamps = false;
	protected $primaryKey = 'ID';

	public function StatoLab(){
		return $this->hasOne('LaboratorioStato','ID','id_laboratorio_stato');
	}

}
