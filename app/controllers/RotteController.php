<?php

class RotteController extends \BaseController {

	/**
	 * Lista di tutti gli eventi, con la scelta tra editare, aggiungere o
	 * cancellare una abilita
	 */
	public function index()
	{
		$selectMercanti = array();
		$abilita = Abilita::find(39);
		if (Auth::user()->usergroup == 7){
			$PGs=$abilita->PG()->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get();
			$selectMercanti[0]= 'Mercato Nero';
			$idpg = 0;
			
		
		} else {
			$idpg = Session::get('idpg');
			$PGs=$abilita->PG()->whereRaw('`Morto` = 0 AND `InLimbo` = 0 AND ID = '+$idpg)->get();
		}
		
		
		foreach($PGs as $PG) {
			$selectMercanti[$PG->ID] = $PG->Nome;
		}
		/*
		$dataRotte = RottaCommerciale::orderBy('ID','Desc')->first();
		
		$data = $dataRotte->DATA;
		
		$rotte = RottaCommerciale::where('DATA','=' ,$data)->where('IDPG', '=', $idpg)->get();
		*/
		
		$rotteGruppo = RottaCommercialeGruppo::orderBy('ID','Desc')->first();
		$idGruppo = $rotteGruppo->ID;
		$rotte = RottaCommerciale::where('Evento','=' ,$idGruppo)->where('IDPG', '=', $idpg)->get();
		
		$sel=array();
		
		foreach ($rotte as $r){
			
			$Opzione= Materiale::find($r['IDMateriale'])->Nome;
			
			$sel[$r['ID']]=array(
					'ID' => $r['ID'],
					'Opzione'=> $Opzione,
					'Costo'=>$r['Costo'],
					'Disponibili' => $r['Disponibili'],
					'Acquistati' => $r['Acquistati'],
					'evento' => $r['Evento'],
					);
			
		}
		$attivaGenera = true;
		$attiva = true;
		
		$evento = Evento::orderBy('ID','Desc')->first();	
		$dataEvento = $evento->Data;
		
		if (strtotime($dataEvento) <= strtotime('today')){ $attiva = false ;}
		else {$attiva = true;}
		
		// load the view and pass the nerds
		return View::make('rotte.index')
			->with('selectMercanti', $selectMercanti)
			->with('sel', $sel)
			//->with('attivaGenera', $attivaGenera)
			->with('attiva', $attiva);
	}


public function show($id)
	{
		$tabella = '';
		if (Auth::user()->usergroup == 7){
		$gruppoRotte = RottaCommercialeGruppo::orderBy('ID','Desc')->first();
		
		$idGruppo = $gruppoRotte->ID;
		
		$rotte = RottaCommerciale::where('Evento','=' ,$idGruppo)->where('IDPG', '=', $id)->get();
		
		$tabella = '<table><tr><th colspan=4>Rotte Commerciali</th></tr><tr><td>Numero</td><td>Oggetto</td><td>Costo</td><td>Disponibili</td></tr>';
		
		foreach ($rotte as $r){
			
			$Opzione= Materiale::find($r['IDMateriale'])->Nome;
			$Costo = INtools::convertiMonete($r['Costo']);
			
			$tabella = $tabella.'<tr><td>'.$r['Acquistati'].'</td><td>'.$Opzione.'</td><td>'.$Costo.'</td><td>'.$r['Disponibili'].'</td></tr>';
			
			}
		
		$tabella = $tabella.'</table>';
		}
		//$tabella = 'tabella'.$id;
		
		if (Request::ajax()){
			//return Response::json($tabella);
			return Response::json(['tabella' => $tabella,]);

		} else {
			return Response::make('Not available', 401);
		}
			
	}
	
public function modifica($id)
	{
		return View::make('rotte.edit');
	}

public function update()
	{
		$idpg = Session::get('idpg');
		
		$opzioni_singole =Input::get('Opzioni');
		$numero_oggetti =Input::get('numero');
		$tipo_oggetti =Input::get('oggetto');
		$costo_oggetti =Input::get('costo');
		$ID_oggetti= Input::get('ID');
		$ID_evento=Input::get('evento');
		$disponibili = Input::get('disponibile');
		$acq_old=Input::get('number_old');
		
		$dataRotte = RottaCommerciale::orderBy('ID','Desc')->first();
		$data = $dataRotte->DATA;
		
		$totale=0;
		$modifiche=false;
		
		if ($numero_oggetti) {	
			
			foreach ($numero_oggetti as $key=>$num){
				 
				if ($num > $disponibili[$key]) $num = $disponibili[$key];
				
				$totale = $totale + ($num*$costo_oggetti[$key]);
				
				if ($num!=$acq_old[$key]){
						$modifiche = true;
						
						$ID = $ID_oggetti[$key];
						
						$rotta = RottaCommerciale::find($ID);
						$rotta->Acquistati = $num;
						$rotta->save();
						
				}
			}
			
			if ($modifiche) {
				$causale = 'Rotte Commerciali '.$data;
				$Spese = Spese::where('Causale',$causale)->where('PG',$idpg)->first();
				
				if (empty($Spese['ID'])) {
					
					$Spese = new Spese;
					$Spese->PG=$idpg;
					$Spese->Spesa=$totale;
					$Spese->Causale=$causale;
					$Spese->save();
					
				} else {
					
					$Spese->Spesa=$totale;
					$Spese->save();
					
				}	
				
			}
			
			Session::flash('message', 'Acquisti aggiornate correttamente!');
			
		}
		
		return Redirect::to('rotte');
	}

	
public function genera()
	{
				
			
			$fazRochelle=Fazione::find(1);
			$condizioneRochelle = $fazRochelle->Condizione;
			$fazNottingham = Fazione::find(2);
			$condizioneNottingham = $fazNottingham->Condizione;
			
			$dataRotte = date('d-m-Y', time());
			
			$month = date('m', time());
			
			if ($month == 12 || $month == 1 || $month == 2){
				$stagione = 1;
			} elseif ($month == 3 || $month == 4 || $month == 5){
				$stagione = 2;
			} elseif ($month == 6 || $month == 7 || $month == 8){
				$stagione = 3;
			} elseif($month == 9 || $month == 10 || $month == 11){
				$stagione = 4;
			}
			
			//Session::flash('message', $stagione);
			
			$evento = Evento::Orderby('ID','Desc')->first();
			$dataEvento = $evento->Data;
			
			$rotteGruppo = new RottaCommercialeGruppo;
			$rotteGruppo->id_evento = (int)$evento->ID;
			$rotteGruppo->data = $evento->Data;
			$rotteGruppo->save();
			
			//mercato nero
			//Session::flash('message',$evento->ID);
			//DB::insert('insert into RotteCommerciali (IDPG, IDMateriale,DATA,Disponibili,Aquistati,Costo,Evento) values (?, ?,?,?,?,?,?)', array(0,8,$dataEvento,1,0,10,$evento->ID));
				
			//rotte commerciali Locali
			$rotteLocali = Abilita::find(39);
			$mercantiLoc = $rotteLocali->PG()->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get();	
			
			$totBase = 6;	
			
			$OM = false;
			foreach ($mercantiLoc as $mercante){
				
				//determino i modificatore per le condizioni del mercato
				$affiliazione = $mercante->Affiliazione;			
				if ($affiliazione =='Nottingham') {
					$condizione = $condizioneNottingham;
				} else if ($affiliazione == 'La Rochelle') {
					$condizione = $condizioneRochelle;
				} else {
					if($condizioneNottingham>$condizioneRochelle) {
						$condizione = $condizioneNottingham;
					} else {
						$condizione = $condizioneRochelle;
					}
				}
				
				//determinare il tot di estrazioni per PG
				$estrazioni = 5;
				$poolEstrazioni = array('B','B','X','X','R');
				//array_push($poolEstrazioni,$materiale->ID);
				
				$abilitaPG = $mercante->Abilita()->get();
				foreach ($abilitaPG as $abi){
					if ($abi['ID']==40) {
						$estrazioni = $estrazioni +3;
						array_push($poolEstrazioni,'B');
						array_push($poolEstrazioni,'X');
						array_push($poolEstrazioni,'R');
						$OM = true;
					}
					//aggiungere altri IF per le abilità che aumentano gli SLOT
				}
				
				$estratti = array();
				//$found = false;
				foreach ($poolEstrazioni as $est){
					$found = false;
					While(!$found){
						$materiali = null;
						//verifica abilità di priorita sugli slot	
						if ($OM) {
							$qryRarita = 'RaritaOM';
						} else { 
							$qryRarita = 'RaritaLoc';
						}
						if ($est == 'B') {	
							// inserire controllo per cui ciascun materiale base
							//ci deve essere almeno una volta
							//tra tutti i mercanti
							
							$basiEstratte = array();
							$rotte = $rotteGruppo->RotteCommerciali();
			
							foreach($rotte as $rotta){
								if ($rotta->Materiale()->Categoria == '2') array_push($basiEstratte,$rotta->IDmateriale);
							}
							
							$materialeOK = false;
							$verde = false;
							$rossa = false;
							$blu = false;
							$legno = false;
							$metallo = false;
							$sabbia = false;
							
							While (!$materialeOK){
							
								$materiali = Materiale::where('Categoria',2)
								->whereNotIn('ID',$estratti)
								->orderBy(DB::raw('RANDOM()'))->get();
								$materialeOK = true;
								//non se ho già trovato tutte le basi
								
								foreach ($basiEstratte as $id){	
									if ($materiali->IDmateriale == $id) $materialeOK = false;
									if ($materiali->IDmateriale == 51) $verde = true;
									if ($materiali->IDmateriale == 52) $rossa = true;
									if ($materiali->IDmateriale == 53) $blu = true;
									if ($materiali->IDmateriale == 59) $legno = true;
									if ($materiali->IDmateriale == 58) $metallo = true;
									if ($materiali->IDmateriale == 60) $sabbia = true;
								}
								if ($verde&&$rossa&&$blu&&$legno&&$meallo&&$sabbia) $materialeOK = true;
								
							}
							
						} else if ($est == 'R') {
							$categoria = CategorieMateriali::where('ID','<>',2)
								->orderBy(DB::raw('RANDOM()'))->first();	
						
							$materiali = Materiale::where('Categoria',$categoria->ID)
							//$materiali = Materiale::where('Categoria','<>',2)
								->where($qryRarita, '>', 2)
								->whereNotIn('ID',$estratti)
								->orderBy(DB::raw('RANDOM()'))->get();
						} else {
							$categoria = CategorieMateriali::where('ID','<>',2)
								->orderBy(DB::raw('RANDOM()'))->first();	
							
							$materiali = Materiale::where('Categoria',$categoria->ID)
							//$materiali = Materiale::where('Categoria','<>',2)
								->whereNotIn('ID',$estratti)
								->orderBy(DB::raw('RANDOM()'))->get();
						} 				
						
					//il controllo del loop passa da un break se trova 
					
					foreach ($materiali as $materiale){
						//Session::flash('message',$j);
						//$materiale = $materiali[$j];
						
						$nome = $materiale->Nome;
						
						if ($OM) {
							$rarita = $materiale->RaritaOM;
							}
						else {
							$rarita = $materiale->RaritaLoc;
							}
					
						$stagioneMat = $materiale->Stagione;
						if ($stagioneMat = $stagione) {$rarita = $rarita -1;}
						
						if ($rarita < 1) {
							//un oggetto molto comune di stagione diventa sempre disponbile
							$prob = '99';
						}
						else {			
							$raritaOBJ = RaritaMateriale::where('ID',$rarita)->first();
							$prob = $raritaOBJ->probabilita;
						}
						
						$modPrezzo = 0;
						$modProb = 0;
						$modQta = 0;
						if ($condizione == 3){
							if ($rarita < 3) { //l'offerta supera la domanda: i prezzi calano, e c'è più disponibilitità, ma i mercanti cercheranno di capitalizzare sui beni di lusso che vanno
								$modPrezzo = -1;
								$modProb = -1;
								$modQta = +1;
							} else if ($rarita > 3){ //la domanda supera l'offerta: i prezzi salgono ed è più facile trovarli sul mercato, ma data la particolarità dei prodotti, le quantita restano limitate
								$modPrezzo = +1;
								$modProb = +1;
								$modQta = 0;
							}
						} else if ($condizione == 1){ 
							if ($rarita < 3) { //la domanda cala e l'offerta resta invariata: salgono soltanto i prezzi.
								$modPrezzo = +1;
								$modProb = 0;
								$modQta = 0;
							} else if ($rarita > 3){//la domanda cala e l'offerta resta invarita: le rarità sul mercato sono solo quelle, ma vendono meno i mercanti hanno più magazzino
								$modPrezzo = 0;
								$modProb = 0;
								$modQta = +1;
							}
						} else if ($condizione == 0){
							if ($rarita < 3) {//la domanda supera l'offerta: il prezo aumenta e le disponibilità sono limitate. sono più presenti sul mercato perchè i mercanti cercano di recuperare denaro puntando sui beni di prima necessità
								$modPrezzo = +1;
								$modProb = +1;
								$modQta = -1;
							} else if ($rarita > 3){//l'offerta supera la domanda: i prezzi scendono, ma non si trovano in giro, e quando si trovano le quantità sono limitate.
								$modPrezzo = -1;
								$modProb = -1;
								$modQta = -1;
							}
						}
						
						$prob = $prob + ($modProb*5);
						
						//determinare quantita
						$qta = $materiale->Quantita;
						$qta = (int)floor($qta + (($qta/2)*$modQta));
						if ($qta < 1) {$prob = 0;}
					
						//determinare costo
						$valore = (int)ceil($materiale->ValoreBase * (1.1+($modPrezzo*0.1)));
						$tiro = rand(1,100);					
						
						if ($tiro <= $prob){
							printf($tiro);
							$rottac = new RottaCommerciale;
							$rottac->IDPG = (int)$mercante->ID;
							$rottac->IDMateriale = (int)$materiale->ID;
							$rottac->DATA = $dataRotte;
							$rottac->disponibili = $qta;
							$rottac->acquistati = 0;
							$rottac->costo = $valore;
							$rottac->Evento = (int)$rotteGruppo->ID;
							$rottac->save();
							
							array_push($estratti,$materiale->ID);
							$found=true;
							break;
						}
						
					}
					
				   }
				}
				
			}
			
			
		return Redirect::to('admin/rotte');
		
		
	}

}
