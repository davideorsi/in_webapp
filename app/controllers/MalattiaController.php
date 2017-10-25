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
				->with('selMalattie',$selMalattie);;
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
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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


}
