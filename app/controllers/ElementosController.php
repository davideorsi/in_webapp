<?php

class ElementosController extends \BaseController {




	/**
	 * Store a newly created elemento in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Elemento::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Elemento::create($data);

		return Redirect::route('elementos.index');
	}

	/**
	 * Display the specified elemento.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$elemento = Elemento::findOrFail($id);
		if (Request::ajax()){
			return Response::json($elemento);
		} else {
			return Redirect::to('elemento');
		}

	}


	/**
	 * Update the specified elemento in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$elemento = Elemento::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Elemento::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$elemento->update($data);

		return Redirect::route('elementos.index');
	}

	/**
	 * Remove the specified elemento from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Elemento::destroy($id);

		return Redirect::route('elementos.index');
	}

}
