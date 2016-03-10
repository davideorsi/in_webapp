<?php

class PGtools {

/* dato un PG
 * $PG= PG::find($id);
 * $PG['Abilita']	=$PG->Abilita;
 * $PG['Incanti']	=$PG->Incanti;
 * $PG['Categorie'] =$PG->Categorie;
 * 
 * $PG['Sbloccate']=PGtools::AbilitaSbloccate($PG);
 * ritorna un array adatto a popolare un select input nel form
 *
 * */
public static function AbilitaSbloccate($PG){

		$sbloccate		=$PG->Sbloccate()->get();

		// trova abilità disponibili per l'acquisto
		$possessed = $PG['Abilita']->lists('ID');
		$categorie = $PG['Categorie']->lists('Categoria');

		$categorie_poss=$categorie;
		array_push($categorie_poss,'Speciali');
		array_push($categorie_poss,'Innate');
		array_push($categorie_poss,'Spiriti');
		
		if (empty($sbloccate)) $sbloccate=array();
		if (empty($possessed)) $possessed=array();
		if (empty($categorie)) $categorie=array();
		$all_ab = Abilita::all();
		#cartellino potere supplementare, aggiungilo se è già stato preso 1 volta, ma meno di 8 volte.
		if (in_array(57,$possessed)) {
			$cc=array_count_values($possessed);
			$cart_pot_supl=$cc[57];
			} else {
				$cart_pot_supl=0;
			}
			
		foreach ($all_ab as $ab){
			 $reqab=$ab->Requisiti;
			 $req=INtools::select_column($reqab,'ID');
			 
			 // se l'abilità è nelle categorie giuste, non è già stata
			 //acquistata, oppure è stata sbloccata, allora aggiungi alla lista
			 if (array_intersect($req,$possessed)==$req &
				 in_array($ab['Categoria'],$categorie) &
				 (!in_array($ab['ID'],$possessed) | in_array('Mistiche',$categorie) &$ab['ID']==57 & $cart_pot_supl<8)) {
				$sbloccate[]=$ab;	
				}
			}

		// controllo se ho le abilità conoscenza profonda //
		// e confini della conoscenza. In base alla loro descrizione,
		// aggiungo o meno abilità alla lista			
		$hasConoscProf=in_array(36,$possessed);
		$hasConoscConf=in_array(37,$possessed);
		
		$num_generiche=0;
		$fuori_categoria=0;
		foreach ($PG['Abilita'] as $ab){
			if ($ab['Generica']==1 & !in_array($ab['Categoria'],$categorie_poss)){
					$num_generiche++;
				}
		}
		
		foreach ($PG['Abilita'] as $ab){
			if (!in_array($ab['Categoria'],$categorie_poss)){
				$fuori_categoria++;
				}
			}

		// conoscenza profonda
		$generiche=Abilita::where('Generica','=','1')->get();
		if ((!$hasConoscProf & $num_generiche<1)|($hasConoscProf & $num_generiche<2)) {
			foreach ($generiche as $ab){
				if (!in_array($ab['ID'],$possessed)){
					$sbloccate[]=$ab;
					}
			}
		}

		//confini della conoscenza
		if (($hasConoscConf & $fuori_categoria<=1)|($hasConoscConf & $hasConoscProf & $fuori_categoria<=2)) {
			foreach ($all_ab as $ab){
				if (!in_array($ab['ID'],$possessed) & !in_array($ab['Categoria'],array('Speciali','Innate','Spiriti'))){
					$sbloccate[]=$ab;
					}
			}
		}
			
		//converto in un array adatto a un SELECT input
		$selSbloccate=array();
		foreach($sbloccate as $sbloccata){
			$selSbloccate[$sbloccata->ID]=$sbloccata->Ability.' ('.$sbloccata->PX.'px)';
			}
		return INtools::array_unshift_assoc($selSbloccate,'0','');
	}

	/* dato un PG
	 * $PG= PG::find($id);
	 * $PG['Abilita']	=$PG->Abilita;
	 * $PG['Incanti']	=$PG->Incanti;
	 * $PG['Categorie'] =$PG->Categorie;
	 * 
	 * $PG['incanti_unlocked']=PGtools::IncantiSbloccati($PG);
	 * ritorna un array adatto a popolare un select input nel form
	 *
	 * */
	public static function IncantiSbloccati($PG){
		$all_inc=Incanto::orderby('Livello','asc')->get();

		if (!empty($PG['Incanti'])) {
			$possessed = $PG['Incanti']->lists('ID');
		} else {
			$possessed = array();
		}  
		
		$selSbloccate=array();
		foreach($all_inc as $inc){
			if (!in_array($inc['ID'],$possessed)) {
				$selSbloccate[$inc->ID]=$inc->Nome.' ('.$inc->Livello.')';
			}
		}
		return INtools::array_unshift_assoc($selSbloccate,'0','');
		}

		
	/* dato un PG
	 * $PG= PG::find($id);
	 * $PG['Abilita']	=$PG->Abilita;
	 * $PG['Incanti']	=$PG->Incanti;
	 * $PG['Categorie'] =$PG->Categorie;
	 * 
	 * $PG['categorie_unlocked']=PGtools::CategorieSbloccati($PG);
	 * ritorna un array adatto a popolare un select input nel form
	 *
	 * */
	public static function CategorieSbloccate($PG){
		$all_cat=Categoria::all();

		if (count($PG['Categorie'])<3) {
				
			if (!empty($PG['Categorie'])) {
				$possessed = $PG['Categorie']->lists('ID');
			} else {
				$possessed = array();
			}  
			
			$selSbloccate=array();
			foreach($all_cat as $cat){
				if (!in_array($cat['ID'],$possessed) &
					!in_array($cat['Categoria'],array('Speciali','Innate','Spiriti')) ) {
					$selSbloccate[$cat->ID]=$cat->Categoria;
				}
			}
			return INtools::array_unshift_assoc($selSbloccate,'0','');
		} else {
			return array();
			}

		}


	public static function Speciali($PG){
		$all_sbl=Abilita::orderBy('Categoria','asc')->whereRaw("Categoria IN ('Speciali','Spiriti','Innate')")->get();
		
		$selSbloccate=array();
		foreach($all_sbl as $sbl){
			$selSbloccate[$sbl->ID]=$sbl->Ability.' ('.$sbl->Categoria.')';
		}
		return INtools::array_unshift_assoc($selSbloccate,'0','');
	}

}
?>
