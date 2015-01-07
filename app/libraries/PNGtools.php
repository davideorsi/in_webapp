<?php

class PNGtools {

/* dato un PNG
 * $PNG= PNG::find($id);
 * $PNG['Abilita']	=$PNG->Abilita;
 * $PNG['Incanti']	=$PNG->Incanti;
 * $PNG['Categorie'] =$PNG->Categorie;
 * 
 * $PNG['Sbloccate']=PNGtools::AbilitaSbloccate($PNG);
 * ritorna un array adatto a popolare un select input nel form
 *
 * */
public static function AbilitaSbloccate($PNG){

		// trova abilità disponibili per l'acquisto
		$possessed = $PNG['Abilita']->lists('ID');
		$categorie = $PNG['Categorie']->lists('Categoria');
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
		foreach ($PNG['Abilita'] as $ab){
			if ($ab['Generica']==1 & !in_array($ab['Categoria'],$categorie)){
					$num_generiche++;
				}
		}
		
		foreach ($PNG['Abilita'] as $ab){
			if (!in_array($ab['Categoria'],$categorie)){
				$fuori_categoria++;
				}
			}

		// conoscenza profonda
		$generiche=Abilita::where('Generica','=','1')->get();
		if ((!$hasConoscProf & $num_generiche<=1)|($hasConoscProf & $num_generiche<=2)) {
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

	/* dato un PNG
	 * $PNG= PNG::find($id);
	 * $PNG['Abilita']	=$PNG->Abilita;
	 * $PNG['Incanti']	=$PNG->Incanti;
	 * $PNG['Categorie'] =$PNG->Categorie;
	 * 
	 * $PNG['incanti_unlocked']=PNGtools::IncantiSbloccati($PNG);
	 * ritorna un array adatto a popolare un select input nel form
	 *
	 * */
	public static function IncantiSbloccati($PNG){
		$all_inc=Incanto::all();

		if (!empty($PNG['Incanti'])) {
			$possessed = $PNG['Incanti']->lists('ID');
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

		
	/* dato un PNG
	 * $PNG= PNG::find($id);
	 * $PNG['Abilita']	=$PNG->Abilita;
	 * $PNG['Incanti']	=$PNG->Incanti;
	 * $PNG['Categorie'] =$PNG->Categorie;
	 * 
	 * $PNG['categorie_unlocked']=PNGtools::CategorieSbloccati($PNG);
	 * ritorna un array adatto a popolare un select input nel form
	 *
	 * */
	public static function CategorieSbloccate($PNG){
		$all_cat=Categoria::all();

		if (!empty($PNG['Categorie'])) {
			$possessed = $PNG['Categorie']->lists('ID');
		} else {
			$possessed = array();
		}  
		
		$selSbloccate=array();
		foreach($all_cat as $cat){
			if (!in_array($cat['ID'],$possessed)) {
				$selSbloccate[$cat->ID]=$cat->Categoria;
			}
		}
		return INtools::array_unshift_assoc($selSbloccate,'0','');
	

		}


}
?>
