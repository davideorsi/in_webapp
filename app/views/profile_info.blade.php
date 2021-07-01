@extends('layouts.master')

@section('content')

	<div style='margin-top: -20px;'>
		<h2 class='nomepg'>{{$data}}<br></h2>
	</div>

	@if ( Session::has('message'))
		<div class="pure-u-1 alert alert-info" style='margin-bottom:10px;'>
			{{ Session::get('message') }}
		</div>
	@endif
	
	<!--######## INFORMAZIONI GENERALI-->
	
	<div class='row'>
		@if (!$Incanti->isEmpty())
		<div class='col-sm-6'>
		@else
		<div>
		@endif

			@if (!empty($Speciali) | !$Sbloccate->isEmpty())
				<h4>Descrizione Abilità Speciali</h4>

			@foreach($Speciali as $ab)
				<article>
					<h5><b>{{$ab['Ability']}} </b><small>Posseduta</small></h5>
					<p style='text-align: justify;'>{{$ab['Descrizione']}}</p>
				</article>
			@endforeach

			@foreach($Sbloccate as $ab)
				<article>
					<h5><b>{{$ab['Ability']}} ({{$ab['PX']}} px) </b><small>Acquistabile</small></h5>
					<p style='text-align: justify;'>{{$ab['Descrizione']}}</p>
				</article>
			@endforeach
			@else
				<p style='text-align: justify;'>Al momento, non ci sono informazioni aggiuntive particolari riguardanti il tuo personaggio.</p>
			@endif
				
		</div>


		@if ($Incanti)
			<div class='col-sm-6'>
			
			@foreach($Incanti as $key=>$ab)
				@if ($key==0)
					<h4>Descrizione Incanti appresi</h4>
				@endif
				<article>
					<h5><b>{{$ab['Nome']}}</b></h5>
					<h6>Livello {{$ab['Livello']}} - <i>{{$ab['Formula']}}</i></h6>
					<p style='text-align: justify;'>{{$ab['Descrizione']}}</p>
				</article>
			@endforeach

			</div>
		@endif
				

	</div>

		
@stop
