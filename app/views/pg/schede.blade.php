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
<body>

	@foreach ( $PG as $pers)
	<div class='panel' style=' page-break-after: always;'>
		
		<!--############# TITOLO ###################################-->
		<div class='panel-heading'>
		<h1 style='font-family: Italianno; margin: 0px;'>
			{{$pers['Nome']}} 
			<small style='font-family: serif; font-size:14px;margin-left:5px;'> {{$pers['NomeGiocatore']}}</small>
		</h1>
		</div>
		
		<div style="background-color: #eeeeee; height:3px;"></div>


		<!--############# INFO ###################################-->
		<div style='padding: 10px;'>
			<div style='float: left; margin-bottom: 10px; width: 30%;'>
				<p style='margin:0px;'>
					<b>PX: </b >{{$pers['Px']}} ({{intval($pers['PxRimasti'])}} disponibili)<br>
					<b>Rendita: </b> {{$pers['Rendita']}}<br>
					<b>Erbe: </b>{{$pers['Erbe']}}<br>
					<b>Cart. Pot.: </b>{{$pers['CartelliniPotere']}}<br>
					<b>Affiliazione: </b>{{$pers['Affiliazione']}}
				</p>
			</div>
			
			<div style='float: left; width:68%; margin-bottom: 10px'>
				@if ($pers['Note'])
				<p> {{ $pers['Note'] }} </p>
				@endif
			</div>
			
			<div style='clear:both;'></div>
			
			<div>	
				@if (array_key_exists('Opzioni',$pers))
				<p class='justified' style='font-size: 80%; margin-bottom: 5px;'>
					@foreach ($pers['Opzioni'] as $opt)	
					 {{ $opt }} <br>
					@endforeach
				</p>
				@endif
				
				@if (array_key_exists('Info',$pers))
				<p  class='justified'style='font-size: 80%; margin-bottom: 5px;'> 
					{{ $pers['Info'] }} 
				</p>
				@endif
			</div>
			
		</div>
		<div style="clear: both; background-color: #eeeeee; height:3px;"></div>


		<!--############# ABILITA ###################################-->
		
		@foreach ($pers['Abilita'] as $key=>$ab)
			@if ($key==11)
			</p>
			</div>
			@endif
			@if($key==0)
				<div style='width: 50%; float:left; margin:0px; padding: 5px;'>
				<h2 style='margin: 0px 0px 0px 5px; font-family: Italianno;'>Abilità</h2>

				<div style='width:50%; float:left; margin:0px; padding: 5px;'>
				<p>
			@elseif($key==11)
				<div style='width:50%; float:left; margin:0px; padding: 5px;'>
				<p>
			@endif
				{{$ab['Ability']}}<br>
			@endforeach
				</p>
				</div>
			</div>

		<!--############# INCANTI ###################################-->
		@foreach ($pers['Incanti'] as $key=>$in)
			@if ($key==0)
			<div style='width: 50%; float:left; margin:0px; padding: 5px; '>
				<h2 style='margin: 0px 0px 0px 5px; font-family: Italianno;'>Incanti</h2>
			
			<div style='margin:0px; padding: 5px; border-left: 2px solid #eeeeee;'>

			@endif
				<p style='font-size: 12px; padding:0px; margin:0px; text-align:justified; margin-bottom:2px;'>
				<b>{{$in['Nome']}} (liv. {{$in['Livello']}})</b>
				<i>{{$in['Formula']}}</i> - {{$in['Descrizione']}}
				</p>
			@if ($key+1 == count($pers['Incanti']))

				</div>
				</div>
			@endif
		@endforeach

	
		<div style="clear: both; background-color: #eeeeee; height:3px;"></div>	
		<!--############# INFO ###################################-->

		<div  style='margin:5px; padding: 5px;'>

	
			@foreach ($pers['Abilita'] as $key=>$ab)
				@if (in_array($ab['Categoria'],array('Innate','Speciali','Spiriti')))
					<p style='font-size: 11px; padding:0px; margin:0px; margin-bottom:2px;'>
					<b>{{$ab['Ability']}} ({{$ab['PX']}}px):</b></br>
					{{$ab['Descrizione']}}
					</p>
				@endif	
			@endforeach
		</div>
		
	</div>
	
	@endforeach
</body>
</html>	
