<?php

class INtools {

	// determina, in base al costo e ad un tiro casuale, se una missiva viene intercettata
	public static function is_intercettato($costo){
		
	$percentuale=array(0.05,0.1,0.01);
	$intercettato=0;
	$perc=mt_rand(0,100)/100;

	switch ($costo){
		case 0:
			$intercettato=0;
			break;
		case 2:
			$intercettato=$perc<$percentuale[0];
			break;
		case 4:
			$intercettato=$perc<$percentuale[1];
			break;
		case 10:
			$intercettato=$perc<$percentuale[2];
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
		
		$Rame= $Monete%10;
		$Argento =($Monete-$Rame)/10;
		if ($Argento%5==0){
			$Oro=floor($Argento/5);
			$Argento=$Argento-$Oro*5;
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
