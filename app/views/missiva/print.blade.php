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

	{{ HTML::style('css/bootstrap.min.css');}}
	{{ HTML::style('css/bootstrap-theme.min.css');}}
	{{ HTML::style('css/missiva.css') }}
	{{ HTML::style('css/Italianno.css');}}

	<link href='http://fonts.googleapis.com/css?family=Italianno&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link rel="shortcut icon" href="favicon.ico">


</head>
<body>

	<article>
		<header>
			<h5>Alla cortese attenzione di</h5>
			<h4>{{$missiva['dest']}}</h4>
		</header>

		<p style='margin-top:20px'>
			{{$missiva['testo']}}
		</p>
		
		<footer>
			<h4>{{$missiva['data']}}</h4>
			{{ HTML::image('img/sigillo.png') }}
		</footer>
	</article>

</body>
</html>	
