<?php

class TramasController extends \BaseController {

	/**
	 * Display a listing of tramas
	 *
	 * @return Response
	 */
	public function index()
	{
		$tramas = Trama::orderBy('title','asc')->get(['ID','title']);
		
		$selectTrama = array();
		foreach($tramas as $trama) {
			$selectTrama[$trama->ID] = $trama->title;
		}

		return View::make('tramas.index')->with('selectTrama',$selectTrama);
	}

	/**
	 * Show the form for creating a new trama
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('tramas.create');
	}

	/**
	 * Store a newly created trama in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Trama::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Trama::create($data);

		return Redirect::route('trama.index');
	}

	/**
	 * Display the specified trama.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$trama = Trama::findOrFail($id);

		if (Request::ajax()){
			return Response::json($trama);
		} else {
			return Redirect::route('trama.index');
		}
	}	

	/**
	 * Show the form for editing the specified trama.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$trama = Trama::find($id);

		return View::make('tramas.edit', compact('trama'));
	}

	/**
	 * Update the specified trama in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$trama = Trama::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Trama::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$trama->update($data);

		return Redirect::to('trama');
	}

	/**
	 * Remove the specified trama from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Trama::destroy($id);

		return Redirect::route('trama');
	}

}
