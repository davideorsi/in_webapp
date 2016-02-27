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
			'#BDC3c7',
			'#9B59b6',
			'#3498DB',
			'#2ecc71',
			'#1abc9c',
			'#f39c12',
			'#d35400',
			'#c0392b',
			'#BDC3c7',
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
		$nomeMaster=array();
		foreach ($Masters as $key2=>$Master){
			$coloreMaster[$Master->id] = $palette_png[$key2];
			$nomeMaster[$Master->id] = $Master->username;
		}
		
		foreach ($vicende as $key=>$vicenda){
				$elementi=$vicenda->Elementi;
				foreach ($elementi as $elemento) {
						$elemento->png;
						$elemento->PNGminori;
						
						foreach ($elemento['png'] as $key3=>$png){
								$elemento['png'][$key3]['color']=$coloreMaster[$png['Master']];
								$elemento['png'][$key3]['nomeuser']=$nomeMaster[$png['Master']];
						}
						
						foreach ($elemento['pngminori'] as $key4=>$png){
								$elemento['pngminori'][$key4]['color']=$coloreMaster[$png['User']];
								$elemento['pngminori'][$key4]['nomeuser']=$nomeMaster[$png['User']];
						}
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
	
	public function show_all_master($id_evento,$idmaster)
	{

		$palette_png=array(
			'black',
			'red',
			'green',
			'blue'
		);

		$Masters = User::orderBy('ID','asc')->where('usergroup','=',7)->get();
		$coloreMaster=array();
		$nomeMaster=array();
		foreach ($Masters as $key2=>$Master){
			$coloreMaster[$Master->id] = $palette_png[$key2];
			$nomeMaster[$Master->id] = $Master->username;
		}
		$ilmaster=User::find($idmaster);

		$evento = Evento::findOrFail($id_evento);
		
		$vicende = $evento->Vicende;
		$elenco=INtools::select_column($vicende,'ID');	
		$elenco = array_map(
			create_function('$value', 'return (int)$value;'),
			$elenco
		);
		
		
		$elementi= Elemento::orderBy('start', 'asc')->whereIn('vicenda',$elenco)->get();
		
		foreach($elementi as $key=>$elemento){
			$elemento->PNGminori;
			$elemento->PNG;
		
			
			$elenco1=INtools::select_column($elemento['pngminori'],'User');
			$elenco2=INtools::select_column($elemento['png'],'Master');
			
			if (!(in_array($idmaster,$elenco1) | in_array($idmaster,$elenco2))) {
				unset($elementi[$key]);
			} else {
				
				foreach ($elemento['png'] as $key3=>$png){
					$elemento['png'][$key3]['color']=$coloreMaster[$png['Master']];
					$elemento['png'][$key3]['nomeuser']=$nomeMaster[$png['Master']];
				}
				
				foreach ($elemento['pngminori'] as $key4=>$png){
					$elemento['pngminori'][$key4]['color']=$coloreMaster[$png['User']];
					$elemento['pngminori'][$key4]['nomeuser']=$nomeMaster[$png['User']];
				}
			
			}
		}
		return View::make('vicendas.master')
			->with('Evento',$evento)
			->with('vicende',$vicende)
			->with('elementi',$elementi)
			->with('master',$ilmaster);
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
