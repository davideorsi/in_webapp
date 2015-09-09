<?php

class MissivaController extends \BaseController {

	/**
	 * Display a search form for the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$idpg = Session::get('idpg');

		if ($idpg | (Auth::user()->usergroup == 7)){
			$PG=PG::whereRaw('Morto = 0 AND InLimbo=0')->orderBy('Nome','asc')->get(array('ID','Nome','NomeGiocatore'));
			$selPG=array(0=>'');
			foreach($PG as $p){
				$selPG[$p->ID]=$p->Nome .' ('. $p->NomeGiocatore.')';
				}
			
			return View::make('missiva.index')->with('selPG',$selPG);
		} else {
			return Redirect::to('/');
		}
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function search()
	{

		$pg=Input::get('PG');
		$png=Input::get('PNG');
		$data=Input::get('Data');
		$testo=Input::get('Testo');
		$interc=Input::get('Intercettato',0);
		$solononrisp=Input::get('Solononrisp',0);
		$conpng=Input::get('ConPNG',0);

		
		$condizione='';
		$params=array();
		
		if ($interc){
			if ($condizione) {$condizione.=" AND ";}
			$params[]=$interc;
			$condizione.="(`intercettato` = ?)";
		}
		
				
		if ($solononrisp){
			if ($condizione) {$condizione.=" AND ";}
			$params[]=$solononrisp;
			$condizione.="(`rispondere` = ?)";
		}

		if ($conpng){
			if ($condizione) {$condizione.=" AND ";}
			$condizione.="(`tipo_mittente` = 'PNG' OR `tipo_destinatario` = 'PNG')";
		}
		
		
		if (Auth::user()->usergroup == 7) {
				if ($pg){
					if ($condizione) {$condizione.=" AND ";}
					$params[]=$pg;
					$params[]=$pg;
					$condizione.="(`mittente` = ? OR `destinatario` = ?)";
				} 
		} elseif (Auth::user()) {
					if ($condizione) {$condizione.=" AND ";}
					$idpg = DB::table('giocatore-pg')->where('user', Auth::user()->id)->pluck('pg');
					if ($pg){
						$params[]=$idpg;
						$params[]=$pg;
						$params[]=$pg;
						$params[]=$idpg;
						$condizione.="((`mittente` = ? AND `destinatario` = ?) OR (`mittente` = ? AND `destinatario` = ?))";

					} else {
						$params[]=$idpg;
						$params[]=$idpg;
						$condizione.="(`mittente` = ? OR `destinatario` = ?)";
					}
		}
		if ($png){
			if ($condizione) {$condizione.=" AND ";}
			$params[]="%".$png."%";
			$params[]="%".$png."%";
			$condizione.="(`mittente` LIKE ? OR `destinatario`LIKE ?) ";
		}
		if ($data){
			if ($condizione) {$condizione.=" AND ";}
			$words=explode(' ', $data);
			$i=0;
			foreach ($words as $parola){
				$i++;
				if ($i>1) {$condizione.=" AND ";} else {$condizione.="(";}
				$params[]="%".$parola."%";
				$condizione.="`data` LIKE ?";
				if ($parola=== end($words)) {$condizione.=")";}
			}
		}
		if ($testo){
			if ($condizione) {$condizione.=" AND ";}
			$words=explode(' ', $testo);
			$i=0;
			foreach ($words as $parola){
				$i++;
				if ($i>1) {$condizione.=" AND ";} else {$condizione.="(";}
				$params[]="% ".$parola." %";
				$condizione.="`testo` LIKE ?";
				if ($parola=== end($words)) {$condizione.=")";}
			}
		}
		if (!$condizione){$condizione="1"; }
		$missive=Missiva::whereRaw($condizione,$params)->orderBy('id','desc')->paginate(10);

		foreach ($missive as $missiva){
			$data= new Datetime($missiva['data']);
			$missiva['data']=strftime("%d %b %Y",$data->gettimestamp());
			}
		
		return Response::json($missive);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		$idpg = Session::get('idpg');

		if ($idpg | (Auth::user()->usergroup == 7)){
			$costo= array(
				0  => 'Missiva tra PG (gratuita)',
				2  => 'Missiva nel Ducato (2 Rame)',
				4  => 'Missiva Estera (4 Rame)',
				10 => 'Missiva Sicura (1 Argento)');
	
			$Vivi=PG::orderBy('Nome','asc')->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get();
	
			$data=Voce::where('Bozza','=',0)->orderBy('Data','desc')->take(1)->pluck('Data');
			$data= new Datetime($data);
			$data=strftime("%d %B %Y",$data->gettimestamp());
	
			$selVivi=array(0=>'');
			foreach ($Vivi as $vivo){
				$selVivi[(string)$vivo->ID] = $vivo['Nome'].' ('.$vivo['NomeGiocatore'].')';
			}
			return View::make('missiva.create')
							->with('costo',$costo)
							->with('data', $data)
							->with('selVivi',$selVivi);
		} else {
			return Redirect::to('/');
		}
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
			'testo' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('missive/create')
				->withErrors($validator);
		} else {
			//variables

			$time=Voce::where('Bozza','=',0)->orderBy('Data','desc')->take(1)->pluck('Data');

			$costo=Input::get('tipo');
			$intercettato = INtools::is_intercettato($costo);
			
			// store
			$missiva = new Missiva;
			$missiva->data       		= $time;
			$missiva->costo 	  		= $costo;
			$missiva->intercettato 		= $intercettato;
			$missiva->testo      		= Input::get('testo');
			$missiva->rispondere		= 0;
				
			if (Auth::user()->usergroup == 7) {
				$missiva->mittente       	= Input::get('mittente');
				$missiva->destinatario      = Input::get('destinatario');
				$missiva->pagato			= 1;
				$missiva->tipo_mittente		= 'PNG';
				$missiva->tipo_destinatario = 'PG';
			} else {
				$idpg = DB::table('giocatore-pg')->where('user', Auth::user()->id)->pluck('pg');
				$destinatario_PG=Input::get('destinatario');
				$destinatario_PNG=Input::get('destinatario_PNG');
				$missiva->pagato			= 0;
				$missiva->mittente     	= $idpg;
				$missiva->tipo_mittente		= 'PG';
				if ($destinatario_PG && !$destinatario_PNG){
					$missiva->destinatario = $destinatario_PG;
					$missiva->tipo_destinatario		= 'PG';
					$missiva->costo 	  		= 0;
					$missiva->pagato			= 1;
					}
				elseif (!$destinatario_PG && $destinatario_PNG){
					$missiva->destinatario = $destinatario_PNG;
					$missiva->tipo_destinatario		= 'PNG';
					$missiva->rispondere		= 1;
					}
				else {
					Session::flash('message', 'Errore! Indica come destinatario un pg OPPURE un png!');
					return Redirect::to('missive/create');
					}				
			}

			//############ MISSIVA #####################################
			
			$data=[];
			// aggiungendo le email di notifica
			if ($missiva->tipo_mittente=='PNG') {
					$data['mittente']=$missiva->mittente;
					$PG=PG::find($missiva->destinatario);
					$data['destinatario']=$PG['Nome'];

					$emails=User::where('usergroup','=',7)->get(array('email'));
					$emails=INtools::select_column($emails,'email');

					
					$user_id=$PG->User;
					$user_id=$user_id['user'];
					$user_email=User::find($user_id)->email;					
					array_push($emails,$user_email);
					
				} elseif ($missiva->tipo_destinatario=='PNG') {
					$PG=PG::find($missiva->mittente);
					$data['mittente']=$PG['Nome'];
					$data['destinatario']=$missiva->destinatario;
					
					$emails=User::where('usergroup','=',7)->get(array('email'));
					$emails=INtools::select_column($emails,'email');					
				} else {

					$emails=User::where('usergroup','=',7)->get(array('email'));
					$emails=INtools::select_column($emails,'email');
					
					$PG=PG::find($missiva->destinatario);
					$data['destinatario']=$PG['Nome'];

					$user_id=$PG->User;
					$user_id=$user_id['user'];
					$user_email=User::find($user_id)->email;
					array_push($emails,$user_email);

					
					$PG=PG::find($missiva->mittente);
					$data['mittente']=$PG['Nome'];

					$user_id=$PG->User;
					$user_id=$user_id['user'];
					$user_email=User::find($user_id)->email;					
					array_push($emails,$user_email);



				}

			$data['missiva']=$missiva;
				
			Mail::send('emails.missiva', $data, function($message) use ($emails)
			{
				$message->to($emails)->subject('Missiva inviata');
			});
			
			// salva
			$missiva->save();
			
			// redirect
			Session::flash('message', 'Missiva inviata con successo!');
			return Redirect::to('missive');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$missiva=Missiva::find($id);


		$time= new Datetime($missiva['data']);
		$missiva['data']=strftime("%d %B %Y",$time->gettimestamp());
		$missiva->testo=nl2br($missiva->testo);
		$pubblica=False;
		
		// MOSTRA tutte le missive ai master
		if (Auth::user()->usergroup == 7) {
			$pubblica=True;
		}
		// MENTRE agli utenti normali mostra solo quelle che li riguardano
		elseif (Auth::user()) {
			$idpg = DB::table('giocatore-pg')->where('user', Auth::user()->id)->pluck('pg');
			if ($missiva->mittente == $idpg | $missiva->destinatario == $idpg)
				{
					$pubblica=True;
				}
		}

		if ($pubblica){
				if (Request::ajax()){
					return Response::json($missiva);
				} else {
					$data['missiva']=$missiva;
					$pdf = PDF::loadView('missiva.print',$data);
					return $pdf->setWarnings(false)->stream();
				}
				
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
		$missiva = Missiva::find($id);
		$missiva -> delete();

		Session::flash('message', 'Missiva cancellata correttamente!');
		return Redirect::to('missive');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function toggle_rispondere($id)
	{
		$missiva = Missiva::find($id);
		$status = $missiva['rispondere'];
		
		$missiva -> rispondere = 1-$status;
		$missiva -> save();

		Session::flash('message', 'Missiva aggiornata!');
		return Redirect::to('missive');
	}


	/*
	 * Ritorna i costi delle missive
	 * con una lista, da cui sarà possibile eliminare i debiti dei PG
	 *
	 *
	 * */

	public function debito($id)
	{

		$idpg = Session::get('idpg');
		if (($idpg == $id) | (Auth::user()->usergroup == 7)) {
			$lista = Missiva::orderBy('id','asc')->whereRaw("`mittente` = ? AND ((`pagato` IS NULL) OR (`pagato` = 0))",[$pg['ID']])->get(['costo']);
			$costi=INtools::select_column($lista,'costo');
			
			$totale = INtools::convertiMonete(array_sum($costi));
			
			if (!$totale) { $totale=0;}
		} else {

			$totale='';
		}
				
		return Response::json($totale);
	}

	public function debiti()
	{
        $pgs=PG::orderBy('Nome','asc')->get(['ID','Nome','NomeGiocatore']);

        $lista=[];
        foreach ($pgs as $pg){
		    $missive = Missiva::orderBy('id','asc')->whereRaw("`mittente` = ? AND ((`pagato` IS NULL) OR (`pagato` = 0))",[$pg['ID']])->get(['costo']);
			$costi=INtools::select_column($missive,'costo');
			
			$totale = INtools::convertiMonete(array_sum($costi));
			
            if ($totale) {
                $lista[]=array('Nome'=>$pg['Nome'],
                               'NomeGiocatore'=>$pg['NomeGiocatore'],
                               'ID'=>$pg['ID'],
                               'debito'=>$totale);
            }
	    }			
		return View::make('missiva.debiti')->with('lista',$lista);
	}

    public function azzera_debito($id)
    {

        $lista = Missiva::orderBy('id','asc')->whereRaw("`mittente` = ? AND ((`pagato` IS NULL) OR (`pagato` = 0))",[$id])->get(['id']);

        foreach ($lista as $elem)
        {
            $missiva= Missiva::find($elem['id']);
            $missiva['pagato']=1;
            $missiva->save();        
        }   
        return Response::json(['OK']);    
    }    
    
     /*
	 * GESTIONE DELLE MISSIVE INTERCETTATE
	 * per automatizzarne l'invio ad ogni mese.
	 *
	 * */
	 public function intercettate(){
		 
		$data_attuale=Voce::where('Bozza','=',0)->orderBy('Data','desc')->take(1)->pluck('Data');
		$data_attuale= new Datetime($data_attuale);
		$mese_attuale=strftime("%b",$data_attuale->sub(new DateInterval('P1M'))->gettimestamp());
		
		$missive=Missiva::where('intercettato','=','1')->orderBy('id','desc')->take(5)->get();

		$selMissiva=array(''=>'');
		$coinvolto=array();
		foreach ($missive as $key=>$missiva){
			$data= new Datetime($missiva['data']);
			if (strcmp($mese_attuale,strftime("%b",$data->gettimestamp()))==0){
				$missiva['data']=strftime("%d %b %Y",$data->gettimestamp());
				$selMissiva[$missiva['id']]=$key+1;
				if ($missiva['tipo_mittente']=='PG') {
					$coinvolto[$key]=$missiva['mittente'];
				} else{
					$coinvolto[$key]=$missiva['destinatario'];
				}
			} else {
				unset($missive[$key]);
			}
		}
			
		$infiltrato=Abilita::where('Ability','=','Infiltrato')->get(['ID']);
		$abilita = Abilita::find($infiltrato[0]['ID']);
		$PG=$abilita->PG()->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get(['PG.ID','Nome','NomeGiocatore']);
		
		$elenco=array_keys($selMissiva);
		unset($elenco[0]);
		if ($elenco) {
		foreach( $PG as $pers) {
			$index=array_rand($elenco);
			$quale=$elenco[$index];
			
			$pers['missiva']=$quale;
			}
		} else {
		foreach( $PG as $pers) {
			$pers['missiva']='';
			}
				
		}

		return View::make('missiva.intercettate')
					->with('missive',$missive)
					->with('selMissiva',$selMissiva)
					->with('PG',$PG);
		 
		 
	 }
	 
	 
	 public function inoltra_intercettate(){
		 
		 $personaggi=Input::get('PG');
		 $missive=Input::get('missiva');

	     $currtime=Voce::where('Bozza','=',0)->orderBy('Data','desc')->take(1)->pluck('Data');
					 
		 foreach ($missive as $key=>$idmiss) {
		 #$idmiss=$missive[0];
		 #$key=0;
		    if ($idmiss) {
			$missiva=Missiva::find($idmiss);
			
			$time= new Datetime($missiva['data']);
			$data=strftime("%d %B %Y",$time->gettimestamp());
			
			
			$intercetto= new Missiva;
			$intercetto->data=$currtime;
			$intercetto['mittente']='STAFF, Abilità "Infiltrato", missiva intercetta del mese di '.strftime("%B %Y",$time->gettimestamp());
			$intercetto->destinatario=$personaggi[$key];
			$intercetto->costo=10;
			$intercetto->pagato=1;
			$intercetto->rispondere	= 0;
			$intercetto->intercettato = 0;
			$intercetto['tipo_destinatario']='PG';
			$intercetto['tipo_mittente']='PNG';
			$intercetto['testo']='DATA: '.$data.'</br>';
			$intercetto['testo'].='DESTINATARIO: '.$missiva['dest'].'</br>';	
			$intercetto['testo'].='</br>';
			$intercetto['testo'].=$missiva['testo'];	
			$intercetto->save();		 
			
			$pers=PG::find($personaggi[$key]);
			
			$data=[];
			$data['mittente']=$intercetto->mittente;
			$PG=PG::find($intercetto->destinatario);
			$data['destinatario']=$pers['Nome'];

			$emails=User::where('usergroup','=',7)->get(array('email'));
			$emails=INtools::select_column($emails,'email');

			
			$user_id=$pers->User;
			$user_id=$user_id['user'];
			$user_email=User::find($user_id)->email;					
			array_push($emails,$user_email);
			
			$data['missiva']=$intercetto;
			
			Mail::send('emails.missiva', $data, function($message) use ($emails){
				$message->to($emails)->subject('Missiva inviata');
			});
			
			}
		 }
		 
		 return Redirect::to('missive');
	 }
    


}
