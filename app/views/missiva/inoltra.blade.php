@extends('layouts.master')

	@section('content')
		<div class='row'>
			<div class='col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3'>
				<h3>Inoltra Missiva</h3>
				@if ( Session::has('message'))
					<div id='info' class="alert alert-info">
						{{ Session::get('message') }}
					</div>
				@endif
			
				{{ Form::open(array('url'=>'missive')) }}
				{{ Form::hidden('missivaOriginale', $missivaOriginale, ['class'=>'form-control']) }}
		        <div class="form-group">
					{{ Form::label('mittente', 'Mittente') }}
					{{ Form::select('Mittente', $mittente, null, ['class'=>'form-control selectform']) }}
				</div>
				<div class="form-group">
					{{ Form::label('firmaMitt', 'Firma Mittente') }}
					{{ Form::select('firmaMitt', $firmaMitt, $firmaDefault, ['class'=>'form-control selectform']) }}
				</div>
		        <div class="form-group">
					{{ Form::label('destinatario', 'Destinatario (PG)') }}
					{{ Form::select('destinatario', $selVivi, null, ['class'=>'form-control selectform']) }}
				</div>
				<div class="form-group">
					{{ Form::label('firmaDest', 'Identità Destinatario') }}
					{{ Form::select('firmaDest',  $firme, null, ['class'=>'form-control selectform']) }}
				</div>
					
		        <div class="form-group">
					{{ Form::label('tipo', 'Tipo') }}
					{{ Form::select('tipo', $costo, $costoDefault, ['class'=>'form-control']) }}
				</div>
	        
				<p class="alert alert-success">{{ 'Data di invio: '}}<strong>{{$data}}</strong></p>
							
		        <div class="form-group">
					{{ Form::label('testo', 'Testo') }}
					{{ Form::textarea('testo', Input::old('testo'), array('class'=>'form-control selectform', 'text' => $TestoMissiva)) }}
				</div>
				
				
				
						
		        <div class="form-group">
					{{ Form::submit('Inoltra Missiva', array('class' => 'btn btn-primary')) }}
				</div>
				{{ Form::close() }}
	
			</div>
		</div>
	@show
	
@stop
