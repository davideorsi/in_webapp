<?php

class MalattiaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$Malattie=Malattia::orderBy('Nome','asc')->get();
		
		$selMalattie=array('NULL' => '');
		foreach ($Malattie as $malattia){
			$selMalattie[(string)$malattia->ID] = $malattia['Nome'];
		}
		
		$malati=PG::has('Malattie')->get(['Nome','ID']);
		$malati->load('Malattie');
		$selMalati=array();
		foreach($malati as $malato){
			$idstadio=INtools::select_column($malato->Malattie,'ID');
			$stadio=Stadio::find($idstadio[0])->toArray();
			$Malattia=Malattia::find($stadio['Malattia']);
			$selMalati[]=array('ID'=>$malato->ID,'Nome'=>$malato->Nome,'Stadio'=>$stadio['Numero'],'Malattia'=>$Malattia['Nome']);
			}
			
		$Vivi=PG::orderBy('Affiliazione','asc')->orderBy('Nome','asc')->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get();
		$selVivi=array('NULL' => '');
		foreach ($Vivi as $vivo){
			$selVivi[$vivo['Affiliazione']][(string)$vivo->ID] = $vivo['Nome'].' ('.$vivo['NomeGiocatore'].')';
		}
		
		$Stadi=Stadio::orderBy('Malattia','asc')->get();
		$selStadi=array('NULL' => '');
		foreach ($Stadi as $stadio){
			$Malattia=Malattia::find($stadio['Malattia']);
			$selStadi[$Malattia['Nome']][(string)$stadio['ID']] = 'Stadio '.$stadio['Numero'];
		}
			
		return View::make('malattia.index')
				->with('selMalattie',$selMalattie)
				->with('selMalati',$selMalati)
				->with('selVivi',$selVivi)
				->with('selStadi',$selStadi);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('malattia.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$Malattia = new Malattia;
		$Malattia->Nome	= Input::get('Nome');
		$Malattia->save();
		
		// redirect
		Session::flash('message', 'Malattia creata con successo!');
		return Redirect::to('admin/malattie');
	
	}
	
	
	public function nuovoStadio()
	{
		$Stadio = new Stadio;
		$Stadio->Numero	= Input::get('Numero');
		$Stadio->Malattia	= Input::get('Malattia');
		$Stadio->Descrizione	= Input::get('Descrizione');
		$Stadio->Effetti	= Input::get('Effetti');
		$Stadio->Contagio	= Input::get('Contagio');
		$Stadio->save();
		
		// redirect
		Session::flash('message', 'Stadio creato con successo!');
		return Redirect::to('admin/malattie/'.$Stadio->Malattia.'/edit');
	
	}



	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$Malattia=Malattia::find($id);
		$data=$Malattia->toArray();
		$data['Stadi']=$Malattia->Stadi->toArray();
		$data['Cure']=$Malattia->Cure->toArray();
		return View::make('malattia.show')
				->with('Malattia',$data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$Malattia=Malattia::find($id);
		$data=$Malattia->toArray();
		$data['Stadi']=$Malattia->Stadi->toArray();
		$data['Cure']=$Malattia->Cure->toArray();
		return View::make('malattia.edit')
				->with('Malattia',$data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$Malattia=Malattia::find($id);
		$Malattia->Nome	= Input::get('Nome');
		$Malattia->save();
		
		// redirect
		Session::flash('message', 'Malattia modificata con successo!');
		return Redirect::to('admin/malattie/'.$id.'/edit');
	}

	public function aggiornaStadio($id)
	{
		$Stadio = Stadio::find($id);
		$Stadio->Numero	= Input::get('Numero');
		$Stadio->Descrizione	= Input::get('Descrizione');
		$Stadio->Effetti	= Input::get('Effetti');
		$Stadio->Contagio	= Input::get('Contagio');
		$Stadio->save();
		
		// redirect
		Session::flash('message', 'Stadio modificato con successo!');
		return Redirect::to('admin/malattie/'.$Stadio->Malattia.'/edit');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$Malattia = Malattia::find($id);
		$Malattia -> delete();

		Session::flash('message', 'Malattia cancellata correttamente!');
		return Redirect::to('admin/malattie');
	}
	
	
	public function cancellaStadio($id)
	{
		
		$Stadio = Stadio::find($id);
		$malattia=$Stadio->Malattia;
		$Stadio -> delete();

		Session::flash('message', 'Stadio cancellato correttamente!');
		return Redirect::to('admin/malattie/'.$malattia.'/edit');
	}

	public function cancellaMalato()
	{
		$idPg=Input::get('PG');
		$idStadio=Input::get('Stadio');


		$Stadio=Stadio::find($idStadio);
		$Stadio->PG()->detach($idPg);

		Session::flash('message', 'Malattia rimossa correttamente!');
		return Redirect::to('admin/malattie/');
	}
	public function aggiungiMalato()
	{
		$idPg=Input::get('pg_vivi');
		$idStadio=Input::get('malattia');


		$Stadio=Stadio::find($idStadio);
		$Stadio->PG()->attach($idPg);

		Session::flash('message', 'Malattia assegnata correttamente!');
		return Redirect::to('admin/malattie/');
	}
	

}
