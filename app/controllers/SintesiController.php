<?php

class SintesiController extends \BaseController {

    public function index()
	{
    $activeTab = 'pills-sintesi';


    $totOggetti = 0;
    $idpg = Session::get('idpg');
    $evento = Evento::Orderby('ID','Desc')->first();
		$dataEvento  = $evento->Data;
		if($dataEvento >= date("Y-m-d")){
			$idEvento = $evento->ID -1;
			$evento = Evento::where('ID',$idEvento)->first();
		}
    $selLab = array();

    $selPG=array();
    $selPG[''][0] = 'Master';
    $PGSvivi = PG::where('Morto',0)->where('InLimbo',0)->Get();
    foreach($PGSvivi as $pg) {
      $aff = $pg->Affiliazione;
      $selPG[$aff][$pg->ID] = $pg->Nome;
    }
    $PGSLimbo = PG::where('InLimbo',1)->Get();
    foreach($PGSLimbo as $pg) {
      $selPG['Limbo'][$pg->ID] = $pg->Nome;
    }
    $PGSmorti = PG::where('Morto',1)->Get();
    foreach($PGSmorti as $pg) {
      $selPG['Morti'][$pg->ID] = $pg->Nome;
    }

    $selCD=array(0=>'');
    $CD=SostanzeCromodinamica::get();
     foreach($CD as $c){
       $padre = $c->Padre->DESC;
        $selCD[$padre][$c->ID] = $c->DESC.' ('.$c->livello.')';
     }

    $selEvento =  array(0=>'');
    $Eventi = Evento::Orderby('ID','Desc')->Get();
    foreach($Eventi as $e){
      $selEvento[$e->ID]=$e->Titolo;
    }

    if (Auth::user()->usergroup == 7) {
      $idpg = 0;
      $CartelliniUsati = 0;
      $CartelliniRimanenti = 10;
      $ricercatore = true;
      $maestro = true;
      $alchimia = true;

      $fazioni = Fazione::Orderby('ID','Asc')->Get();
      foreach($fazioni as $f){
        $stato = $f->StatoLab()->First()->Descrizione;

        if($f->ID!=3){
          $desc = $f->Fazione.' - '.$stato;
          $selLab[$f->ID]=$desc;
        }else{
          $desc = 'Ospitale - '.$stato;
          $selLab[$f->ID]=$desc;
        }
      }


    }else{
      $totOggetti = 0;
      $PG = PG::find($idpg);
      $abilitaPG = $PG->Abilita()->get();
      $ricercatore = false;
      $maestro = false;
      $alchimia = false;
      foreach ($abilitaPG as $abi){
          $totOggetti=  $totOggetti+$abi['Oggetti'];
          if ($abi['ID']==135) {
            $maestro = true;
          }
          if ($abi['ID']==164) {
            $ricercatore = true;
          }
          if ($abi['ID']==33) {
            $alchimia = true;
          }
      }

      $fazione = Fazione::where('Fazione',$PG->Affiliazione)->Orderby('ID','Asc')->first();
      if($fazione->ID!=3){
        $stato = $fazione->StatoLab()->First()->Descrizione;
        $desc = $fazione->Fazione.' - '.$stato;
        $selLab[$fazione->ID]=$desc;
      }
      $fazioneNA = Fazione::where('ID',3)->first();
      $stato = $fazioneNA->StatoLab()->First()->Descrizione;
      $desc = 'Ospitale - '.$stato;
      $selLab[3]=$desc;

      $CartelliniSintesi = Sintesi::where('id_pg','=',$idpg)->where('id_evento','=',$evento['ID'])->sum('oggetti');
      $CartelliniAnalisi = SintesiAnalisi::where('id_pg','=',$idpg)->where('id_evento','=',$evento['ID'])->sum('oggetti');
      $CartelliniEstratti = SintesiEstratti::where('id_pg','=',$idpg)->where('id_evento','=',$evento['ID'])->sum('oggetti');
      $CartelliniUsati = $CartelliniSintesi+$CartelliniAnalisi+$CartelliniEstratti;
      $CartelliniRimanenti = $totOggetti - $CartelliniUsati;


    }

    $SintesiPG = Sintesi::where('id_pg','=',$idpg)->orderBy('id_sintesi','desc')->take(5)->get();
    $EstrattiPG = SintesiEstratti::where('id_pg','=',$idpg)->orderBy('id_estratto','desc')->take(5)->get();
    $AnalisiPG = SintesiAnalisi::where('id_pg','=',$idpg)->orderBy('id_analisi','desc')->take(5)->get();

		return View::make('sintesi.index')
      ->with('CartelliniUsati', $CartelliniUsati)
      ->with('CartelliniRimanenti', $CartelliniRimanenti)
      ->with('ricercatore', $ricercatore)
      ->with('maestro', $maestro)
      ->with('alchimia', $alchimia)
      ->with('SintesiPG', $SintesiPG)
      ->with('EstrattiPG', $EstrattiPG)
      ->with('AnalisiPG', $AnalisiPG)
      ->with('selCD', $selCD)
      ->with('selPG', $selPG)
      ->with('selectLab', $selLab)
      ->with('selEvento', $selEvento)
      ->with('tab', $activeTab);
	}

  public function search(){
    $idpg = Input::get('pgSearch');
    $id_evento = Input::get('eventoSearch');
    $dataStart = Input::get('dataInizio');
    $dataEnd = Input::get('dataFine');
    $id_cromodinamica = Input::get('CDsearch');
    $diluizione = Input::get('diluizioneSearch');
    $sostanza = Input::get('sostanzaSearch');
    $effetti = Input::get('effettiSearch');
    $R = Input::get('Rsearch');
    $V = Input::get('Vsearch');
    $B = Input::get('Bsearch');

    $SintesiQry = Sintesi::with('sostanza','cromodinamica','materiali');

    if($idpg){
      $SintesiQry->where('id_pg',$idpg) ;
    }

    if($id_evento){
      $SintesiQry->where('id_evento',$id_evento) ;
    }

    if($dataStart){
      $SintesiQry->where('data','>=',$dataStart);
    }

    if($dataEnd){
      $SintesiQry->where('data','<=',$dataEnd);
    }

    if($id_cromodinamica){
      $SintesiQry->where('id_cromodinamica',$id_cromodinamica) ;
    }

    if($sostanza){
      //$SintesiQry->where('sostanza.nome','like', '%'.$sostanza.'%') ;
      $SintesiQry->whereHas('sostanza', function($q) use ($sostanza){
          $q->where('nome','like', '%'.$sostanza.'%');
        });
    }

    if($effetti){
      //$SintesiQry->whereHas('sostanza.effetti','like', '%'.$effetti.'%') ;
      $SintesiQry->whereHas('sostanza', function($q) use ($effetti){
          $q->where('effetti','like', '%'.$effetti.'%');
        });
    }

    if($diluizione){
      $SintesiQry->whereRaw('R_matrice+V_matrice+B_matrice = '.$diluizione) ;
    }

    if(!($R==''||$R==null)){
      $SintesiQry->where('R_matrice',$R) ;
    }

    if(!($V==''||$V==null)){
      $SintesiQry->where('V_matrice',$V) ;
    }

    if(!($B==''||$B==null)){
      $SintesiQry->where('B_matrice',$B) ;
    }
  //  $error = $R.','.$V.','.$B;
  //  $error = $error.' - '.$SintesiQry->toSql();

    $sintesiPG = $SintesiQry->orderBy('id_sintesi','desc')->paginate(10);

  //  Session::flash('message', $error);
    return Response::json($sintesiPG);

  }

  public function show(){
    $idpg = Input::get('pgSearch');
    $id_evento = Input::get('eventoSearch');
    $dataStart = Input::get('dataInizio');
    $dataEnd = Input::get('dataFine');
    $id_cromodinamica = Input::get('CDsearch');
    $diluizione = Input::get('diluizioneSearch');
    $sostanza = Input::get('sostanzaSearch');
    $effetti = Input::get('effettiSearch');
    $R = Input::get('RSearch');
    $V = Input::get('VSearch');
    $B = Input::get('BSearch');

    $SintesiQry = Sintesi::with('sostanza','cromodinamica','materiali');

    if($idpg){
      $SintesiQry->where('id_pg',$idpg) ;
    }

    if($id_evento){
      $SintesiQry->where('id_evento',$idEvento) ;
    }

    if($dataStart){
      $SintesiQry->where('data','>=',$dataStart);
    }

    if($dataEnd){
      $SintesiQry->where('data','<=',$dataEnd);
    }

    if($id_cromodinamica){
      $SintesiQry->where('id_cromodinamica',$id_cromodinamica) ;
    }

    if($sostanza){
      $SintesiQry->where('sostanza.nome','like', '%'.$sostanza.'%') ;
    }

    if($sostanza){
      $SintesiQry->where('sostanza.effetti','like', '%'.$effetti.'%') ;
    }

    if($diluizione){
      $SintesiQry->whereRaw('R_matrice+V_matric+B_matrice = '.$diluizione) ;
    }

    if($R){
      $SintesiQry->where('R_matrice',$R) ;
    }

    if($V){
      $SintesiQry->where('V_matrice',$V) ;
    }

    if($B){
      $SintesiQry->where('B_matrice',$B) ;
    }

    $sintesiPG = $SintesiQry->orderBy('id_sintesi','desc')->paginate(10);

    return Response::json($sintesiPG);

  }

  public function somma_cromodinamica($id_CD_A, $id_CD_B){
    //$cromodinamica_prodotto = null;
    $CD_A = SostanzeCromodinamica::find($id_CD_A);
    $CD_B = SostanzeCromodinamica::find($id_CD_B);


      $Final_CD_R = 0;
      $Final_CD_V = 0;
      $Final_CD_B = 0;
      $R_A = $CD_A['cromo_R'];
      $V_A = $CD_A['cromo_V'];
      $B_A = $CD_A['cromo_B'];
      $R_B = $CD_B['cromo_R'];
      $V_B = $CD_B['cromo_V'];
      $B_B = $CD_B['cromo_B'];

      $param = SintesiParametri::find(1);
      $soglia_cd_h = $param["soglia_cd_h"];
      $soglia_cd_l = $param["soglia_cd_l"];
      $max_cr = $param["max_cr"];
      $med_cr = $param["med_cr"];
      $min_cr = $param["min_cr"];

      $CD_R_tot = $R_A+$R_B;
      $CD_V_tot = $V_A+$V_B;
      $CD_B_tot = $B_A+$B_B;

      $MaxCD = max($CD_R_tot,$CD_V_tot,$CD_B_tot);

      $Rap_R = $CD_R_tot/$MaxCD;
      $Rap_V = $CD_V_tot/$MaxCD;
      $Rap_B = $CD_B_tot/$MaxCD;

      $Angolo = (($R_A*$R_B)+($V_A*$V_B)+($B_A*$B_B))/(sqrt(pow($R_A,2)+pow($V_A,2)+pow($B_A,2))*sqrt(pow($R_B,2)+pow($V_B,2)+pow($B_B,2)));

      if($CD_A["livello"]==$CD_B["livello"]){
        //Vettore Diretto
        //valore R
        if($Rap_R>=$soglia_cd_h){
          $Final_CD_R = $max_cr;
        }else{
          if ($Rap_R<=max((1-$Angolo),$soglia_cd_l)){
            $Final_CD_R = $min_cr;
          }else{
            $Final_CD_R = $med_cr;
          }
        }
        //Valore V
        if($Rap_V>=$soglia_cd_h){
          $Final_CD_V = $max_cr;
        }else{
          if ($Rap_V<=max((1-$Angolo),$soglia_cd_l)){
            $Final_CD_V = $min_cr;
          }else{
            $Final_CD_V = $med_cr;
          }
        }
        //VAlore B
        if($Rap_B>=$soglia_cd_h){
          $Final_CD_B = $max_cr;
        }else{
          if ($Rap_B<=max((1-$Angolo),$soglia_cd_l)){
            $Final_CD_B = $min_cr;
          }else{
            $Final_CD_B = $med_cr;
          }
        }

      }else{
        //Vettore Inverso
        //valore R
        if((1-$Rap_R)>MIN($Angolo,$soglia_cd_h)){
          $Final_CD_R = $max_cr;
        }else{
          if((1-$Rap_R)<=$soglia_cd_l){
            $Final_CD_R = $min_cr;
          }else{
            $Final_CD_R = $med_cr;
          }
        }
        //valore V
        if((1-$Rap_V)>MIN($Angolo,$soglia_cd_h)){
          $Final_CD_V = $max_cr;
        }else{
          if((1-$Rap_V)<=$soglia_cd_l){
            $Final_CD_V = $min_cr;
          }else{
            $Final_CD_V = $med_cr;
          }
        }
        //valore B
        if((1-$Rap_B)>MIN($Angolo,$soglia_cd_h)){
          $Final_CD_B = $max_cr;
        }else{
          if((1-$Rap_B)<=$soglia_cd_l){
            $Final_CD_B = $min_cr;
          }else{
            $Final_CD_B = $med_cr;
          }
        }
      }

      $cromodinamica_prodotto = SostanzeCromodinamica::Where('cromo_V', $Final_CD_V)
                                                    ->Where('cromo_B', $Final_CD_B)
                                                    ->Where('cromo_R', $Final_CD_R)
                                                    ->first();


      if($id_CD_A = 14){
        $cromodinamica_prodotto == $CD_B;
      }elseif($id_CD_B = 14){
        $cromodinamica_prodotto == $CD_A;
      }

      //Session::flash('message', "angolo:".$Angolo."|RapR:".$Rap_R."|RapV:".$Rap_V."|RapB:".$Rap_B."|FinalR:". $Final_CD_R."|FinalV:". $Final_CD_V."|FinalB:". $Final_CD_B."|SogliaH:".$soglia_cd_h."|SogliaL:".$soglia_cd_l."|CDA:".$id_CD_A."|CDB:".$id_CD_B);
    return $cromodinamica_prodotto;
  }

  public function cromodinamicaMatrice($rosse,$verdi,$blu){
    $cromodinamica_matrice = null;

    $param = SintesiParametri::find(1);
    $soglia_cd_h = $param["soglia_cd_h"];
    $soglia_cd_l = $param["soglia_cd_l"];
    $soglia_dil = $param["soglia_dil"];
    $max_cr = $param["max_cr"];
    $med_cr = $param["med_cr"];
    $min_cr = $param["min_cr"];
    $tolleranza_dil = $param["tolleranza_dil"];

  //calcolare la cromodinamica della matrice e poi sommare le cromodinamiche.

    $rosso_mat = 0;
    $verde_mat = 0;
    $blu_mat = 0;

    $rosso_tot = $rosso_mat + $rosse;
    $verde_tot = $verde_mat + $verdi;
    $blu_tot = $blu_mat + $blu;
    $tot_cd=$blu_tot+$verde_tot+$rosso_tot;

    $dil_r = $rosso_tot/$tot_cd;
    $dil_v = $verde_tot/$tot_cd;
    $dil_b = $blu_tot/$tot_cd;

    $max_mat = max($rosso_tot,$verde_tot,$blu_tot);
    $rap_r = $rosso_tot/$max_mat;
    $rap_v = $verde_tot/$max_mat;
    $rap_b = $blu_tot/$max_mat;

    if($rap_r>$soglia_cd_h){

        if($dil_r>$soglia_dil){
          $cromodinamica_r = $max_cr;
        }else{
            $cromodinamica_r = $med_cr;
        }
    }else{
      if($rap_r>$soglia_cd_l){

          if($dil_r>$soglia_dil){
            $cromodinamica_r = $med_cr;
          }else{
              $cromodinamica_r = $min_cr;
          }
      }else{
        $cromodinamica_r = $min_cr;
      }
    }

    if($rap_v>$soglia_cd_h){
        if($dil_v>$soglia_dil){
          $cromodinamica_v = $max_cr;
        }else{
            $cromodinamica_v = $med_cr;
        }
    }else{
      if($rap_v>$soglia_cd_l){
          if($dil_v>$soglia_dil){
            $cromodinamica_v = $med_cr;
          }else{
            $cromodinamica_v = $min_cr;
          }
      }else{
        $cromodinamica_v = $min_cr;
      }
    }

    if($rap_b>$soglia_cd_h){
      if($dil_b>$soglia_dil){
        $cromodinamica_b = $max_cr;
      }else{
        $cromodinamica_b = $med_cr;
      }
    }else{
      if($rap_b>$soglia_cd_l){
        if($dil_b>$soglia_dil){
          $cromodinamica_b = $med_cr;
        }else{
          $cromodinamica_b = $min_cr;
        }
      }else{
        $cromodinamica_b = $min_cr;
      }
    }

    $cromodinamica_matrice = SostanzeCromodinamica::Where('cromo_V', $cromodinamica_v)
                                                  ->Where('cromo_B', $cromodinamica_b)
                                                  ->Where('cromo_R', $cromodinamica_r)
                                                  ->first();

    return $cromodinamica_matrice;
  }

  public function sintesi(){
    $evento = Evento::Orderby('ID','Desc')->first();
		$dataEvento  = $evento->Data;
		if($dataEvento >= date("Y-m-d")){
			$idEvento = $evento->ID -1;
			$evento = Evento::where('ID',$idEvento)->first();
		}
    $group=Auth::user()->usergroup;
    if ( $group!= 7) {
      $idpg = Session::get('idpg');

      $farmacologia = false;
      $maestro = false;
      $alchimia = false;
      $studi = false;


      $PG = PG::find($idpg);
      $abilitaPG = $PG->Abilita()->get();
      foreach ($abilitaPG as $abi){

          if ($abi['ID']==135) {
            $maestro = true;
          }
          if ($abi['ID']==165) {
            $farmacologia = true;
          }
          if ($abi['ID']==33) {
            $alchimia = true;
          }
          if ($abi['ID']==35) {
            $studi = true;

          }
      }
   }else{
     $idpg = 0;
     $farmacologia = true;
     $maestro = true;
     $alchimia = true;
     $studi = true;

   }

    $materiali = array();
    $CD_componenti = null;
    /*
    $CD_R_mat = 0;
    $CD_V_mat = 0;
    $CD_B_mat = 0;
    */
    $errore = "";

      //check nomi materiali
    $materiali_sintesi = Input::get('materiale_sintesi');
    $qta_sintesi = Input::get('qta_sintesi');
    if (count($materiali_sintesi)>0){
      if ($alchimia){
        $estratto = true;
        foreach ($materiali_sintesi as $key=>$nome){
          $qta = 1;
          if ($qta_sintesi){
            $qta = $qta_sintesi[$key];
          }
          //$nome = $materiali_sintesi[$key];
          $materiale = Materiale::where('Nome','=',$nome)->first();
          if($materiale){
            $id_materiale = $materiale['ID'];
            $materiali[$id_materiale] = $qta;
            $CD_MAT = $materiale->cd()->first();
            //check se il pg ha mastro/farmacologia
            $categoria=$materiale['Categoria'];
            if($categoria==3){
                if($maestro==false){
                  $errore = $errore.'Il PG non sa lavorare il materiale: '.$nome." ".$key." ".$qta;
                }
            }else{
              if($id_materiale==66){
                if($farmacologia==false){
                  $errore = $errore.'Il PG non sa lavorare il materiale: '.$nome." ".$key." ".$qta;
                }
              }else{
                  $estratto = false;
              }
            }

            if ($CD_MAT){
// da fare la miscelazione delle cromodinamiche con ogni materiale
                if($CD_componenti){
                  $CD_componenti = $this->somma_cromodinamica($CD_componenti["ID"],$CD_MAT["ID"]);
                }else{
                  $CD_componenti = $CD_MAT;
                }
                /*
                $CD_R_mat = $CD_R_mat + ($CD_MAT['Cromo_R'] * $qta);
                $CD_V_mat = $CD_V_mat + ($CD_MAT['Cromo_V'] * $qta);
                $CD_B_mat = $CD_B_mat + ($CD_MAT['Cromo_B'] * $qta);
                */
            }else{
              $errore = $errore.'Materiale inadatto alla sintesi: '.$nome;
            }
          }else{
            $errore = $errore.'Materiale non riconosciuto: '.$nome;
          }
        }
      }else{
        $errore = $errore.'Il PG non sa lavorare il materiale: '.$nome;///." ".$key." ".$qta;
      }
    }

    $lab = Input::get('selectLab');
    $fazione = Fazione::find($lab);
    $statoLab = $fazione->StatoLab()->first();
    if($fazione->ID != 3){
      $nomeLab = $fazione->Fazione;
    }else{
      $nomeLab = 'Ospitale';
    }

    $rosse = Input::get('rosse');
    $verdi = Input::get('verdi');
    $blu = Input::get('blu');
    $tot_erbe = $rosse + $verdi + $blu;

    if($statoLab->ID == 5){
        $errore = $errore.' Il Laboratorio '.$nomeLab.' è Distrutto. Non è possibile utilizzarlo per una sintesi.';
    }

    if($tot_erbe<3){
        $errore = $errore.' Per effettuare una sintesa serve una matrice di almeno 3 erbe.';
    }

    if (strlen($errore) > 0){
      //Session::flash('message', $errore);
        Session::flash('message', $errore);
    }else{
      // segnare avere in registrazione
      $param = SintesiParametri::find(1);
      $soglia_cd_h = $param["soglia_cd_h"];
      $soglia_cd_l = $param["soglia_cd_l"];
      $soglia_dil = $param["soglia_dil"];
      $max_cr = $param["max_cr"];
      $med_cr = $param["med_cr"];
      $min_cr = $param["min_cr"];
      $tolleranza_dil = $param["tolleranza_dil"];

    //calcolare la cromodinamica della matrice e poi sommare le cromodinamiche.

      $rosso_mat = 0;
      $verde_mat = 0;
      $blu_mat = 0;

      $rosso_tot = $rosso_mat + $rosse;
      $verde_tot = $verde_mat + $verdi;
      $blu_tot = $blu_mat + $blu;
      $tot_cd=$blu_tot+$verde_tot+$rosso_tot;

      $dil_r = $rosso_tot/$tot_cd;
      $dil_v = $verde_tot/$tot_cd;
      $dil_b = $blu_tot/$tot_cd;

      $max_mat = max($rosso_tot,$verde_tot,$blu_tot);
      $rap_r = $rosso_tot/$max_mat;
      $rap_v = $verde_tot/$max_mat;
      $rap_b = $blu_tot/$max_mat;

      if($rap_r>$soglia_cd_h){

          if($dil_r>$soglia_dil){
            $cromodinamica_r = $max_cr;
          }else{
              $cromodinamica_r = $med_cr;
          }
      }else{
        if($rap_r>$soglia_cd_l){

            if($dil_r>$soglia_dil){
              $cromodinamica_r = $med_cr;
            }else{
                $cromodinamica_r = $min_cr;
            }
        }else{
          $cromodinamica_r = $min_cr;
        }
      }

      if($rap_v>$soglia_cd_h){
          if($dil_v>$soglia_dil){
            $cromodinamica_v = $max_cr;
          }else{
              $cromodinamica_v = $med_cr;
          }
      }else{
        if($rap_v>$soglia_cd_l){
            if($dil_v>$soglia_dil){
              $cromodinamica_v = $med_cr;
            }else{
              $cromodinamica_v = $min_cr;
            }
        }else{
          $cromodinamica_v = $min_cr;
        }
      }

      if($rap_b>$soglia_cd_h){
        if($dil_b>$soglia_dil){
          $cromodinamica_b = $max_cr;
        }else{
          $cromodinamica_b = $med_cr;
        }
      }else{
        if($rap_b>$soglia_cd_l){
          if($dil_b>$soglia_dil){
            $cromodinamica_b = $med_cr;
          }else{
            $cromodinamica_b = $min_cr;
          }
        }else{
          $cromodinamica_b = $min_cr;
        }
      }

      $cromodinamica_matrice = SostanzeCromodinamica::Where('cromo_V', $cromodinamica_v)
                                                    ->Where('cromo_B', $cromodinamica_b)
                                                    ->Where('cromo_R', $cromodinamica_r)
                                                    ->first();


// adesso calcolo la cromodinamica della miscela
      $cromodinamica = null;
      if(count($materiali)>0){
        $cromodinamica = $this->somma_cromodinamica($CD_componenti["ID"],$cromodinamica_matrice["ID"]);
      }else
      {
        $cromodinamica = $cromodinamica_matrice;
      }
//  Session::flash('message', $Final_CD_V.' '.$Final_CD_B.' '. $Final_CD_R);
//    Session::flash('message',   $cromodinamica['ID']);

      $sostanza_sintetizzata=null;
      //i valori di cromodinamica qui sono espressi in sacala 255
      //controllo cromodinamica + elenco componenti su tabella sotanze
      //ogni combinazione Cromodinamica/Componente è univoca
      $error = '';
      $rubedo = false;
      if(count($materiali)>0){

        $sostanzeQry = Sostanze::Where('id_cromodinamica',$cromodinamica['ID'])
                            ->Where('cancellata',0);
        //$sostanze = $sostanzeQry->get();
        //$error = $error.'Pars: '.$cromodinamica['ID'].',0';
        foreach($materiali as $ID=>$qta){
          //$error = $error.','.$ID.','.$qta.' - ';
          $sostanzeQry->whereHas('Materiali', function($q) use ($ID,$qta){
              $q->where('Sostanze-Materiali.ID','=', $ID)->where('Sostanze-Materiali.quantita','=', $qta);
            });
        }
        //$error =   $error.$sostanzeQry->toSql();
        $sostanza_sintetizzata =$sostanzeQry->first();

        //se non trovo una sostanza con l'esatta cromodinamica, verifico se esistono sostanze con la CD padre e gli stessi componenti.
        //se ci sono, indico rubedo.
        if(!$sostanza_sintetizzata){
          $sostanzeQry = Sostanze::Where('cancellata',0);
          //$sostanze = $sostanzeQry->get();
          //$error = $error.'Pars: '.$cromodinamica['ID'].',0';
          foreach($materiali as $ID=>$qta){
            //$error = $error.','.$ID.','.$qta.' - ';
            $sostanzeQry->whereHas('Materiali', function($q) use ($ID,$qta){
                $q->where('Sostanze-Materiali.ID','=', $ID)->where('Sostanze-Materiali.quantita','=', $qta);
              });
          }
          $sostanzeQry->whereHas('Cromodinamica', function($q) use ($cromodinamica){
              $q->where('id_padre','=', $cromodinamica['id_padre']);
            });
          //$error =   $error.$sostanzeQry->toSql();
          $sostanza_sintetizzata = $sostanzeQry->first();
          if($sostanza_sintetizzata){
              $rubedo = true;
          }

        }

        if($sostanza_sintetizzata){
          //$error =   $error.' | '.$tot_erbe.' | '.$sostanza_sintetizzata['diluizione'].' | '.$tolleranza_dil;

          //se ok controllo la diluizione
          //if(($sostanza_sintetizzata['diluizione']>=($tot_erbe-$tolleranza_dil))&&($sostanza_sintetizzata['diluizione']<=($tot_erbe+$tolleranza_dil)))
          if((($tot_erbe >= $sostanza_sintetizzata['diluizione']-$tolleranza_dil)) && ($tot_erbe <= ($sostanza_sintetizzata['diluizione']+$tolleranza_dil)))
          {
            // se ok, esiste una sostanza con queste caratteristiche, ma devo controllare la rubedo>
            // Se non cé rubedo restituisco la cromodinamica del composto senza indicazione della diluizione e con effetti
            // se invece cé non passo ne diluiizione ne effetti ma solo rubedo
            $diluizione = 0;
            if($rubedo){
              $sostanza_sintetizzata = null;
            }
          }else{
            if (($tot_erbe)<($sostanza_sintetizzata['diluizione']-$tolleranza_dil)){
              //nero cioe troppo concentrato
              $diluizione = 1;
              $sostanza_sintetizzata = null;
            }
            elseif (($tot_erbe)>($sostanza_sintetizzata['diluizione']+$tolleranza_dil)){
              //bianco cioe troppo diluito
              $diluizione = -1;
              $sostanza_sintetizzata = null;
            }
            // restituisco la cromodinamica del composto con indicazione della diluizione ma senza con effetti

          }

        }else{
          //nessuna sostanza corrisponde a questi materiali e cromodinamica
          // restituisco la cromodinamica del composto ma senza indicazione della diluizione e senza effetti
          $diluizione = 0;
          $sostanza_sintetizzata = null;
        }

      }else{
        // sintesi senza componenti
        $sostanze = Sostanze::Where('R',$rosse)
                            ->Where('V',$verdi)
                            ->Where('B',$blu)
                            ->Where('Cancellata',0)
                            ->Has('Materiali','=',0)
                            ->get();
        if(count($sostanze)==1){
          $sostanza_sintetizzata = $sostanze[0];
        }else{
          $sostanza_sintetizzata = null;
        }
        $diluizione = 0;
      }

      // salvo la sintesi
        if($sostanza_sintetizzata){
          $id_sostanza = $sostanza_sintetizzata['id_sostanza'];
        }else{
          $id_sostanza = null;
        }

        $sintesi = new Sintesi;
        $sintesi->id_laboratorio = $lab;
        $tiroFallimento = rand(0,99);
        $sogliaFallimento = 100 - $statoLab->Fallimento;
        if($tiroFallimento < $sogliaFallimento){

          $sintesi->id_evento =  $evento['ID'];
          $sintesi->id_pg = $idpg;
          $sintesi->data = date("Y-m-d");
          $sintesi->R_matrice = $rosse;
          $sintesi->V_matrice = $verdi;
          $sintesi->B_matrice = $blu;
          $sintesi->diluizione = $diluizione;
          $sintesi->rubedo = $rubedo;
          $sintesi->oggetti = 1;
          $sintesi->id_sostanza = $id_sostanza;

          $sintesi->id_cromodinamica = $this->filtraIdCromodinamica($studi,$cromodinamica);

        }else{
          $sintesi->id_evento =  $evento['ID'];
          $sintesi->id_pg = $idpg;
          $sintesi->data = date("Y-m-d");
          $sintesi->R_matrice = $rosse;
          $sintesi->V_matrice = $verdi;
          $sintesi->B_matrice = $blu;
          $sintesi->diluizione = 0;
          $sintesi->rubedo = 0;
          $sintesi->oggetti = 1;
          $sintesi->id_sostanza = null;

          $sintesi->id_cromodinamica =  13;
        }



        $sintesi->save();

        if(count($materiali)>0){
          foreach($materiali as $ID=>$qta){
            $sintesi->mat()->attach($ID,['quantita' => $qta]);
          }
        }

      }

      //Session::flash('message', $error);
      //refresh della pagina
      return Redirect::to('sintesi');
  }

  public function filtraIdCromodinamica($studi, $cromodinamica){
    $id_cromodinamica = 0;
    $soglia = 1;
    if($studi){$soglia = 2;}

    if($cromodinamica['livello']>$soglia){
      $id_cromodinamica = $cromodinamica['id_padre'];
    }else{
      $id_cromodinamica = $cromodinamica['ID'];
    }

    return $id_cromodinamica;
  }


  public function analisi(){
    $errore = '';
    $eventi = Evento::where('tipo','EVENTO LIVE')->Orderby('ID','Desc')->take(2)->get();
    $evento = $eventi[0];
		$dataEvento  = $evento->Data;
		if($dataEvento >= date("Y-m-d")){
      $evento = $eventi[1];
			//$evento = Evento::where('ID',$idEvento)->first();
		}
    $materiale_analisi = Input::get('materiale_analisi');
    //$qta_estratti = Input::get('qta_estratti');
    $studi = false;
    $studiplus = false;

    $group=Auth::user()->usergroup;
    if ( $group!= 7) {
      $idpg = Session::get('idpg');
      $PG = PG::find($idpg);
      $abilitaPG = $PG->Abilita()->get();
      foreach ($abilitaPG as $abi){

          if ($abi['ID']==35) {
            $studi = true;
            $studiplus = true;
          }
      }
    }else{
      $idpg = 0;
      $studi = true;
      $studiplus = true;
    }

    $lab = Input::get('selectLabAnalisi');
    $fazione = Fazione::find($lab);
    $statoLab = $fazione->StatoLab()->first();
    if($fazione->ID != 3){
      $nomeLab = $fazione->Fazione;
    }else{
      $nomeLab = 'Ospitale';
    }
    if($statoLab->ID == 5){
        $errore = $errore.' Il Laboratorio '.$nomeLab.' è Distrutto. Non è possibile utilizzarlo per una sintesi.';
    }

    $materiale = Materiale::where('nome','=',$materiale_analisi)->first();
    if(!$materiale){
        $errore = 'Materiale non riconosciuto: '.$materiale_analisi;
    }

    if (strlen($errore) > 0){
      //Session::flash('message', $errore);
        Session::flash('message', $errore);
    }else{
      $analisi = new SintesiAnalisi();
      $analisi->id_laboratorio = $lab;
      $tiroFallimento = rand(0,99);
      $sogliaFallimento = 100 - $statoLab->Fallimento;
      if($tiroFallimento < $sogliaFallimento){
        $analisi->id_materiale = $materiale->ID;
        $analisi->id_pg = $idpg;
        $analisi->data = date("Y-m-d");
        $analisi->oggetti = 1;
        $analisi->id_evento = $evento->ID;
        //$analisi->id_evento = 62;

        $id_cromodinamica = $materiale["id_cromodinamica"];

        if($id_cromodinamica!=null){
            $cromodinamica = SostanzeCromodinamica::where('ID',$id_cromodinamica)->first();
            $id_cromodinamica2 = $this->filtraIdCromodinamica($studi,$studiplus,$cromodinamica);
            $analisi->id_cromodinamica = $id_cromodinamica2;
        }
      }else{
        $analisi->id_materiale = $materiale->ID;
        $analisi->id_pg = $idpg;
        $analisi->data = date("Y-m-d");
        $analisi->oggetti = 1;
        $analisi->id_evento = $evento->ID;
        $analisi->id_cromodinamica = 17;
      }

      $analisi->save();

    }



    //  Session::flash('message', count($eventi).' - '.$dataEvento );
      //refresh della pagina
      //return Redirect::to('sintesi#pills-analisi');
      return Redirect::to('sintesi')->withInput(['tab'=>'pills-analisi']);;
  }

  public function estrai(){
    $errore = '';
    $eventi = Evento::where('tipo','EVENTO LIVE')->Orderby('ID','Desc')->take(2)->get();
    $evento = $eventi[0];
		$dataEvento  = $evento->Data;
		if($dataEvento >= date("Y-m-d")){
      $evento = $eventi[1];
		}
    $materiale_estratti = Input::get('materiale_estratti');
    //$qta_estratti = Input::get('qta_estratti');

    $group=Auth::user()->usergroup;
    if ( $group!= 7) {
      $idpg = Session::get('idpg');
      $PG = PG::find($idpg);
    }else{
      $idpg = 0;
    }

    $lab = Input::get('selectLabEstratti');
    $fazione = Fazione::find($lab);
    $statoLab = $fazione->StatoLab()->first();
    if($fazione->ID != 3){
      $nomeLab = $fazione->Fazione;
    }else{
      $nomeLab = 'Ospitale';
    }
    if($statoLab->ID == 5){
        $errore = $errore.' Il Laboratorio '.$nomeLab.' è Distrutto. Non è possibile utilizzarlo per una sintesi.';
    }

    $materiale = Materiale::where('nome','=',$materiale_estratti)->first();
    if(!$materiale){
        $errore = 'Materiale non riconosciuto: '.$materiale_estratti;
    }

    if (strlen($errore) > 0){
      //Session::flash('message', $errore);
        Session::flash('message', $errore);
    }else{
        $estrazione = new SintesiEstratti();
        $estrazione->id_laboratorio = $lab;
        $tiroFallimento = rand(0,99);
        $sogliaFallimento = 100 - $statoLab->Fallimento;
        if($tiroFallimento < $sogliaFallimento){

          $estrazione->id_materiale = $materiale->ID;
          $estrazione->id_pg = $idpg;
          $estrazione->oggetti = 1;
          $estrazione->id_evento = $evento->ID;
          $estrazione->data = date("Y-m-d");

          $estratto = $materiale->Estratto()->first();
          if($estratto){
            $estrazione->id_estratto = $estratto->ID;
          }
        }else{
          $estrazione->id_materiale = $materiale->ID;
          $estrazione->id_pg = $idpg;
          $estrazione->oggetti = 1;
          $estrazione->id_evento = $evento->ID;
          $estrazione->data = date("Y-m-d");
        }

        $estrazione->save();

      }


    //refresh della pagina
    //return Redirect::to('sintesi')
    return Redirect::to('sintesi')->withInput(['tab'=>'pills-estratti']);;
  }

  public function verificaCura(){
    $evento = Evento::Orderby('ID','Desc')->first();
    $dataEvento  = $evento->Data;
    if($dataEvento >= date("Y-m-d")){
      $idEvento = $evento->ID -1;
      $evento = Evento::where('ID',$idEvento)->first();
    }

    $esitoCura=array();
    $cd_materiale = null;
    $cd_matrice = null;
    $cd_malattia = null;
    $malattia = null;

    $esito = 'fail';
    $effetto = 'nessuno';

    $id_pg_malato = Input::get('pg_malati');
    $pg_malato = PG::find($id_pg_malato);
    if($pg_malato){
      $malattia = $pg_malato->Malattie()->first()->MalattiaObj()->first();
      $cd_malattia = $malattia->Cromodinamica()->first();
    }

    $evPG = EventiPG::where('PG',	$id_pg_malato)->where('Evento',$evento->ID)->first();

    $id_materiale = Input::get('MaterialeCura');
    $materiale = Materiale::find($id_materiale);
    if($materiale){
      $cd_materiale = $materiale->cd()->first();
    }

    $rosse = Input::get('Rosse');
    $verdi = Input::get('Verdi');
    $blu = Input::get('Blu');

    $cd_matrice = $this->cromodinamicaMatrice($rosse,$verdi,$blu);

    $cd_cura = $this->somma_cromodinamica($cd_materiale["ID"],$cd_matrice["ID"]);

    $cd_esito = $this->somma_cromodinamica($cd_cura["ID"],$cd_malattia["ID"]);

    if($cd_esito["ID"]==14){
      $curaQry = $malattia->Cure()->where("Estratto",$materiale["Nome"]);
      $Cura = $curaQry->first();
      if($Cura){
        //Cura
        $esito = 'Cura';
        $effetto = $Cura['Effetti'];
        // segna la cura su gestione evento
        if($evPG){
          $evPG->Cura = 1;
          $evPG->Save();
        }
      }else{
        // pagliativo
        $Cura = Cura::where('Malattia',0)->first();
        $esito = 'Pagliativo';
        $effetto = $Cura['Effetti'];
        // segna pagliativo su gestione evento
        if($evPG){
          $evPG->Pagliativo = 1;
          $evPG->Save();
        }
      }
    }

    $esitoCura=array('esito'=>$esito,'effetto'=>$effetto);

    return Response::json($esitoCura);
  }

}
