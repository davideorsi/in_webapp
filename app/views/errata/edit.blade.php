@extends('layouts.master')
	
	@section('content')
		<div class='row'>
			<div class='col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3'>
				<h3>Modifica Errata</h3>
		
				{{ Form::model($errata, array('method' => 'PUT', 'url' => 'admin/errata/'.$errata->ID)) }}

		
		        <div class="form-group">
					{{ Form::label('Titolo', 'Titolo') }}
					{{ Form::textarea('Titolo', null, array('class'=>'form-control', 'placeholder' => 'Titolo	')) }}
				</div>
		
		        <div class="form-group">
					{{ Form::label('Testo', 'Testo') }}
					{{ Form::textarea('Testo', null, array('class'=>'form-control', 'placeholder' => 'Errata Corrige')) }}
				</div>
				
				
		        <div class="form-group">
					{{Form::label('Bozza', 'Bozza')}}
					{{ Form::checkbox('Bozza', 1, null)}}
				</div>
		
		        <div class="form-group">
					{{ Form::submit('Modifica Errata', array('class' => 'btn btn-primary')) }}
				</div>
				{{ Form::close() }}
			</div>
		</div>
	@stop
	
