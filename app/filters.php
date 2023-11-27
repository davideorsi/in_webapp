<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	setlocale(LC_TIME, 'it_IT.utf8');
	
	App::singleton('prelive', function(){
        $prelive = true; #true in prelive, false nell'uso normale
        return $prelive; 
    });
	App::singleton('blocca_missive', function(){
        $blocca_missive = false; #true blocca le missive
        return $blocca_missive; 
    });
});


App::after(function($request, $response)
{
	
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});

Route::filter('master', function()
{
	if (Auth::guest()){
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	} else {
		if (Auth::user()->usergroup != 7) {
			return Response::make('Unauthorized', 401);
		}
	}
});

Route::filter('aiutomaster', function()
{
	if (Auth::guest()){
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	} else {
		if ((Auth::user()->usergroup != 7) & (Auth::user()->usergroup != 15) ) {
			return Response::make('Unauthorized', 401);
		}
	}
});

Route::filter('scrivere', function()
{
	if (Auth::guest()){
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	} else {
		$group=Auth::user()->usergroup;
		
		if ( $group!= 7) {
			$idpg = Session::get('idpg');
			$abilita_del_PG=PG::find($idpg)->Abilita()->get();

			$lista=INtools::select_column($abilita_del_PG,'Ability');			

			$leggere=in_array('Leggere',$lista)|in_array('Leggere e scrivere',$lista);
		} else {
			$leggere=true;
		}
			
		if (!$leggere) {
			return Response::make('Unauthorized', 401);
		}
	}
});



Route::filter('mercante_arte', function()
{
	if (Auth::guest()){
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	} else {
		$group=Auth::user()->usergroup;
		
		if ( $group!= 7) {
			$idpg = Session::get('idpg');
			$abilita_del_PG=PG::find($idpg)->Abilita()->get();

			$lista=INtools::select_column($abilita_del_PG,'Ability');			

			$mercante_arte=in_array("Appassionato d'Arte",$lista);
		} else {
			$mercante_arte=true;
		}
			
		if (!$mercante_arte) {
			return Response::make('Unauthorized', 401);
		}
	}
});

Route::filter('rotte_commerciali', function()
{
	if (Auth::guest()){
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	} else {
		$group=Auth::user()->usergroup;
		
		if ( $group!= 7) {
			$idpg = Session::get('idpg');
			$abilita_del_PG=PG::find($idpg)->Abilita()->get();

			$lista=INtools::select_column($abilita_del_PG,'Ability');			

			$rotte_commerciali=in_array("Rotte commerciali locali",$lista);
		} else {
			$rotte_commerciali=true;
		}
			
		if (!$rotte_commerciali) {
			return Response::make('Unauthorized', 401);
		}
	}
});

Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
