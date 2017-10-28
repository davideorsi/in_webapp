<?php

class MalattiaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$Malattie=Malattia::orderBy('Nome','asc')->get();
		
		$selMalattie=array('NULL' => '');
		foreach ($Malattie as $malattia){
			$selMalattie[(string)$malattia->ID] = $malattia['Nome'];
		}
		
		return View::make('malattia.index')
				->with('selMalattie',$selMalattie);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('malattia.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$Malattia = new Malattia;
		$Malattia->Nome	= Input::get('Nome');
		$Malattia->save();
		
		// redirect
		Session::flash('message', 'Malattia creata con successo!');
		return Redirect::to('admin/malattie');
	
	}
	
	
	public function nuovoStadio()
	{
		$Stadio = new Stadio;
		$Stadio->Numero	= Input::get('Numero');
		$Stadio->Malattia	= Input::get('Malattia');
		$Stadio->Descrizione	= Input::get('Descrizione');
		$Stadio->Effetti	= Input::get('Effetti');
		$Stadio->Contagio	= Input::get('Contagio');
		$Stadio->save();
		
		// redirect
		Session::flash('message', 'Stadio creato con successo!');
		return Redirect::to('admin/malattie/'.$Stadio->Malattia.'/edit');
	
	}



	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$Malattia=Malattia::find($id);
		$data=$Malattia->toArray();
		$data['Stadi']=$Malattia->Stadi->toArray();
		$data['Cure']=$Malattia->Cure->toArray();
		return View::make('malattia.edit')
				->with('Malattia',$data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$Malattia=Malattia::find($id);
		$Malattia->Nome	= Input::get('Nome');
		$Malattia->save();
		
		// redirect
		Session::flash('message', 'Malattia modificata con successo!');
		return Redirect::to('admin/malattie/'.$id.'/edit');
	}

	public function aggiornaStadio($id)
	{
		$Stadio = Stadio::find($id);
		$Stadio->Numero	= Input::get('Numero');
		$Stadio->Descrizione	= Input::get('Descrizione');
		$Stadio->Effetti	= Input::get('Effetti');
		$Stadio->Contagio	= Input::get('Contagio');
		$Stadio->save();
		
		// redirect
		Session::flash('message', 'Stadio modificato con successo!');
		return Redirect::to('admin/malattie/'.$Stadio->Malattia.'/edit');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$Malattia = Malattia::find($id);
		$Malattia -> delete();

		Session::flash('message', 'Malattia cancellata correttamente!');
		return Redirect::to('admin/malattie');
	}
	
	
	public function cancellaStadio($id)
	{
		
		$Stadio = Stadio::find($id);
		$malattia=$Stadio->Malattia;
		$Stadio -> delete();

		Session::flash('message', 'Stadio cancellato correttamente!');
		return Redirect::to('admin/malattie/'.$malattia.'/edit');
	}


}
