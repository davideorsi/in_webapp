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
	{{ HTML::style('css/bootstrap-toggle.min.css');}}
	{{ HTML::style('css/IN.css');}}
	{{ HTML::style('css/Italianno.css');}}
		@section('CSS')
		
	
		@show
	
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="favicon.ico">

	<!-- JavaScript
	================================================== -->

</head>
<body>
	<!-- Primary Page Layout
	================================================== -->

	<!--Container -->

	<div class="container">

			<!--<div id='titlebar' class='hidden-xs'>
				<div>
					<h1 class="remove-bottom">Intempesta Noctis</h1>
					<h4 class='subtitle'>Gioco di Ruolo dal vivo nel Ducato di Parma di inizio Ottocento</h4>
				</div>
			</div>-->
			
			@include('layouts.menu')

			<div class="spacer"></div>
			
			@yield('content')


	</div><!-- container -->
<footer class='bodyfooter'>
	<div class='centerbar'>
		Intempesta Noctis - Gioco di Ruolo dal vivo nel Ducato di Parma di inizio Ottocento
	</div>
</footer>

<!-- End Document
================================================== -->

{{ HTML::script('js/jquery.min.js');}}
{{ HTML::script('js/jquery.bootpag.min.js');}}
{{ HTML::script('js/bootstrap.min.js');}}
{{ HTML::script('js/bootstrap-toggle.min.js');}}
{{ HTML::script('js/IN.js');}}

@section('JS')
@show

<script>
	$(function() {
    $('.checkbox').bootstrapToggle({
      on: 'Si',
      off: 'No'
    });
  })
	
	@section('Scripts')

	
	@show
</script>
</body>
</html>
