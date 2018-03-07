<?php

class PreziosiController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /preziosi
	 *
	 * @return Response
	 */
	public function index()
	{
		$Preziosi = Preziosi::whereNull('Comprato')->orderBy('Data', 'Asc')->get();

		foreach($Preziosi as $key=>$prezioso){
			if (is_null($prezioso['Creatore'])){$Preziosi[$key]['Creatore']='Sconosciuto';}
			if (is_numeric($prezioso['Creatore'])){
				$pg=PG::find($prezioso['Creatore']);
				$Preziosi[$key]['Creatore']=$pg['Nome'].' ('.$pg['NomeGiocatore'].')';
				}
			if (is_null($prezioso['Venditore'])){$Preziosi[$key]['Venditore']='Sconosciuto';}
			if (is_numeric($prezioso['Venditore'])){
				$pg=PG::find($prezioso['Venditore']);
				$Preziosi[$key]['Venditore']=$pg['Nome'].' ('.$pg['NomeGiocatore'].')';
				}
				
			//controllo offerta massima
			$offerte=$prezioso->Offerte->toArray();
			if ($offerte){
				$massima=INtools::is_maximum($offerte,'Offerta');
			}
			else $massima=NULL;
			
			if (count($massima)==1) {
				$offertamassima=PreziosiOfferte::find($offerte[$massima[0]]['ID']);	
				$Preziosi[$key]['OffertaMassima']=array('Nome'=>$offertamassima->PG->Nome,'PG'=>intval($offertamassima['ID_PG']),'Offerta'=>$offertamassima['Offerta']);
			} elseif(count($massima)>1) { 
				$Preziosi[$key]['OffertaMassima']='Almeno due offerte uguali';
			} else { 
				$Preziosi[$key]['OffertaMassima']=NULL;
			}
			$data= new Datetime($prezioso['Data']);
			$Preziosi[$key]['Data']=strftime("%d %B %Y",$data->gettimestamp());
			}
			
		// controllo se l'utente possiede anche "Valutare" (o è un master)
		
		$group=Auth::user()->usergroup;
		if ( $group!= 7) {
			$idpg = Session::get('idpg');
			$abilita_del_PG=PG::find($idpg)->Abilita()->get();

			$lista=INtools::select_column($abilita_del_PG,'Ability');			

			$valutare=in_array('Leggere',$lista)|in_array("Valutare",$lista);
			$master=false;
			
			$offertepg=array();
			foreach($Preziosi as $key=>$prezioso){
					$offerta=PreziosiOfferte::where('ID_PG','=',$idpg)->where('ID_Prezioso','=',$prezioso['ID'])->get(array('Offerta'))->toArray();
					if ($offerta) {
						$offertepg[$key]=$offerta[0]['Offerta'];
					} else {
						$offertepg[$key]=NULL;
						}
				}
			
			
		} else {
			$offertepg=NULL;
			$valutare=true;
			$master=true;
		}


		$Fazioni = Fazione::orderBy('ID', 'asc')->take(2)->get();
		$CondizioneMigliore=max(array($Fazioni[0]['Condizione'],$Fazioni[1]['Condizione']));
		
		$numero_vendita=array(1,2,3,4);
		$percentuale_vendita=array(50,40,30,30);
		
		$Numero=$numero_vendita[$CondizioneMigliore-1];
		$Percentuale=$percentuale_vendita[$CondizioneMigliore-1];

			
		return View::make('preziosi.index')
			->with('Numero', $Numero)
			->with('Percentuale', $Percentuale)
			->with('valutare', $valutare)
			->with('master', $master)
			->with('offertepg', $offertepg)
			->with('Preziosi', $Preziosi->toArray());
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /preziosi/create
	 *
	 * @return Response
	 */
	public function create()
	{
			$group=Auth::user()->usergroup;

			$data=Voce::where('Bozza','=',0)->orderBy('Data','desc')->take(1)->pluck('Data');
			$Vivi=PG::orderBy('Nome','asc')->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get(['ID','Nome','NomeGiocatore']);
			$selVivi=array(NULL=>'Sconosciuto');
			foreach ($Vivi as $vivo){
				$selVivi[(string)$vivo->ID] = $vivo['Nome'].' ('.$vivo['NomeGiocatore'].')';
			}
			
			$orafo=Abilita::where('Ability','=','Orafo')->get(['ID']);
			$orafo = Abilita::find($orafo[0]['ID']);
			$Orafi=$orafo->PG()->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get(['PG.ID','Nome','NomeGiocatore']);
			$selOrafi=array(NULL=>'Sconosciuto');
			foreach ($Orafi as $orafo){
				$selOrafi[(string)$orafo->ID] = $orafo['Nome'].' ('.$orafo['NomeGiocatore'].')';
			}
			
			return View::make('preziosi.create')
							->with('data', $data)
							->with('selVivi',$selVivi)
							->with('selOrafi',$selOrafi);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /preziosi
	 *
	 * @return Response
	 */
	public function store()
	{
			$prezioso = new Preziosi;
			$prezioso->Nome      		= Input::get('Nome');
			$prezioso->Creatore      	= Input::get('Creatore');
			$prezioso->Venditore      	= Input::get('Venditore');
			$prezioso->data       		= Input::get('Data');
			$prezioso->Materiali      	= Input::get('Materiali');
			$prezioso->Valore      		= Input::get('Valore');
			$prezioso->BaseAsta     	= Input::get('BaseAsta');
			$prezioso->Aspetto      	= Input::get('Aspetto');
			// salva
			$prezioso->save();

			Session::flash('message', 'Oggetto Prezioso aggiunto con successo!');
			return Redirect::to('admin/preziosi');
	}
	
	public function rimuovi_offerta($id)
	{
			$idpg = Session::get('idpg');
			
			$offerta=PreziosiOfferte::where('ID_PG','=',$idpg)->where('ID_Prezioso','=',$id)->get(array('ID'))->toArray();
			if ($offerta) {
				$offerta=PreziosiOfferte::find($offerta[0]['ID']);
				$offerta->delete();
				}
				
			Session::flash('message', "Offerta rimossa!");
			
			return Redirect::to('preziosi');
	}
	
	public function fai_offerta($id,$importo)
	{
			$idpg = Session::get('idpg');
			$data=Voce::where('Bozza','=',0)->orderBy('Data','desc')->take(1)->pluck('Data');
			
			$oggetto=Preziosi::find($id);
			$baseasta=$oggetto['BaseAsta'];
			if ($importo>=$baseasta){
				$offerta=PreziosiOfferte::where('ID_PG','=',$idpg)->where('ID_Prezioso','=',$id)->get(array('ID'))->toArray();
				if ($offerta) {
						$offerta=PreziosiOfferte::find($offerta[0]['ID']);
						$offerta->Offerta      	    = $importo;
						$offerta->Data       		= $data;
						$offerta->save();
					} else {
						$offerta = new PreziosiOfferte;
						$offerta->ID_Prezioso     	= $id;
						$offerta->ID_PG      		= $idpg;
						$offerta->Offerta      	    = $importo;
						$offerta->Data       		= $data;
						// salva
						$offerta->save();
					}
				Session::flash('message', 'Offerta aggiunta con successo!');
			}else{
				Session::flash('message', "Offerta inferiore alla base d'asta dell'oggetto!");
			}
			return Redirect::to('preziosi');
	}

	/**
	 * Display the specified resource.
	 * GET /preziosi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 * PUT /preziosi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function vendita_random(){
		// Sorteggia oggetti da vendere a caso al mercato.
		$Preziosi = Preziosi::whereNull('Comprato')->orderBy('Data', 'Asc')->get();
		$Fazioni = Fazione::orderBy('ID', 'asc')->take(2)->get();
		$CondizioneMigliore=max(array($Fazioni[0]['Condizione'],$Fazioni[1]['Condizione']));
		
		$numero_vendita=array(1,2,3,4);
		$percentuale_vendita=array(50,40,30,30);
		
		$Numero=$numero_vendita[$CondizioneMigliore-1];
		$Percentuale=$percentuale_vendita[$CondizioneMigliore-1];
		
		$venduti=0;
		foreach ($Preziosi as $prezioso){
			$offerte=$prezioso->Offerte->toArray();
			if ($offerte){
				$massima=INtools::is_maximum($offerte,'Offerta');
			}
			
			
			$perc=mt_rand(1,100);
			if($venduti<$Numero and $perc<=$Percentuale){
				if(!$offerte){
					$this->vendita($prezioso['ID']);
					$venduti=$venduti+1;
					} 
				elseif (count($massima)>1) {
					$offertamassima=PreziosiOfferte::find($offerte[$massima[0]]['ID']);	
					$this->vendita($prezioso['ID'],NULL,$offertamassima['Offerta']+1);
					$venduti=$venduti+1;
					} 
				}
			}
		return Redirect::to('admin/preziosi');			
	} 
	 
	public function vendita($id,$acquirente=NULL,$prezzo_acquisto=NULL)
	{
		// segna oggetto come "Venduto", perchè acquistato dal mercato 
		// attribuisce il valore sul conto del PG venditore.
		$prezioso = Preziosi::find($id);
		$prezioso->Comprato = true;
		
		$prezioso->Acquirente=$acquirente;
		
		$data=Voce::where('Bozza','=',0)->orderBy('Data','desc')->take(1)->pluck('Data');
		$prezioso->DataAcquisto = $data;	
				
		if ($prezzo_acquisto){
			$somma=$prezzo_acquisto;
		} else {
			$somma=$prezioso->BaseAsta;
		}

		$prezioso->PrezzoAcquisto=$somma;
		
		// addebita i soldi sul conto del venditore
		if ($prezioso['Venditore']){
			$pg=PG::find($prezioso['Venditore']);
			$conto=$pg->Conto;
			// se ha un conto addebito la somma	
			if ($conto[0]){ 
				$Conto = Conto::find($conto[0]['ID']);
				$Conto->Importo = $Conto->Importo + $somma;
				$Conto->save();	

			} else 
			{ // se non ha un conto, ne creo uno e addebito
				$Conto = new Conto;
				$Conto->PG=$venditore;
				$Conto->Importo=$somma;
				$Conto->Interessi=0;
				$Conto->save();	
			}
		}
		
		
		// aggiungi una spesa per l'acquirente
		if ($acquirente){
			$Spese = new Spese;
			$Spese->PG=$acquirente;
			$Spese->Spesa=$somma;
			$Spese->Causale='Acquisto oggetto prezioso "'.$prezioso['Nome'].'"';
			$Spese->save();
			}
			
			
		$prezioso->save();
		Session::flash('message', 'Oggetto "'.$prezioso['Nome'].'" venduto correttamente!');
		return Redirect::to('admin/preziosi');	
		
		
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /preziosi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$prezioso = Preziosi::find($id);
		$prezioso -> delete();

		Session::flash('message', 'Oggetto cancellato correttamente!');
		return Redirect::to('admin/preziosi');
	}

}
