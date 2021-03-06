@extends('layouts.master')

	@section('content')
		<div class='row'>
			<div class='col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3'>
				<h3>Rispondi a Missiva</h3>
				@if ( Session::has('message'))
					<div id='info' class="alert alert-info">
						{{ Session::get('message') }}
					</div>
				@endif
			
				{{ Form::open(array('url'=>'missive')) }}
		
		        <div class="form-group">
					{{ Form::hidden('missivaOriginale', $missivaOriginale, ['class'=>'form-control']) }}
					@if (Auth::user()->usergroup == 7)
					{{ Form::label('mittente', 'Mittente') }}
					{{ Form::text('mittente', $Mitt_PNG, ['class'=>'form-control']) }}
					
					@else
					{{ Form::label('destinatario_PNG', 'Destinatario (PNG)') }}
					{{ Form::text('destinatario_PNG', $Dest_PNG, ['class'=>'form-control']) }}
					@endif
				</div>
							
		        <div class="form-group">
					{{ Form::label('destinatario', 'Destinatario (PG)') }}
					{{ Form::select('destinatario', $selVivi, null, ['class'=>'form-control selectform']) }}
				</div>
						
		        <div class="form-group">
					{{ Form::label('tipo', 'Tipo') }}
					{{ Form::select('tipo', $costo, $costoDefault, ['class'=>'form-control']) }}
				</div>
	        
				<p class="alert alert-success">{{ 'Data di invio: '}}<strong>{{$data}}</strong></p>
							
		        <div class="form-group">
					{{ Form::label('testo', 'Testo') }}
					{{ Form::textarea('testo', Input::old('testo'), array('class'=>'form-control selectform', 'placeholder' => 'Il testo della missiva')) }}
				</div>
				
				<div class="form-group">
					@if (Auth::user()->usergroup == 7)
						{{ Form::label('firma', 'Identità Destinatario') }}
					@else
						{{ Form::label('firma', 'Firma') }}
					@endif
					{{ Form::select('firma', $firme, $firmaDefault, ['class'=>'form-control selectform']) }}
				</div>
						
		        <div class="form-group">
					{{ Form::submit('Invia Missiva', array('class' => 'btn btn-primary')) }}
				</div>
				{{ Form::close() }}
	
			</div>
		</div>
	@show
	
@stop
