<?php

class DomandaController extends \BaseController {

	/**
	 * Lista di tutti gli eventi, con la scelta tra editare, aggiungere o
	 * cancellare una domanda
	 */
	public function index()
	{
		$domande = Domanda::orderBy('ID', 'desc')->get(array('ID','Domanda','Risposta','Bozza'));
		$selectDomande = array(0=>"");
		foreach($domande as $domanda) {
			$selectDomande[$domanda->ID] = $domanda->ID.') '. $domanda->Domanda;
			if  ($domanda->Bozza==1){
				$selectDomande[$domanda->ID].= ' (Bozza)';
			}
		}
		// load the view and pass the nerds
		return View::make('domanda.index')
			->with('domande', $domande)
			->with('selectDomande', $selectDomande);
	}

	public function list()
	{
		$domande = Domanda::where('Bozza','=',0)->orderBy('ID', 'desc')->get(array('ID','Domanda','Risposta','Bozza'));
		$selectDomande = array(0=>"");
		foreach($domande as $domanda) {
			$selectDomande[$domanda->ID] = $domanda->ID.') '. $domanda->Domanda;
		}
		// load the view and pass the nerds
		return View::make('domanda.list')
			->with('domande', $domande)
			->with('selectDomande', $selectDomande);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('domanda.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//regole del validatore
		$rules = array(
			'Domanda' => 'required',
			'Risposta' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/domanda/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$domanda = new Domanda;
			$domanda->Domanda       = Input::get('Domanda');
			$domanda->Risposta      = Input::get('Risposta');
			$domanda->Bozza 	  = Input::get('Bozza',0);
			$domanda->save();

			// redirect
			Session::flash('message', 'Domanda creata con successo!');
			return Redirect::to('admin/domanda');
		}
	}

	
	/**
	 * Ritorna la domanda indicata da $id in formato json (per l'editing).
	 *
	 * 
	 */
	public function show($id)
	{
		$domanda = Domanda::find($id);
		$domanda['N']=Domanda::orderBy('id', 'DESC')->count();
		$domanda['Domanda']=nl2br($domanda['Domanda']);
		$domanda['Risposta']=nl2br($domanda['Risposta']);
		if ($domanda['Bozza']==0) {
			return Response::json($domanda);
		} else {
			return Response::json(array());
		}		
		
	}

	public function show_master($id)
	{
		//mostra tutte le domande se sei un master
		$domanda = Domanda::find($id);
		$domanda['N']=Domanda::orderBy('id', 'DESC')->count();
		$domanda['Domanda']=nl2br($domanda['Domanda']);
		$domanda['Risposta']=nl2br($domanda['Risposta']);
		return Response::json($domanda);	
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$domanda = Domanda::find($id);

		// show the edit form and pass the object
		return View::make('domanda.edit')
			->with('domanda', $domanda);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//regole del validatore
		$rules = array(
			'Domanda' => 'required',
			'Risposta' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/domanda/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$domanda = Domanda::find($id);
			$domanda->Domanda       = Input::get('Domanda');
			$domanda->Risposta      = Input::get('Risposta');
			$domanda->Bozza 	  = Input::get('Bozza',0);
			$domanda->save();

			// redirect
			Session::flash('message', 'Domanda aggiornata con successo!');
			return Redirect::to('admin/domanda');
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$domanda = Domanda::find($id);
		$domanda -> delete();

		Session::flash('message', 'Domanda cancellata correttamente!');
		return Redirect::to('admin/domanda');
	}
	
	


}
