@extends('layouts.master')

	
@section('content')
<div class='row'>
	<div class='col-sm-8 col-sm-offset-2'>
		<h3>Domande Frequenti</h3>


		@if ( Session::has('message'))
			<div class="alert alert-info">
				{{ Session::get('message') }}
			</div>
		@endif

		<div class='form-group'>
			{{ Form::open() }}
			{{ Form::select('domanda', $selectDomande, null, ['class'=>'form-control', 'id'=>'selectdomanda']) }}
			{{ Form::close() }}
		</div>

		<div>
			<h4 id="domanda_domanda" class='justified'></h4>
			<p id="domanda_risposta" class='justified '></p>
			
		</div>
	</div>
</div>
@stop

@section('Scripts')
		$(function(ready) {
			get_domanda($('#selectdomanda').val());
			$('#selectdomanda').change( function() {
				get_domanda($(this).val());
			});
		});
@stop
		

