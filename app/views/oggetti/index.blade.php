@extends('admin')


	@section('CSS')
		{{ HTML::style('css/jquery-ui.min.css');}}
	@show
	
	@section('content')
		<div class='row'>
			<div class='col-sm-6 '>
				<h3>Nuovo Oggetto</h3>
			
				{{ Form::open(array('url'=>'admin/oggetti/stampa')) }}
		
		        <div class="form-group">
					{{ Form::label('Nome', 'Nome') }}
					{{ Form::input('text','Nome', Input::old('Nome'), array('class'=>'form-control', 'placeholder' => "Nome dell'oggetto")) }}
				</div>
		
		        <div class="form-group">
					{{ Form::label('Testo', 'Testo') }}
					{{ Form::textarea('Testo', Input::old('Testo'), array('class'=>'form-control', 'placeholder' => 'Effetti')) }}
				</div>
		
		        <div class="form-group">
					{{ Form::submit('Crea PDF', array('class' => 'btn btn-primary')) }}
				</div>
				{{ Form::close() }}
				
			</div>
			
			<div class='col-sm-6 '>
				<h3>Oggetti predefiniti</h3>
				
				{{ Form::open(array('url'=>'admin/oggetti/stampa')) }}
				{{ Form::hidden('Nome',"Erba Rossa")}}
				{{ Form::hidden('Testo',null) }}
				{{ Form::submit('Erba Rossa', array('class' => 'btn btn-danger')) }}
				{{ Form::close() }}
				
				{{ Form::open(array('url'=>'admin/oggetti/stampa')) }}
				{{ Form::hidden('Nome',"Erba Verde")}}
				{{ Form::hidden('Testo',null) }}
				{{ Form::submit('Erba Verde', array('class' => 'btn btn-success')) }}
				{{ Form::close() }}
				
				{{ Form::open(array('url'=>'admin/oggetti/stampa')) }}
				{{ Form::hidden('Nome',"Erba Blu")}}
				{{ Form::hidden('Testo',null) }}
				{{ Form::submit('Erba Blu', array('class' => 'btn btn-primary')) }}
				{{ Form::close() }}
							
			</div>	
		</div>
	@show
	
@stop
