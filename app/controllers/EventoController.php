<?php

class EventoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$eventi = Evento::orderBy('ID', 'desc')->get(array('ID','Tipo','Titolo'));

		$selectEventi = array();
		foreach($eventi as $evento) {
			$selectEventi[$evento->ID] = $evento->Tipo .'-'. $evento->Titolo;
		}
		// load the view and pass the nerds
		return View::make('evento.index')
			->with('eventi', $eventi)
			->with('selectEventi', $selectEventi);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('evento.create');
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
			'Data' => 'required',
			'Luogo' => 'required',
			'Titolo' => 'required',
			'Tipo' => 'required',
			'Orari' => 'required',
			'Info' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/evento/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$evento = new Evento;
			$evento->Data       = Input::get('Data');
			$evento->Luogo       = Input::get('Luogo');
			$evento->Tipo      = Input::get('Tipo');
			$evento->Titolo 	  = Input::get('Titolo');
			$evento->Info 	  = Input::get('Info');
			$evento->Orari 	  = Input::get('Orari');
			$evento->save();

			// redirect
			Session::flash('message', 'Evento creato con successo!');
			return Redirect::to('admin/evento');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$evento = Evento::orderBy('ID', 'DESC')->take(1)->offset($id-1)->get();
		$evento[0]['N']=Evento::where('1','=','1')->count();

		$data= new Datetime($evento[0]['Data']);
		$evento[0]['Data']=strftime("%d %B %Y",$data->gettimestamp());
		
		$evento[0]['Orari']=nl2br($evento[0]['Orari']);
		$evento[0]['Info']=nl2br($evento[0]['Info']);
		if (Request::ajax()){
			return Response::json($evento[0]);
		} else {
			return View::make('evento.show')->with('evento', $evento[0]);
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
		$evento = Evento::find($id);

		// show the edit form and pass the object
		return View::make('evento.edit')
			->with('evento', $evento);
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
			'Data' => 'required',
			'Luogo' => 'required',
			'Titolo' => 'required',
			'Tipo' => 'required',
			'Orari' => 'required',
			'Info' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/evento/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$evento = Evento::find($id);
			$evento->Data       = Input::get('Data');
			$evento->Luogo       = Input::get('Luogo');
			$evento->Tipo      = Input::get('Tipo');
			$evento->Titolo 	  = Input::get('Titolo');
			$evento->Info 	  = Input::get('Info');
			$evento->Orari 	  = Input::get('Orari');
			$evento->save();

			// redirect
			Session::flash('message', 'Evento aggiornato con successo!');
			return Redirect::to('admin/evento');
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
		$evento = Evento::find($id);
		$evento -> delete();

		Session::flash('message', 'Evento cancellato correttamente!');
		return Redirect::to('admin/evento');
	}


}
