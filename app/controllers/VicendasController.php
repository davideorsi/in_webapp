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

	public function show_all($id_evento)
	{
		$evento = Evento::findOrFail($id_evento);
		$vicende = $evento->Vicende;
		
		$palette=array(
			'#9B59b6',
			'#3498DB',
			'#2ecc71',
			'#1abc9c',
			'#f39c12',
			'#d35400',
			'#c0392b',
			'#BDC3c7'
		);
		

		$palette_png=array(
			'black',
			'red',
			'green',
			'blue'
		);

		$Masters = User::orderBy('ID','asc')->where('usergroup','=',7)->get();
		$coloreMaster=array();
		foreach ($Masters as $key2=>$Master){
			$coloreMaster[$Master->id] = $palette_png[$key2];
		}
		
		foreach ($vicende as $key=>$vicenda){
				$elementi=$vicenda->Elementi;
				foreach ($elementi as $elemento) {
						$pngs=$elemento->png;
						
						foreach ($pngs as $key3=>$png){
								$pngs[$key3]['color']=$coloreMaster[$png['Master']];
						}
						$elemento['png']=$pngs;
						
						
						$pngminoris=$elemento->PNGminori;
						
						foreach ($pngminoris as $key4=>$png){
								$pngminoris[$key4]['color']=$coloreMaster[$png['User']];
								$Master = User::find($png['User']);
								$pngminoris[$key4]['nomeuser']=$Master['username'];
						}
						$elemento['pngminori']=$pngminoris;
					}
					
				$vicenda['schedule']=$elementi;
				$vicenda['color']=$palette[$key%count($vicende)];
			}
		if (Request::ajax()){
			return Response::json($vicende);
		} else {
			
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

			return View::make('vicendas.all')
				->with('selectTrama', $selectTrama)
				->with('selectEventi', $selectEventi)
			->with('vicende',$vicende);
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

		return Redirect::back();
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
