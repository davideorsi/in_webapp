<?php

class PngController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$Morti=PNG::orderBy('Nome','asc')->where('Morto','=','1')->get();
		$Vivi=PNG::orderBy('Nome','asc')->where('Morto','=','0')->get();

		$selMorti=array('NULL' => '');
		foreach ($Morti as $morto){
			$selMorti[(string)$morto->ID] = $morto['Nome'].' ('.$morto['Ruolo'].')';
		}

		$selVivi=array('NULL' => '');
		foreach ($Vivi as $vivo){
			$selVivi[(string)$vivo->ID] = $vivo['Nome'].' ('.$vivo['Ruolo'].')';
		}

		return View::make('png.index')
				->with('selMorti',$selMorti)
				->with('selVivi',$selVivi);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$Masters = User::orderBy('ID','desc')->where('usergroup','=',7)->get();
		$selMaster=array();
		foreach ($Masters as $Master){
			$selMaster[(string)$Master->id] = $Master['username'];
		}
			
		return View::make('png.create')
					->with('selMaster',$selMaster);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$PNG = new PNG;
		$PNG->Nome				=	Input::get('Nome');
		$PNG->Master			=	Input::get('Master');
		$PNG->Ruolo				=	Input::get('Ruolo');
		$PNG->Morto				=	Input::get('Morto',0);
		$PNG->Descrizione		=	Input::get('Descrizione');
		$PNG->save();
		// redirect
		Session::flash('message', 'PNG creato con successo!');
		return Redirect::to('admin/png');
	}


	/**
	 * 
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$PNG= PNG::find($id);

		// Retrieving infos

		$PNG['Abilita']=PNG::find($id)->Abilita;
		$PNG['Incanti']=PNG::find($id)->Incanti;

		
		$PNG['Categorie']=PNG::find($id)->Categorie;
		$PNG['Monete']=INtools::convertiMonete($PNG->Rendita());
		$PNG['Px']=$PNG->Px();
		$PNG['Erbe']=$PNG->Erbe();
		$PNG['CartelliniPotere']=$PNG->CartelliniPotere();

		unset($PNG['descrizione']);
		
		$data=array(
			'name' 		=> Auth::user()->username,
			'PNG'		=> $PNG
		);
		return View::make('png.show',$data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

		$Masters = User::orderBy('ID','desc')->where('usergroup','=',7)->get();
		$selMaster=array();
		foreach ($Masters as $Master){
			$selMaster[(string)$Master->id] = $Master['username'];
		}
		
		$PNG= PNG::find($id);
		$PNG['Incanti']	= $PNG->Incanti;
		$PNG['Abilita']	= $PNG->Abilita;
		$PNG['Categorie']= $PNG->Categorie;

		
		$PNG['Px']= $PNG->Px();
		$PNG['categorie_unlocked'] = PNGtools::CategorieSbloccate($PNG);
		$PNG['abilita_unlocked']   = PNGtools::AbilitaSbloccate($PNG);
		$PNG['incanti_unlocked']   = PNGtools::IncantiSbloccati($PNG);
		

		return View::make('png.edit')
			->with('PNG', $PNG)
			->with('selMaster',$selMaster);
		} 


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// store
		$PNG = PNG::find($id);
		$PNG->Nome				=	Input::get('Nome');
		$PNG->Master			=	Input::get('Master');
		$PNG->Ruolo				=	Input::get('Ruolo');
		$PNG->Morto				=	Input::get('Morto',0);
		$PNG->Descrizione		=	Input::get('Descrizione');
		$PNG->save();

		
		// redirect
		$msg=' Informazioni aggiornate con successo.';
		Session::flash('message', $msg);
		return Redirect::to('admin/png/'.$id.'/edit');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$PNG = PNG::find($id);
		$PNG -> delete();

		Session::flash('message', 'PNG cancellato correttamente!');
		return Redirect::to('admin/png');
	}

//######## GESTIONE CATEGORIE #########################################
	public function add_categoria()
	{
		$idPng=Input::get('ID');
		$idCategoria=Input::get('Categoria');


		$PNG=PNG::find($idPng);
		$PNG->Categorie()->attach($idCategoria);

		Session::flash('message', 'Categoria aggiunta correttamente!');
		return Redirect::to('admin/png/'.$idPng.'/edit');
		
	}

	public function del_categoria()
	{
		$idPng=Input::get('ID');
		$idCategoria=Input::get('Categoria');


		$PNG=PNG::find($idPng);
		$PNG->Categorie()->detach($idCategoria);

		Session::flash('message', 'Categoria rimossa correttamente!');
		return Redirect::to('admin/png/'.$idPng.'/edit');
		
	}


//######## GESTIONE ABILITA #########################################
	public function add_abilita()
	{
		$idPng=Input::get('ID');
		$idAbilita=Input::get('Abilita');


		$PNG=PNG::find($idPng);
		$PNG->Abilita()->attach($idAbilita);

		Session::flash('message', 'Abilita aggiunta correttamente!');
		return Redirect::to('admin/png/'.$idPng.'/edit');
		
	}

	public function del_abilita()
	{
		$idPng=Input::get('ID');
		$idAbilita=Input::get('Abilita');


		$PNG=PNG::find($idPng);
		$PNG->Abilita()->detach($idAbilita);

		Session::flash('message', 'Abilità rimossa correttamente!');
		return Redirect::to('admin/png/'.$idPng.'/edit');
		
	}

	//######## GESTIONE INCANTI #########################################
	public function add_incanto()
	{
		$idPng=Input::get('ID');
		$idIncanto=Input::get('Incanto');


		$PNG=PNG::find($idPng);
		$PNG->Incanti()->attach($idIncanto);

		Session::flash('message', 'Incanto aggiunto correttamente!');
		return Redirect::to('admin/png/'.$idPng.'/edit');
		
	}

	public function del_incanto()
	{
		$idPng=Input::get('ID');
		$idIncanto=Input::get('Incanto');


		$PNG=PNG::find($idPng);
		$PNG->Incanti()->detach($idIncanto);

		Session::flash('message', 'Incanto rimosso correttamente!');
		return Redirect::to('admin/png/'.$idPng.'/edit');
	}
	
}
