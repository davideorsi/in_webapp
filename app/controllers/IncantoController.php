<?php

class IncantoController extends \BaseController {

	/**
	 * Lista di tutti gli eventi, con la scelta tra editare, aggiungere o
	 * cancellare una incanto
	 */
	public function index()
	{
		$incanti = Incanto::orderBy('Livello', 'asc')->get(array('ID','Nome','Livello'));

		$selectIncanti = array();
		foreach($incanti as $incanto) {
			$selectIncanti[$incanto->ID] = $incanto->Nome .'- (liv. '. $incanto->Livello .')';
		}
		// load the view and pass the nerds
		return View::make('incanto.index')
			->with('incanti', $incanti)
			->with('selectIncanti', $selectIncanti);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('incanto.create');
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
			'Nome' => 'required',
			'Livello' => 'required',
			'Formula' => 'required',
			'Descrizione' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/incanto/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$incanto = new Incanto;
			$incanto->Nome       = Input::get('Nome');
			$incanto->Livello      = Input::get('Livello');
			$incanto->Formula 	  = Input::get('Formula');
			$incanto->Descrizione	  = Input::get('Descrizione');
			$incanto->Base	  = Input::get('Base',0);
			$incanto->save();

			// redirect
			Session::flash('message', 'Incanto creato con successo!');
			return Redirect::to('admin/incanto');
		}
	}

	
	/**
	 * Ritorna la incanto indicata da $id in formato json (per l'editing).
	 *
	 * 
	 */
	public function show($id)
	{
		// mostra solo le incanti che non sono bozze

		$incanto = Incanto::find($id);
		
		$incanto['Descrizione']=nl2br($incanto['Descrizione']);
		if (Request::ajax()){
			return Response::json($incanto);
		} else {
			return Response::make('Not available', 401);
		}
			
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$incanto = Incanto::find($id);

		// show the edit form and pass the object
		return View::make('incanto.edit')
			->with('incanto', $incanto);
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
			'Nome' => 'required',
			'Livello' => 'required',
			'Formula' => 'required',
			'Descrizione' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/incanto/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$incanto = Incanto::find($id);
			$incanto->Nome       = Input::get('Nome');
			$incanto->Livello      = Input::get('Livello');
			$incanto->Formula 	  = Input::get('Formula');
			$incanto->Descrizione	  = Input::get('Descrizione');
			$incanto->Base	  = Input::get('Base',0);
			$incanto->save();

			// redirect
			Session::flash('message', 'Incanto aggiornato con successo!');
			return Redirect::to('admin/incanto');
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
		$incanto = Incanto::find($id);
		$incanto -> delete();

		Session::flash('message', 'Incanto cancellato correttamente!');
		return Redirect::to('admin/incanto');
	}


}
