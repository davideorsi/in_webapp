<?php

class INtools {
	
	//trova indici di array multidimensionale con valore massimo in una colonna.
	public static function is_maximum($arr,$column){
			$valori=array_map('intval', INtools::select_column($arr,$column));
			$max = array_keys($valori,max($valori));
			$massimi=array();
			foreach($max as $m){
				$massimi[]=$m;
			}
			return $massimi;
		}

	// determina, in base al costo e ad un tiro casuale, se una missiva viene intercettata
	public static function is_intercettato($costo, $non_firmata=false){
		
	$percentuale=array(5,10,1);
	$intercettato=0;
	$perc=mt_rand(1,100);

	switch ($costo){
		case 0:
			$intercettato=0;
			break;
		case 1:
			if ($non_firmata){$intercettato=0;}
			else {
				$intercettato=$perc<=$percentuale[0];
			}
			break;
		case 2:
			if ($non_firmata){$intercettato=0;}
			else {
				$intercettato=$perc<=$percentuale[0];
			}
			break;
		case 3:
			$intercettato=$perc<=$percentuale[1];
			break;
		case 4:
			$intercettato=$perc<=$percentuale[1];
			break;
		case 10:
			$intercettato=$perc<=$percentuale[2];
			break;
	}

	return $intercettato;
	}


	public static function array_unshift_assoc($arr, $key, $val) { 
		$arr = array_reverse($arr, true); 
		$arr[$key] = $val; 
		return array_reverse($arr, true); 
	}

	
	// ritorna una sola colonna di una array con molte keys
	public static function select_column($list,$key){
		$colonna=array();
		foreach ($list as $item){
			$colonna[]=$item[$key];
		}
		return $colonna;	
	}

	public static function first_words($sentence, $n){
		 return implode(' ', array_slice(preg_split( '/\n| |!|&[^\s]*;/', $sentence), 0, $n));
	}
	

	// converte le monete da n° di monete di rame in una stringa HumanFriendly
	public static function convertiMonete($Monete)	{
		
		$monetestr='';
		if ($Monete<0){
			$Monete = -$Monete;
			$monetestr='Debito di ';
			}
		
		$Rame= floor($Monete%10);
		$Argento =floor(($Monete-$Rame)/10);
		if (floor($Argento%5)>0){
			$Oro=floor($Argento/5);
			$Argento=floor($Argento-$Oro*5);
		}
		elseif ($Argento>=5){
			$Oro=floor($Argento/5);
			$Argento=0;
		}
		else{
			$Oro=0;
		}

		
		if ($Oro>0){
			$monetestr.= strval($Oro).'&nbsp;Oro; ';
		}
		if ($Argento>0){
			$monetestr.= strval($Argento).'&nbsp;Argento; ';
		}
		if ($Rame>0){
			$monetestr.= strval($Rame).'&nbsp;Rame.';
		}


		return $monetestr;
	}

}

?>
