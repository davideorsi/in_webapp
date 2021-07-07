<?php

class LicenzaController extends \BaseController {

	/**
	 * Lista di tutti le licenze, con la scelta tra editare, aggiungere o
	 * cancellare una licenza
	 */
	public function index()
	{
		$Licenze = Licenza::orderBy('Livello', 'asc')->get(array('ID','Nome','Livello'));
		$Vivi=PG::orderBy('Affiliazione','asc')->orderBy('Nome','asc')->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get();
		$eventi = Evento::orderBy('ID', 'desc')->get(array('ID','Tipo','Titolo','Data'));

		$datacorrente=$eventi[0]['Data'];

		$selectEventi = array();
		foreach($eventi as $evento) {
			$selectEventi[$evento->Data] = $evento->Tipo .'-'. $evento->Titolo.' ('.$evento->Data.')';
		}

		//$selectLicenze = array(0 => '');
		$selectLicenze = array();
		foreach($Licenze as $Licenza) {
			$selectLicenze[$Licenza->ID] = $Licenza->Nome;
		}
		
		$index=0;
		$selVivi=array('NULL' => '');
		$listalicenze=array();
		foreach ($Vivi as $vivo){
			$selVivi[$vivo['Affiliazione']][(string)$vivo->ID] = $vivo['Nome'].' ('.$vivo['NomeGiocatore'].')';
			$halicenza=$vivo->Licenza()->get()->toarray();
			if ($halicenza) {
				$index=$index+1;
				foreach ($halicenza as $lic){
					if ($lic['pivot']['Scaduta']==0){
						$listalicenze[$index]['IDPG'] = $vivo->ID;
						$listalicenze[$index]['IDLicenza'] = $lic['pivot']['IDLicenza'];
						$listalicenze[$index]['NomePG'] = $vivo['Nome'];
						$listalicenze[$index]['Licenza'] = $lic['Nome'];
						$listalicenze[$index]['Inizio'] = $lic['pivot']['Inizio'];
						$listalicenze[$index]['UltimoRinnovo'] = $lic['pivot']['UltimoRinnovo'];
						$listalicenze[$index]['Rinnovi'] = $lic['pivot']['Rinnovi'];
						$listalicenze[$index]['Prezzo'] = $lic['pivot']['Prezzo'];
						}
					}
				}
			
		}
		//dd($listalicenze);
		
		
		// load the view and pass the nerds
		return View::make('licenza.index')
			->with('Licenze', $Licenze)
			->with('selectLicenze', $selectLicenze)
			->with('selectPG', $selVivi)
			->with('selectEventi', $selectEventi)
			->with('listalicenze', $listalicenze)
			->with('datacorrente', $datacorrente);
	}

	public function lista()
	{
		$Licenze = Licenza::orderBy('Livello', 'asc')->get(array('ID','Nome','Livello'));
		
		$selectLicenze = array();
		foreach($Licenze as $Licenza) {
			$selectLicenze[$Licenza->ID] = $Licenza->Nome;
		}
		
		// load the view and pass the nerds
		return View::make('licenza.lista')
			->with('Licenze', $Licenze)
			->with('selectLicenze', $selectLicenze);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('licenza.create');
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
			'Disponibili' => 'required',
			'Prezzo' => 'required',
			'Permette' => 'required',
			'Limitazioni' => 'required',
			'Tassazione' => 'required',
			'Durata' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/licenza/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$Licenza = new Licenza;
			$Licenza->Nome       = Input::get('Nome');
			$Licenza->Disponibili      = Input::get('Disponibili');
			$Licenza->Prezzo 	  = Input::get('Prezzo');
			$Licenza->Permette	  = Input::get('Permette');
			$Licenza->Limitazioni	  = Input::get('Limitazioni');
			$Licenza->Tassazione  = Input::get('Tassazione');
			$Licenza->Durata	  = Input::get('Durata');
			$Licenza->save();

			// redirect
			Session::flash('message', 'Licenza creata con successo!');
			return Redirect::to('admin/licenza');
		}
	}

	
	/**
	 * Ritorna la Licenza indicata da $id in formato json (per l'editing).
	 *
	 * 
	 */
	public function show($id)
	{

		$Licenza = Licenza::find($id);
		
		$Licenza['Permette']=nl2br($Licenza['Permette']);
		$Licenza['Limitazioni']=nl2br($Licenza['Limitazioni']);
		if (Request::ajax()){
			return Response::json($Licenza);
		} else {
			return View::make('licenza.print')
				->with('licenza',$Licenza);
		}
			
	}
	
	public function showpg($id)
	{

		$Licenza = Licenza::find($id);
		
		$Licenza['Permette']=nl2br($Licenza['Permette']);
		$Licenza['Limitazioni']=nl2br($Licenza['Limitazioni']);
		if (Request::ajax()){
			return Response::json($Licenza);
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
		$Licenza = Licenza::find($id);

		// show the edit form and pass the object
		return View::make('licenza.edit')
			->with('Licenza', $Licenza);
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
			'Disponibili' => 'required',
			'Prezzo' => 'required',
			'Permette' => 'required',
			'Limitazioni' => 'required',
			'Tassazione' => 'required',
			'Durata' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/licenza/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$Licenza = Licenza::find($id);
			$Licenza->Nome       = Input::get('Nome');
			$Licenza->Disponibili      = Input::get('Disponibili');
			$Licenza->Prezzo 	  = Input::get('Prezzo');
			$Licenza->Permette	  = Input::get('Permette');
			$Licenza->Limitazioni	  = Input::get('Limitazioni');
			$Licenza->Tassazione  = Input::get('Tassazione');
			$Licenza->Durata	  = Input::get('Durata');
			$Licenza->save();

			// redirect
			Session::flash('message', 'Licenza aggiornata con successo!');
			return Redirect::to('admin/licenza');
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
		$Licenza = Licenza::find($id);
		$Licenza -> delete();

		Session::flash('message', 'Licenza cancellata correttamente!');
		return Redirect::to('admin/licenza');
	}


	//######## GESTIONE LICENZE #########################################
	public function add_licenza()
	{
		$idPg=Input::get('IDpg');
		$idLicenza=Input::get('IDlicenza');
		$data=Input::get('Data');

		$prezzo=Input::get('Prezzo');


		$PG=PG::find($idPg);
		$PG->Licenza()->attach($idLicenza,array('Inizio'=>$data,'UltimoRinnovo'=>$data,'Rinnovi'=>0,'Scaduta'=>0,'Prezzo'=>$prezzo));

		Session::flash('message', 'Licenza assegnata!');
		return Redirect::to('admin/licenza');		
	}

	public function scade_licenza()
	{
		$idPg=Input::get('IDpg');
		$idLicenza=Input::get('IDLicenza');


		$PG=PG::find($idPg);
		$PG->Licenza()->updateExistingPivot($idLicenza, ['Scaduta' => 1]);

		Session::flash('message', 'Licenza rimossa!');
		return Redirect::to('admin/licenza');
	}

	public function rinnova_licenza()
	{
		$idPg=Input::get('IDpg');
		$idLicenza=Input::get('IDLicenza');
		$prezzo=Input::get('PrezzoRinnovo');
		$data=Input::get('DataRinnovo');
		$rinnovi=Input::get('Rinnovi');


		$PG=PG::find($idPg);
		$PG->Licenza()->updateExistingPivot($idLicenza, ['Rinnovi' => $rinnovi+1, 'Prezzo'=>$prezzo, 'UltimoRinnovo'=>$data]);

		Session::flash('message', 'Licenza rimossa!');
		return Redirect::to('admin/licenza');
	}

}
