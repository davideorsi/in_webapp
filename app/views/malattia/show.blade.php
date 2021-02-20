@extends('admin')

	@section('content')
	
		<div class="row bs-callout bs-callout-Default">
			<div class="col-md-6 col-md-offset-3">
				<h3>{{$Malattia['Nome']}}</h3>
			</div>	
		</div>	


		<!-- Edita uno stadio della malattia-->
		@foreach($Malattia['Stadi'] as $Stadio)
		<div class="row bs-callout bs-callout-primary">
			<div class="col-md-6 col-md-offset-3">
			        <h4>Stadio {{$Stadio['Numero']}}</h4>
			        <p class='justified'><b>Descrizione: </b>{{$Stadio['Descrizione']}}</p>
			        <p class='justified'><b>Effetti: </b>{{$Stadio['Effetti']}}</p>
			        <p class='justified'><b>Contagio: </b>{{$Stadio['Contagio']}}</p>
			</div>
		</div>
		@endforeach

@show
	
	
			
@stop

@section('Scripts')
@stop
