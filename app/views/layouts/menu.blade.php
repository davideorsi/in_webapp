<!--Navigation menu-->
<?php  
	$idpg = Session::get('idpg');
	if ($idpg) {
		$abilita_del_PG=PG::find($idpg)->Abilita()->get();
		$lista=INtools::select_column($abilita_del_PG,'Ability');			
		$scrivere=in_array('Scrivere',$lista)|in_array('Leggere e scrivere',$lista);
		$mercante_arte=in_array("Appassionato d'Arte",$lista);
		$rotte_commerciali = in_array('Rotte commerciali locali',$lista);
        $mercante = $mercante_arte|$rotte_commerciali;
	} else {
		$scrivere=false;
		 $rotte_commerciali=false;
        $mercante_arte=false;
        $mercante = false;
	}
?>

<nav class="navbar navbar-inverse navbar-fixed-top titlebar" role="navigation">
<div>
<div class="container-fluid centerbar">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
		<a class="navbar-brand" href="{{ URL::to('/') }}">
		  <!--Intempesta Noctis<br><small class='subtitle'>Gioco di Ruolo dal Vivo</small>-->
		  {{ HTML::image('img/logo.png','Logo',array('style'=>'margin: -10px 0px 0px -40px; width: 210px;', 'class'=>'visible-xs-inline'))}}
		  {{ HTML::image('img/logo.png','Logo',array('style'=>'margin: -10px 0px 0px -40px; width: 210px;', 'class'=>'hidden-xs'))}}
		</a>
    </div>
    <div class="navbar-collapse collapse" >
		<ul class="nav navbar-nav">

			
			<!--############# HOME & GENERALE ########################-->

			<li class='dropdown'>
				<a  href="#" class="dropdown-toggle" data-toggle="dropdown">
					<span class='glyphicon glyphicon-home'></span>
					<div class='visible-xs-inline'>Il Gioco</div>
					<span class="caret">
					<h6 class='hidden-xs didascalia'>Il Gioco</h6>
				</span></a>
				<ul class="dropdown-menu" role="menu">
					<li ><a href="{{ URL::to('/') }}"><small>Home</small></a></li>
					<li ><a href="{{ URL::to('/istruzioni') }}"><small>Come Iniziare</small></a></li>
					<li ><a href="{{ URL::to('/ambientazione') }}"><small>Ambientazione</small></a></li>
					<li ><a href="{{ URL::to('/licenza') }}"><small>Licenze Commerciali</small></a></li>
					<li ><a href="{{ URL::to('/famoso') }}"><small>Notabili del Ducato</small></a></li>
					<li ><a href="{{ URL::to('/regolamento') }}"><small>Regolamento</small></a></li>
					<li ><a href="{{ URL::to('/domanda') }}"><small>Domande Frequenti</small></a></li>
					<li ><a href="{{ URL::to('/errata') }}"><small>Errata Corrige</small></a></li>
				</ul>
			</li>
			



			<!--############# ADMIN / ACCOUNT ########################-->
			
			@if (Auth::check())
				@if (Auth::user()->usergroup == 7)
					<li class='dropdown'>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span class='glyphicon glyphicon-info-sign'></span>
							<div class='visible-xs-inline'>Iscrizioni</div>
							<span class="caret"></span>
							<h6 class='hidden-xs didascalia'>Iscrizioni</h6>
						</a>
						
						<ul class="dropdown-menu" role="menu">
						<li><a href="{{ URL::to('admin') }}"><small>Gestione</small></a></li>
						<li><a href="{{ URL::to('mail') }}"><small>Invia Mail</small></a></li>
						<li><a href="{{ URL::to('admin/px') }}"><small>Aggiungi Px</small></a></li>
						<li><a href="{{ URL::to('admin/medicina') }}"><small>Cicatrici e Cibo</small></a></li>
						</ul>
					</li>
					<li class='dropdown'>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span class='glyphicon glyphicon-tags'></span>
							<div class='visible-xs-inline'>Account</div>
							<span class="caret"></span>
							<h6 class='hidden-xs didascalia'>Account</h6>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li ><a href="{{ URL::to('info') }}"><small>I tuoi dati</small></a></li>
							<li ><a href="{{ URL::to('admin/invito') }}"><small>Invito</small></a></li>
							<li ><a href="{{ URL::to('users') }}"><small>Utenti</small></a></li>
						</ul>
				</li>
				@else
					<li class='dropdown'>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span class='glyphicon glyphicon-info-sign'></span>
							<div class='visible-xs-inline'>Account</div>
							<span class="caret"></span>
							<h6 class='hidden-xs didascalia'>Account</h6>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li ><a href="{{ URL::to('info') }}"><small>I tuoi dati</small></a></li>
							@if ($idpg) 
							<li ><a href="{{ URL::to('account') }}"><small>Iscrizione</small></a></li>
							<li ><a href="{{ URL::to('pg') }}"><small>Il tuo PG</small></a></li>
							<li ><a href="{{ URL::to('pg/info') }}"><small>Info Speciali</small></a></li>
							@endif
						</ul>
				</li>
				@endif		
			@endif


			<!--############# MISSIVE ########################-->
			@if (Auth::check())
				@if ($idpg | Auth::user()->usergroup == 7) 
				<li class='dropdown'>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class='glyphicon glyphicon-envelope'></span>
						<div class='visible-xs-inline'>Missive</div>
						<span class="caret"></span>
						<h6 class='hidden-xs didascalia'>Missive</h6>
					</a>
					<ul class="dropdown-menu" role="menu">
						
						<li ><a href="{{ URL::to('missive') }}"><small>Cerca</small></a></li>

                        @if (Auth::user()->usergroup == 7)
						<li ><a href="{{ URL::to('missive/create') }}"><small>Invia</small></a></li>
                        <li><a href="{{ URL::to('admin/intercettate/') }}"><small>Intercettate</small></a></li>
                        @else
	                        @if (!app('blocca_missive'))

									@if ($scrivere)
										<li ><a href="{{ URL::to('missive/create') }}"><small>Invia</small></a></li>
									@endif

							@endif
									
									
                        @endif
                    </ul>
				</li>
                @endif
			@endif


			<!--############# GESTIONE MASTER ########################-->
			
			@if (Auth::check())
			@if (Auth::user()->usergroup == 7)
				<li class='dropdown'>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class='glyphicon glyphicon-book'></span>
						<div class='visible-xs-inline'>Gestione</div>
						<span class="caret"></span>
						<h6 class='hidden-xs didascalia'>Gestione</h6>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li ><a href="{{ URL::to('admin/voce') }}"><small>Voci di Locanda</small></a></li>
						<li ><a href="{{ URL::to('admin/evento') }}"><small>Eventi</small></a></li>
                        <li><a href="{{ URL::to('admin/preziosi/') }}"><small>Mercato dei Preziosi</small></a></li>
                        <li><a href="{{ URL::to('admin/rotte/') }}"><small>Rotte Commerciali</small></a></li>
						<li ><a href="{{ URL::to('admin/licenza') }}"><small>Licenze Commerciali</small></a></li>
                        <li><a href="{{ URL::to('admin/debito/') }}"><small>Spese e Debiti</small></a></li>
                        <li><a href="{{ URL::to('admin/conto/') }}"><small>Banca Ducale</small></a></li>
						<li ><a href="{{ URL::to('admin/oggetti') }}"><small>Oggetti</small></a></li>
						<li ><a href="{{ URL::to('admin/economia') }}"><small>Economia</small></a></li>
						<li ><a href="{{ URL::to('admin/malattie') }}"><small>Malattie</small></a></li>
						<li ><a href="{{ URL::to('admin/informatori') }}"><small>Informatori</small></a></li>
						<li ><a href="{{ URL::to('admin/post') }}"><small>Ambientazione</small></a></li>
						<li ><a href="{{ URL::to('admin/domanda') }}"><small>Domande Frequenti</small></a></li>
						<li ><a href="{{ URL::to('admin/errata') }}"><small>Errata Corrige</small></a></li>
						<li ><a href="{{ URL::to('admin/famoso') }}"><small>PG Famosi</small></a></li>
						<li ><a href="{{ URL::to('admin/pozioni') }}"><small>Pozioni</small></a></li>
						<li ><a href="{{ URL::to('admin/incanto') }}"><small>Incanti</small></a></li>
						<li ><a href="{{ URL::to('admin/abilita') }}"><small>Abilità</small></a></li>
					</ul>
				</li>
				<li class='dropdown'><a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<span class='glyphicon glyphicon-user'></span>
					<div class='visible-xs-inline'>PG</div>
					<span class="caret"></span>
					<h6 class='hidden-xs didascalia'>PG</h6>
				</a>
					<ul class="dropdown-menu" role="menu">
						<li ><a href="{{ URL::to('admin/pg') }}"><small>PG</small></a></li>
						<li ><a href="{{ URL::to('admin/userpg') }}"><small>Utenti - PG</small></a></li>
						<li ><a href="{{ URL::to('admin/png') }}"><small>PNG</small></a></li>
					</ul>
					
				</li>
				<li class='dropdown'><a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<span class='glyphicon glyphicon-list-alt'></span>
					<div class='visible-xs-inline'>Trame</div>
					<span class="caret"></span>
					<h6 class='hidden-xs didascalia'>Trame</h6>
				</a>
					<ul class="dropdown-menu" role="menu">
						<li ><a href="{{ URL::to('scheduler') }}"><small>Ora per Ora</small></a></li>
						<li ><a href="{{ URL::to('trama') }}"><small>Trame</small></a></li>
						<li ><a href="{{ URL::to('vicenda') }}"><small>Vicende</small></a></li>
						<li ><a href="{{ URL::to('admin/png') }}"><small>PNG</small></a></li>
					</ul>
					
				</li>
			@else
				<li class='dropdown'>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class='glyphicon glyphicon-book'></span>
						<div class='visible-xs-inline'>Voci</div>
						<span class="caret"></span>
						<h6 class='hidden-xs didascalia'>Voci</h6>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li ><a href="{{ URL::to('voci') }}"><small>Elenco</small></a></li>
					</ul>
				</li>
			@endif
			
			@if ($mercante)
				<li class='dropdown'><a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<span class='glyphicon glyphicon-list-alt'></span>
					<div class='visible-xs-inline'>Mercato</div>
					<span class="caret"></span>
					<h6 class='hidden-xs didascalia'>Mercato</h6>
				</a>
					<ul class="dropdown-menu" role="menu">
						@if ($mercante_arte)
                        <li ><a href="{{ URL::to('preziosi') }}"><small>Mercato dei Preziosi</small></a></li>
                        @endif
                        @if ($rotte_commerciali)
                        <li ><a href="{{ URL::to('rotte') }}"><small>Rotte Commerciali</small></a></li>
                        @endif
					</ul>
				</li>
			@endif
			
			@if (Auth::user()->usergroup == 15) <!-- Aiuto Masters -->
				<li class='dropdown'><a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<span class='glyphicon glyphicon-user'></span>
					<div class='visible-xs-inline'>Master</div>
					<span class="caret"></span>
					<h6 class='hidden-xs didascalia'>Master</h6>
				</a>
					<ul class="dropdown-menu" role="menu">
						<li ><a href="{{ URL::to('png') }}"><small>PNG</small></a></li>
						<li ><a href="{{ URL::to('eventi') }}"><small>Trame</small></a></li>
						<li ><a href="{{ URL::to('admin/pozioni') }}"><small>Pozioni</small></a></li>
					</ul>
					
				</li>
			@endif
			@endif


			<!--############# LOGIN / LOGOUT ########################-->
			@if (Auth::check())
				<li >
					<a href="{{ URL::to('logout') }}">
					<span class='glyphicon glyphicon-log-out'></span>
					<div class='visible-xs-inline'>Logout</div>
					<h6 class='hidden-xs didascalia'>Logout</h6>
					</a>
				</li>
				
			@else
				<li >
					<a href="{{ URL::to('login') }}">
						<span class='glyphicon glyphicon-log-in'></span>
						<div class='visible-xs-inline'>Accedi</div>
						<h6 class='hidden-xs didascalia'>Accedi</h6>
					</a>
				</li>
			@endif
			
		</ul>
	</div>
</div>
</div>
</nav>
