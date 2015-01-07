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

	@foreach ( array_chunk($PG,2,true) as $group)
	@foreach ( $group as $pers)
	<div class='panel' style='height:480px; position:relative; border: 1px solid #252525;'>
		
		<!--############# TITOLO ###################################-->
		<div class='panel-heading'>
		<h3 class='panel-title'>{{$pers['Nome']}}
			<small style='font-size: 14px;'> {{$pers['NomeGiocatore']}}</small>
		</h3>
		</div>
		<div style="margin-left:1%; width:98%; background-color: #eeeeee; height:3px;"></div>


		<!--############# INFO ###################################-->
		<div class='row'>
			<div style='width:20%; position: absolute; top: 45px; left: 10px;'>
				<p>
					<b>PX: </b >{{$pers['Px']}} ({{intval($pers['PxRimasti'])}} rimasti)<br>
					<b>Rendita: </b> {{$pers['Rendita']}}<br>
					<b>Erbe: </b>{{$pers['Erbe']}}<br>
					<b>Cart. Pot.: </b>{{$pers['CartelliniPotere']}}
				</p>
			</div>
			
			<div style='width:70%; position: absolute; top: 45px; right: 10px;'>
				<p> {{ $pers['Note'] }} </p>
			</div>
			
		</div>
		<div style="position: absolute; left: 0px; top: 130px; margin-left:1%; width:98%; background-color: #eeeeee; height:3px;"></div>


		<!--############# ABILITA ###################################-->
		
		@foreach ($pers['Abilita'] as $key=>$ab)
			@if ($key==11)
			</p>
			</div>
			@endif
			@if($key==0)
			<div class='row' style='width:60%; position: absolute; top: 135px; left: 0px; margin:5px; padding: 5px;'>
				<h4><b>Abilità</b></h4>
			</div>
			<div class='row' style='width:30%; position: absolute; top: 153px; left: 0px; margin:0px; padding: 10px;'>
			<p>
			@elseif($key==11)
			<div class='row' style='width:30%; position: absolute; top: 153px; left: 30%; margin:0px; padding: 10px;'>
			<p>
			@endif
				{{$ab['Ability']}}<br>
		@endforeach
			</p>
			</div>

		<!--############# INCANTI ###################################-->
		@foreach ($pers['Incanti'] as $key=>$in)
			@if ($key==0)
			<div class='row' style='width:38%; position: absolute; top: 135px; left: 61%; margin:0px; padding: 5px; border-left: 2px solid #eeeeee;'>
				<h4><b>Incanti</b></h4>
			</div
			<div style='width:38%; position: absolute; top: 153px; left: 61%; margin:0px; padding: 5px; border-left: 2px solid #eeeeee;'>
			<p style='font-size: 10px; padding:0px; margin:0px;'>
			@endif
			
				<b>{{$in['Nome']}} (liv. {{$in['Livello']}})</b> 
				<i>{{$in['Formula']}}</i> - {{$in['Descrizione']}}<br>

			@if ($key+1 == count($pers['Incanti']))
			</p>
			</div>
			@endif
			@endforeach
	</div>
	
	@endforeach




	@foreach ( $group as $pers)
	<div class='panel' style='height:480px; position:relative; border: 1px solid #252525;'>

		<!--############# TITOLO ###################################-->
		<div class='panel-heading'>
		<h3 class='panel-title'>{{$pers['Nome']}}
			<small style='font-size: 14px;'> {{$pers['NomeGiocatore']}}</small>  - Informazioni Aggiuntive
		</h3>
		</div>
		<div style="margin-left:1%; width:98%; background-color: #eeeeee; height:3px;"></div>

		
		<!--############# ABILITA ###################################-->

		<div class='row' style='width:100%; position: absolute; top: 40px; left: 0px; margin:5px; padding: 5px;'>

		@foreach ($pers['Abilita'] as $key=>$ab)
			@if (in_array($ab['Categoria'],array('Innate','Speciali','Spiriti')))
				<p style='font-size: 10px; padding:0px; margin:0px;'>
				<b>{{$ab['Ability']}} ({{$ab['PX']}}px):</b>
				{{$ab['Descrizione']}}
				</p>
			@endif	
		@endforeach
		</div>
		
	</div>
	@endforeach
	
	@endforeach
</body>
</html>	
