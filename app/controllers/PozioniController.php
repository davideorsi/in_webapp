<?php

class PozioniController extends \BaseController {

	/**
	 * Lista di tutti gli eventi, con la scelta tra editare, aggiungere o
	 * cancellare una incanto
	 */
	public function index()
	{
		$pozioni = Pozione::orderBy('ID', 'asc')->get(array('ID','Nome'));

		$selectPozioni = array();
		foreach($pozioni as $pozione) {
			$selectPozioni[$pozione->ID] = 'Pozione '.$pozione->Nome ;
		}

		$veleni = Veleno::orderBy('Nome', 'asc')->get(array('ID','Nome'));

		$selectVeleni = array();
		foreach($veleni as $veleno) {
			$selectVeleni[$veleno->ID] = $veleno->Nome ;
		}


		// load the view and pass the nerds
		return View::make('pozioni.index')
			->with('selectVeleni', $selectVeleni)
			->with('selectPozioni', $selectPozioni);
	}
	
	public function info()
	{
		if(Input::has('pozione'))
           $idPozione=Input::get('pozione');
		if(Input::has('veleno'))
           $idVeleno=Input::get('veleno');
           
        $pozione=Pozione::find($idPozione);
        $veleno=Veleno::find($idVeleno);
        
        $rosse=$pozione->Rosse+$veleno->Rosse;
        $verdi=$pozione->Verdi+$veleno->Verdi;
        $blu  =$pozione->Blu  +$veleno->Blu;
        $effetto = $pozione->Effetto .'<br>'.$veleno->Effetto;
        $nome = $pozione->Nome .' '.$veleno->Nome;

		// load the view and pass the nerds
		return Response::json(array(
						'rosse' => $rosse, 
						'verdi' => $verdi, 
						'blu' => $blu, 
						'effetto' => $effetto, 
						'nome' => $nome
						));
	}
	
	public function ricetta()
	{
		if(Input::has('rosse'))
           $rosse=Input::get('rosse');
		if(Input::has('verdi'))
           $verdi=Input::get('verdi');;
		if(Input::has('blu'))
           $blu=Input::get('blu');
           
        $pozione=Pozione::where('Rosse','=', $rosse)
				->where('Verdi', '=', $verdi)
				->where('Blu', '=', $blu)->first();
		
		if(empty($pozione)){
			$veleno = DB::select("select Pozioni.ID AS PID, Veleni.ID AS VID FROM Pozioni,Veleni WHERE Pozioni.Rosse+Veleni.Rosse=".$rosse." AND Pozioni.Verdi+Veleni.Verdi=".$verdi." AND Pozioni.Blu+Veleni.Blu=".$blu." AND Pozioni.ID IN (15,16,17)");
				
			if(empty($veleno)){
			} else {
				$output=$veleno[0];
			}
			
		} else {
				$output['PID']=$pozione['ID'];
				$output['VID']=1;
		}
		
		if(empty($pozione)&empty($veleno)){
			$output=null;	
		}
		
			
		// load the view and pass the nerds
		return Response::json($output);
	}
	
	public function stampa($id)
	{	

		
		$pozione=Pozione::find($id);

        $effetto = str_replace('il pg subisce','subisci',$pozione->Effetto);
		
		return View::make('pozioni.print')
			->with('effetto',$effetto);
	}

}
