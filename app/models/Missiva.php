<?php

class Missiva extends Eloquent {

	protected $table = 'messaggi';
	public $timestamps = false;
	protected $primaryKey = 'id';
	protected $appends = array('mitt', 'dest','tipo');

	public function getTipoAttribute() {
		switch ($this->costo) {
			case 0:
				$tipo = array('icon'=>'text-success glyphicon glyphicon-comment','text'=>'Missiva tra PG');
				break;
			case 2:
				$tipo = array('icon'=>'text-primary glyphicon glyphicon-tower','text'=>'Missiva nel Ducato');
				break;
			case 4:
				$tipo = array('icon'=>'text-warning glyphicon glyphicon-globe','text'=>'Missiva Estera');
				break;
			case 10:
				$tipo = array('icon'=>'text-danger glyphicon glyphicon-certificate','text'=>'Missiva Sicura');
				break;
			}
			return $tipo;
	}

	public function getMittAttribute() {
		if ($this->tipo_mittente=='PG') {
			$pg=PG::find($this->mittente);
			return $pg->Nome;
			}
		else {
			return $this->mittente;
			}
		}

	public function getDestAttribute() {
		if ($this->tipo_destinatario=='PG') {
			$pg=PG::find($this->destinatario);
			return $pg->Nome;
			}
		else {
			return $this->destinatario;
			}
		}

}

?>
