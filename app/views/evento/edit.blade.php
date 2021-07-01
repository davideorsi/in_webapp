@extends('admin')

	
	@section('content')
		<div>
			<h3>Modifica Evento</h3>
		
			{{ Form::model($evento, array('method' => 'PUT', 'url' => 'admin/evento/'.$evento->ID)) }}

			<div class='row'>
				<div class='col-sm-6 col-md-5 '>
			        <div class="form-group">
						{{ Form::label('Tipo', 'Tipo') }}
						{{ Form::select('Tipo', array('EVENTO LIVE' => 'EVENTO LIVE', 'EPISODIO' => 'EPISODIO'), null,['class'=>'form-control']) }}
					</div>
	
					<div class="form-group">
						{{ Form::label('Titolo', 'Titolo') }}
						{{ Form::text('Titolo', null, array('class'=>'form-control', 'placeholder' => 'Titolo dell\'evento')) }}
					</div>
				</div>
				<div class='col-sm-6 col-md-5'>
			        <div class="form-group">
						{{ Form::label('Data', 'Data') }}
						{{ Form::input('date','Data', null, array('class'=>'form-control')) }}
					</div>
					
			        <div class="form-group">
						{{ Form::label('Luogo', 'Luogo') }}
						{{ Form::text('Luogo', null,['class'=>'form-control'])}}
					</div>
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-6 col-md-5'>
			        <div class="form-group">
						{{ Form::label('Orari', 'Orari') }}
						{{ Form::textarea('Orari', null, array('class'=>'form-control', 'placeholder' => 'Orari di inizio e fine evento')) }}
					</div>
				</div>
				<div class='col-sm-6 col-md-5'>
			        <div class="form-group">
						{{ Form::label('Info', 'Info') }}
						{{ Form::textarea('Info', null, array('class'=>'form-control','placeholder' => 'Informazioni varie (compresa mappa GPS e altre info)')) }}
					</div>
				</div>
			</div>
		        <div class="form-group">
					{{ Form::submit('Modifica Evento', array('class' => 'btn btn-primary')) }}
				</div>
			{{ Form::close() }}
	
		</div>
	@show
	
	
			
@stop
