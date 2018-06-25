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
				<h3>Pergamena Magica</h3>
			</header>

			<p class='justified'>
				Questa pergamena ha in sé il potere di un incanto. Chiunque senza alcuna abilità può strapparla e recitare la seguente formula:
			</p>

			<h4>
				{{$incanto['Formula']}}
			</h4>

			<p class='justified'>
				... e lanciare l'incanto relativo
			</p>
			
			<footer>
				<b>{{$incanto['Nome']}}</b><br>
				<i>Formula: </i>{{$incanto['Formula']}}<br>
				<i>Note: </i>{{$incanto['Descrizione']}}<br>
				<i>Livello: </i>{{$incanto['Livello']}}<br>
				<br>
				Questa pergamena NON può essere utilizzata per apprendere l'incanto
			</footer>
		</article>
		
			@if (!($i%2))
				<div style='clear:both'></div>
			@endif
		@endfor

	</div>
	
</body>
</html>	
