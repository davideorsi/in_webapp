@extends('layouts.master')
	
	@section('content')
		<div class='row'>
			<div class='col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3'>
				<h3>Nuova Domanda Frequente</h3>
			
				{{ Form::open(array('url'=>'admin/domanda')) }}
		
		        <div class="form-group">
					{{ Form::label('Domanda', 'Domanda') }}
					{{ Form::textarea('Domanda', Input::old('Domanda'), array('class'=>'form-control', 'placeholder' => 'Il testo della domanda')) }}
				</div>
		
		        <div class="form-group">
					{{ Form::label('Risposta', 'Risposta') }}
					{{ Form::textarea('Risposta', Input::old('Risposta'), array('class'=>'form-control', 'placeholder' => 'Il testo della risposta')) }}
				</div>
				
		        <div class="form-group">
					{{Form::label('Bozza', 'Bozza')}}
					{{ Form::checkbox('Bozza', 1, Input::old('Bozza'))}}
				</div>
		
		        <div class="form-group">
					{{ Form::submit('Aggiungi domanda', array('class' => 'btn btn-primary')) }}
				</div>
				{{ Form::close() }}
	
			</div>
		</div>
	@stop
	
	

