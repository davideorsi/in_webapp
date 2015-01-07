<?php

class UserController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	// show the User info
	public function showAccount()
	{
		
		$idpg = Session::get('idpg');
		if ($idpg){

			$pg=PG::find($idpg);
			$evento = Evento::orderBy('Data','Desc')->take(1)->get(array('Titolo','Luogo','Data','ID'));

			// Parsing della data in formato corretto.
			$data= new Datetime($evento[0]['Data']);
			$limite= new Datetime($evento[0]['Data']);
			
			$evento[0]['Data']=strftime("%d %B %Y",$data->gettimestamp());


			$limite=$limite->sub(new DateInterval('P3D'));
			$today=new Datetime();

			// Verifica l'Iscrizione
			$iscrizione=Evento::find($evento[0]['ID'])->PG()->where('PG.ID','=',$idpg)->get(array('Arrivo','Cena','Pernotto','Note'));
			$iscritto = !empty($iscrizione[0]);
			if (empty($iscrizione[0])){
				$iscrizione = array(0=>[]);
				}

			//Verifica delle Abilità che consentono di scegliere oggetti o informazioni da avere all'inizio del live. Le info verranno salvate come "note" all'iscrizione.
			$abilita_con_opzioni= Abilita::has('Opzioni')->get();
			$abilita_del_PG=PG::find($idpg)->Abilita()->get();
			$abilita_del_PG=INtools::select_column($abilita_del_PG,'ID');
			
			$posseduta=array();
			$sel=array();
			foreach ($abilita_con_opzioni as $ab){
				$posseduta[]=in_array($ab['ID'],$abilita_del_PG);
				switch ($ab['Ability']) {
					case "Informatori":
						$sel[$ab['Ability']]=array(0=>'');
						foreach ($ab['Opzioni'] as $opt){
							$sel[$ab['Ability']][$opt['Opzione']]=$opt['Opzione'];
							}
						break;
					case "Ragno tessitore":
						$sel[$ab['Ability']]=array(0=>'');
						foreach ($ab['Opzioni'] as $opt){
							$sel[$ab['Ability']][$opt['Opzione']]=$opt['Opzione'];
							}
						break;
					case "Iscritto all'albo":
						$sel[$ab['Ability']]=array(0=>'');
						foreach ($ab['Opzioni'] as $opt){
							$sel[$ab['Ability']][$opt['Opzione']]=$opt['Opzione'];
							}
						break;
					case "Rotte commerciali locali":
						$sel[$ab['Ability']]=array();
						foreach ($ab['Opzioni'] as $opt){
							$sel[$ab['Ability']][]=array(
									'Opzione'=>$opt['Opzione'],
									'Costo'=>$opt['Costo']);
								}
						break;

					case "Rotte commerciali d'oltremare":
						$sel[$ab['Ability']]=array();
						foreach ($ab['Opzioni'] as $opt){
							$sel[$ab['Ability']][]=array(
									'Opzione'=>$opt['Opzione'],
									'Costo'=>$opt['Costo']);
								}
						break;
					
					}				
				}

			
			if ($today < $limite)	{
				$datalimite=$limite->format("d/m/Y");
				return View::make('account')
							->with('in_tempo',true)
							->with('data_iscrizione',$datalimite)
							->with('pg',$pg)
							->with('evento',$evento[0])
							->with('iscritto',$iscritto)
							->with('iscrizione',$iscrizione[0])
							->with('posseduta',$posseduta)
							->with('sel',$sel)
							->with('abilita_con_opzioni',$abilita_con_opzioni);
			}
			elseif ($today->format('Y-m-d') >= $data->format('Y-m-d')) {
				// pagina di info se nessun evento è programmato
				return View::make('account_noevento');
			} else {
				return View::make('account')
							->with('in_tempo',false)
							->with('pg',$pg)
							->with('evento',$evento[0])
							->with('iscritto',$iscritto)
							->with('iscrizione',$iscrizione[0])
							->with('posseduta',$posseduta)
							->with('sel',$sel)
							->with('abilita_con_opzioni',$abilita_con_opzioni);
			}
			
		}
		else {
			return Redirect::to('/informazioni');
		}

	}

	# iscrive il PG all'evento
	public function updateAccount(){
		
		if (Auth::user()->usergroup != 7) {
			$PG=Session::get('idpg');
		} else {
			$PG=false;
		}
		
		$idPg		=Input::get('PG');
		$idEvento	=Input::get('Evento');
		$arrivo		=Input::get('Arrivo');
		$cena		=Input::get('Cena',0);
		$pernotto	=Input::get('Pernotto',0);

		$opzioni_singole =Input::get('Opzioni');
		$numero_oggetti =Input::get('numero');
		$tipo_oggetti =Input::get('oggetto');
		$costo_oggetti =Input::get('costo');

		if ($opzioni_singole){
			$note=implode('<br>',$opzioni_singole);
		} else
		{
			$note='';
		}
		
		if ($numero_oggetti) {
			$totale=0;
			foreach ($numero_oggetti as $key=>$num){
				if ($num>0){
						if ($key==0){
							$note.=$tipo_oggetti[$key].'('.$num.'X)';
						}else{
							$note.='<br>'.$tipo_oggetti[$key].'('.$num.'X)';
							}
						$totale+=$num*$costo_oggetti[$key];
					}
				}
			if ($totale>0) {
				$note.='<br>Costo totale: '.INtools::convertiMonete($totale);
				}
		}

		$Evento=Evento::find($idEvento);

		
		if ((Auth::user()->usergroup == 7) | ($PG==$idPg)) {
			$Evento->PG()->attach($idPg,array('Arrivo'=>$arrivo,'Cena'=>$cena,	'Pernotto'=>$pernotto, 'Note'=>$note));
		
			Session::flash('message', 'Iscrizione aggiunta correttamente!');
		} else {
			Session::flash('message', 'Si è verificato un errore!');
		}

		if (Auth::user()->usergroup == 7){
			return Redirect::to('admin');
		} else {
			return Redirect::to('account');
		}
	
		

		
	}
	

	// show the profile (PG info)
	public function showPg()
	{
		$idpg = Session::get('idpg');
		if ($idpg){
			$PG=PG::find($idpg);

			// Retrieving infos
			$PG['Abilita']=$PG->Abilita;
			$PG['Incanti']=$PG->Incanti;
			$PG['Categorie']=$PG->Categorie;
			$PG['abilita_unlocked']   = PGtools::AbilitaSbloccate($PG);
	
			$PG['Monete']=INtools::convertiMonete($PG->Rendita());
			$PG['Px Rimasti']=$PG->PxRimasti();
			$PG['Erbe']=$PG->Erbe();
			$PG['CartelliniPotere']=$PG->CartelliniPotere();
			$PG['Note']=$PG->Note();
			
			$data=array(
				'name' 		=> Auth::user()->username,
				'PG'		=> $PG
			);
			return View::make('profile',$data);
		} else {
			return Redirect::to('/');
		}
	}

	public function updatePg(){
		$id = Input::get('ID');
		$PG = PG::find($id);
		
		$msg='';
		//aggiungi abilita;
		$add_ab =Input::get('sel_abilita');	
	
		if ($add_ab!=0){
			$ab=Abilita::find($add_ab);
			$Px=$ab['PX'];
			if ($Px <= $PG->PxRimasti()) {

				$data['PG']=$PG;
				$data['abilita']=Abilita::find($add_ab);
				$emails=User::where('usergroup','=',7)->get(array('email'));
				$emails=INtools::select_column($emails,'email');
				
				Mail::send('emails.abilita', $data, function($message) use ($emails)
				{
					$message->to($emails)->subject('Aggiunta Abilità');
				});

				
				$PG->Abilita()->attach($add_ab);
				
			} else { 
				$msg='Il PG non ha Px a sufficienza per acquistare l\'abilità selezionata!';
			}
		} 



		
		// redirect		
		if (empty($msg)) $msg.=' Abilità aggiunta correttamente';
		Session::flash('message', $msg);
		return Redirect::to('pg');

	}

	// Mostra informazioni su incanti e abilità non presenti nel regolamento.
	public function showPGinfo(){

		$idpg = Session::get('idpg');
		if ($idpg){
			$PG=PG::find($idpg);
			
			$Abilita=$PG->Abilita;
			$Speciali=array();
			foreach ($Abilita as $ab){
				if (in_array($ab['Categoria'],array('Speciali','Spiriti','Innate')) ){
					$Speciali[]=$ab;
					}
				}
			$Incanti=$PG->Incanti;
			$Sbloccate= $PG->Sbloccate;
			
			$data=$PG['Nome'];
			return View::make('profile_info')
					->with('data',$data)
					->with('Speciali',$Speciali)
					->with('Incanti',$Incanti)
					->with('Sbloccate',$Sbloccate);
		} else {
			return Redirect::to('/informazioni');
		}


	}

	############## Admin page: editare iscrizione agli eventi ##########
	public function showAdmin()
	{
		$Evento = Evento::orderBy('Data','Desc')->take(1)->get(array('Data','Titolo','ID'));

		$data=new Datetime($Evento[0]['Data']);
		$Evento[0]['Data']=strftime("%d %B %Y",$data->gettimestamp());

		$Evento[0]['PG'] = $Evento[0]->PG()->orderby('Arrivo','asc')->get(array('Nome','PG.ID','Affiliazione','NomeGiocatore'));

		$affiliazione['Nottingham']=0;
		$affiliazione['La Rochelle']=0;
		$affiliazione['Non Affiliati']=0;
		$pernottano=0;
		$cenano=0;
		foreach ($Evento[0]['PG'] as $pg){
			$pernottano+=$pg['pivot']['Pernotto'];
			$cenano+=$pg['pivot']['Cena'];
			$affiliazione[$pg['Affiliazione']]+=1;
		}
		$Evento[0]['pernottano']=$pernottano;
		$Evento[0]['cenano']=$cenano;

		$Vivi=PG::orderBy('Nome','asc')->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get();

		// seleziono elenco dei PG vivi
		$selVivi=array('NULL' => '');
		foreach ($Vivi as $vivo){
			$selVivi[(string)$vivo->ID] = $vivo['Nome'].' ('.$vivo['NomeGiocatore'].')';
		}
		
		return View::make('homeadmin')
				->with('Evento',$Evento[0])
				->with('affiliazione',$affiliazione)
				->with('selVivi',$selVivi);

	}

	## Elimina iscrizione utente dall'evento.
	public function unsuscribe()
	{
		$idPg=Input::get('PG');
		$idEvento=Input::get('Evento');


		$Evento=Evento::find($idEvento);
		$Evento->PG()->detach($idPg);

		Session::flash('message', 'Iscrizione rimossa correttamente!');
		return Redirect::to('admin');

	}

}
