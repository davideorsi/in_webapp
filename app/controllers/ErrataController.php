<?php

class ErrataController extends \BaseController {

	/**
	 * Lista di tutti gli eventi, con la scelta tra editare, aggiungere o
	 * cancellare una errata
	 */
	public function index()
	{
		$errati = Errata::orderBy('ID', 'desc')->get(array('ID','Titolo','Testo','Bozza'));
		$selectErrati = array();
		foreach($errati as $errata) {
			$selectErrati[$errata->ID] = $errata->ID.') '. $errata->Titolo;
			if  ($errata->Bozza==1){
				$selectErrati[$errata->ID].= ' (Bozza)';
			}
		}
		// load the view and pass the nerds
		return View::make('errata.index')
			->with('errati', $errati)
			->with('selectErrati', $selectErrati);
	}

	public function lista()
	{
		$errati = Errata::where('Bozza','=',0)->orderBy('ID', 'desc')->get(array('ID','Titolo','Testo','Bozza'));
		$selectErrati = array(0=>"");
		foreach($errati as $errata) {
			$selectErrati[$errata->ID] = $errata->ID.') '. $errata->Titolo;
		}
		// load the view and pass the nerds
		return View::make('errata.list')
			->with('errati', $errati)
			->with('selectErrati', $selectErrati);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('errata.create');
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
			'Titolo' => 'required',
			'Testo' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/errata/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$errata = new Errata;
			$errata->Titolo       = Input::get('Titolo');
			$errata->Testo      = Input::get('Testo');
			$errata->Bozza 	  = Input::get('Bozza',0);
			$errata->save();

			// redirect
			Session::flash('message', 'Errata creata con successo!');
			return Redirect::to('admin/errata');
		}
	}

	
	/**
	 * Ritorna la errata indicata da $id in formato json (per l'editing).
	 *
	 * 
	 */
	public function show($id)
	{
		$errata = Errata::find($id);
		$errata['N']=Errata::orderBy('id', 'DESC')->count();
		$errata['Titolo']=nl2br($errata['Titolo']);
		$errata['Testo']=nl2br($errata['Testo']);
		if ($errata['Bozza']==0) {
			return Response::json($errata);
		} else {
			return Response::json(array());
		}		
		
	}

	public function show_master($id)
	{
		//mostra tutte le errati se sei un master
		$errata = Errata::find($id);
		$errata['N']=Errata::orderBy('id', 'DESC')->count();
		$errata['Titolo']=nl2br($errata['Titolo']);
		$errata['Testo']=nl2br($errata['Testo']);
		return Response::json($errata);	
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$errata = Errata::find($id);

		// show the edit form and pass the object
		return View::make('errata.edit')
			->with('errata', $errata);
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
			'Titolo' => 'required',
			'Testo' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/errata/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$errata = Errata::find($id);
			$errata->Titolo       = Input::get('Titolo');
			$errata->Testo      = Input::get('Testo');
			$errata->Bozza 	  = Input::get('Bozza',0);
			$errata->save();

			// redirect
			Session::flash('message', 'Errata aggiornata con successo!');
			return Redirect::to('admin/errata');
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
		$errata = Errata::find($id);
		$errata -> delete();

		Session::flash('message', 'Errata cancellata correttamente!');
		return Redirect::to('admin/errata');
	}
	
	


}
