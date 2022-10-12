@extends('admin')

	@section('content')

		<!-- Edita uno stadio della malattia-->
		@foreach($PGmalati as $Malato)
			<div>
			        <h3>{{$Malato['Nome']}} ({{$Malato['NomeGiocatore']}})</h3>

							@foreach($Malato['Malattie'] as $Stadio)
							<div>
											<h4>{{$Stadio['MalattiaObj']->Nome}} Stadio {{$Stadio['Numero']}}</h4>

											<p class='justified'><b>Descrizione: </b>{{$Stadio['Descrizione']}}</p>
											<p class='justified'><b>Effetti: </b>{{$Stadio['Effetti']}}</p>
											<p class='justified'><b>Diagnosticare: </b>{{$Stadio['Diagnosticare']}}</p>
							</div>

							@endforeach


			</div>
		@endforeach
			<br>
@show



@stop

@section('Scripts')
@stop
