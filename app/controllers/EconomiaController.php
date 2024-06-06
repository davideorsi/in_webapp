<?php

class EconomiaController extends \BaseController {

	/**
	 * Lista di tutti gli eventi, con la scelta tra editare, aggiungere o
	 * cancellare una incanto
	 */
	public function index()
	{
		$Fazioni = Fazione::orderBy('ID', 'asc')->take(3)->get();
		$Beni = Bene::orderBy('ID', 'asc')->get();
		$statiLaboratori = LaboratorioStato::orderBy('ID', 'asc')->get();

		$max=max(array($Fazioni[0]['Condizione'],$Fazioni[1]['Condizione']));
		$min=min(array($Fazioni[0]['Condizione'],$Fazioni[1]['Condizione']));

		$selCondizione=array(
			1 => 'Carestia',
			2 => 'Difficile',
			3 => 'Normale',
			4 => 'Florida'
			);

		$totrich=array(2,4,6,8);
		$minrich=array(2,2,3,4);

		foreach($Fazioni as $faz) {
			$faz['Totale']=INtools::convertiMonete($totrich[$faz['Condizione']-1]*50+$faz['Ricchezza']*50-$faz['Sovratassa']);
			$faz['Minimo']=INtools::convertiMonete($minrich[$faz['Condizione']-1]*50);
			}

		$Nbeni=array(0,3,5,8,10);
		$Nbeni=$Nbeni[$max];
		$PBA=array(0,30,20,10,5);
		$PBV=array(0,40,30,20,10);


		foreach ($Beni as $bene){
			$bene['PA']=INtools::convertiMonete($PBA[$max]*floatval($bene['IR']));
			$bene['PV']=INtools::convertiMonete($PBV[$min]*floatval($bene['IR']));

		}

		$selStatoLab = array();
		foreach($statiLaboratori as $stato){
			$selStatoLab[$stato["ID"]] = $stato["Descrizione"];
		}

		// dd($Beni);
		// load the view and pass the nerds
		return View::make('economia.index')
			->with('Fazioni', $Fazioni)
			->with('selCondizione', $selCondizione)
			->with('Nbeni',$Nbeni)
			->with('selStatoLab',$selStatoLab)
			->with('Beni', $Beni);
	}

	public function update()
	{
		$cond=Input::get('Condizione');
		$infl=Input::get('Influenza');
		$rich=Input::get('Ricchezza');
		$sovr=Input::get('Sovratassa');
		$IR=Input::get('IR');

		$labR =Input::get('labRochelle');
		$labN =Input::get('labNottingham');
		$labO =Input::get('labOspitale');

		$Beni = Bene::orderBy('ID', 'asc')->get();
		foreach ($Beni as $key=>$bene){
			$bene->IR=$IR[$key];
			$bene->save();
		}

		$Fazione=Fazione::find(1);
		$Fazione->Condizione=$cond[0];
		$Fazione->Influenza=$infl[0];
		$Fazione->Ricchezza=$rich[0];
		$Fazione->Sovratassa=$sovr[0];
		$Fazione->id_laboratorio_stato=$labR;
		$Fazione->save();

		$Fazione=Fazione::find(2);
		$Fazione->Condizione=$cond[1];
		$Fazione->Influenza=$infl[1];
		$Fazione->Ricchezza=$rich[1];
		$Fazione->Sovratassa=$sovr[1];
		$Fazione->id_laboratorio_stato=$labN;
		$Fazione->save();

		$Fazione=Fazione::find(3);
		$Fazione->id_laboratorio_stato=$labO;
		$Fazione->save();

		$msg=' Informazioni aggiornate con successo.';
		Session::flash('message', $msg);
		return Redirect::to('admin/economia');
	}

}
