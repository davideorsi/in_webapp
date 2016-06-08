<?php

class BancaController extends \BaseController {
	
	public function index()
	{
        
        $pgs=PG::orderBy('Nome','asc')->get(['ID','Nome','NomeGiocatore']);
        
        $Vivi=PG::orderBy('Nome','asc')->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get(['ID','Nome','NomeGiocatore']);
	
		$selVivi=array(0=>'');
		foreach ($Vivi as $vivo){
			$selVivi[(string)$vivo->ID] = $vivo['Nome'].' ('.$vivo['NomeGiocatore'].')';
		}
        
        $conti=[];
        
        foreach ($pgs as $pg){
			$conto=$pg->Conto;
            if ($conto){
				
				
				foreach ($conto as $ct){
					if ($ct['Importo']<0) {
						$colore='bg-danger';
					} else {
						$colore='';
					}
					$conti[]=array('Nome'=>$pg['Nome'],
                               'NomeGiocatore'=>$pg['NomeGiocatore'],
                               'ID'=>$ct['ID'],
                               'Importo'=>INtools::convertiMonete($ct['Importo']),
                               'Interessi'=>INtools::convertiMonete($ct['Interessi']),
                               'Colore'=>$colore,
                               'Intestatario'=>$ct['Intestatario']);
                }
			}
		
		}
		return View::make('banca.index')
				->with('conti',$conti)
				->with('selVivi',$selVivi);
        
    }
	

	public function debiti_e_spese()
	{
        $pgs=PG::orderBy('Nome','asc')->get(['ID','Nome','NomeGiocatore']);
        $Vivi=PG::orderBy('Nome','asc')->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get(['ID','Nome','NomeGiocatore']);
	
		$selVivi=array(0=>'');
		foreach ($Vivi as $vivo){
			$selVivi[(string)$vivo->ID] = $vivo['Nome'].' ('.$vivo['NomeGiocatore'].')';
		}

		$spese=[];
        $debiti_missive=[];
        foreach ($pgs as $pg){
		    $missive = Missiva::orderBy('id','asc')->whereRaw("`mittente` = ? AND ((`pagato` IS NULL) OR (`pagato` = 0))",[$pg['ID']])->get(['costo']);
			$costi=INtools::select_column($missive,'costo');
			
			$totale = INtools::convertiMonete(array_sum($costi));
			
            if ($totale) {
                $debiti_missive[]=array('Nome'=>$pg['Nome'],
                               'NomeGiocatore'=>$pg['NomeGiocatore'],
                               'ID'=>$pg['ID'],
                               'debito'=>$totale);
                               
            }
            
            $spesa=$pg->Spese;
            if ($spesa){
				
				
				foreach ($spesa as $sp){
					$spese[]=array('Nome'=>$pg['Nome'],
                               'NomeGiocatore'=>$pg['NomeGiocatore'],
                               'ID'=>$sp['ID'],
                               'Spesa'=>INtools::convertiMonete($sp['Spesa']),
                               'Causale'=>$sp['Causale']);
                }
			}
            
	    }
	    
	    
		return View::make('banca.debiti')
				->with('spese',$spese)
				->with('lista',$debiti_missive)
				->with('selVivi',$selVivi);
	}
	
	public function store_spesa()
	{
		$Spese = new Spese;
		$Spese->PG=Input::get('PG');
		$Spese->Spesa=Input::get('Importo');
		$Spese->Causale=Input::get('Causale');
		$Spese->save();
		// redirect
		Session::flash('message', 'Spesa aggiunta con successo!');
		return Redirect::to('admin/debito');
	}
	
	public function store_conto()
	{
		$Conto = new Conto;
		$Conto->PG=Input::get('PG');
		$Conto->Importo=Input::get('Importo');
		$Conto->Interessi=0;
		$Conto->Intestatario=Input::get('Intestatario');
		$Conto->save();
		// redirect
		Session::flash('message', 'Spesa aggiunta con successo!');
		return Redirect::to('admin/conto');
	}
	
	public function update_conto($id)
	{
		$Conto = Conto::find($id);
		$Conto->Importo=Input::get('Importo');
		$Conto->Interessi=Input::get('Interessi');
		$Conto->Intestatario=Input::get('Intestatario');
		$Conto->save();
		// redirect
		Session::flash('message', 'Spesa modificata con successo!');
		return Redirect::to('admin/conto');
	}

	public function update_interessi()
	{
		
		// se è un credito, aggiungo gli interessi
		$Conti = Conto::where('Importo','>',0)->get();
		foreach($Conti as $Conto){
			$imp=$Conto->Importo;
			$Conto->Importo=floor($imp*1.05);
			$Conto->save();
		}
		
		// se è un debito, conteggio a parte gli interessi
		$Conti = Conto::where('Importo','<',0)->get();
		foreach($Conti as $Conto){
			$imp=$Conto->Importo;
			$int=$Conto->Interessi;
			$Conto->Interessi=$int+ceil($imp*0.1); 
			$Conto->save();
		}
		
        return Response::json(['OK']);    
	}

	

    public function azzera_spesa($id,$alla_banca = 0)
    {
		$spese= Spese::find($id);
		
		// se addebitato alla banca
		if ($alla_banca==1) {
			$PG=PG::find($spese->PG);
			$conto=$PG->Conto;
			
			//se il conto non esiste lo crea
			if ($conto->isEmpty()) {
				$NewConto = new Conto;
				$NewConto->PG=$spese->PG;
				$NewConto->Importo=-$spese->Spesa;
				$NewConto->save();
				
			//se il conto esiste addebita e basta
			} else {
				$OldConto=Conto::find($conto[0]['ID']);
				$OldConto->Importo=$OldConto->Importo-$spese->Spesa;
				$OldConto->save();
			}
		} 
		
		$spese->delete();        
		               
        return Response::json(['OK']);    
    }  
    
    public function azzera_conto($id)
    {

        $conto= Conto::find($id);
        $conto->delete();        
                       
        return Response::json(['OK']);    
    }  


    public function show($id)
    {

        $conto= Conto::find($id);        
        $conto->Personaggio;               
        return Response::json($conto);    
    }  

    
    public function azzera_debito($id,$alla_banca = 0)
    {

        $lista = Missiva::orderBy('id','asc')->whereRaw("`mittente` = ? AND ((`pagato` IS NULL) OR (`pagato` = 0))",[$id])->get(['id','costo']);
        $costi=INtools::select_column($lista,'costo');
		$totale = array_sum($costi);
    
		// se addebitato alla banca
		if ($alla_banca==1) {
			$PG=PG::find($id);
			$conto=$PG->Conto;

			//se il conto non esiste lo crea
			if ($conto->isEmpty()) {
				$NewConto = new Conto;
				$NewConto->PG=$id;
				$NewConto->Importo=-$totale;
				$NewConto->save();
				
			//se il conto esiste addebita e basta
			} else {
				$OldConto=Conto::find($conto[0]['ID']);
				$OldConto->Importo=$OldConto->Importo-$totale;
				$OldConto->save();
			}
		} 

        foreach ($lista as $elem)
        {
            $missiva= Missiva::find($elem['id']);
            $missiva['pagato']=1;
            $missiva->save();        
        }   
        return Response::json(['OK']);    
    }    


}
