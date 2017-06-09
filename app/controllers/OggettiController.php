<?php

class OggettiController extends \BaseController {

	public function index()
	{
		return View::make('oggetti.index');
	}

	public function stampa()
	{	
		
		$data['Nome']=Input::get('Nome');
		$data['Testo']=Input::get('Testo');
		$data['Size']=Input::get('Size');
		
		return View::make('oggetti.print')
			->with('Nome',$data['Nome'])
			->with('Size',$data['Size'])
			->with('Testo',$data['Testo']);
		//$pdf = PDF::loadView('oggetti.print',$data);
		//return $pdf->setWarnings(false)->stream();
	}

}


