@extends('admin')

	
	@section('content')
		<div class="pure-u-1">
			<h3>Nuova Voce di Locanda</h3>
		
			{{ Form::open(array('url'=>'admin/evento','class'=>'pure-form pure-form-aligned')) }}
	

			<div class='row'>
				<div class='col-sm-6 col-md-5 '>
			        <div class="form-group">
						{{ Form::label('Tipo', 'Tipo') }}
						{{ Form::select('Tipo', array('EVENTO LIVE' => 'EVENTO LIVE', 'EPISODIO' => 'EPISODIO'), Input::old('Tipo'),['class'=>'form-control']) }}
					</div>
	
					<div class="form-group">
						{{ Form::label('Titolo', 'Titolo') }}
						{{ Form::text('Titolo', Input::old('Titolo'), array('class'=>'form-control', 'placeholder' => 'Titolo dell\'evento')) }}
					</div>
				</div>
				<div class='col-sm-6 col-md-5'>
			        <div class="form-group">
						{{ Form::label('Data', 'Data') }}
						{{ Form::input('date','Data', Input::old('Data'), array('class'=>'form-control')) }}
					</div>
					
			        <div class="form-group">
						{{ Form::label('Luogo', 'Luogo') }}
						{{ Form::text('Luogo', Input::old('Luogo'),['class'=>'form-control'])}}
					</div>
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-6 col-md-5'>
			        <div class="form-group">
						{{ Form::label('Orari', 'Orari') }}
						{{ Form::textarea('Orari', Input::old('Orari'), array('class'=>'form-control', 'placeholder' => 'Orari di inizio e fine evento')) }}
					</div>
				</div>
				<div class='col-sm-6 col-md-5'>
			        <div class="form-group">
						{{ Form::label('Info', 'Info') }}
						{{ Form::textarea('Info', Input::old('Info'), array('class'=>'form-control','placeholder' => 'Informazioni varie (compresa mappa GPS e altre info)')) }}
					</div>
				</div>
			</div>
				
		
		        <div class="form-group">
					{{ Form::submit('Aggiungi Evento', array('class' => 'btn btn-primary')) }}
				</div>
			{{ Form::close() }}
	
		</div>
	@show
	
	
			
@stop
