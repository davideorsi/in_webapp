<?php

class SostanzeController extends \BaseController {

  public function search(){

    $cromodinamica = Input::get('CD');
    $effetto = Input::get('effetti');
    $nome = Input::get('nome');
    $diluizione = Input::get('diluizione');
    $materiale = Input::get('materiali');
    $cancellata = Input::get('cancellate');
    $R = Input::get('Rosse');
    $V = Input::get('Verdi');
    $B = Input::get('Blu');

    $condizione='';
		$params=array();

    if (!empty($cancellata)&&$cancellata=1) {
        $sosQuery = Sostanze::where('cancellata',1);
        //$params[]=1;
    }else{
        $sosQuery = Sostanze::where('cancellata',0);
        //$params[]=0;
    }
    //$condizione.="(`cancellata` = ?)";


    if (!empty($cromodinamica)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$cromodinamica;
        //$condizione.="(`id_cromodinamica` = ?)";

        $sosQuery->where('id_cromodinamica',$cromodinamica);
    }

    if (!empty($effetto)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$effetto;
        //$condizione.='(`effetti` like "%?%")';

        $sosQuery->where('effetti','like','%'.$effetto.'%');
    }

    if (!empty($nome)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$nome;
        //$condizione.='(`nome` like "%?%")';

        $sosQuery->where('nome','like','%'.$nome.'%');
    }

    if (!empty($diluizione)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$diluizione;
        //$condizione.="(`diluizione` = ?)";

          $sosQuery->where('diluizione',$diluizione);
    }
    //if (!empty($R)) {
    if (!($R==''||$R==null)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$R;
        //$condizione.="(`R` = ?)";
        $sosQuery->where('R',$R);
    }

    //if (!empty($V)) {
    if (!($V==''||$V==null)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$V;
        //$condizione.="(`V` = ?)";

        $sosQuery->where('V',$V);
    }

    //if (!empty($B)) {
    if (!($B==''||$B==null)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$B;
        //$condizione.="(`B` = ?)";

        $sosQuery->where('B',$B);
    }

    if (!empty($materiale)) {
       //$mat = Materiali::where('nome','like',$materiale)->Get();

       $sosQuery->whereHas('materiali', function($q) use ($materiale)
        {
            $q->where('nome', 'like', '%'.$materiale.'%');

        });
    }

      if (!empty($condizione)) {
            //$sostanze = Sostanze::whereRaw($condizione,$params)->orderBy('id_sostanza','desc')->paginate(10);
      }else{
            //$sostanze = Sostanze::orderBy('id_sostanza','desc')->paginate(10);
      }

      $sostanze = $sosQuery->orderBy('id_sostanza','desc')->paginate(10);

    //$sostanze = Sostanze::paginate(5);

    return Response::json($sostanze);
  }

  public function index()
  {
    $selCD=array(0=>'');
    $CD=SostanzeCromodinamica::get();
	   foreach($CD as $c){
       $padre = $c->Padre->DESC;
       $selCD[$padre][$c->ID] = $c->DESC.' ('.$c->livello.')';
     }

    $sostanze = Sostanze::where('cancellata',0)->orderBy('id_sostanza','desc')->paginate(10);

    return View::make('sostanze.index')->with('sostanze', $sostanze)->with('selCD', $selCD);
  }

 public function destroy($id){
   $sostanza = Sostanze::find($id);

   //$sostanza -> delete();
   $sostanza->cancellata = 1;
   $sostanza->save();

   Session::flash('message', 'Sostanza cancellata correttamente!');
   return Redirect::to('admin/sostanze');

   /*
   $selCD=array(0=>'');
   $CD=SostanzeCromodinamica::get();
    foreach($CD as $c){
      $selCD[$c->ID]=$c->DESC;
    }

   $sostanze = Sostanze::where('cancellata',0)->orderBy('id_sostanza','desc')->paginate(10);

   return View::make('sostanze.index')->with('sostanze', $sostanze)->with('selCD', $selCD);
   */
 }

 public function show($id)
 {
   $sostanza=Sostanze::find($id);

   //if ($pubblica){
       if (Request::ajax()){
         return Response::json($sostanza);
       }
   //}
 }

 public function edit($id){
    $sostanza=Sostanze::find($id);
    $cromodinamiche=SostanzeCromodinamica::where('ID','>',3)->get();
    $materiali=Materiale::where('categoria','!=',5)->get();
    $materialiSostanza=$sostanza->Materiali()->get();

    $selectMateriali = array();
    $selectMateriali['---'][0] = 'Seleziona un Materiale..';
		foreach($materiali as $mat) {
      $cat = $mat->Categoria()->first()->Descrizione;
			$selectMateriali[$cat][$mat->ID] = $mat->Nome;
    }

    $selectCD = array();
  		foreach($cromodinamiche as $cd) {
        $padre = $cd->Padre->DESC;
  			$selectCD[$padre][$cd->ID] = $cd->DESC.' ('.$cd->livello.')';
    }
    return View::make('sostanze.edit')
      ->with('sostanza', $sostanza)
      ->with('selCd', $selectCD)
      ->with('materiali', $selectMateriali)
      ->with('matSos', $materialiSostanza)
      ->with('edit', true);
 }

 public function update(){
      $id = Input::get('ID');
      $sostanzaEdit=Sostanze::find($id);
      $nome = Input::get('Nome');
      $mR = Input::get('rosse');
      $mV = Input::get('verdi');
      $mB = Input::get('blu');
      $dil = Input::get('diluizione');
      $cd = Input::get('cromodinamica');
      $effetti = Input::get('effetti');
      $mat_qta = Input::get('mat_qta');
      $mat_qta_old = Input::get('mat_qta_old');
      $mat_id = Input::get('mat_id');

      if(empty($nome)||empty($dil)||empty($cd)||empty($effetti)||(empty($mat_qta)&&empty($mR)&&empty($mV)&&empty($mB))){
        Session::flash('message', 'campi minimi non compilati');

        return Redirect::to('/admin/sostanze/create');
      }else{

        $condizione='';
        $params=array();

        $params[]=0;
        $condizione.="(`cancellata` = ?)";

        $ok = true;

        $mess='';

       if ($mat_qta){
         //SE CI SONO MATERIALI fa un iter
         // Non devono esserci sostanze che hanno la stessa cromodinamica e combinazione di materiali (a prescindere da diluizione o quantità dei materiali)
         // aggiungo un filtro per trovare le sostanze con la cromodinamica selezionata
         if (!empty($cd)) {
             if ($condizione) {$condizione.=" AND ";}
             $params[]=$cd;
             $condizione.="(`id_cromodinamica` = ?)";
         }

         $sostanze = Sostanze::whereRaw($condizione,$params)->get();

         if(sizeof($sostanze)>0){
           //faccio scorrere tutte le sostanze trovate
           foreach( $sostanze as $sos){
             //se hanno materiali, faccio scorrere l'elenco materiali della sostanza trovata e lo confronto con l'elenco dei materiali
             //della nuova sostanza inserita: se trova anche solo una discrepanza da l'ok per qualla sostanza
             //se tutte le sostanze trovate danno esito ok al controllo allora non ci sono doppioni e si può procedere all'insrimento
             if ($sos['id_sostanza']!=$id){
               $materialiSostanza=$sos->Materiali()->get();
               $mess = $mess.'|'.$sos['nome'].';num.Materiali:'.sizeof($materialiSostanza).';';
               $okSos = false;
               if(sizeof($materialiSostanza)>0){
                  foreach($materialiSostanza as $matSos){
                    /*
                    $mess = $mess.$matSos['Nome'].'-';
                    $mess = $mess.$matSos['ID'].'-';
                    $mess = $mess.$matSos['pivot']->quantita.',';
                    */
                    $okMat = false;
                    foreach ($mat_qta as $key=>$num){
                      if ($mat_id[$key]!=$matSos['ID']){
                      //||$num!=$matSos['pivot']->quantita
                        //se c'è lo stesso materiale rimane false
                        $okMat=true;
                      }
                    }
                    //$mess = $mess.$okMat;
                    $okSos=$okSos||$okMat;
                  }
                  //$ok=$ok&&$okSos;
               }else{
                 // SE la sostanza non ha materiali il check è ok.
                 $okSos = true;
                 //$ok=$ok&&true;
               }
               //$mess = $mess.';SostanzaOK?'.$okSos;
               $ok=$ok&&$okSos;
             }
           }
         }

       }else{
         //SE NON CI SONO MATERIALI fa un iter diverso
         //aggiungo al filtro la matrice e controllo solo quella

         if (!empty($mR)) {
             if ($condizione) {$condizione.=" AND ";}
             $params[]=$mR;
             $condizione.="(`R` = ?)";
         }

         if (!empty($mV)) {
             if ($condizione) {$condizione.=" AND ";}
             $params[]=$mV;
             $condizione.="(`V` = ?)";
         }

         if (!empty($mB)) {
             if ($condizione) {$condizione.=" AND ";}
             $params[]=$mB;
             $condizione.="(`B` = ?)";
         }

         if (!empty($cd)) {
             if ($condizione) {$condizione.=" AND ";}
             $params[]=$cd;
             $condizione.="(`id_cromodinamica` = ?)";
         }

         $sostanze = Sostanze::whereRaw($condizione,$params)->get();
         if(sizeof($sostanze)>0){
           // Se esiste una sostanza con la stessa matrice allora il check fallisce.
           $ok = false;
         }
       }

       if($ok==true){
         if ($mat_qta){
           // aggiorno cambi di quantita
           foreach ($mat_qta as $key=>$num){
             if ($num!=$mat_qta_old[$key]){
                 $sosMat = SostanzeMateriali::where('ID',$mat_id[$key])->where('id_sostanza',$id)->first();
                 $sosMat->quantita = $num;
                 $sosMat->save();
             }
           }
         }

         $sostanzaEdit->nome = $nome;
         $sostanzaEdit->R = $mR;
         $sostanzaEdit->V = $mV;
         $sostanzaEdit->B = $mB;
         $sostanzaEdit->diluizione = $dil;
         $sostanzaEdit->effetti = $effetti;
         $sostanzaEdit->id_cromodinamica = $cd;
         $sostanzaEdit->save();



        Session::flash('message', $nome.' aggiornata con successo');
        return Redirect::to('/admin/sostanze/');
       }else{
        Session::flash('message', 'la sostanza esiste già!');
        return Redirect::to('/admin/sostanze/create');
       }
    }
 }

 public function create(){
   $sostanza = new Sostanze();
   //$cromodinamiche=SostanzeCromodinamica::where('ID','>',3)->get();
   $cromodinamiche=SostanzeCromodinamica::get();
   $materiali=Materiale::where('Categoria','!=',5)->get();
   $materialiSostanza = array();
   $selectMateriali = array();
   $selectMateriali['---'][0] = 'Seleziona un Materiale..';
   foreach($materiali as $mat) {
     $cat = $mat->Categoria()->first()->Descrizione;
    $selectMateriali[$cat][$mat->ID] = $mat->Nome;
   }

   $selectCD = array();
    foreach($cromodinamiche as $cd) {
      $padre = $cd->Padre->DESC;
      $selectCD[$padre][$cd->ID] = $cd->DESC.' ('.$cd->livello.')';
   }

   return View::make('sostanze.edit')
     ->with('sostanza', $sostanza)
     ->with('selCd', $selectCD)
     ->with('materiali', $selectMateriali)
     ->with('matSos', $materialiSostanza)
     ->with('edit', false);

 }

 public function store(){
   $sostanza = new Sostanze();
   $nome = Input::get('Nome');
   $mR = Input::get('rosse');
   $mV = Input::get('verdi');
   $mB = Input::get('blu');
   $dil = Input::get('diluizione');
   $cd = Input::get('cromodinamica');
   $effetti = Input::get('effetti');
   $mat_qta = Input::get('mat_qta');
   $mat_id = Input::get('mat_id');

   if(empty($nome)||empty($dil)||empty($cd)||empty($effetti)||(empty($mat_qta)&&empty($mR)&&empty($mV)&&empty($mB))){
     Session::flash('message', 'campi minimi non compilati');

     return Redirect::to('/admin/sostanze/create');
   }else{

     $condizione='';
     $params=array();

     $params[]=0;
     $condizione.="(`cancellata` = ?)";

     $ok = true;
// debug

     $mess='';
/*
     foreach ($params as $p){
       $mess = $mess.$p.',';
     }
     $mess=$mess.';';

     foreach ($mat_qta as $key=>$num){
       $mess = $mess.$mat_id[$key].'-';
       $mess = $mess.$num.',';
     }
     $mess=$mess.'||';
//*/
    if ($mat_qta){
      //SE CI SONO MATERIALI fa un iter
      // Non devono esserci sostanze che hanno la stessa cromodinamica e combinazione di materiali (a prescindere da diluizione o quantità dei materiali)
      // aggiungo un filtro per trovare le sostanze con la cromodinamica selezionata
      if (!empty($cd)) {
          if ($condizione) {$condizione.=" AND ";}
          $params[]=$cd;
          $condizione.="(`id_cromodinamica` = ?)";
      }

      $sostanze = Sostanze::whereRaw($condizione,$params)->get();

      if(sizeof($sostanze)>0){
        //faccio scorrere tutte le sostanze trovate
        foreach( $sostanze as $sos){
          //se hanno materiali, faccio scorrere l'elenco materiali della sostanza trovata e lo confronto con l'elenco dei materiali
          //della nuova sostanza inserita: se trova anche solo una discrepanza da l'ok per qualla sostanza
          //se tutte le sostanze trovate danno esito ok al controllo allora non ci sono doppioni e si può procedere all'insrimento
          $materialiSostanza=$sos->Materiali()->get();
          $mess = $mess.'|'.$sos['nome'].';num.Materiali:'.sizeof($materialiSostanza).';';
          $okSos = false;
          if(sizeof($materialiSostanza)>0){
             foreach($materialiSostanza as $matSos){
               $mess = $mess.$matSos['Nome'].'-';
               $mess = $mess.$matSos['ID'].'-';
               $mess = $mess.$matSos['pivot']->quantita.',';
               $okMat = false;
               foreach ($mat_qta as $key=>$num){
                 if ($mat_id[$key]!=$matSos['ID']){
                 //||$num!=$matSos['pivot']->quantita
                   //se c'è lo stesso materiale rimane false
                   $okMat=true;
                 }
               }
               $mess = $mess.$okMat;
               $okSos=$okSos||$okMat;
             }
             //$ok=$ok&&$okSos;
          }else{
            // SE la sostanza non ha materiali il check è ok.
            $okSos = true;
            //$ok=$ok&&true;
          }
          $mess = $mess.';SostanzaOK?'.$okSos;
          $ok=$ok&&$okSos;
        }
      }

    }else{
      //SE NON CI SONO MATERIALI fa un iter diverso
      //aggiungo al filtro la matrice e controllo solo quella

      if (!empty($mR)) {
          if ($condizione) {$condizione.=" AND ";}
          $params[]=$mR;
          $condizione.="(`R` = ?)";
      }

      if (!empty($mV)) {
          if ($condizione) {$condizione.=" AND ";}
          $params[]=$mV;
          $condizione.="(`V` = ?)";
      }

      if (!empty($mB)) {
          if ($condizione) {$condizione.=" AND ";}
          $params[]=$mB;
          $condizione.="(`B` = ?)";
      }

      $sostanze = Sostanze::whereRaw($condizione,$params)->get();
      if(sizeof($sostanze)>0){
        // Se esiste una sostanza con la stessa matrice allora il check fallisce.
        $ok = false;
      }
    }

//


     //Session::flash('message', $mess);
     if($ok==true){
       $sostanza->nome = $nome;
       $sostanza->R = $mR;
       $sostanza->V = $mV;
       $sostanza->B = $mB;
       $sostanza->diluizione = $dil;
       $sostanza->effetti = $effetti;
       $sostanza->id_cromodinamica = $cd;
       $sostanza->save();

       if ($mat_qta){
         foreach ($mat_qta as $key=>$num){
             $sosMat = new SostanzeMateriali();
             $sosMat->ID = $mat_id[$key];
             $sosMat->id_sostanza = $sostanza->id_sostanza;
             $sosMat->quantita = $num;
             $sosMat->save();

         }
       }

      Session::flash('message', $nome.' creata con successo');
      return Redirect::to('/admin/sostanze/');
     }else{
      Session::flash('message', 'la sostanza esiste già!');
      return Redirect::to('/admin/sostanze/create');
     }


    }
 }

 public function add_mat($id_sos){
   $mat = Input::get("SelMateriali");
   $qta = Input::get("qtaMat");


   $sosMat = SostanzeMateriali::where('ID',$mat)->where('id_sostanza',$id_sos)->first();
   try{
     $qta_old = $sosMat->quantita;
     $sosMat->quantita =  $qta_old + $qta;
     $sosMat->save();

   }catch (Exception $e){
     $sosMat = new SostanzeMateriali();
     $sosMat->id_sostanza = $id_sos;
     $sosMat->ID = $mat;
     $sosMat->quantita = $qta;
     $sosMat->save();
   }

 }

public function del_mat($id_mat,$id_sos){
  $sosMat = SostanzeMateriali::where('ID',$id_mat)->where('id_sostanza',$id_sos)->first();

         $sosMat->delete();

}

public function mapped_implode($glue, $array, $symbol = '=') {
    return implode($glue, array_map(
            function($k, $v) use($symbol) {
                return $k . $symbol . $v;
            },
            array_keys($array),
            array_values($array)
            )
        );
}

public function get_matrice($id_cromodinamica,$diluizione){
  //$id_sostanza = Input::get("ID");
  //$id_cromodinamica = Input::get("cromodinamica");
  //$diluizione = Input::get("diluizione");
  $mat_qta = Input::get('mat_qta');
  $mat_id = Input::get('mat_id');

  $cromodinamica = SostanzeCromodinamica::find($id_cromodinamica);
  $param = SintesiParametri::find(1);
  $soglia_cd_h = $param["soglia_cd_h"];
  $soglia_cd_l = $param["soglia_cd_l"];
  $soglia_dil = $param["soglia_dil"];
  $max_cr = $param["max_cr"];
  $med_cr = $param["med_cr"];
  $min_cr = $param["min_cr"];

  $cd_R = $cromodinamica["cromo_R"];
  $cd_V = $cromodinamica["cromo_V"];
  $cd_B = $cromodinamica["cromo_B"];
  $colore_dominante_minimo = 0;
  $colore_dominante_massimo = $diluizione-1;

  $risultati = array();

  if(max($cd_R,$cd_V,$cd_B)>128){
    $colore_dominante_minimo = round($diluizione * $soglia_dil,0);
    $max_cr_s =   $max_cr;
    $med_cr_s =   $med_cr;
  }else{
    $colore_dominante_massimo = round($diluizione * $soglia_dil,0);
    $max_cr_s =   $med_cr;
    $med_cr_s =   $min_cr;
  }

  // prendere i colori dei materiali
  $R_comp = 0;
  $V_comp = 0;
  $B_comp = 0;

  $messaggio = '';

  if ($mat_qta){
      $messaggio = 'si:';
  	foreach ($mat_qta as $key=>$qta){
  		$ID = $mat_id[$key];
  		$mat = Materiale::find($ID);
      $messaggio = $messaggio.$ID;
          $R_comp = $R_comp + ($mat['CromoDinamicaR'] * $qta);
          $V_comp = $V_comp + ($mat['CromoDinamicaV'] * $qta);
          $B_comp = $B_comp + ($mat['CromoDinamicaB'] * $qta);
          $messaggio = $messaggio.','.$R_comp;
          $messaggio = $messaggio.','.$V_comp;
          $messaggio = $messaggio.','.$B_comp.';';
      }
      $messaggio = $messaggio.'|';
  }else{
      $messaggio = 'no|';
  }



    for ($i = 0; $i <= $diluizione; $i++) {

        $erbe_disponibili = $diluizione -$i;

        for ($n = 0; $n <= $erbe_disponibili; $n++) {

          $rosso_matr = $i;
          $verde_matr = $n;
          $blu_matr = $erbe_disponibili - $n;

          $rosso_tot = $rosso_matr+$R_comp;
          $verde_tot = $verde_matr+$V_comp;
          $blu_tot = $blu_matr+$B_comp;

          $max_mat = max($rosso_tot,$verde_tot,$blu_tot);
          $rap_r = $rosso_tot/$max_mat;
          $rap_v = $verde_tot/$max_mat;
          $rap_b = $blu_tot/$max_mat;

          if($rap_r>$soglia_cd_h){
              $cromodinamica_r = $max_cr_s;
          }else{
            if($rap_r>$soglia_cd_l){
                $cromodinamica_r = $med_cr_s;
            }else{
              $cromodinamica_r = $min_cr;
            }
          }

          if($rap_v>$soglia_cd_h){
              $cromodinamica_v = $max_cr_s;
          }else{
            if($rap_v>$soglia_cd_l){
                $cromodinamica_v = $med_cr_s;
            }else{
              $cromodinamica_v = $min_cr;
            }
          }

          if($rap_b>$soglia_cd_h){
              $cromodinamica_b = $max_cr_s;
          }else{
            if($rap_b>$soglia_cd_l){
                $cromodinamica_b = $med_cr_s;
            }else{
              $cromodinamica_b = $min_cr;
            }
          }

          if(($cromodinamica_r==$cd_R)&&($cromodinamica_v==$cd_V)&&($cromodinamica_b==$cd_B)){
            $set = array(
              "R"=>$rosso_matr,
              "V"=>$verde_matr,
              "B"=>$blu_matr,
            );

            if ($mat_qta){
              //se ci sono materiali
              array_push($risultati, $set);

            }else{
              //se non ci sono materiali
              $sostanze = Sostanze::Where('R',$rosso_matr)
                                  ->Where('V',$verde_matr)
                                  ->Where('B',$blu_matr)
                                  ->get();
              if(count($sostanze)=== 0){array_push($risultati, $set);}
            }

          }
        }
    }

    $num = count($risultati);

    if($num === 0){
      //non ci sono combinazioni valide per questa cromodinamica e quel numero di erbe
       $messaggio = $messaggio.'Non ci sono matrici disponibili per il colore '.$cromodinamica['DESC'].' con Diluizione '.$diluizione;
       Session::flash('message', $messaggio);
       //return Response::json($messaggio);
       $matrice = array(
         "R"=>0,
         "V"=>0,
         "B"=>0,
       );
       return Response::json($matrice);
    }else{
      //random 0 = num e prendo $risutlati[$num];
      $indice = rand(0, $num-1);

      $matrice = $risultati[$indice];

    $symbol = ' = ';
    $messaggio = $messaggio.'elenco matrici: ';
    foreach($risultati as $matrice){
      $mat_str =implode(', ', array_map(
              function($k, $v) use($symbol) {
                  return $k . $symbol . $v;
              },
              array_keys($matrice),
              array_values($matrice)
              )
          );
      $messaggio = $messaggio.' | '.$mat_str.' ;';

    }

    //$messaggio = 'matrice calcolata correttamente';
    Session::flash('message', $messaggio);
    //$messaggio = 'matrice calcolata correttamente: '.$mat_str.'. risultato '.$indice.' di '.$num.' .';
    //Session::flash('message', $messaggio);
    //Session::flash('message', 'matrice calcolata correttamente');
    return Response::json($matrice);
  }
  //Session::flash('message', $messaggio);
  //return Redirect::to('admin/sostanze/'.$id_sostanza.'/edit');



}

public function get_cromodinamica($id_cd){
  $cromodinamica = SostanzeCromodinamica::find($id_cd);


    return Response::json($cromodinamica);

}



}
