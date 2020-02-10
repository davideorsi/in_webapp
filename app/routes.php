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
	Route::post('/mail', 'HomeController@sendMail')->before('master');
	Route::get('/mail',function () {
		return View::make('mail');
	});
	
	// route per le Voci di Locanda
	Route::get('voce','VoceController@show');
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/voce', 'VoceController',array('except' => array('show')));
		Route::get('admin/voce/{id}', 'VoceController@show_master');
	});
		
	// route per gli Eventi
	Route::get('evento/{id}','EventoController@show');
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/evento', 'EventoController');
		Route::get('admin/evento/{id}/list', 'EventoController@show_master');
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
		Route::get('admin/incanto/{id}/imparabile', 'IncantoController@imparabile');
	});

	// route per la Medicina, le cicatrici, le malattie etc.
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/medicina', 'MedicinaController');
		Route::resource('admin/malattie', 'MalattiaController');
		Route::get('admin/medicina/evento/{id}', 'MedicinaController@showCicatriciEvento');
	    Route::post('admin/medicina/evento',     'MedicinaController@setCicatriciEvento');
		Route::post('admin/malattie/nuovo_stadio','MalattiaController@nuovoStadio');
		Route::post('admin/malattie/nuova_cura','MalattiaController@nuovaCura');
		Route::put('admin/stadio/{id}','MalattiaController@aggiornaStadio');
		Route::delete('admin/stadio/{id}','MalattiaController@cancellaStadio');
		Route::put('admin/cura/{id}','MalattiaController@aggiornaCura');
		Route::delete('admin/cura/{id}','MalattiaController@cancellaCura');
		Route::post('admin/stadiopg','MalattiaController@aggiungiMalato');
		Route::delete('admin/stadiopg','MalattiaController@cancellaMalato');
	});
	
	// route per le Abilita
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/abilita', 'AbilitaController');
		Route::post('admin/abilita_opzione', 'AbilitaController@add_opzione');
		Route::delete('admin/abilita_opzione', 'AbilitaController@del_opzione');
		Route::post('admin/abilita_requisito', 'AbilitaController@add_requisito');
		Route::delete('admin/abilita_requisito', 'AbilitaController@del_requisito');
		Route::post('admin/abilita_esclusa', 'AbilitaController@add_esclusa');
		Route::delete('admin/abilita_esclusa', 'AbilitaController@del_esclusa');
	});

	// route per editare i collegamenti PG - USER
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/userpg', 'UserpgController',array('except' => array('create','show','edit','update')));
	});

	
	// route per editare i PG
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/pg', 'PgController');
		Route::get('admin/schede', 'PgController@schede');
		Route::get('admin/buste', 'PgController@buste');
		Route::get('admin/sanita', 'PgController@sanita');
		Route::put('admin/pg_categoria', 'PgController@add_categoria');
		Route::put('admin/pg_abilita', 'PgController@add_abilita');
		Route::put('admin/pg_sbloccate', 'PgController@add_sbloccate');
		Route::put('admin/pg_incanto', 'PgController@add_incanto');
		Route::put('admin/pg_id','PgController@add_firma');
		Route::delete('admin/pg_categoria', 'PgController@del_categoria');
		Route::delete('admin/pg_abilita', 'PgController@del_abilita');
		Route::delete('admin/pg_sbloccate', 'PgController@del_sbloccate');
		Route::delete('admin/pg_incanto', 'PgController@del_incanto');
		Route::delete('admin/pg_id', 'PgController@del_firma');
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
	
	
	Route::group(array('before'=>'aiutomaster'), function() { 
		Route::get('png/{id}', 'PngController@show');
		Route::get('png', 'PngController@png_list');
	});
	
	
	
	
	// route per le missive
	Route::group(array('before'=>'auth'), function() {
		Route::post('missive/{id}/{master}/aggiorna_master','MissivaController@aggiorna_master');
		Route::get('missive/search','MissivaController@search');
		Route::get('debito/{id}','MissivaController@debito');
		Route::resource('missive', 'MissivaController',array('except' => array('update','edit')));
	});	
	Route::group(array('before'=>'scrivere'), function() {
		Route::get('missive/{id}/rispondi','MissivaController@rispondi');
		Route::resource('missive', 'MissivaController',array('only' => array('create')));
	});
	
	// Missive Intercettate, spese delle missive, costi e spese dei PG
    Route::group(array('before'=>'master'), function() {
		Route::get('missive/{id}/inoltra','MissivaController@Inoltra');
        Route::get('admin/intercettate/','MissivaController@intercettate');
        Route::post('admin/intercettate/','MissivaController@inoltra_intercettate');
        Route::post('missive/{id}/toggle','MissivaController@toggle_rispondere');
        Route::post('admin/debito/{id}/{alla_banca?}','BancaController@azzera_debito');
        Route::post('admin/spesa/{id}/{alla_banca?}','BancaController@azzera_spesa');
        Route::post('admin/spesa','BancaController@store_spesa');
        Route::get('admin/debito/','BancaController@debiti_e_spese');
        Route::post('admin/conto/','BancaController@store_conto');
        Route::post('admin/conto/{id}','BancaController@azzera_conto');
        Route::get('admin/conto/','BancaController@index');
        Route::get('admin/conto/{id}','BancaController@show');
        Route::put('admin/conto/{id}','BancaController@update_conto');
        Route::post('admin/interessi/{id}','BancaController@update_interessi');
    });

	Route::group(array('before'=>'aiutomaster'), function() {
        Route::get('admin/pozioni/','PozioniController@index');
        Route::get('admin/infopozioni/','PozioniController@info');
        Route::get('admin/pozioni/{id}/stampa','PozioniController@stampa');
        Route::get('admin/pozioni/{id}/etichetta','PozioniController@etichetta');
        Route::get('admin/ricetta/','PozioniController@ricetta');
    });
    
    
	Route::group(array('before'=>'master'), function() {
        Route::get('admin/economia/','EconomiaController@index');
        Route::put('admin/economia/','EconomiaController@update');
    });

	########## Trame ###############################
	Route::group(array('before'=>'master'), function() {    
		Route::resource('trama', 'TramasController');
		Route::resource('vicenda', 'VicendasController');
		Route::resource('elemento', 'ElementosController');
		
        Route::get('scheduler/','SchedulerController@index');
        Route::get('vicende/{id}','VicendasController@show_all');
        Route::get('vicende/{id}/master/{num?}','VicendasController@show_all_master');
        Route::get('evento_info/{id}','EventoController@show_info');
		Route::post('elemento/{id}', 'ElementosController@update_time');
		Route::post('elemento_png/{id}', 'ElementosController@add_png');
		Route::post('elemento_png_remove/{id}', 'ElementosController@remove_png');
		Route::post('elemento_png_minor/{id}', 'ElementosController@add_png_minor');
		Route::post('elemento_png_minor_remove/{id}', 'ElementosController@remove_png_minor');
    });
    
    
	Route::group(array('before'=>'aiutomaster'), function() {    
        Route::get('eventi/','VicendasController@eventi_aiutomaster');
        Route::get('vicende/{id}/master/{num?}','VicendasController@show_all_master');
    });
      
	########## Trame ###############################
	Route::group(array('before'=>'master'), function() {    
        Route::get('admin/oggetti','OggettiController@index');
        Route::post('admin/oggetti/stampa','OggettiController@stampa');
	});
	
	
	// route per il mercato dei Prezioni
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/preziosi', 'PreziosiController',array('except' => array('update','edit')));
		Route::put('admin/preziosi/{id}/vendita/{acquirenti?}/{prezzo_acquisto?}','PreziosiController@vendita');
		Route::put('admin/preziosi/vendita_random','PreziosiController@vendita_random');
		Route::put('admin/preziosi/risolvi_aste','PreziosiController@risolvi_aste');
	});
	Route::group(array('before'=>'mercante_arte'), function() { 
		Route::resource('preziosi', 'PreziosiController',array('except' => array('update','edit','create','store')));
		Route::post('preziosi/{id}/offerta/{importo}','PreziosiController@fai_offerta');
		Route::delete('preziosi/{id}/rimuovi_offerta','PreziosiController@rimuovi_offerta');
	});
	
	// route per le Domande Frequenti
	Route::get('domanda/{id}','DomandaController@show');
	Route::get('domanda','DomandaController@lista');
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/domanda', 'DomandaController',array('except' => array('show')));
		Route::get('admin/domanda/{id}', 'DomandaController@show_master');
	});
	
	// route per le Errata Corrige
	Route::get('errata/{id}','ErrataController@show');
	Route::get('errata','ErrataController@lista');
	Route::group(array('before'=>'master'), function() { 
		Route::resource('admin/errata', 'ErrataController',array('except' => array('show')));
		Route::get('admin/errata/{id}', 'ErrataController@show_master');
	});


	// UTENTI ###########################################################
	Route::get('registrazione/{chiave}',  array('uses' => 'UserController@register_form'));
	Route::post('registrazione/{chiave}',  array('uses' => 'UserController@register_user'));
	Route::controller('password', 'RemindersController');
	Route::group(array('before'=>'master'), function() { 	
		Route::get('users',  'UserController@index');
		Route::delete('users/{id}',  'UserController@delete');
		Route::resource('admin/invito', 'InvitoController',array('except' => array('create','show','edit')));
	});
	
