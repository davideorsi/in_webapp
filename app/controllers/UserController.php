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


	public function showInfo()
	{
		$USER=Auth::user();

		$email=$USER->email;
		return View::make('info')
			->with('email',$email);

	}

	public function updateInfo()
	{
		$USER=Auth::user();
		$USER->email = Input::get('email');

		$USER->save();
		
		return Redirect::to('/info');

	}
	

	// show the User info: iscrizioni
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
			$iscrizione=Evento::find($evento[0]['ID'])->PG()->where('PG.ID','=',$idpg)->get(array('Arrivo','Cena','Pernotto','Note','Pagato'));
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
			return Redirect::to('/istruzioni');
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


		if (Auth::user()->usergroup != 7) {
			if ($opzioni_singole){
				$note=implode('<br>',$opzioni_singole);
			} else
			{
				$note='';
			}
		} else {
			$note=Input::get('Note');
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
			$Evento->PG()->attach($idPg,array('Arrivo'=>$arrivo,'Cena'=>$cena,	'Pernotto'=>$pernotto, 'Note'=>$note, 'Pagato'=>0));
		
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
			return Redirect::to('/istruzioni');
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
			return Redirect::to('/istruzioni');
		}


	}

	############## Admin page: editare iscrizione agli eventi ##########
	public function showAdmin()
	{
		$Evento = Evento::orderBy('Data','Desc')->take(1)->get(array('Data','Titolo','ID','Tipo'));

		$data=new Datetime($Evento[0]['Data']);
		$Evento[0]['Data']=strftime("%d %B %Y",$data->gettimestamp());
		$Evento[0]['PG'] = $Evento[0]->PG()->orderby('Arrivo','asc')->get(array('Nome','PG.ID','Affiliazione','NomeGiocatore'));
		
	
	
		// tassazione ##################################################	
		if ($Evento[0]['Tipo']=='EVENTO LIVE') {
		
			$Eventoprec=Evento::orderBy('Data','Desc')->where('Tipo','=','EVENTO LIVE')->take(2)->get(array('Data','Titolo','ID','Tipo'));
			$Eventoprec[1]['PG'] = $Eventoprec[1]->PG()->orderby('Arrivo','asc')->get(array('Nome','PG.ID','Affiliazione','NomeGiocatore'));
	
			$tassazione['Nottingham']=0;
			$tassazione['La Rochelle']=0;
			$tassazione['Non Affiliati']=0;
			$sconto['Nottingham']=0;
			$sconto['La Rochelle']=0;
			$sconto['Non Affiliati']=0;
			foreach ($Eventoprec[1]['PG'] as $pg){
				$tassazione[$pg['Affiliazione']]+=1;
				$abilita_del_PG=$pg->Abilita()->get();
				$abilita_del_PG=INtools::select_column($abilita_del_PG,'ID');
				if (in_array(42,$abilita_del_PG)){ // se non ha privilegi economici
					$sconto[$pg['Affiliazione']]+=1;
				}
			}
			
			$diff=$tassazione['La Rochelle']-$tassazione['Nottingham'];
			if ($diff>=0) {
				$tassazione['La Rochelle']=INtools::convertiMonete(($tassazione['La Rochelle']-$sconto['La Rochelle'])*5+5*$diff);
				$tassazione['Nottingham']=INtools::convertiMonete(($tassazione['Nottingham']-$sconto['Nottingham'])*5);
			} else {
				$tassazione['Nottingham']=INtools::convertiMonete(($tassazione['Nottingham']-$sconto['Nottingham'])*5-$diff*5);
				$tassazione['La Rochelle']=INtools::convertiMonete(($tassazione['La Rochelle']-$sconto['La Rochelle'])*5);
			}
			
		} else {
			$tassazione=NULL;
		}
		
		// evento corrente #############################################

		$affiliazione['Nottingham']=0;
		$affiliazione['La Rochelle']=0;
		$affiliazione['Non Affiliati']=0;
		
		$pernottano=0;
		$cenano=0;
		
		$secondaria['Nottingham']=0;
		$secondaria['La Rochelle']=0;
		$secondaria['Non Affiliati']=0;
		foreach ($Evento[0]['PG'] as $pg){
			$pernottano+=$pg['pivot']['Pernotto'];
			$cenano+=$pg['pivot']['Cena'];
			$affiliazione[$pg['Affiliazione']]+=1;
			if ($pg['Affiliazione']=='Nottingham'){
				$pg['classe_affiliazione']='text-danger';
			} elseif ($pg['Affiliazione']=='La Rochelle') {
				$pg['classe_affiliazione']='text-primary';
			} else {
				$pg['classe_affiliazione']='text-warning';
			}
			$abilita_del_PG=$pg->Abilita()->get();
			$abilita_del_PG=INtools::select_column($abilita_del_PG,'ID');
			if (!in_array(8,$abilita_del_PG)){
				if (in_array(43,$abilita_del_PG)){
					$secondaria[$pg['Affiliazione']]+=20;
				} else {
					$secondaria[$pg['Affiliazione']]+=10;
				}
				$pg['Rendita_tot']=$pg->Rendita();
			} else {
				$pg['Rendita_tot']=$pg->Rendita();
				if (in_array(43,$abilita_del_PG)){
					$pg['Rendita_tot']+=20;
				} else {
					$pg['Rendita_tot']+=10;
				}
			}
			$lista = Missiva::orderBy('id','asc')->whereRaw("`mittente` = ? AND ((`pagato` IS NULL) OR (`pagato` = 0))",[$pg['ID']])->get(['costo']);
			$costi=INtools::select_column($lista,'costo');
			$debtotale = array_sum($costi);
			$pg['Debiti_tot']=INtools::convertiMonete($debtotale);
			
			$inbusta=$pg['Rendita_tot']-$debtotale;
			
			if ($inbusta<0) {
				$pg['class_denaro']='text-danger';	
			} else {
				$pg['class_denaro']='text-success';
			} 
			$pg['Denaro_busta']=INtools::convertiMonete(abs($inbusta));
			
			$pg['Rendita_tot']=INtools::convertiMonete($pg['Rendita_tot']);
		}
		$secondaria['Nottingham']=INtools::convertiMonete($secondaria['Nottingham']);
		$secondaria['La Rochelle']=INtools::convertiMonete($secondaria['La Rochelle']);
		$secondaria['Non Affiliati']=INtools::convertiMonete($secondaria['Non Affiliati']);
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
				->with('tassazione',$tassazione)
				->with('secondaria',$secondaria)
				->with('selVivi',$selVivi);

	}
	
		############## Admin page: editare iscrizione agli eventi ##########
	public function showAdminPx()
	{
		$Evento = Evento::orderBy('Data','Desc')->take(1)->get(array('Data','Titolo','ID'));
		$data=new Datetime($Evento[0]['Data']);
		$Evento[0]['Data']=strftime("%d %B %Y",$data->gettimestamp());
		
		$Evento[0]['PG'] = $Evento[0]->PG()->orderby('Arrivo','asc')->get(array('Nome','PG.ID','Px','NomeGiocatore'));

		
		return View::make('adminpx')
				->with('Evento',$Evento[0]);

	}
	
	public function updateAdminPx()
	{
		$pgs=Input::get('pg');
		$px=Input::get('px');
		
		foreach ($pgs as $key=>$pg){
				$pers = PG::find($pg);
				$pers['Px']=$pers['Px']+$px[$key];
				$pers->save();
			}
		Session::flash('message', 'PX assegnati correttamente!');
		return Redirect::to('admin/px');

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

	#Segna se il giocatore ha pagato o no
	public function updatePagato()
	{
		$idPg=Input::get('PG');
		$idEvento=Input::get('Evento');


		$Evento=Evento::find($idEvento);
		$Evento->PG()->updateExistingPivot($idPg,array('Pagato'=>Input::get('Pagato')));

		Session::flash('message', 'Informazione correttamente registrata!');
		return Redirect::to('admin');

	}

	public function user_unsubscribe()
	{		
		$idPg = Session::get('idpg');
		$evento = Evento::orderBy('Data','Desc')->take(1)->get(array('ID'));
		$idEvento=$evento[0]['ID'];


		$Evento=Evento::find($idEvento);
		$Evento->PG()->detach($idPg);

		Session::flash('message', 'Iscrizione rimossa correttamente!');
		return Redirect::to('account');

	}

}
