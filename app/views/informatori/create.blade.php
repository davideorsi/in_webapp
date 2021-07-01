@extends('admin')

	
	@section('content')
		<div class="pure-u-1">
			<h3>Nuova Informazione</h3>
		
			{{ Form::open(array('url'=>'admin/informatori','class'=>'pure-form pure-form-aligned')) }}
				<div class="form-group">
					{{ Form::label('Evento', 'Evento') }}
					{{ Form::select('Evento', $selectEventi, Input::old('Titolo'), array('class'=>'form-control'))}}
				</div>
				
				<div class="form-group">
					{{ Form::label('Categoria', 'Categoria') }}
					{{ Form::select('Categoria', $selectCategoria, Input::old('Tipo'),['class'=>'form-control']) }}
				</div>
				
		        
		        <div class="form-group">
					{{ Form::label('Testo', 'Testo') }}
					{{ Form::textarea('Testo', Input::old('Info'), array('class'=>'form-control','placeholder' => "Testo dell'informazione")) }}
				</div>
				
		
		        <div class="form-group">
					{{ Form::submit('Aggiungi Informazione', array('class' => 'btn btn-primary')) }}
				</div>
			{{ Form::close() }}
	
		</div>
	@show
	
	
			
@stop
