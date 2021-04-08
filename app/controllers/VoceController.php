<?php

class VoceController extends \BaseController {

	/**
	 * Lista di tutti gli eventi, con la scelta tra editare, aggiungere o
	 * cancellare una voce
	 */
	public function index()
	{
		$voci = Voce::orderBy('Data', 'desc')->get(array('rowid','Data','Testo','Bozza'));
		$selectVoci = array();
		$id=count($voci)+1;
		foreach($voci as $voce) {
			$id-=1;
			$data=new Datetime($voce['Data']);
			$selectVoci[$voce->rowid] = $id.') '. strftime("%d %B %Y",$data->gettimestamp()) .' - '. INtools::first_words($voce->Testo,3).'&hellip;';
			if  ($voce->Bozza==1){
				$selectVoci[$voce->rowid].= ' (Bozza)';
			}
		}
		// load the view and pass the nerds
		return View::make('voce.index')
			->with('voci', $voci)
			->with('selectVoci', $selectVoci);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('voce.create');
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
			'Data' => 'required',
			'Testo' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/voce/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$voce = new Voce;
			$voce->Data       = Input::get('Data');
			$voce->Testo      = Input::get('Testo');
			$voce->Chiusa 	  = Input::get('Chiusa');
			$voce->Bozza 	  = Input::get('Bozza',0);
			$voce->save();

			// redirect
			Session::flash('message', 'Voce creata con successo!');
			return Redirect::to('admin/voce');
		}
	}

	
	/**
	 * Ritorna la voce indicata da $id in formato json (per l'editing).
	 *
	 * 
	 */
	public function show()
	{
		$text=Input::get('testo');
		//mostra solo le voci che non sono bozze
		$voci=Voce::orderBy('Data', 'desc')->orderBy('rowid', 'desc')->where('Bozza','!=','1')
				->where('Testo', 'like', '%'.$text.'%')
				->paginate(2);	
		
		if (!$voci->isEmpty()) {
		foreach($voci as $voce){
			$data=new Datetime($voce['Data']);
			$voce['Data']=strftime("%d %B %Y",$data->gettimestamp());
			$voce['Testo']=nl2br($voce['Testo']);
		}
		}
		
		if (Request::ajax()){
			return Response::json($voci);
		} else {
			return Redirect::to('/');
		}	
	}

	public function show_master($id)
	{
		//mostra tutte le voci se sei un master
		$voce = Voce::find($id);
		$voce['N']=Voce::orderBy('id', 'DESC')->count();
		$data=new Datetime($voce['Data']);
		$voce['Data']=strftime("%d %B %Y",$data->gettimestamp());
		$voce['Testo']=nl2br($voce['Testo']);

		return Response::json($voce);	
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$voce = Voce::find($id);
		// show the edit form and pass the object
		return View::make('voce.edit')
			->with('voce', $voce)->with('id',$id);
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
			'Data' => 'required',
			'Testo' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/voce/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			/*$voce = Voce::find($id);
			$voce->Data       = Input::get('Data');
			$voce->Testo      = Input::get('Testo');
			$voce->Chiusa 	  = Input::get('Chiusa');
			$voce->Bozza 	  = Input::get('Bozza','0');
			$voce->save();*/
			DB::table('Voci di Locanda')->where('rowid', '=', $id)->update(['Data'=>Input::get('Data'),'Testo'=>Input::get('Testo'),'Chiusa'=>Input::get('Chiusa'),'Bozza'=>Input::get('Bozza','0')]);

			// redirect
			Session::flash('message', 'Voce aggiornata con successo!');
			return Redirect::to('admin/voce');
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
		//$voce = Voce::find($id);
		//$voce -> delete();	
		DB::table('Voci di Locanda')->where('rowid', '=', $id)->delete();
	

		Session::flash('message', 'Voce cancellata correttamente!');
		return Redirect::to('admin/voce');
	}
	
	public function fulllist()
	{
		$voci = Voce::whereRaw('Bozza = 0')->orderBy('Data', 'desc')->get(array('rowid','Data','Testo','Chiusa'));
		$selectVoci = array();
		$id=count($voci)+1;
		foreach($voci as $voce) {
			$id-=1;
			$data=new Datetime($voce['Data']);
			$selectVoci[$voce->rowid] = $id.') '. strftime("%d %B %Y",$data->gettimestamp()) .' - '. $voce->Chiusa;

		}
		// load the view and pass the nerds
		return View::make('voce.lista')
			->with('voci', $voci)
			->with('selectVoci', $selectVoci);
	}

	
	public function search()
	{

		$data=Input::get('Data');
		$testo=Input::get('Testo');
		$chiusa=Input::get('Chiusa');

		
		$condizione='Bozza = 0 AND "Voci di Locanda" MATCH "';

		if ($data){
			$words=explode(' ', $data);
			foreach ($words as $parola){
				$condizione.=" Data:".$parola." ";
			}
		}

		if ($testo){
			$words=explode(' ', $testo);
			foreach ($words as $parola){
				$condizione.=" Testo:".$parola." ";
			}
		}

		if ($chiusa){
			$words=explode(' ', $chiusa);
			foreach ($words as $parola){
				$condizione.=" Chiusa:".$parola." ";
			}
		}
		$condizione.='"';

		$voci=Voce::whereRaw($condizione)->orderBy('Data', 'desc')->get(array('rowid','Data','Testo','Chiusa'));
		$selectVoci = array();
		$id=count($voci)+1;
		foreach($voci as $voce) {
			$id-=1;
			$data=new Datetime($voce['Data']);
			$selectVoci[$voce->rowid] = $id.') '. strftime("%d %B %Y",$data->gettimestamp()) .' - '. $voce->Chiusa;

		}
		
		return Response::json($selectVoci);
	}


}
