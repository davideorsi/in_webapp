<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="it"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title>Intempesta Noctis</title>
	<meta name="description" content="gioco di ruolo dal vivo">
	<meta name="author" content="Intempesta Noctis - Il Borgo e La Ruota">
	<meta property="og:title" content="Intempesta Noctis" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://intempestanoctis.boru.it" />
	<meta property="og:image" content="http://intempestanoctis.boru.it/thumb.jpg" />
	<meta property="og:description" content="Gioco di Ruolo dal Vivo nel Ducato di Parma di Inizio Ottocento" />
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSS
  ================================================== -->

	{{ HTML::style('css/IN.css');}}
	{{ HTML::style('css/cartellini.css');}}
	{{ HTML::style('css/bootstrap.min.css');}}
	{{ HTML::style('css/bootstrap-theme.min.css');}}

	<link href='http://fonts.googleapis.com/css?family=Italianno&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link rel="shortcut icon" href="favicon.ico">

</head>
<body>

	<div class='panel' style='page-break-after: always;'>
		@for ($i = 1; $i <= 4; $i++)
		<article class='pergamena'>
			<header>
				<h3>Licenza Commerciale</h3>
			</header>

			<h4>{{$licenza['Nome']}}</h4>


			<p>
				<b>Licenza commerciale assegnata a: </b>
				____________________________________<br>
				<b>Licenza stipulata il giorno:</b>
				__________________________________________<br>
				<b>Per la somma di:</b> 
				@if (strpos($licenza['Prezzo'],'asta')== false)
					{{$licenza['Prezzo'];}}________
				@else
				____________________________________			
				@endif
				<br>
			</p>
			
			<footer>
				<b>La licenza permette: </b>{{$licenza['Permette']}}<br>
				<b>Limitazioni: </b>{{$licenza['Limitazioni']}}<br>
				<i>Tassazione: </i>{{$licenza['Tassazione']}}<br>
				<i>Durata: </i>{{$licenza['Durata']}}<br>
				<br>
			</footer>
		</article>
		
			@if (!($i%2))
				<div style='clear:both'></div>
			@endif
		@endfor

	</div>
	
</body>
</html>	
