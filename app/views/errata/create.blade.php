@extends('layouts.master')
	
	@section('content')
		<div class='row'>
			<div class='col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3'>
				<h3>Nuova Errata Corrige</h3>
			
				{{ Form::open(array('url'=>'admin/errata')) }}
		
		        <div class="form-group">
					{{ Form::label('Titolo', 'Titolo') }}
					{{ Form::textarea('Titolo', Input::old('Titolo'), array('class'=>'form-control', 'placeholder' => 'Titolo')) }}
				</div>
		
		        <div class="form-group">
					{{ Form::label('Testo', 'Testo') }}
					{{ Form::textarea('Testo', Input::old('Testo'), array('class'=>'form-control', 'placeholder' => 'Il testo della errata corrige')) }}
				</div>
				
		        <div class="form-group">
					{{Form::label('Bozza', 'Bozza')}}
					{{ Form::checkbox('Bozza', 1, Input::old('Bozza'))}}
				</div>
		
		        <div class="form-group">
					{{ Form::submit('Aggiungi Errata', array('class' => 'btn btn-primary')) }}
				</div>
				{{ Form::close() }}
	
			</div>
		</div>
	@stop
	
	

