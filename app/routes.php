<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
	// route to the homepage
	Route::get('/', 'HomeController@showHome');
	
	// route to show the login form
	Route::get('login', array('uses' => 'HomeController@showLogin'));
	// route to process the form
	Route::post('login', array('uses' => 'HomeController@doLogin'));
	// route to log out	
	Route::get('logout', array('uses' => 'HomeController@doLogout'));

	// normal user profile e admin
	Route::get('account', 'UserController@showAccount')->before('auth');
	Route::put('account', 'UserController@updateAccount')->before('auth');
	Route::get('info', 'UserController@showInfo')->before('auth');
	Route::put('info', 'UserController@updateInfo')->before('auth');
	Route::delete('account', 'UserController@user_unsubscribe')->before('auth');
	Route::get('pg', 'UserController@showPg')->before('auth');
	Route::get('pg/info', 'UserController@showPginfo')->before('auth');
	Route::put('pg', 'UserController@updatePg')->before('auth');
	Route::get('admin', 'UserController@showAdmin')->before('master');
	Route::get('admin/px', 'UserController@showAdminPx')->before('master');
	Route::post('admin/px', 'UserController@updateAdminPx')->before('master');
	Route::post('admin', 'UserController@updateAccount')->before('master');
	Route::put('admin', 'UserController@updatePagato')->before('master');
	Route::delete('admin', 'UserController@unsuscribe')->before('master');
	
	// route per le Voci di Locanda
	Route::get('voce/{id}','VoceController@show');
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/voce', 'VoceController',array('except' => array('show')));
		Route::get('admin/voce/{id}', 'VoceController@show_master');
	});
		
	// route per gli Eventi
	Route::get('evento/{id}','EventoController@show');
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/evento', 'EventoController');
	});

	// route per gli Informatori	
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/informatori', 'InformatoriController');
	});

	// route per gli PG Famosi
	
	Route::get('famoso/','FamosoController@gallery');
	Route::get('famoso/{id}','FamosoController@show');
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/famoso', 'FamosoController');
	});
	Route::get('images/famoso/{id}', function($id) {
		$filepath = storage_path() . '/images/famoso/' . Famoso::find($id)->Foto;
		return Response::download($filepath);
	});

	// regolamento

	Route::get('regolamento',function()
		{
			return View::make('regolamento');
		});
	Route::get('istruzioni',function()
		{
			return View::make('informazioni');
		});

	
	// route per i Post di ambientazione
	Route::get('ambientazione','PostController@ambientazione');
	Route::get('post/{cat}/{id}','PostController@show');
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/post', 'PostController',array('except' => array('show')));
	});

	// route per gli Incanti
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/incanto', 'IncantoController');
	});
	
	// route per le Abilita
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/abilita', 'AbilitaController');
		Route::post('admin/abilita_opzione', 'AbilitaController@add_opzione');
		Route::delete('admin/abilita_opzione', 'AbilitaController@del_opzione');
	});

	// route per editare i collegamenti PG - USER
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/userpg', 'UserpgController',array('except' => array('create','show','edit','update')));
	});

	
	// route per editare i PG
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/pg', 'PgController');
		Route::get('admin/schede', 'PgController@schede');
		Route::put('admin/pg_categoria', 'PgController@add_categoria');
		Route::put('admin/pg_abilita', 'PgController@add_abilita');
		Route::put('admin/pg_sbloccate', 'PgController@add_sbloccate');
		Route::put('admin/pg_incanto', 'PgController@add_incanto');
		Route::delete('admin/pg_categoria', 'PgController@del_categoria');
		Route::delete('admin/pg_abilita', 'PgController@del_abilita');
		Route::delete('admin/pg_sbloccate', 'PgController@del_sbloccate');
		Route::delete('admin/pg_incanto', 'PgController@del_incanto');
	});

	// route per editare i PNG
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/png', 'PngController');
		Route::put('admin/png_categoria', 'PngController@add_categoria');
		Route::put('admin/png_abilita', 'PngController@add_abilita');
		Route::put('admin/png_incanto', 'PngController@add_incanto');
		Route::delete('admin/png_categoria', 'PngController@del_categoria');
		Route::delete('admin/png_abilita', 'PngController@del_abilita');
		Route::delete('admin/png_incanto', 'PngController@del_incanto');
	});
	
	// route per le missive
	Route::group(array('before'=>'auth'), function() {
		Route::get('missive/search','MissivaController@search');
		Route::get('debito/{id}','MissivaController@debito');
		Route::resource('missive', 'MissivaController',array('except' => array('update','edit')));
	});	

    Route::group(array('before'=>'master'), function() {
        Route::get('admin/debito/','MissivaController@debiti');
        Route::get('admin/intercettate/','MissivaController@intercettate');
        Route::post('missive/{id}/toggle','MissivaController@toggle_rispondere');
        Route::post('admin/debito/{id}','MissivaController@azzera_debito');
    });
