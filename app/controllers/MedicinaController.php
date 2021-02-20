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
	
		$PG = $Evento[0]->PG()->orderby('Affiliazione','asc')->get(array('Nome','PG.ID','Affiliazione','NomeGiocatore'));

		$PGR=array();
		foreach($PG as $pg){
				$pg['Cicatrici']=5*$pg->Ferite();
				$pg['CicatriciRimaste']=$pg['pivot']['Cicatrici'];
				$pg['Cibo']=$pg['pivot']['Cibo'];
				$pg['Armi']=$pg['pivot']['Armi'];
				
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
		$armi=Input::get('armi');
		if (is_null($cibo)) {$cibo=array();}
		if (is_null($armi)) {$armi=array();}
		
		$Evento=Evento::find($idEvento);
		
		
		foreach ($pgs as $key=>$pg){
				$valCibo=0;
				if (in_array($pg,$cibo)) {$valCibo=1;} 
				$valArmi=0;
				if (in_array($pg,$armi)) {$valArmi=1;} 
				if (is_null($cicatrici[$key])) {$cicatrici[$key]=0;}
				$Evento->PG()->updateExistingPivot($pg,array('Cicatrici'=>$cicatrici[$key],'Cibo'=>$valCibo,'Armi'=>$valArmi));
				}
		Session::flash('message', 'Cicatrici, Cibo e Armi salvati correttamente!');
		return Redirect::to('admin/medicina');

	}

	
}
