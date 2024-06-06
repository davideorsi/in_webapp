<?php

class MalattiaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$check=null;
		$Malattie=Malattia::orderBy('Nome','asc')->get();
		$Cure=Cura::orderBy('Malattia','asc')->get();

		$materiali=Materiale::where('categoria','!=',5)->where('cancellata',0)->get();
		$selMateriali = array();
    $selMateriali['---'][0] = 'Seleziona un Materiale..';
		foreach($materiali as $mat) {
      $cat = $mat->Categoria()->first()->Descrizione;
			$selMateriali[$cat][$mat->ID] = $mat->Nome;
    }

		$selMalattie=array('NULL' => '');
		foreach ($Malattie as $malattia){
			$selMalattie[(string)$malattia->ID] = $malattia['Nome'];
		}

		$malati=PG::has('Malattie')->get(['Nome','ID']);
		$malati->load('Malattie');
		$selMalati=array();
		$pgMalati=array();
		$pgMalati[0]='';
		foreach($malati as $malato){
			$idstadio=INtools::select_column($malato->Malattie,'ID');
			$stadio=Stadio::find($idstadio[0])->toArray();
			$Malattia=Malattia::find($stadio['Malattia']);
			$selMalati[]=array('ID'=>$malato->ID,'Nome'=>$malato->Nome,'Stadio'=>$stadio['Numero'],'StadioID'=>$stadio['ID'],'Malattia'=>$Malattia['Nome']);
			$pgMalati[$malato->ID]=$malato->Nome;
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

		$selCD=array(0=>'');
    $CD=SostanzeCromodinamica::get();
     foreach($CD as $c){
       $padre = $c->Padre->DESC;
        $selCD[$padre][$c->ID] = $c->DESC.' ('.$c->livello.')';
     }

		return View::make('malattia.index')
				->with('selMalattie',$selMalattie)
				->with('Cure',$Cure)
				->with('selMalati',$selMalati)
				->with('pgMalati',$pgMalati)
				->with('selMateriali',$selMateriali)
				->with('selVivi',$selVivi)
				->with('check',$check)
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

	public function showParametri(){
		$parametri = MalattieParametri::first();
		//retrun $parametri;
		return View::make('malattia.parametri')
				->with('parametri',$parametri);
	}

	public function aggiornaParametri($id){
		$parametri = MalattieParametri::find($id);
		$parametri->ProbBase =Input::get('ProbBase');
		$parametri->ProbCibo =Input::get('ProbCibo');
		$parametri->ProbMAX =Input::get('ProbMAX');
		$parametri->ProbCicaLow =Input::get('ProbCicaLow');
		$parametri->ProbCicaMid =Input::get('ProbCicaMid');
		$parametri->ProbCicaTop =Input::get('ProbCicaTop');
		$parametri->SogliaCicaLow =Input::get('SogliaCicaLow');
		$parametri->SogliaCicaTop =Input::get('SogliaCicaTop');
		$parametri->MaxMalati =Input::get('MaxMalati');
		$parametri->SogliaExtra =Input::get('SogliaExtra');
		$parametri->SogliaGravCiboL =Input::get('SogliaGravCiboL');
		$parametri->SogliaGravCiboT =Input::get('SogliaGravCiboT');
		$parametri->SogliaGravFerL =Input::get('SogliaGravFerL');
		$parametri->SogliaGravFerT =Input::get('SogliaGravFerT');
		$parametri->SogliaGravMisL =Input::get('SogliaGravMisL');
		$parametri->SogliaGravMisT =Input::get('SogliaGravMisT');
		$parametri->SogliaMalusF =Input::get('SogliaMalusF');
		$parametri->MalusF =Input::get('MalusF');
		$parametri->save();

		Session::flash('message', 'Parametri Modificati con successo!');
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
		$Stadio->Contatto	= Input::get('Contatto');
		$Stadio->Diagnosticare	= Input::get('Diagnosticare');
		$Stadio->Guarigione	= Input::get('Guarigione');
		$Stadio->Complicazione	= Input::get('Complicazione');
		$Stadio->save();

		// redirect
		Session::flash('message', 'Stadio creato con successo!');
		return Redirect::to('admin/malattie/'.$Stadio->Malattia.'/edit');
	}

	public function nuovaCura()
	{
		$Cura = new Cura;
		$Cura->Estratto	= Input::get('Estratto');
		$Cura->NumeroEstratti	= Input::get('NumeroEstratti');
		$Cura->Malattia	= Input::get('Malattia');
		/*
		$Stadio->Rosse	= Input::get('Rosse');
		$Stadio->Verdi	= Input::get('Verdi');
		$Stadio->Blu	= Input::get('Blu');
		*/
		$Cura->Effetti	= Input::get('Effetti');
		$Cura->BonusGuarigione	= Input::get('BonusGuarigione');
		$Cura->save();

		// redirect
		Session::flash('message', 'Cura creata con successo!');
		return Redirect::to('admin/malattie/'.$Cura->Malattia.'/edit');
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
		$Categorie=MalattieCategorie::get();
		$data=$Malattia->toArray();
		$data['Stadi']=$Malattia->Stadi->toArray();
		$data['Cure']=$Malattia->Cure->toArray();
		foreach($Categorie as $cat){
			$data['Categorie'][$cat['ID']]=$cat['Descrizione'];
		}
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
		$Categorie=MalattieCategorie::get();

		$data=$Malattia->toArray();
		$data['Stadi']=$Malattia->Stadi->toArray();
		$data['Cure']=$Malattia->Cure->toArray();
		foreach($Categorie as $cat){
			$data['Categorie'][$cat['ID']]=$cat['Descrizione'];
		}
		$selCD=array(0=>'');
    $CD=SostanzeCromodinamica::get();
     foreach($CD as $c){
       $padre = $c->Padre->DESC;
        $selCD[$padre][$c->ID] = $c->DESC.' ('.$c->livello.')';
     }

		return View::make('malattia.edit')
				->with('selCD', $selCD)
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
		$Malattia->Categoria = Input::get('Categorie');
		$Malattia->Descrizione = Input::get('Descrizione');
		/*
		$Malattia->CromoR = Input::get('Rosse');
		$Malattia->CromoV = Input::get('Verdi');
		$Malattia->CromoB = Input::get('Blu');
		*/
		$Malattia->IdCromodinamica = Input::get('CDmalattia');
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
		$Stadio->Contatto	= Input::get('Contatto');
		$Stadio->Diagnosticare	= Input::get('Diagnosticare');
		$Stadio->Guarigione	= Input::get('Guarigione');
		$Stadio->Complicazione	= Input::get('Complicazione');

		$Stadio->save();

		// redirect
		Session::flash('message', 'Stadio modificato con successo!');
		return Redirect::to('admin/malattie/'.$Stadio->Malattia.'/edit');
	}


	public function aggiornaCura($id)
	{
		$Stadio = Cura::find($id);
		$Stadio->Estratto	= Input::get('Estratto');
		$Stadio->NumeroEstratti	= Input::get('NumeroEstratti');
		$Stadio->Malattia	= Input::get('Malattia');
		/*
		$Stadio->Rosse	= Input::get('Rosse');
		$Stadio->Verdi	= Input::get('Verdi');
		$Stadio->Blu	= Input::get('Blu');
		*/
		$Stadio->Effetti	= Input::get('Effetti');
		$Cura->BonusGuarigione	= Input::get('BonusGuarigione');
		$Stadio->save();

		// redirect
		Session::flash('message', 'Cura modificata con successo!');
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
	public function cancellaCura($id)
	{

		$Cura = Cura::find($id);
		$malattia=$Cura->Malattia;
		$Cura -> delete();

		Session::flash('message', 'Cura cancellata correttamente!');
		return Redirect::to('admin/malattie/'.$malattia.'/edit');
	}

	public function cancellaMalato()
	{
		$idPg=Input::get('PG');
		$idStadio=Input::get('Stadio');
		$Stadio=Stadio::find($idStadio);
		$Stadio->PG()->detach($idPg);
		#DB::delete('DELETE FROM `Malattie-PG` WHERE PG = ? AND Stadio = ?',[$idPg, $idStadio]);
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

	public function stampaMalati(){
		$evento = Evento::Orderby('ID','Desc')->first();
		$PGmalati = $evento->PG()->has('Malattie')->get();
		return View::make('malattia.stampa')
				->with('PGmalati',$PGmalati);
	}


	public function aggiornaMalati(){
		$evento = Evento::Orderby('ID','Desc')->first();
		$dataEvento  = $evento->Data;
		if($dataEvento >= date("Y-m-d")){
			$idEvento = $evento->ID -1;
			$evento = Evento::where('ID',$idEvento)->first();
		}

		if ($evento->ID>58){$NN=3;} else {$NN=5;} #3 cartellini per PF dall'evento 5, luglio 2021

		$parametri = MalattieParametri::find(1);
		$PGmalati = $evento->PG()->has('Malattie')->get(['PG.ID']);
		$arrayMalati = Array();
		foreach ($PGmalati as $malato){
			array_push($arrayMalati,$malato->ID);
		}

		$TotMalati = PG::has('Malattie')->get();
		$Nmalati = sizeof($TotMalati);
		$PGsani = $evento->PG()->where('Morto',0)
							->where('InLimbo',0)
							->whereNotIn('PG.ID',$arrayMalati)
							->get(['PG.ID']);

		//aggiorno stato PG malati

		foreach($PGmalati as $malato){
				$Stadi = $malato->Malattie()->Get();
				$evPG = EventiPG::where('PG',	$malato->ID)->where('Evento',$evento->ID)->first();

				foreach($Stadi as $stadio){
					$malattia = Malattia::find($stadio->Malattia);
					$pagliativo = $evPG->Pagliativo;
					$Guarigione = $stadio->Guarigione;
					$Complicazione = $stadio->Complicazione;
					if($evPG->Cibo == 1){$Cibo = 0;} else {$Cibo = $parametri->ProbCibo;}
					if($evPG->Terapia == 1){$Terapia = $parametri->Terapia;} else {$Terapia = 0;}
					if($evPG->Cura == 1){
						$c = Cura::where('Malattia',$stadio->Malattia)->first();
						$Cura = $c->BonusGuarigione;
					} else {
						$Cura = 0;
					}

					$cicatriciRimaste = $evPG->Cicatrici;
					$cicatriciTotali = $NN*$malato->Ferite();
					$cicatriciPerse = (1-($cicatriciRimaste/$cicatriciTotali))*100;

					if ($cicatriciPerse==0){
						$Cicatrici =0;
					} else if($cicatriciPerse<$parametri->SogliaCicaLow){
						$Cicatrici = $parametri->ProbCicaLow;
					}else if($cicatriciPerse<$parametri->SogliaCicaTop){
						$Cicatrici = $parametri->ProbCicaMid;
					}else{
						$Cicatrici = $parametri->ProbCicaTop;
					}

					$livello = $stadio->Numero;

					if(($Terapia!=0)&&($Cura!=0)){
						$stadio->PG()->detach($malato->ID);
						$Nmalati = $Nmalati-1;
					}else{
						$tiro = rand(1,100);

						$perc=($Guarigione+$Terapia+$Cura-$Cibo-$Cicatrici);
						if ($malattia->Categoria==1 && $Cibo!=0){
							$perc=0;
						}

						if($tiro<=$perc){
							// stadio precedente
							if ($livello>1){
								$stadioP = Stadio::where('Malattia',$stadio->Malattia)->where('Numero',$livello-1)->first();
								$stadioP->PG()->attach($malato->ID);
								$stadio->PG()->detach($malato->ID);
							}else{
								$stadio->PG()->detach($malato->ID);
								$Nmalati = $Nmalati-1;
							}
						}else if($tiro<$Complicazione-$Terapia-$Cura+$Cibo+$Cicatrici){
							// stadio successivo
							if($Pagliavito==0&&$Cura==0){
								$stadioLast = Stadio::where('Malattia',$stadio->Malattia)->orderBy('Numero','Desc')->first();
								if($livello<$stadioLast->Numero){
									$stadioP = Stadio::where('Malattia',$stadio->Malattia)->where('Numero',$livello+1)->first();
									$stadioP->PG()->attach($malato->ID);
									$stadio->PG()->detach($malato->ID);
								}
							}
						}

					}
				}

		}

		//verifico se qualcun-altro si ammala
		$PGtiri = Array();

		foreach ($PGsani as $sano){
			$evPG = $sano['pivot'];

			if($evPG->Cibo == 1){$Cibo = 0;} else {$Cibo = $parametri->ProbCibo;}
			if($evPG->IDmalattia!=0){
				$malattia = Malattia::find($evPG->IDmalattia);
				$contatto = $malattia->Contatto;
			}else{
				$malattia = null;
				$contatto = 0;
			}

			$cicatriciRimaste = $evPG->Cicatrici;
			$cicatriciTotali = $NN*$sano->Ferite();
			$cicatriciPerse = (1-($cicatriciRimaste/$cicatriciTotali))*100;

			if ($cicatriciPerse==0){
				$Cicatrici =0;
			} else if($cicatriciPerse<$parametri->SogliaCicaLow){
				$Cicatrici = $parametri->ProbCicaLow;
			}else if($cicatriciPerse<$parametri->SogliaCicaTop){
				$Cicatrici = $parametri->ProbCicaMid;
			}else{
				$Cicatrici = $parametri->ProbCicaTop;
			}
			$perc = $Cibo + $Cicatrici + $contatto + $parametri->ProbBase;

			$pg['ID']=$sano->ID;
			$pg['perc']=$perc;
			$pg['cicatriciPerse']=$cicatriciPerse;
			$pg['malattia']=$malattia;
			$pg['cibo']=$Cibo;

			array_push($PGtiri,$pg);
		}

		$percCol = array_column($PGtiri, 'perc');
		array_multisort($percCol, SORT_DESC, $PGtiri);
		$malatiMax = $parametri->MaxMalati;




		foreach($PGtiri as $pg){

			if (($Nmalati<$malatiMax)||($pg['perc']>$parametri->SogliaExtra)){
				$tiro = rand(1,100);
				if ($tiro<=$pg['perc']){



					if($pg['perc'] < $parametri->SogliaExtra){
							$Nmalati = $Nmalati+1;
					}
					if($pg['malattia']!=null){
						$stadio = $pg['malattia']->Stadi()->orderBy('Numero','ASC')->first();
						$stadio->PG()->attach($pg['ID']);
					} else {
						$soloCibo = false;

						if(($pg['cicatriciPerse']!=0)&&($pg['cibo']!=0)){
							//Misto
							$sogliaL = $parametri->SogliaGravMisL;
							$sogliaT = $parametri->SogliaGravMisT;

						}else if(($pg['cicatriciPerse']!=0)&&($pg['cibo']==0)){
							//Ferito
							$sogliaL = $parametri->SogliaGravFerL;
							$sogliaT = $parametri->SogliaGravFerT;

						}else if(($pg['cicatriciPerse']==0)&&($pg['cibo']!=0)){
							//Solo Cibo
							$sogliaL = $parametri->SogliaGravCiboL;
							$sogliaT = $parametri->SogliaGravCiboT;
							$soloCibo = true;
						}

						if(($pg['cicatriciPerse']>$parametri->SogliaMalusF)){
							$sogliaL = $sogliaL-$parametri->MalusF;
							$sogliaT = $sogliaT-$parametri->MalusF;
						}
					//	$found = false;

					//	while(!$found){
							$tiroGrav = rand(1,100);

							if ($soloCibo){
								if ($tiroGrav < $sogliaL){
											$malattia = Malattia::where('Categoria',1)
												->orderBy(DB::raw('RANDOM()'))->first();

								}else if ($tiroGrav > $sogliaT){
									$malattia = Malattia::where('Categoria',4)
										->orWhere('Categoria',3)
										->orderBy(DB::raw('RANDOM()'))->first();
								}else {
									$malattia = Malattia::where('Categoria',3)
										->orWhere('Categoria',2)
										->orderBy(DB::raw('RANDOM()'))->first();
								}

							} else {

								if ($tiroGrav < $sogliaL){
										if($pg['cibo']==0){
											$malattia = Malattia::where('Categoria',2)
												->orderBy(DB::raw('RANDOM()'))->first();
										} else {
											$malattia = Malattia::where('Categoria',2)
												->orWhere('Categoria',1)
												->orderBy(DB::raw('RANDOM()'))->first();
										}
								}else if ($tiroGrav > $sogliaT){
									$malattia = Malattia::where('Categoria',4)
										->orderBy(DB::raw('RANDOM()'))->first();
								}else {
									$malattia = Malattia::where('Categoria',3)
										->orderBy(DB::raw('RANDOM()'))->first();
								}

								/*
								$tiroCont = rand(1,100);
								if($tiroCont<$stadio->Contatto){
									$stadio->PG()->attach($pg->ID);
									$found = true;
								}
								*/
						//	}
							}

							$stadio = $malattia->Stadi()->orderBy('Numero','ASC')->first();

							$stadio->PG()->sync([$pg['ID']]);
					}
				}
			}

		}
		Session::flash('message', 'Malati aggiornati con successo! ');
		return Redirect::to('admin/malattie/');

	}

}
