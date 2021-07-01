@extends('layouts.master')
	
	@section('content')
		<div class='row'>
			<div class='col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3'>
				<h3>Modifica Domanda Frequente</h3>
		
				{{ Form::model($domanda, array('method' => 'PUT', 'url' => 'admin/domanda/'.$domanda->ID)) }}

		
		        <div class="form-group">
					{{ Form::label('Domanda', 'Domanda') }}
					{{ Form::textarea('Domanda', null, array('class'=>'form-control', 'placeholder' => 'Il testo della domanda')) }}
				</div>
		
		        <div class="form-group">
					{{ Form::label('Risposta', 'Risposta') }}
					{{ Form::textarea('Risposta', null, array('class'=>'form-control', 'placeholder' => 'Il testo della risposta')) }}
				</div>
				
				
		        <div class="form-group">
					{{Form::label('Bozza', 'Bozza')}}
					{{ Form::checkbox('Bozza', 1, null)}}
				</div>
		
		        <div class="form-group">
					{{ Form::submit('Modifica domanda', array('class' => 'btn btn-primary')) }}
				</div>
				{{ Form::close() }}
			</div>
		</div>
	@stop
	
