@extends('layouts.master')

@section('content')

	@if ( Session::has('message'))
		<div class="pure-u-1 alert alert-info" style='margin-bottom:10px;'>
			{{ Session::get('message') }}
		</div>
	@endif

	
	<div class='account_bcg img-rounded' style='margin-bottom: 20px; max-width: 960px; margin-left:auto; margin-right:auto;'>
		

		<div style='padding: 5px; margin:5px;'>
			<h3><small>Prossimo Evento: </small>{{$evento['Titolo']}}</h3>
			<h5>{{$evento['Data']}} - {{$evento['Luogo']}}</h5>
		</div>
		
		<div class='row' style='margin-left:5px; margin-right:5px;'>
		@if (!$iscritto)

			<div class='col-sm-6'>
				<div class='img-rounded row' style='color: #000; background: rgba(255,255,255,0.7); padding:5px; margin-bottom: 10px'>
		
					@if ($in_tempo)
					<p>
						<h5>Iscrizioni aperte fino al {{$data_iscrizione}} incluso!</h5>
						Non risulti ancora iscritto! Cosa aspetti?</br>
						Partecipa come {{$pg['Nome']}}!
					</p>
		
		
					{{ Form::model([], array('files'=>true, 'method' => 'PUT', 'url' => 'account', 'class'=>'form-inline')) }}
					{{ Form::hidden('PG',$pg['ID'])}}
					{{ Form::hidden('Evento',$evento['ID']) }}
					<div class='form-group col-xs-6'>
						
						{{ Form::label('Arrivo', 'Ora di Arrivo',['style'=>'width:100%']) }}
						{{ Form::input('time','Arrivo','12:00', ['class'=>'form-control'])}}
					</div>
					<div class='form-group col-xs-3'>
						{{ Form::label('Cena', '',['style'=>'width:100%']) }}
						{{ Form::checkbox('Cena',1,false,['class'=>'checkbox']) }}
					</div>
					<div class='form-group col-xs-3'>
					
						{{ Form::label('Pernotto', '',['style'=>'width:100%']) }}
						{{ Form::checkbox('Pernotto',1,false,['class'=>'checkbox']) }}
					</div>
				</div>
			</div>

	


				

				@foreach ($abilita_con_opzioni as $key=>$ab)
					@if ($posseduta[$key])
					<div class='col-sm-6'>
						<div class='img-rounded' style='color: #000; background: rgba(255,255,255,0.7); padding:5px; margin-bottom: 10px'>
						<table >
						<p class=justified'>
							Alcune tue abilità ti consentono di effettuare una scelta prima dell'evento. Riceverai quanto scelto qui con la tua scheda personaggio.
						</p>
						<tr><th colspan=3>{{$ab['Ability']}}</th></tr>
							
						@if (in_array($ab['Ability'],array('Informatori','Ragno Tessitore',"Iscritto all'albo")) )
							<!-- Abilità con scelta singola e zero costo -->
							<tr><td colspan=3>{{ Form::select('Opzioni[]', 	$sel[$ab['Ability']], null, ['class'=>'form-control']) }}</td></tr>
						@else
							
							<!-- Abilità con scelta multipla e costo da pagare -->
							<tr><td>Numero</td><td>Oggetto</td><td>Costo</td></tr>
							@foreach($sel[$ab['Ability']] as $opt)
								<tr>
									<td>
										{{ Form::input('number','numero[]','0', ['class'=>'form-control','style'=>'width:50px;']) }}
										{{ Form::hidden('oggetto[]',$opt['Opzione'])}}	
										{{ Form::hidden('costo[]',$opt['Costo'])}}
									</td>
									</td>
									<td>{{ $opt['Opzione'] }}</td>
									<td>{{ INtools::convertiMonete($opt['Costo']) }}</td>
								</tr>
							@endforeach
						@endif
						</table>
						</div>
					</div>
					@endif
				@endforeach
				


			
			<div class='col-sm-12' style='padding:5px 15px 10px 15px;'>
			{{ Form::submit('Iscriviti!', array('class' => 'btn btn-success')) }}
			{{ Form::close()}}
			</div>
			@else
				<p>
				Non risulti iscritto!</br>
				Speriamo tu possa partecipare come {{$pg['Nome']}} al nostro prossimo evento... Se però ti fossi dimenticato, e volessi ancora venire con noi, contatta un Master al più presto!
				</p>

			@endif

			
		@else

			
			<div class='col-sm-6'>
				<div class='img-rounded' style='color: #000; background: rgba(255,255,255,0.7); padding:5px; margin-bottom: 10px'>
				<h5>Iscrizioni aperte fino al {{$data_iscrizione}} incluso!</h5>
				<p>Risulti già iscritto all'evento.</p>
				<table>
					<tr>
						<td><b>Ora di arrivo</b></td>
						<td align = "center"><b>Cena</b></td>
						<td align = "center"><b>Pernotto</b></td>
					</tr>
						<td>{{$iscrizione['Arrivo']}}</td>
						<td align = "center">
							@if ($iscrizione['Cena'])
							<span class='glyphicon glyphicon-ok'></span>
							@endif
						</td>
						<td align = "center">
							@if ($iscrizione['Pernotto'])
							<span class='glyphicon glyphicon-ok'></span>
							@endif
						</td>
					<tr>
	
					</tr>
				</table>
				<p><b>Note</b><br>{{$iscrizione['Note']}}</p>

				<a class='btn btn-warning' onclick="unsubscribe()">Cancella Iscrizione</a>
				</div>
			</div>
			
			<div class='col-sm-6 justified'>
				<div class='img-rounded' style='color: #000; background: rgba(255,255,255,0.7); padding:5px; margin-bottom:10px;'>
				<p>Potrai saldare la quota di partecipazione direttamente prima dell'evento. </br> Nel caso ti trovassi in difficoltà e dovessi disdire l'iscrizione, oppure anche solo se devi fare una modifica importante, clicca sull'apposito pulsante. </p>
				</div>
			</div>
			
		@endif
		

		</div>
	</div>


@stop

@section('Scripts')
@stop
