<?php

class VoceController extends \BaseController {

	/**
	 * Lista di tutti gli eventi, con la scelta tra editare, aggiungere o
	 * cancellare una voce
	 */
	public function index()
	{
		$voci = Voce::orderBy('Data', 'desc')->get(array('ID','Data','Testo','Bozza'));
		$selectVoci = array();
		foreach($voci as $voce) {
			$data=new Datetime($voce['Data']);
			$selectVoci[$voce->ID] = $voce->ID.') '. strftime("%d %B %Y",$data->gettimestamp()) .' - '. INtools::first_words($voce->Testo,3).'&hellip;';
			if  ($voce->Bozza==1){
				$selectVoci[$voce->ID].= ' (Bozza)';
			}
		}
		// load the view and pass the nerds
		return View::make('voce.index')
			->with('voci', $voci)
			->with('selectVoci', $selectVoci);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('voce.create');
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
			'Testo' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/voce/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$voce = new Voce;
			$voce->Data       = Input::get('Data');
			$voce->Testo      = Input::get('Testo');
			$voce->Chiusa 	  = Input::get('Chiusa');
			$voce->Bozza 	  = Input::get('Bozza',0);
			$voce->save();

			// redirect
			Session::flash('message', 'Voce creata con successo!');
			return Redirect::to('admin/voce');
		}
	}

	
	/**
	 * Ritorna la voce indicata da $id in formato json (per l'editing).
	 *
	 * 
	 */
	public function show($text)
	{
		//mostra solo le voci che non sono bozze
		$voci=Voce::orderBy('Data', 'desc')->where('Bozza','!=','1')->where('Testo', 'like', '%'.$text.'%')->paginate(2);	
		
		foreach($voci as $voce){
			$data=new Datetime($voce['Data']);
			$voce['Data']=strftime("%d %B %Y",$data->gettimestamp());
			$voce['Testo']=nl2br($voce['Testo']);
		}
		
		if (Request::ajax()){
			return Response::json($voci);
		} else {
			return Redirect::to('/');
		}	
	}

	public function show_master($id)
	{
		//mostra tutte le voci se sei un master
		$voce = Voce::find($id);
		$voce['N']=Voce::orderBy('id', 'DESC')->count();
		$data=new Datetime($voce['Data']);
		$voce['Data']=strftime("%d %B %Y",$data->gettimestamp());
		$voce['Testo']=nl2br($voce['Testo']);
		return Response::json($voce);	
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$voce = Voce::find($id);

		// show the edit form and pass the object
		return View::make('voce.edit')
			->with('voce', $voce);
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
			'Testo' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/voce/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$voce = Voce::find($id);
			$voce->Data       = Input::get('Data');
			$voce->Testo      = Input::get('Testo');
			$voce->Chiusa 	  = Input::get('Chiusa');
			$voce->Bozza 	  = Input::get('Bozza',0);
			$voce->save();

			// redirect
			Session::flash('message', 'Voce aggiornata con successo!');
			return Redirect::to('admin/voce');
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
		$voce = Voce::find($id);
		$voce -> delete();

		Session::flash('message', 'Voce cancellata correttamente!');
		return Redirect::to('admin/voce');
	}
	
	


}
