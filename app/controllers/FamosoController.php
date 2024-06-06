<?php

class FamosoController extends \BaseController {

	/**
	 * Lista di tutti gli eventi, con la scelta tra editare, aggiungere o
	 * cancellare una famoso
	 */
	public function gallery()
	{
		$famosi = Famoso::orderBy('ID','asc')->get(array('ID','Nome','Foto'));


		return View::make('famoso.gallery')
					->with('famosi',$famosi);
	}

	public function frontGallery()
	{
		$famosi = Famoso::orderBy('ID','asc')->get(array('ID','Nome','Foto'));

		return View::make('frontpage.ambientazione.notabiliGallery')
					->with('Notabili',$famosi);
	}


	public function index()
	{
		$famosi = Famoso::all();

		$selectFamosi = array();
		foreach($famosi as $famoso) {
			$selectFamosi[$famoso->ID] = $famoso->Nome;
		}
		// load the view and pass the nerds
		return View::make('famoso.index')
			->with('selectFamosi', $selectFamosi);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('famoso.create');
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
			'Nome' => 'required',
			'photo' => 'image',
			'Storia' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/famoso/create')
				->withErrors($validator)
				->withInput();
		} else {
			// store
			$image= Input::file('photo');
			$fileName=str_random(6) . '_' . $image->getClientOriginalName();
			$destinationPath=storage_path().'/images/famoso/';

			$famoso = new Famoso;
			$famoso->Nome      = Input::get('Nome');
			$famoso->Foto      = $fileName;
			$famoso->Storia    = Input::get('Storia');
			$famoso->save();

			$image->move($destinationPath, $fileName);

			// redirect
			Session::flash('message', 'PG Famoso creato con successo!');
			return Redirect::to('admin/famoso');
		}
	}


	/**
	 * Ritorna la famoso indicata da $id in formato json (per l'editing).
	 *
	 *
	 */
	public function show($id)
	{
		// mostra solo le famosi che non sono bozze

		$famoso = Famoso::find($id);

		$paragrafi=explode( "\n",$famoso['Storia']);
		$abstract=$paragrafi[0].'</br>'.$paragrafi[1];
		unset($paragrafi[0]);
		unset($paragrafi[1]);

		$famoso['Storia']=array($abstract,implode('</br>',$paragrafi));


		if (Request::ajax()){
			return Response::json($famoso);
		} else {
			return View::make('famoso.show')->with('famoso', $famoso);
		}

	}

	public function frontShow($id)
	{
		// mostra solo le famosi che non sono bozze

		$famoso = Famoso::find($id);

		$paragrafi=explode( "\n",$famoso['Storia']);
		$abstract=$paragrafi[0].'</br>'.$paragrafi[1];
		unset($paragrafi[0]);
		unset($paragrafi[1]);

		$famoso['Storia']=array($abstract,implode('</br>',$paragrafi));


		if (Request::ajax()){
			return Response::json($famoso);
		} else {
			return View::make('frontpage.ambientazione.notabile')->with('Notabile', $famoso);
		}

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$famoso = Famoso::find($id);

		// show the edit form and pass the object
		return View::make('famoso.edit')
			->with('famoso', $famoso);
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
			'Nome' => 'required',
			'Storia' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/famoso/'.$id.'/edit')
				->withErrors($validator)
				->withInput();
		} else {

			// store
			$famoso = Famoso::find($id);

			$image=Input::file('Foto');
			if ($image) {
				$fileName=str_random(6) . '_' . $image->getClientOriginalName();
				$destinationPath=storage_path().'/images/famoso/';
				$famoso->Foto      = $fileName;
				$image->move($destinationPath, $fileName);
			}

			$famoso->Nome      = Input::get('Nome');
			$famoso->Storia    = Input::get('Storia');
			$famoso->save();


			// redirect
			Session::flash('message', 'PG Famoso aggiornato con successo!');
			return Redirect::to('admin/famoso');
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
		$famoso = Famoso::find($id);
		$famoso -> delete();

		Session::flash('message', ' PG Famoso cancellato correttamente!');
		return Redirect::to('admin/famoso');
	}


}
