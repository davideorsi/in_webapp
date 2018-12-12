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
	{{ HTML::style('css/bootstrap.min.css');}}
	{{ HTML::style('css/bootstrap-theme.min.css');}}

	<link href='http://fonts.googleapis.com/css?family=Italianno&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link rel="shortcut icon" href="favicon.ico">

</head>
<body style="-webkit-print-color-adjust:exact;">

	@foreach ( $PG as $pers)
	<!--<div style=' page-break-after: always; padding:10px;'>-->
		
		<!--############# cartellino ferita ###################################-->
		@for ($i = 0; $i<$pers['Ferite']; $i++)
			<div class='ferita'>
			    {{ HTML::image('img/IN_Black_WEB_trasp.jpg') }}
				<h1 >
					{{$pers['Nome']}} 
				</h1>
				<p style='text-align:center; width:100%'>{{$giorno}}</p>
				@for ($j = 0; $j<5; $j++)
					<div class='pf' style='left: {{$j*20}}%'>
						<p>Cicatrice</p><br>
						<span style="font-size: 10pt; margin-left:5pt ">{{$giorno}}</span>
					</div>
				@endfor
				
			</div>
		@endfor
		@if($i & 1)
			<div class='ferita'></div>
		@endif
		
	<!--</div>-->
	
	@endforeach
</body>
</html>	
