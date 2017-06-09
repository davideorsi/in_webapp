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
	{{ HTML::style('css/cartellini.css');}}
	<link href='http://fonts.googleapis.com/css?family=Italianno&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link rel="shortcut icon" href="favicon.ico">


</head>
<body>


	<div class='panel' style=' page-break-after: always;'>

		@for ($i = 1; $i <= 40; $i++)
		<article class='oggetto'>
			<div style='width:48%; margin-left:52%;'>
				<header>
					<h4>I. N.</h4>
				</header>
		
				<h3>
					Sostanza
				</h3>
				
				<footer>
				</footer>
			</div>
		</article>
			@if (!($i%4))
				<div style='clear:both'></div>
			@endif
		@endfor

	</div>
	
	
	<div class='panel'>

		@for ($i = 1; $i <= 40; $i++)
		<article class='retro'>
			<div style='width:60%; margin-left:20%;'>
			<p style='text-align: left; font-size: 9pt; line-height: 10pt; margin:-5px;   display: inline-block; vertical-align: middle;
  line-height: normal;'>
				{{$effetto}}
			</p>
			</div>
		</article>
			@if (!($i%4))
				<div style='clear:both'></div>
			@endif
		@endfor

	</div>
</body>
</html>	
