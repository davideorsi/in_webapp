@extends('admin')

	
	@section('content')
	<div class='row'>
		<div class="col-md-8 col-md-offset-2">
			<h3>Eventi</h3>


			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
	
			<div class='form-group'>
			{{ Form::open() }}
			{{ Form::select('evento', $selectEventi, null, ['class'=>'form-control', 'id'=>'selectevento']) }}
			{{ Form::close() }}
			</div>
	
			<?php $keys= array_keys($selectEventi); ?>


			{{ Form::open(array('url'=>'admin/medicina/evento')); }}
			{{ Form:: submit('Aggiorna i dati',
				array("onclick"=>"if(!confirm('Sei sicuro di aver controllato tutto?')){return false;};",
				'class'=>'btn btn-primary',
				'style'=>'margin-bottom:10px;'));
			}}
			{{Form::hidden('evento',0,['id'=>'idevento'])}}
			<div id="evento_testo">
			</div>
			
			{{ Form::close() }}

		</div>
	</div>
@stop
@section('Scripts')
		$(function(ready) {
			get_cicatrici_evento($('#selectevento').val());
			$('#idevento').val($('#selectevento').val());

			$('#selectevento').change( function() {
				get_cicatrici_evento($(this).val());
				$('#idevento').val($(this).val());
			});
		});
@stop
