<?php

class AbilitaController extends \BaseController {

	/**
	 * Lista di tutti gli eventi, con la scelta tra editare, aggiungere o
	 * cancellare una abilita
	 */
	public function index()
	{
		$abilitas = Abilita::orderBy('Categoria', 'asc')->orderBy('Ability', 'asc')->get(array('ID','Ability','Categoria'));

		$selectAbilita = array();
		foreach($abilitas as $abilita) {
			$selectAbilita[$abilita->Categoria][$abilita->ID] = $abilita->Ability;
		}
		// load the view and pass the nerds
		return View::make('abilita.index')
			->with('selectAbilita', $selectAbilita);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$categorie= Categoria::all();
		$categorieSelect = array();
		foreach($categorie as $categoria) {
			$categorieSelect[$categoria->Categoria] = $categoria->Categoria;
		}

		return View::make('abilita.create')
				->with('categorieSelect',$categorieSelect);
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
			'Ability' => 'required',
			'Categoria' => 'required',
			'PX' => 'required',
			'Descrizione' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/abilita/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$abilita = new Abilita;
			$abilita->Ability       = Input::get('Ability');
			$abilita->Categoria      = Input::get('Categoria');
			$abilita->PX 	  = Input::get('PX');
			$abilita->Descrizione	  = Input::get('Descrizione');
			$abilita->Note	  = Input::get('Note');
			$abilita->CartelliniPotere = Input::get('CartelliniPotere');
			$abilita->Erbe	  = Input::get('Erbe');
			$abilita->Rendita	  = Input::get('Rendita');
			$abilita->Generica	  = Input::get('Generica',0);
			$abilita->save();

			// redirect
			Session::flash('message', 'Abilità creata con successo!');
			return Redirect::to('admin/abilita');
		}
	}

	
	/**
	 * Ritorna la abilita indicata da $id in formato json (per l'editing).
	 *
	 * 
	 */
	public function show($id)
	{
		$abilita = Abilita::find($id);

		$abilita['Descrizione']=nl2br('<p>'.$abilita['Descrizione'].'</p>');
		$PG=$abilita->PG()->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get();
		
		$PGab='';
		foreach ($PG as $pers) {
			$PGab.=$pers->Nome.'</br>';
			}
		$abilita['PG']=$PGab;	

		if (Request::ajax()){
			return Response::json($abilita);
		} else {
			return Response::make('Not available', 401);
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
		$abilita = Abilita::find($id);

		$categorie= Categoria::all();
		$categorieSelect = array();
		foreach($categorie as $categoria) {
			$categorieSelect[$categoria->Categoria] = $categoria->Categoria;
		}
		
		$abilitas = Abilita::orderBy('Categoria', 'asc')->orderBy('Ability', 'asc')->get(array('ID','Ability','Categoria'));

		$selectAbilita = array();
		foreach($abilitas as $ab) {
			$selectAbilita[$ab->Categoria][$ab->ID] = $ab->Ability;
		}
		
		$abilita->Requisiti;
		$abilita->Esclusi;
		//dd($abilita['req']);
		
		// show the edit form and pass the object
		return View::make('abilita.edit')
			->with('abilita', $abilita)
			->with('tutte', $selectAbilita)
			->with('categorieSelect', $categorieSelect);
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
			'Ability' => 'required',
			'Categoria' => 'required',
			'PX' => 'required',
			'Descrizione' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/abilita/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$abilita = Abilita::find($id);
			$abilita->Ability       = Input::get('Ability');
			$abilita->Categoria      = Input::get('Categoria');
			$abilita->PX 	  = Input::get('PX');
			$abilita->Descrizione	  = Input::get('Descrizione');
			$abilita->Note	  = Input::get('Note');
			$abilita->CartelliniPotere = Input::get('CartelliniPotere');
			$abilita->Erbe	  = Input::get('Erbe');
			$abilita->Rendita	  = Input::get('Rendita');
			$abilita->Generica	  = Input::get('Generica',0);
			$abilita->save();

			// redirect
			Session::flash('message', 'Abilità aggiornata con successo!');
			return Redirect::to('admin/abilita');
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
		$abilita = Abilita::find($id);
		
		$abilita->Requisiti()->detach();
		$abilita -> delete();

		Session::flash('message', 'Abilità cancellata correttamente!');
		return Redirect::to('admin/abilita');
	}


	//######## GESTIONE OPZIONI #########################################
	public function add_opzione()
	{
		$ab=Input::get('Abilita');
		$opt=Input::get('Opzione');
		$costo=Input::get('Costo');

		if (!empty($opt)){
		$Opzione = new AbilitaOpzioni;
		$Opzione -> Abilita = $ab;
		$Opzione -> Opzione = $opt;
		$Opzione -> Costo = $costo;
		$Opzione->save();
			$msg='Opzione aggiunta correttamente!';
		} else{
			$msg='Errore! Opzione vuota!';
		}
		Session::flash('message', $msg);
		return Redirect::to('admin/abilita/'.$ab.'/edit');
		
	}

	public function del_opzione()
	{
		$ab=Input::get('Abilita');
		$id=Input::get('Opzione');

		$opzione = AbilitaOpzioni::find($id);
		$opzione -> delete();

		Session::flash('message', 'Opzione rimossa correttamente!');
		return Redirect::to('admin/abilita/'.$ab.'/edit');
	}

	//######## GESTIONE REQUISITI #########################################
	public function add_requisito()
	{
		$ab=Input::get('ID');
		$req=Input::get('Req');

		$AB=Abilita::find($ab);
		$AB->Requisiti()->attach($req);
		
		Session::flash('message', 'Requisito aggiunto correttamente!');
		return Redirect::to('admin/abilita/'.$ab.'/edit');
		
	}

	public function del_requisito()
	{
		$ab=Input::get('ID');
		$req=Input::get('Req');

		$AB=Abilita::find($ab);
		$AB->Requisiti()->detach($req);

		Session::flash('message', 'Requisito rimosso correttamente!');
		return Redirect::to('admin/abilita/'.$ab.'/edit');
	}

	//######## GESTIONE ABILITA ESCLUSE #########################################
	public function add_esclusa()
	{
		$ab=Input::get('ID');
		$esc=Input::get('Esc');

		$AB=Abilita::find($ab);
		$AB->Esclusi()->attach($esc);
		
		Session::flash('message', 'Abilità esclusa aggiunta correttamente!');
		return Redirect::to('admin/abilita/'.$ab.'/edit');
		
	}

	public function del_esclusa()
	{
		$ab=Input::get('ID');
		$esc=Input::get('Esc');

		$AB=Abilita::find($ab);
		$AB->Esclusi()->detach($esc);

		Session::flash('message', 'Abilità esclusa rimossa correttamente!');
		return Redirect::to('admin/abilita/'.$ab.'/edit');
	}


}
