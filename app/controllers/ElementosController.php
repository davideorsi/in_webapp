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

		return Redirect::to('scheduler');
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
		$pngminori=$elemento->PNGminori;
		$pngs=$elemento->PNG;
		
		$palette=array(
			'black',
			'red',
			'green',
			'blue',
			'purple',
			'orange'
		);
		
		$Masters = User::orderBy('ID','asc')->where('usergroup','=',7)->orwhere('usergroup','=',15)->get();
		$coloreMaster=array();
		foreach ($Masters as $key=>$Master){
			$coloreMaster[$Master->id] = $palette[$key];
		}
		
		foreach ($pngs as $key=>$png){
				$pngs[$key]['color']=$coloreMaster[$png['Master']];
				$Master = User::find($png['Master']);
				$pngs[$key]['nomemaster']=$Master['username'];
		}		
		if ($pngminori) {
		foreach ($pngminori as $key=>$png){
				$pngminori[$key]['color']=$coloreMaster[$png['User']];
				$Master = User::find($png['User']);
				$pngminori[$key]['nomeuser']=$Master['username'];
		}
		}

		//if (Request::ajax()){
			return Response::json($elemento);
		//} 
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

		return Redirect::back();
	} 
	 
	public function update_time($id)
	{
		$elemento = Elemento::findOrFail($id);

		$data= Input::all();
		$start = $data['start'];
		$end = $data['end'];
		


		$elemento['start']=$start;
		$elemento['end']=$end;

		$elemento->save();

		return Redirect::back();
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
		
		return Redirect::back();
	}
	
	
	public function add_png($idElemento)
	{
		$idPng=Input::get('PNG');

		$Elemento=Elemento::find($idElemento);
		$Elemento->PNG()->attach($idPng);
	}
	
	public function add_png_minor($idElemento)
	{
		$idMaster=Input::get('Master');
		$minori=Input::get('pngminori');

		$el=new ElementoPNGminori;
		$el->User=$idMaster;
		$el->PNG=$minori;
		$el->Elemento=$idElemento;
		$el->save();
		
		return Redirect::to('scheduler');
		
	}

	public function remove_png($idElemento)
	{
		$idPng=Input::get('PNG');

		$Elemento=Elemento::find($idElemento);
		$Elemento->PNG()->detach($idPng);
	}

	public function remove_png_minor($idElemento)
	{
		$Elemento=ElementoPNGminori::destroy($idElemento);
	}
}
