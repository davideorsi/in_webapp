<?php

class VicendasController extends \BaseController {

	/**
	 * Display a listing of vicendas
	 *
	 * @return Response
	 */
	public function index()
	{
		$vicendas = Vicenda::orderBy('live', 'desc')->get(array('ID','live','title','trama'));

		$selectVicenda = array();
		foreach($vicendas as $key=>$vicenda) {
			if ($key==0) {
				$first=$vicenda->ID;
			}
			if ($vicenda['trama']) {
			$trama=	$vicenda->Trama->title;
			$selectVicenda[$vicenda->Evento->Titolo][$vicenda->ID] = $vicenda->title .' ('. $trama.')';
			} else {
				$selectVicenda[$vicenda->Evento->Titolo][$vicenda->ID] = $vicenda->title;
			}
		}
		return View::make('vicendas.index')
					->with('selectVicenda',$selectVicenda)
					->with('first',$first);
	}

	/**
	 * Show the form for creating a new vicenda
	 *
	 * @return Response
	 */
	public function create()
	{
		
		$tramas = Trama::orderBy('title','asc')->get(['ID','title']);
		$selectTrama = array(NULL=>'');
		foreach($tramas as $trama) {
			$selectTrama[$trama->ID] = $trama->title;
		}
		
		$eventi = Evento::orderBy('ID', 'desc')->get(array('ID','Tipo','Titolo'));
		$selectEventi = array();
		foreach($eventi as $evento) {
			$selectEventi[$evento->ID] = $evento->Tipo .'-'. $evento->Titolo;
		}

		return View::make('vicendas.create')
				->with('selectTrama', $selectTrama)
				->with('selectEventi', $selectEventi);
	}

	/**
	 * Store a newly created vicenda in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Vicenda::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Vicenda::create($data);

		return Redirect::to('vicenda');
	}

	/**
	 * Display the specified vicenda.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$vicenda = Vicenda::findOrFail($id);
		if (Request::ajax()){
			return Response::json($vicenda);
		} else {
			return Redirect::to('vicenda');
		}
	}

	/**
	 * Show the form for editing the specified vicenda.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$vicenda = Vicenda::find($id);
		
				
		$tramas = Trama::orderBy('title','asc')->get(['ID','title']);
		$selectTrama = array(NULL=>'');
		foreach($tramas as $trama) {
			$selectTrama[$trama->ID] = $trama->title;
		}
		
		$eventi = Evento::orderBy('ID', 'desc')->get(array('ID','Tipo','Titolo'));
		$selectEventi = array();
		foreach($eventi as $evento) {
			$selectEventi[$evento->ID] = $evento->Tipo .'-'. $evento->Titolo;
		}

		return View::make('vicendas.edit')
				->with('vicenda', $vicenda)
				->with('selectTrama', $selectTrama)
				->with('selectEventi', $selectEventi);
	}

	/**
	 * Update the specified vicenda in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$vicenda = Vicenda::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Vicenda::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$vicenda->update($data);

		return Redirect::to('vicenda');
	}

	/**
	 * Remove the specified vicenda from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Vicenda::destroy($id);

		return Redirect::to('vicenda');;
	}

}
