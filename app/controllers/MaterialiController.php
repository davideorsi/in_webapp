<?php

class MaterialiController extends \BaseController {
  public function search(){

    $cromodinamica = Input::get('CD');
    $RL = Input::get('RL');
    $RO = Input::get('RO');
    $RN = Input::get('RN');
    $nome = Input::get('nome');
    $categoria = Input::get('categoria');
    $stagione = Input::get('stagione');
    $valore = Input::get('valore');
    $quanita = Input::get('quantita');
    $cancellata = Input::get('cancellate');

    $condizione='';
    $params=array();

    if (!empty($cancellata)&&$cancellata=1) {
        //$params[]=1;
        $matQuery = Materiale::with('Estratto','cat','cd','rl','ro','rn')->where('cancellata',1);
    }else{
        //$params[]=0;
        $matQuery = Materiale::with('Estratto','cat','cd','rl','ro','rn')->where('cancellata',0);
    }
    //$condizione.="(`cancellata` = ?)";


    if (!empty($cromodinamica)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$cromodinamica;
        //$condizione.="(`id_cromodinamica` = ?)";

        $matQuery->where('id_cromodinamica',$cromodinamica);
    }

    if (!empty($RL)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$RL;
        //$condizione.="(`RaritàLoc` = ?)";

        $matQuery->where('RaritàLoc',$RL);
    }

    if (!empty($RO)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$RO;
        //$condizione.="(`RaritaOM` = ?)";

          $matQuery->where('RaritaOM',$RO);
    }

    if (!empty($RN)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$RN;
        //$condizione.="(`RaritaMN` = ?)";

        $matQuery->where('RaritMN',$MN);
    }

    if (!empty($nome)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$nome;
        //$condizione.='(Nome like "%?%")'

        $matQuery->where('Nome','like', '%'.$nome.'%');;
    }

    if (!empty($categoria)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$categoria;
        //$condizione.="(`Categoria` = ?)";

        $matQuery->where('Categoria',$categoria);;
    }

    if (!empty($stagione)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$stagione;
        //$condizione.="(`Stagione` = ?)";

        $matQuery->where('Stagione',$stagione);;
    }

    if (!empty($valore)) {
        //if ($condizione) {$condizione.=" AND ";}
        ///$params[]=$valore;
        //$condizione.="(`ValoreBase` = ?)";

        $matQuery->where('ValoreBase',$valore);;
    }

    if (!empty($quantita)) {
        //if ($condizione) {$condizione.=" AND ";}
        //$params[]=$quantita;
        // $condizione.="(`Quantita` = ?)";

        $matQuery->where('Quantita',$quantita);;
    }
/*
      if (!empty($condizione)) {
            $materiali = Materiale::with('Estratto','cat','cd','rl','ro','rn')->whereRaw($condizione,$params)->orderBy('ID','asc')->paginate(10);

      }else{

            $materiali = Materiale::with('Estratto','cat','cd','rl','ro','rn')->orderBy('ID','asc')->paginate(10);
      }
    */
  $materiali = $matQuery->orderBy('ID','desc')->paginate(10);

    return Response::json($materiali);
  }

  public function index()
  {
     $selCD=array(0=>'');
     $selR=array(0=>'');
     $selCat=array(0=>'');
     $selStg=array(0=>'');

     $CD=SostanzeCromodinamica::get();
     foreach($CD as $c){
       $padre = $c->Padre->DESC;
       $selCD[$padre][$c->ID] = $c->DESC.' ('.$c->livello.')';
     }

     $Rarita=RaritaMateriale::get();
      foreach($Rarita as $r){
        $selR[$r->ID]=$r->Descrizione;
     }

     $Categorie=CategorieMateriali::get();
       foreach($Categorie as $cm){
       $selCat[$cm->ID]=$cm->Descrizione;
     }


      $selStg[1]='Inverno';
      $selStg[2]='Primavera';
      $selStg[3]='Estate';
      $selStg[4]='Autunno';
      $selStg[5]='Nessuna';

    $materiali = Materiale::with('Estratto','cat','cd','rl','ro','rn')->orderBy('ID','asc')->paginate(10);

    return View::make('materiali.index')->with('materiali', $materiali)
      ->with('selCD', $selCD)
      ->with('selRL', $selR)
      ->with('selRO', $selR)
      ->with('selRN', $selR)
      ->with('selCat', $selCat)
      ->with('selStg', $selStg);

  }

  public function destroy($id){
    $materiale = Materiale::find($id);

    //$sostanza -> delete();
    $materiale->cancellata = 1;
    $materiale->save();

    Session::flash('message', 'Materiale cancellato correttamente!');
    return Redirect::to('admin/materiali');
  }

  public function show($id)
  {
    $materiali=Materiale::find($id);

    //if ($pubblica){
        if (Request::ajax()){
          return Response::json($materiali);
        }
    //}
  }

  public function edit($id){
     $materiali=Materiale::find($id);

     $selCD=array(0=>'');
     $selR=array(0=>'');
     $selCat=array(0=>'');
     $selStg=array(0=>'');

     $CD=SostanzeCromodinamica::get();
     foreach($CD as $c){
       $padre = $c->Padre->DESC;
       $selCD[$padre][$c->ID] = $c->DESC.' ('.$c->livello.')';
     }
     $Rarita=RaritaMateriale::get();
      foreach($Rarita as $r){
        $selR[$r->ID]=$r->Descrizione;
     }
     $Categorie=CategorieMateriali::get();
       foreach($Categorie as $cm){
       $selCat[$cm->ID]=$cm->Descrizione;
     }



      $selStg[1]='Inverno';
      $selStg[2]='Primavera';
      $selStg[3]='Estate';
      $selStg[4]='Autunno';
      $selStg[5]='Nessuna';


     return View::make('materiali.edit')
       ->with('materiale', $materiali)
       ->with('selCD', $selCD)
       ->with('selR', $selR)
      // ->with('selRO', $selR)
       //->with('selRN', $selR)
       ->with('selCat', $selCat)
       ->with('selStg', $selStg)
       ->with('edit', true);
  }

  public function update(){
       $id = Input::get('ID');
       $materiale=Materiale::find($id);
       $cromodinamica = Input::get('cromodinamica');
       $RL = Input::get('RL');
       $RO = Input::get('RO');
       $RN = Input::get('RN');
       $nome = Input::get('Nome');
       $categoria = Input::get('categoria');
       $stagione = Input::get('stagione');
       $valore = Input::get('valore');
       $quantita = Input::get('quantita');

       if(empty($nome)||empty($categoria)||empty($cromodinamica)||empty($stagione)||empty($RL)||empty($RO)||empty($RN)||empty($valore)||empty($quantita)){
         Session::flash('message', 'campi minimi non compilati');

       }else{
         $mat_search = Materiale::where('Nome',$nome)->first();

         if($mat_search->ID != $materiale->ID){
           Session::flash('message', 'Il Materiale '.$nome.' esiste già!');

         }else{
           $materiale->nome = $nome;
           $materiale->RaritàLoc = $RL;
           $materiale->RaritaOM = $RO;
           $materiale->RaritaMN = $RN;
           $materiale->id_cromodinamica = $cromodinamica;
           $materiale->Categoria = $categoria;
           $materiale->Stagione = $stagione;
           $materiale->ValoreBase = $valore;
           $materiale->Quantita = $quantita;
           $materiale->save();

           Session::flash('message', 'Materiale "'.$nome.'" aggiornato con successo!');
         }
       }

       return Redirect::to('admin/materiali');
  }

  public function create(){
    $materiali= new Materiale();

    $selCD=array(0=>'');
    $selR=array(0=>'');
    $selCat=array(0=>'');
    $selStg=array(0=>'');

    $CD=SostanzeCromodinamica::get();
    foreach($CD as $c){
      $padre = $c->Padre->DESC;
      $selCD[$padre][$c->ID] = $c->DESC.' ('.$c->livello.')';
    }
    $Rarita=RaritaMateriale::get();
     foreach($Rarita as $r){
       $selR[$r->ID]=$r->Descrizione;
    }
    $Categorie=CategorieMateriali::get();
      foreach($Categorie as $cm){
      $selCat[$cm->ID]=$cm->Descrizione;
    }

     $selStg[1]='Inverno';
     $selStg[2]='Primavera';
     $selStg[3]='Estate';
     $selStg[4]='Autunno';
     $selStg[5]='Nessuna';


    return View::make('materiali.edit')
      ->with('materiale', $materiali)
      ->with('selCD', $selCD)
      ->with('selR', $selR)
     // ->with('selRO', $selR)
      //->with('selRN', $selR)
      ->with('selCat', $selCat)
      ->with('selStg', $selStg)
      ->with('edit', false);

  }

  public function store(){

    $materiale= new Materiale();
    $cd = Input::get('cromodinamica');
    $RL = Input::get('RL');
    $RO = Input::get('RO');
    $RN = Input::get('RN');
    $nome = Input::get('Nome');
    $categoria = Input::get('categoria');
    $stagione = Input::get('stagione');
    $valore = Input::get('valore');
    $quantita = Input::get('quantita');

    if(empty($nome)||empty($categoria)||empty($cd)||empty($stagione)||empty($RL)||empty($RO)||empty($RN)||empty($valore)||empty($quantita)){
      Session::flash('message', 'campi minimi non compilati');

      return Redirect::to('/admin/materiali/create');
    }else{
      $mat_search = Materiale::where('Nome',$nome)->first();
      if($mat_search){
        Session::flash('message', 'Il Materiale '.$nome.' esiste già!');
        return Redirect::to('/admin/materiali/create');
      }else{
        $materiale->nome = $nome;
        $materiale->RaritàLoc = $RL;
        $materiale->RaritaOM = $RO;
        $materiale->RaritaMN = $RN;
        $materiale->id_cromodinamica = $cd;
        $materiale->Categoria = $categoria;
        $materiale->Stagione = $stagione;
        $materiale->ValoreBase = $valore;
        $materiale->Quantita = $quantita;
        $materiale->save();
      }

      Session::flash('message','Materiale '.$nome.' creato con successo!');
      return Redirect::to('/admin/materiali/');

    }


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

  public function get_cromodinamica($id_cd){
    $cromodinamica = SostanzeCromodinamica::find($id_cd);


      return Response::json($cromodinamica);

  }


}
