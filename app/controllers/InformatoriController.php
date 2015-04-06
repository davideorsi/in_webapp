<?php

class InformatoriController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$informatori = Informatori::orderBy('IDEvento', 'desc')->orderBy('Categoria', 'asc')->get();

		$selectInfo = array();
			foreach ($informatori as $info){
				$Evento=$info->Evento->ID .' - '.$info->Evento->Titolo ;
				$selectInfo[$Evento][$info->ID] = $info->Categoria;
			}
			
		if (!$selectInfo){
				$selectInfo[0]=NULL;
			}
			
		// load the view and pass the nerds
		return View::make('informatori.index')
			->with('selectInfo', $selectInfo);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$eventi = Evento::orderBy('ID', 'desc')->get(array('ID','Tipo','Titolo'));

		$selectEventi = array();
		foreach($eventi as $evento) {
			$selectEventi[$evento->ID] = $evento->Tipo .'-'. $evento->Titolo;
		}
		
		$selectCategoria=array(
			'Politica e Avvenimenti Ducali' => 'Politica e Avvenimenti Ducali', 
			'Politica e Avvenimenti Stati Esteri' => 'Politica e Avvenimenti Stati Esteri',  
			'Voci di Strada' => 'Voci di Strada', 
			'Occulto' => 'Occulto',
			'Economia Ducale' => 'Economia Ducale',
			'Situazione Militare' => 'Situazione Militare',
			'Cultura e Conoscenza' => 'Cultura e Conoscenza' 
			);
			
		// load the view and pass the nerds
		return View::make('informatori.create')
			->with('selectCategoria', $selectCategoria)
			->with('selectEventi', $selectEventi);
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
			'Evento' => 'required',
			'Categoria' => 'required',
			'Testo' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/informatori/create')
				->withErrors($validator);
		} else {
			// store
			$informatori = new Informatori;
			$informatori->IDEvento       = Input::get('Evento');
			$informatori->Categoria       = Input::get('Categoria');
			$informatori->Testo      = Input::get('Testo');
			$informatori->save();

			// redirect
			Session::flash('message', 'Informazione creata con successo!');
			return Redirect::to('admin/informatori');
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
		$info = Informatori::find($id);
		$out['Categoria']=$info['Categoria'];
		$out['Evento']=$info->Evento->Tipo .'-'. $info->Evento->Titolo;
		$out['Testo']=nl2br($info['Testo']);
		return Response::json($out);	
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$info = Informatori::find($id);
		
		$eventi = Evento::orderBy('ID', 'desc')->get(array('ID','Tipo','Titolo'));

		$selectEventi = array();
		foreach($eventi as $evento) {
			$selectEventi[$evento->ID] = $evento->Tipo .'-'. $evento->Titolo;
		}
		
		$selectCategoria=array(
			'Politica e Avvenimenti Ducali' => 'Politica e Avvenimenti Ducali', 
			'Politica e Avvenimenti Stati Esteri' => 'Politica e Avvenimenti Stati Esteri',  
			'Voci di Strada' => 'Voci di Strada', 
			'Occulto' => 'Occulto',
			'Economia Ducale' => 'Economia Ducale',
			'Situazione Militare' => 'Situazione Militare',
			'Cultura e Conoscenza' => 'Cultura e Conoscenza' 
			);

		// show the edit form and pass the object
		return View::make('informatori.edit')
			->with('info', $info)
			->with('selectCategoria', $selectCategoria)
			->with('selectEventi', $selectEventi);
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
			'IDEvento' => 'required',
			'Categoria' => 'required',
			'Testo' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/informatori/'.$id.'/edit')
				->withErrors($validator);
		} else {
			// store
			$informatori = Informatori::find($id);
			$informatori->IDEvento       = Input::get('IDEvento');
			$informatori->Categoria       = Input::get('Categoria');
			$informatori->Testo      = Input::get('Testo');
			$informatori->save();

			// redirect
			Session::flash('message', 'Informazione aggiornata con successo!');
			return Redirect::to('admin/informatori');
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
		$info = Informatori::find($id);
		$info -> delete();

		Session::flash('message', 'Informazione cancellata correttamente!');
		return Redirect::to('admin/informatori');
	}


}
