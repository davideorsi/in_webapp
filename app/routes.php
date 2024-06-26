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
  Route::get('/front', 'HomeController@showFront');

	// route per le immagini della frontpage
	Route::get('images/ambientazione/{id}', function($id) {
		$filepath = storage_path() . '/images/ambientazione/' .$id;
		return Response::download($filepath);
	});
	Route::get('images/gallery/{id}/{nome}', function($id,$nome) {
		$filepath = storage_path() . '/images/gallery/' .$id.'/'.$nome;
		return Response::download($filepath);
	});
	Route::get('images/gallery/{id}', function($id) {
		$filepath = storage_path() . '/images/gallery/' .$id;
		return Response::download($filepath);
	});

	Route::get('images/regolamento/{id}', function($id) {
		$filepath = storage_path() . '/images/gallery/' .$id;
		return Response::download($filepath);
	});
	Route::get('images/front/{id}', function($id) {
		$filepath = storage_path() . '/images/front/' .$id;
		return Response::download($filepath);
	});

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
	Route::get('voce/{id}', 'VoceController@show_master');
	Route::get('voci/search','VoceController@search');
	Route::get('voci','VoceController@fulllist');
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
	Route::get('tomo_regole',function()
		{
			$regole=(File::get(storage_path('files/regole.markdown.txt')));
			return View::make('tomo_regole')->with('regole',$regole);
		});
	Route::get('tomo_abilita','AbilitaController@lista_completa_PG');

	Route::get('tomo_economia',function()
		{
			$economia=(File::get(storage_path('files/economia.markdown.txt')));
			return View::make('tomo_economia')->with('economia',$economia);
		});
	Route::get('istruzioni',function()
		{
			return View::make('informazioni');
		});


	// route per i Post di ambientazione
	Route::get('ambientazione','PostController@ambientazione');
	Route::get('mappa','PostController@mappa');
	Route::get('post/{cat}/{id}','PostController@show');
	Route::group(array('before'=>'master'), function() {
		Route::resource('admin/post', 'PostController',array('except' => array('show')));
	});

	// route per gli Incanti
	Route::get('incanto', 'IncantoController@index_PG');
	Route::get('incanto/{id}', 'IncantoController@showPG');
	Route::group(array('before'=>'master'), function() {
		Route::resource('admin/incanto', 'IncantoController');
		Route::get('admin/incanto/{id}/imparabile', 'IncantoController@imparabile');
	});

	// route per le Licenze

	Route::get('licenza', 'LicenzaController@lista');
	Route::get('licenza/{id}', 'LicenzaController@showpg');
	Route::group(array('before'=>'master'), function() {
		Route::resource('admin/licenza', 'LicenzaController');
		Route::put('admin/licenza-pg', 'LicenzaController@add_licenza');
		Route::put('admin/licenza-pg-scaduta', 'LicenzaController@scade_licenza');
		Route::put('admin/rinnova-licenza-pg', 'LicenzaController@rinnova_licenza');
	});

	// route per la Medicina, le cicatrici, le malattie etc.
		Route::post('admin/malattie/aggiornaMalati','MalattiaController@aggiornaMalati');
		Route::get('admin/malattie/stampaMalati','MalattiaController@stampaMalati');
		Route::get('admin/malattie/verificaCura','SintesiController@verificaCura');
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

		  Route::get('admin/malattie/parametri/show','MalattiaController@showParametri');
		  Route::put('admin/malattie/parametri/edit/{id}','MalattiaController@aggiornaParametri');
	});

	// route per le Abilita
	Route::get('abilita', 'AbilitaController@index_PG');
	Route::get('abilita/{id}', 'AbilitaController@showPG');
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

	/*
	Route::get('/podcast', function() {return File::get(public_path() . '/podcastfolder/index.html');});
	Route::get('/podcast/podcast.rss', function() {return File::get(public_path() . '/podcastfolder/podcast.rss');});
	Route::get('/podcast/thumb.jpg', function() {return File::get(public_path() . '/podcastfolder/thumb.jpg');});
	Route::get('/podcast/Capitolo%200%20-%20Introduzione.mp3', function() {return File::get(public_path() . '/podcastfolder/Capitolo%200%20-%20Introduzione.mp3');});
	Route::get('/podcast/Capitolo%201%20-%20Assi%20nella%20Manica.mp3', function() {return File::get(public_path() . '/podcastfolder/Capitolo%201%20-%20Assi%20nella%20Manica.mp3');});
	Route::get('/podcast/Capitolo%202%20-%20Il%20primo%20maggiordomo.mp3', function() {return File::get(public_path() . '/podcastfolder/Capitolo%202%20-%20Il%20primo%20maggiordomo.mp3');});
	*/

	// route per Rotte commerciali
	Route::group(array('before'=>'master'), function() {
		Route::put('admin/rotte/genera',  array('uses' => 'RotteController@genera'));
		//Route::put('admin/rotte/rigenera/{id}',  array('uses' => 'RotteController@rigenera'));
		Route::get('admin/rotte/rigenera/{id_pg}',  array('uses' => 'RotteController@rigenera'));
		Route::get('admin/rotte/{id_pg}/{id_evento}',  array('uses' => 'RotteController@show'));
		//Route::get('admin/rotte/{id}/modifica',  array('uses' => 'RotteController@modifica'));
		Route::put('admin/rotte/modifica/{id_pg}',  array('uses' => 'RotteController@modifica'));
		Route::resource('admin/rotte', 'RotteController',array('except' => array('update','create','store','destroy')));
	});

	Route::group(array('before'=>'Rotte_Commerciali'), function() {
		Route::resource('rotte', 'RotteController',array('except' => array('update','edit','create','store','destroy')));
		Route::put('rotte',  array('uses' => 'RotteController@update'));
	});

	// route per Sintesi
	Route::group(array('before'=>'master'), function() {
		Route::put('admin/sintesi/sintetizza',  array('uses' => 'SintesiController@sintesi'));
		Route::put('admin/sintesi/analizza',  array('uses' => 'SintesiController@analisi'));
		Route::put('admin/sintesi/estrai',  array('uses' => 'SintesiController@estrai'));
		Route::get('admin/sintesi/search',  array('uses' => 'SintesiController@search'));
		Route::get('admin/sostanze/search',  array('uses' => 'SostanzeController@search'));
		Route::get('admin/sostanze/create',  array('uses' => 'SostanzeController@create'));
		Route::get('admin/sostanze/cromodinamica/{id_cd}',  array('uses' => 'SostanzeController@get_cromodinamica'));
		Route::put('admin/sostanze/matrice/{id_cd}/{dil}',  array('uses' => 'SostanzeController@get_matrice'));
		Route::post('admin/sostanze/update',  array('uses' => 'SostanzeController@update'));
		Route::post('admin/sostanze/store',  array('uses' => 'SostanzeController@store'));
		Route::put('admin/sostanze/materiale/{id_sos}',  array('uses' => 'SostanzeController@add_mat'));
		Route::delete('admin/sostanze/materiale/{id_mat}/{id_sos}',  array('uses' => 'SostanzeController@del_mat'));
		Route::get('admin/materiali/search',  array('uses' => 'MaterialiController@search'));
		Route::get('admin/materiali/create',  array('uses' => 'MaterialiController@create'));
		Route::post('admin/materiali/update',  array('uses' => 'MaterialiController@update'));
		Route::post('admin/materiali/store',  array('uses' => 'MaterialiController@store'));;
		Route::resource('admin/sintesi', 'SintesiController',array('except' => array('update','create','store')));
		Route::resource('admin/sostanze', 'SostanzeController',array('except' => array('update','create','store')));
		Route::resource('admin/materiali', 'MaterialiController',array('except' => array('update','create','store')));

	});
		Route::group(array('before'=>'Erboristeria'), function() {
			Route::put('sintesi/sintetizza',  array('uses' => 'SintesiController@sintesi'));
			Route::put('sintesi/analizza',  array('uses' => 'SintesiController@analisi'));
			Route::put('sintesi/estrai',  array('uses' => 'SintesiController@estrai'));
			Route::resource('sintesi', 'SintesiController',array('except' => array('update','create','store')));
		});



	// route per la landing page
	Route::get('gallery/{id}','GalleryController@show');
	Route::get('ambientazione/notabili/{id}','FamosoController@frontShow');
	Route::get('ambientazione/notabili','FamosoController@frontGallery');
	Route::get('ambientazione/cronache','CronacheController@show');
	Route::get('ambientazione/ducato','AmbientazioneController@showDucato');
	Route::get('ambientazione/nottingham','AmbientazioneController@showNottingham');
	Route::get('ambientazione/rochelle','AmbientazioneController@showRochelle');
	Route::get('faq','FaqController@show');
