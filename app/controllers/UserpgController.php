<?php

class UserpgController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$Users=User::all();

		$selUser=array();
		$freeUser=array();
		$PGusati=array();
		foreach ($Users as $user){
			$PG=$user->PG->first();
			if ($PG) {
				$selUser[]=array(
					'id'=>$user['id'], 
					'nome'=>$user['username'],
					'nomepg'=>$PG['Nome'],
					'idpg'=>$PG['ID']);
				$PGusati[]=$PG['ID'];
			} else {
				$freeUser[$user['id']]=$user['username'];
			}
		}

		$Vivi=PG::orderBy('Nome','asc')->whereRaw('`Morto` = 0 AND `InLimbo` = 0')->get();

		$selVivi=array();
		foreach ($Vivi as $vivo){
			if (!in_array($vivo->ID,$PGusati)) {
				$selVivi[(string)$vivo->ID] = $vivo['Nome'].' ('.$vivo['NomeGiocatore'].')';
			}
		}
		
		return View::make('userpg.index')
					->with('selUser',$selUser)
					->with('freeUser',$freeUser)
					->with('selVivi',$selVivi);
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$User= User::find(Input::get('User'));

		$User -> PG() ->attach(Input::get('PG'));
		Session::flash('message', 'Connessione aggiunta con successo!');
		return Redirect::to('admin/userpg');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$User= User::find($id);

		$User -> PG() ->detach(Input::get('PG'));
		Session::flash('message', 'Connessione rimossa con successo!');
		return Redirect::to('admin/userpg');
	}


}
