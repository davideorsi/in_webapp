<?php

class MedicinaController extends \BaseController {

	/**
	 * Lista di tutti gli eventi
	 */
	public function index()
	{
		$eventi = Evento::orderBy('ID', 'desc')->get(array('ID','Tipo','Titolo'));

		$selectEventi = array();
		foreach($eventi as $evento) {
			$selectEventi[$evento->ID] = $evento->Tipo .'-'. $evento->Titolo;
		}

		return View::make('medicina.index')
			->with('eventi', $eventi)
			->with('selectEventi', $selectEventi);
	}

	public function showCicatriciEvento($id)
	{
		$Evento = Evento::where('ID','=',$id)->get();
		if ($id>58){$NN=3;} else {$NN=5;} #3 cartellini per PF dall'evento 5, luglio 2021


		$PG = $Evento[0]->PG()->orderby('Affiliazione','asc')->get(array('Nome','PG.ID','Affiliazione','NomeGiocatore'));
		$malattie = Malattia::get();
		$PGR=array();

		foreach($malattie as $m){
			$PGR['malattie'][]=$m;
		}

		foreach($PG as $pg){
				$pg['Cicatrici']=$NN*$pg->Ferite();
				$pg['CicatriciRimaste']=$pg['pivot']['Cicatrici'];
				$pg['Cibo']=$pg['pivot']['Cibo'];
				//$pg['Armi']=$pg['pivot']['Armi'];
				$pg['Terapia']=$pg['pivot']['Terapia'];
				$pg['Cura']=$pg['pivot']['Cura'];
				$pg['Malattia']=$pg['pivot']['IDmalattia'];

				$PGR[$pg['Affiliazione']][]=$pg;
			}

		return Response::json($PGR);
	}

	public function setCicatriciEvento()
	{
		$pgs=Input::get('pg');
		$idEvento=Input::get('evento');
		$cicatrici=Input::get('cicatrici');
		$cibo=Input::get('cibo');
		if (is_null($cibo)) {$cibo=array();}
		//$armi=Input::get('armi');
		//if (is_null($armi)) {$armi=array();}
		$terapia=Input::get('terapia');
		if (is_null($terapia)) {$terapia=array();}
		$cura=Input::get('cura');
		if (is_null($cura)) {$cura=array();}
		$malattia=Input::get('malattia');
		if (is_null($malattia)) {$malattia=array();}

		$Evento=Evento::find($idEvento);


		foreach ($pgs as $key=>$pg){
				$valCibo=0;
				if (in_array($pg,$cibo)) {$valCibo=1;}
				$valArmi=0;
				//if (in_array($pg,$armi)) {$valArmi=1;}
				$valTerapia=0;
				$valCura=0;
				if (in_array($pg,$terapia)) {$valTerapia=1;}
				if (in_array($pg,$cura)) {$valCura=1;}
				if (is_null($malattia[$key])) {$malattia[$key]=0;}
				if (is_null($cicatrici[$key])) {$cicatrici[$key]=0;}

				$Evento->PG()->updateExistingPivot($pg,array('Cicatrici'=>$cicatrici[$key],'Cibo'=>$valCibo,'Armi'=>$valArmi,'Terapia'=>$valTerapia,'Cura'=>$valCura,'IDmalattia'=>$malattia[$key]));
				}
		Session::flash('message', 'Cicatrici, Cibo e Malattie salvati correttamente!');
		return Redirect::to('admin/medicina');

	}


}
