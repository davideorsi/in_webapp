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
		$vicende = $trama->Vicende()->get();
		
		$Masters = User::orderBy('ID','asc')->where('usergroup','=',7)->orwhere('usergroup','=',15)->get();
		$nomeMaster=array();
		foreach ($Masters as $key2=>$Master){
			$nomeMaster[$Master->id] = $Master->username;
		}
		
		foreach ($vicende as &$vic ) {
			$evento= Evento::find($vic['live']);
			$vic['Evento']=$evento->Titolo;
			$vic['Data']=$evento->Data;
			
			$elementi=$vic->Elementi;
				foreach ($elementi as $elemento) {
	
						$elemento->png;
						$elemento->PNGminori;
							foreach ($elemento['png'] as $key3=>$png){
								$elemento['png'][$key3]['nomeuser']=$nomeMaster[$png['Master']];
							}
						
							foreach ($elemento['pngminori'] as $key4=>$png){
								$elemento['pngminori'][$key4]['nomeuser']=$nomeMaster[$png['User']];
							}
						
					}
					
				$vic['schedule']=$elementi;
			
		}

		//var_dump($vicende);
		if (Request::ajax()){
			return Response::json($trama);
		}else {
		return View::make('tramas.show')->with('trama',$trama)->with('vicende',$vicende);
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
