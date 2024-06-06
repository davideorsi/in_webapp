<?php

class PG extends Eloquent {

	protected $table = 'PG';
	public $timestamps = false;
	protected $primaryKey = 'ID';

	public function Abilita() {
		return $this->belongsToMany('Abilita', 'Ability-PG', 'ID PG', 'ID Abil');
	}

	public function Incanti() {
		return $this->belongsToMany('Incanto', 'Incanti-PG', 'ID PG', 'ID Incanto');
	}

	public function Categorie() {
		return $this->belongsToMany('Categoria', 'Categorie-PG', 'PG', 'CAT');
	}

	public function Sbloccate() {
		return $this->belongsToMany('Abilita', 'Sbloccate-PG', 'ID PG', 'ID Abil');
	}

	public function User(){
		return $this->belongsTo('Giocatore','ID','pg');
	}

	public function Spese(){
		return $this->hasMany('Spese','PG','ID');
	}
	public function Conto(){
		return $this->hasMany('Conto','PG','ID');
	}

	public function Firme(){
		return $this->hasMany('IDENTITAPG','ID_PG','ID');
	}

	public function RotteCommerciali(){
		return $this->hasMany('RottaCommerciale','IDPG','ID');
	}

	public function Malattie(){
		return $this->belongsToMany('Stadio', 'Malattie-PG', 'PG', 'Stadio');
	}

	public function Ferite(){
		$pf=2;
		$ab=$this->Abilita()->get();
		$ab=INtools::select_column($ab,'Ability');
		if(in_array('Costituzione debole',$ab)){$pf-=1;}
		if(in_array('Robustezza',$ab)){$pf+=1;}
		if(in_array('Robustezza 2',$ab)){$pf+=1;}
		return $pf;
		}
	public function PxRimasti(){
		return intval($this->Px - $this->Abilita->sum('PX'));
		}
	public function Erbe(){
		return intval($this->Abilita()->sum('Erbe'));
		}
	public function Oggetti(){
		return intval($this->Abilita()->sum('Oggetti'));
		}
	public function Lettere(){
		return intval($this->Abilita()->sum('Lettere'));
		}
	public function Rendita(){
		return intval(2 + $this->Abilita()->sum('Rendita'));
		}

	public function CartelliniPotere(){
		return intval($this->Abilita()->sum('CartelliniPotere'));
		}

	public function Note(){
		return implode('<br>',$this->Abilita()->where('Note','!=','')->lists('Note'));
		}


	public function Licenza() {
		return $this->belongsToMany('Licenza', 'Licenze-PG', 'IDPG', 'IDLicenza')
					->withPivot('Inizio','UltimoRinnovo','Scaduta','Rinnovi','Prezzo');
	}

	public function Rotte($id_evento){
		$acquisti = '';
		try{
			$rotteGruppo = RottaCommercialeGruppo::where('id_evento',$id_evento)->Orderby('ID','Desc')->first();
			if($rotteGruppo){
				$rotte_pg = $this->RotteCommerciali()->where('Evento',$rotteGruppo["ID"])->get();

				foreach ($rotte_pg as $Rotta){
					$num = $Rotta['Acquistati'];
					$nome = $Rotta->Materiale()->pluck('Nome');
					if ($num > 0) {
						if ($acquisti != '')  $acquisti .= '<br>';
						$acquisti .= $nome.' x'.$num;
						}

					}
			}

		} catch (ErrorException $e) {};
		return $acquisti;
	}

	public function Sintesi(){
		return $this->hasMany('Sintesi','id_pg','ID');
	}

	public function SintesiEstratti(){
		return $this->hasMany('SintesiEstratti','id_pg','ID');
	}

	public function SintesiAnalisi(){
		return $this->hasMany('SintesiAnalisi','id_pg','ID');
	}

	public function SintesiAvere($id_evento){
		$avere = '';
		$eventi = Evento::where('tipo','EVENTO LIVE')->where('ID','<=',$id_evento)->Orderby('ID','Desc')->take(2)->get();
    $evento = $eventi[1];

		$sintesiPG = $this->Sintesi()->where('id_evento',$evento["ID"])->get();
		$analisiPG = $this->SintesiAnalisi()->where('id_evento',$evento["ID"])->get();
		$estrattiPG = $this->SintesiEstratti()->where('id_evento',$evento["ID"])->get();

		$vTot = 0;
		$rTot = 0;
		$bTot = 0;
		$materiali = '';

		foreach ($sintesiPG as $sin){

			$vTot = $vTot + $sin["V_matrice"];
			$rTot = $rTot + $sin["R_matrice"];
			$bTot = $bTot + $sin["B_matrice"];

			$matSin = $sin->mat()->get();

			foreach ($matSin as $mat){
				if ($materiali != '')  $materiali.= '<br>';
				$materiali.= $mat["Nome"].' x1';
			}
		}

		foreach ($analisiPG as $analisi){
			if ($materiali != '')  $materiali.= '<br>';
			$string = $analisi->Materiale()->pluck('Nome').' x1';
			$materiali.= $string;
		}

		foreach ($estrattiPG as $estratto){
			if ($materiali != '')  $materiali.= '<br>';
			$string = $estratto->Materiale()->pluck('Nome').' x2';
			$materiali.= $string;
		}

		if($vTot>0){
			if ($avere != '')  $avere.= '<br>';
			$avere.= "Erba Verde x".$vTot;
		}

		if($rTot>0){
			if ($avere != '')  $avere.= '<br>';
			$avere.= "Erba Rosso x".$rTot;
		}

		if($bTot>0){
			if ($avere != '')  $avere.= '<br>';
			$avere.= "Erba Blu x".$bTot;
		}

		if($materiali!=''){
			if ($avere != '')  $avere.= '<br>';
			$avere.= $materiali;
		}


		return $avere;
	}

	public function SintesiDare($id_evento){
		$dare = '';

		$eventi = Evento::where('tipo','EVENTO LIVE')->where('ID','<=',$id_evento)->Orderby('ID','Desc')->take(2)->get();
		$evento = $eventi[1];

		$sintesiPG = $this->Sintesi()->where('id_evento',$evento["ID"])->get();
		$estrattiPG = $this->SintesiEstratti()->where('id_evento',$evento["ID"])->get();

		foreach ($sintesiPG as $sin){

			$sostanza = $sin->Sostanza()->first();

			if($sostanza){
				if ($dare != '')  	$dare.= '<br>';
				$dare.= $sostanza["nome"].' x1';
			}
		}

		foreach ($estrattiPG as $estratto){
			$mat = $estratto->Estratto()->first();
			if($mat){
					if ($dare != '')  	$dare.= '<br>';
					$dare.= $mat["Nome"].' x1';
			}
		}

		return $dare;
	}
}
?>
