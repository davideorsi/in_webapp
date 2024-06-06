<?php

class Sostanze extends Eloquent {

	protected $table = 'Sostanze';
	public $timestamps = false;
	protected $primaryKey = 'id_sostanza';
	protected $appends = array('tipo','cd','materiali');

	public function Materiali(){
		return $this->belongsToMany('Materiale','Sostanze-Materiali','id_sostanza','ID')->withPivot('quantita');
	}

	public function Sintesi(){
		return $this->OneToMany('Sintesi','id_sostanza','id_sostanza');
	}

	public function Cromodinamica(){
		return $this->hasOne('SostanzeCromodinamica','ID','id_cromodinamica');
	}

	public function getTipoAttribute() {

		$materiali = $this->Materiali()->Get();
		$mat=0;
		$estratto = false;

		foreach($materiali as $materiale){
			 $mat=$mat+1;

			 if($materiale->Categoria == 3){
					$estratto = true;
			 }

		}

		if ($mat>0){
			  if ($estratto){
				 	$tipo = array('icon'=>'text-warning glyphicon glyphicon-filter','text'=>'Maestro');
				}else{
				 	$tipo = array('icon'=>'text-warning glyphicon glyphicon-fire','text'=>'Alchimista');
				}
		}else{
				$tipo = array('icon'=>'text-warning glyphicon glyphicon-leaf','text'=>'Erborista');
		}

		//$tipo = array('icon'=>'text-warning glyphicon glyphicon-leaf','text'=>'Erborista');
		return $tipo;
	}

	public function getCdAttribute() {
		$cromodinamica = $this->Cromodinamica()->first();
		$cd = $cromodinamica->DESC;
		//$cd = 'giallo';
		return $cd;
	}

	public function getMaterialiAttribute() {
		$materiali = $this->Materiali()->get();

		return $materiali;
	}

}
?>
