<?php

class SchedulerController extends \BaseController {

	public function index()
	{
		$eventi = Evento::orderBy('ID', 'desc')->get(array('ID','Tipo','Titolo'));

		$selectEventi = array();
		foreach($eventi as $evento) {
			$selectEventi[$evento->ID] = $evento->Tipo .'-'. $evento->Titolo;
		}
		// load the view and pass the nerds
		return View::make('scheduler.index')
			->with('selectEventi', $selectEventi);
	}


}


