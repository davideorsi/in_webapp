<?php

class SchedulerController extends \BaseController {

	public function index()
	{
		$eventi = Evento::orderBy('ID', 'desc')->get(array('ID','Tipo','Titolo'));

		$selectEventi = array();
		foreach($eventi as $evento) {
			$selectEventi[$evento->ID] = $evento->Tipo .'-'. $evento->Titolo;
		}
		
		
		$palette_png=array(
			'black',
			'red',
			'green',
			'blue'
		);
		
		$Masters = User::orderBy('ID','asc')->where('usergroup','=',7)->get();
		foreach ($Masters as $key2=>$Master){
			$Master['color'] = $palette_png[$key2];		
			$Master->PNG;
		}
		
		$selMaster=array();
		foreach ($Masters as $Master){
			$selMaster[(string)$Master->id] = $Master['username'];
		}
		
		// load the view and pass the nerds
		return View::make('scheduler.index')
			->with('Masters', $Masters)
			->with('selMaster',$selMaster)
			->with('selectEventi', $selectEventi);
	}


}


