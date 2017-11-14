<?php

class PgController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$Morti=PG::orderBy('Affiliazione','asc')->orderBy('Nome','asc')->where('Morto','=','1')->get();
		$Limbo=PG::orderBy('Affiliazione','asc')->orderBy('Nome','asc')->where('InLimbo','=','1')->get();
		$Vivi=PG::orderBy('Affiliazione','asc')->orderBy('Nome','asc')->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get();

		$selMorti=array('NULL' => '');
		foreach ($Morti as $morto){
			$selMorti[$morto['Affiliazione']][(string)$morto->ID] = $morto['Nome'].' ('.$morto['NomeGiocatore'].')';
		}

		$selLimbo=array('NULL' => '');
		foreach ($Limbo as $limb){
			$selLimbo[$limb['Affiliazione']][(string)$limb->ID] = $limb['Nome'].' ('.$limb['NomeGiocatore'].')';
		}

		$selVivi=array('NULL' => '');
		foreach ($Vivi as $vivo){
			$selVivi[$vivo['Affiliazione']][(string)$vivo->ID] = $vivo['Nome'].' ('.$vivo['NomeGiocatore'].')';
		}

		return View::make('pg.index')
				->with('selMorti',$selMorti)
				->with('selLimbo',$selLimbo)
				->with('selVivi',$selVivi);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$sel_affiliazione=array();
		$fazioni = Fazione::all();
		foreach ($fazioni as $fazione){
			$sel_affiliazione[$fazione['Fazione']]=$fazione['Fazione'];
		}
			
		return View::make('pg.create')
					->with('sel_affiliazione',$sel_affiliazione);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$PG = new PG;
		$PG->Nome				=	Input::get('Nome');
		$PG->NomeGiocatore		=	Input::get('NomeGiocatore');
		$PG->Email				=	Input::get('Email');
		$PG->Affiliazione		=	Input::get('Affiliazione');
		$PG->Px					=	Input::get('Px');
		$PG->Morto				=	Input::get('Morto',0);
		$PG->InLimbo			=	Input::get('InLimbo',0);
		$PG->Sesso				=	Input::get('Sesso');
		$PG->background			=	Input::get('background');
		$PG->save();
		
		$ID = new IDENTITAPG;
		$ID->ID_PG = $PG->ID;
		$ID->FIRMA = $PG->Nome;
		$ID->save();
		// redirect
		Session::flash('message', 'PG creato con successo!');
		return Redirect::to('admin/pg');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$PG= PG::find($id);

		// Retrieving infos

		$PG['Abilita']=PG::find($id)->Abilita;
		$PG['Incanti']=PG::find($id)->Incanti;

		$sesso=$PG['Sesso'];
		switch ($sesso) {
			case 'M':
				$PG['Sesso']='Uomo';
				break;
			case 'F':
				$PG['Sesso']='Donna';
				break;
			}
		$PG['Categorie']=PG::find($id)->Categorie;
		$PG['Monete']=INtools::convertiMonete($PG->Rendita());
		$PG['Px Rimasti']=$PG->PxRimasti();
		$PG['Erbe']=$PG->Erbe();
		$PG['CartelliniPotere']=$PG->CartelliniPotere();
		$PG['Note']=$PG->Note();
		$bg=nl2br($PG['background']);

		unset($PG['background']);
		
		$data=array(
			'name' 		=> Auth::user()->username,
			'PG'		=> $PG,
			'bg'		=> $bg
		);
		return View::make('pg.show',$data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		
		$PG= PG::find($id);
		$PG['abilita_unlocked']   = PGtools::AbilitaSbloccate($PG);
		$PG['incanti_unlocked']   = PGtools::IncantiSbloccati($PG);
		$PG['categorie_unlocked'] = PGtools::CategorieSbloccate($PG);
		$PG['speciali_unlocked']   = PGtools::Speciali($PG);
		
		$PG['PxRimasti']=$PG->PxRimasti();

		

		
		$sel_affiliazione=array();
		$fazioni = Fazione::all();
		foreach ($fazioni as $fazione){
			$sel_affiliazione[$fazione['Fazione']]=$fazione['Fazione'];
		}

		return View::make('pg.edit')
			->with('PG', $PG)
			->with('sel_affiliazione',$sel_affiliazione);
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
		$PG = PG::find($id);
		$PG->Nome				=	Input::get('Nome');
		$PG->NomeGiocatore  	=	Input::get('NomeGiocatore');
		$PG->Email				=	Input::get('Email');
		$PG->Affiliazione		=	Input::get('Affiliazione');
		$PG->Px					=	Input::get('Px');
		$PG->Morto				=	Input::get('Morto',0);
		$PG->InLimbo			=	Input::get('InLimbo',0);
		$PG->Sesso				=	Input::get('Sesso');
		$PG->background			=	Input::get('background');
		$PG->save();

		
		// redirect
		$msg=' Informazioni aggiornate con successo.';
		Session::flash('message', $msg);
		return Redirect::to('admin/pg/'.$id.'/edit');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$PG = PG::find($id);
		$PG -> delete();

		Session::flash('message', 'PG cancellato correttamente!');
		return Redirect::to('admin/pg');
	}

//######## GESTIONE CATEGORIE #########################################
	public function add_categoria()
	{
		$idPg=Input::get('ID');
		$idCategoria=Input::get('Categoria');


		$PG=PG::find($idPg);
		$PG->Categorie()->attach($idCategoria);

		Session::flash('message', 'Categoria aggiunta correttamente!');
		return Redirect::to('admin/pg/'.$idPg.'/edit');
		
	}

	public function del_categoria()
	{
		$idPg=Input::get('ID');
		$idCategoria=Input::get('Categoria');


		$PG=PG::find($idPg);
		$PG->Categorie()->detach($idCategoria);

		Session::flash('message', 'Categoria rimossa correttamente!');
		return Redirect::to('admin/pg/'.$idPg.'/edit');
		
	}


//######## GESTIONE ABILITA #########################################
	public function add_abilita()
	{
		$idPg=Input::get('ID');
		$idAbilita=Input::get('Abilita');


		$PG=PG::find($idPg);
		if ($idAbilita!=0){
			$ab=Abilita::find($idAbilita);
			$Px=$ab['PX'];
			if ($Px <= $PG->PxRimasti()) {
				$PG->Abilita()->attach($idAbilita);
				$PG->Sbloccate()->detach($idAbilita);
				$msg='Abilita aggiunta correttamente!';
			} else { 
				$msg='Il PG non ha Px a sufficienza per acquistare l\'abilità selezionata!<br>';
			}
		}

		Session::flash('message', $msg);
		return Redirect::to('admin/pg/'.$idPg.'/edit');
		
	}

	public function del_abilita()
	{
		$idPg=Input::get('ID');
		$idAbilita=Input::get('Abilita');


		$PG=PG::find($idPg);
		$PG->Abilita()->detach($idAbilita);

		Session::flash('message', 'Abilità rimossa correttamente!');
		return Redirect::to('admin/pg/'.$idPg.'/edit');
		
	}

//######## GESTIONE ABILITA SPECIALI SBLOCCATE #########################
	public function add_sbloccate()
	{
		$idPg=Input::get('ID');
		$idAbilita=Input::get('Abilita');

		$PG=PG::find($idPg);
		$PG->Sbloccate()->attach($idAbilita);
		$msg='Abilita Sbloccata aggiunta correttamente!';


		Session::flash('message', $msg);
		return Redirect::to('admin/pg/'.$idPg.'/edit');
		
	}

	public function del_sbloccate()
	{
		$idPg=Input::get('ID');
		$idAbilita=Input::get('Abilita');


		$PG=PG::find($idPg);
		$PG->Sbloccate()->detach($idAbilita);

		Session::flash('message', 'Abilità Sbloccata rimossa correttamente!');
		return Redirect::to('admin/pg/'.$idPg.'/edit');
		
	}

	//######## GESTIONE INCANTI #########################################
	public function add_incanto()
	{
		$idPg=Input::get('ID');
		$idIncanto=Input::get('Incanto');


		$PG=PG::find($idPg);
		$PG->Incanti()->attach($idIncanto);

		Session::flash('message', 'Incanto aggiunto correttamente!');
		return Redirect::to('admin/pg/'.$idPg.'/edit');
		
	}

	public function del_incanto()
	{
		$idPg=Input::get('ID');
		$idIncanto=Input::get('Incanto');


		$PG=PG::find($idPg);
		$PG->Incanti()->detach($idIncanto);

		Session::flash('message', 'Incanto rimosso correttamente!');
		return Redirect::to('admin/pg/'.$idPg.'/edit');
	}

	//######## GESTIONE FIRME #########################################
	public function add_firma()
	{
		$idPg=Input::get('ID');
		
		$id= new IDENTITAPG;
		$id->ID_PG = $idPg;
		$id->FIRMA = Input::get('Firma');
		$id->save();

		Session::flash('message', 'Firma aggiunta correttamente!');
		return Redirect::to('admin/pg/'.$idPg.'/edit');
		
	}

	public function del_firma()
	{
		$idPg=Input::get('ID');
		$idFirma=Input::get('Firma');

		IDENTITAPG::Destroy($idFirma);
		

		Session::flash('message', 'Firma rimossa correttamente!');
		return Redirect::to('admin/pg/'.$idPg.'/edit');
	}

	//######## SCHEDE PG #########################################
	public function schede()
	{
		$Evento = Evento::orderBy('Data','Desc')->take(1)->get(array('Data','Titolo','ID'));
		$InfoList = Evento::find($Evento[0]['ID'])->Informatori;
		$Informatori=array();
		foreach ($InfoList as $inf) {
			$Informatori[$inf->Categoria][]=$inf->Testo;
			}
		
		$data['Evento']=$Evento[0]->toArray();

		$data['PG']=array();
		foreach($Evento[0]->PG()->orderby('Arrivo','asc')->get() as $key=>$pg){
				$data['PG'][$key]=$pg->toArray();
				$data['PG'][$key]['Rendita']=INtools::convertiMonete($pg->Rendita());
				$data['PG'][$key]['PxRimasti']=intval($pg->PxRimasti());
				$data['PG'][$key]['Erbe']=intval($pg->Erbe());
				$data['PG'][$key]['Oggetti']=intval($pg->Oggetti());
				$data['PG'][$key]['Lettere']=intval($pg->Lettere());
				$data['PG'][$key]['CartelliniPotere']=intval($pg->CartelliniPotere());
				$data['PG'][$key]['Note']=$pg->Note();
				$data['PG'][$key]['Abilita']=$pg->Abilita()->orderBy('Categoria','asc')->get();
				$data['PG'][$key]['Incanti']=$pg->Incanti()->orderBy('Livello','asc')->get();
		
				# Aggiungere gli oggetti e gli informatori selezionati alla scheda PG
				$opzioni=explode('<br>',$pg['pivot']['Note']);
				foreach ($opzioni as $ii => $opt) {
					if (array_key_exists($opt,$Informatori)) {
						$num=count($Informatori[$opt]);
						$quale=mt_rand(0,$num-1);
						$data['PG'][$key]['Opzioni'][$ii]=$Informatori[$opt][$quale];
					} else {
						if ($opt) {
							$data['PG'][$key]['Opzioni'][$ii]="Riceve: ".$opt;
						}
					}
				}
				$data['PG'][$key]['Informatori']=$Informatori;
				
				# SE il PG ha spie, nella scheda trova l'elenco degli informatori
				$informatori= Abilita::where('Ability','=','Informatori')->first();
				$PG=$informatori->PG()->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get();
				$PGab="Questi personaggi hanno l'abilità 'Informatori': ";
				foreach ($PG as $pers) {
					$PGab.=$pers->Nome.'; ';
				}
				
				if (in_array('Spie',INtools::select_column($data['PG'][$key]['Abilita'],'Ability'))) {
					$data['PG'][$key]['Info'] =  $PGab;			
				} 
		
		}
		
		
		
		//$pdf = PDF::loadView('pg.schede',$data);
		//return $pdf->setWarnings(false)->stream();
		return View::make('pg.schede')->with('PG',$data['PG']);
	}
	
	
	//######## CARTELLINI SANITA' #########################################
	public function sanita()
	{
		$Evento = Evento::orderBy('Data','Desc')->take(1)->get(array('Data','Titolo','ID'));
		$PGs=$Evento[0]->PG()->orderby('Arrivo','asc')->get();
		
		$data=array();
		foreach($PGs as $key=>$pg){
				$data[$key]['Nome']=$pg->Nome;
				$data[$key]['Ferite']=intval($pg->Ferite());
		}
		
		//return Response::json($data);
		return View::make('pg.ferite')->with('PG',$data);
	}
}
