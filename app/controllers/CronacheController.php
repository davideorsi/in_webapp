<?php

class CronacheController extends \BaseController {

  public function show()
	{
		// mostra solo le famosi che non sono bozze

		$anni = Post::Where('tag','=','anno')->get();

		return View::make('frontpage.ambientazione.cronache')->with('anni', $anni);


	}



}
