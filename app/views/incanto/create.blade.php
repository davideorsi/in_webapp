@extends('admin')

	
	@section('content')	
	<div class='row'>
		<div class='col-sm-6 col-sm-offset-3'>
				<h3>Nuovo Incanto</h3>
			
				{{ Form::open(array('url'=>'admin/incanto','class'=>'pure-form pure-form-aligned')) }}
		
		        <div class="form-group">
					{{ Form::label('Nome', 'Nome') }}
					{{ Form::text('Nome', Input::old('Nome'), ['class'=>'form-control']) }}
				</div>

						
		        <div class="form-group">
					{{ Form::label('Formula', 'Formula') }}
					{{ Form::text('Formula', Input::old('Formula'), ['class'=>'form-control']) }}
				</div>

						
		        <div class="form-group">
					{{ Form::label('Livello', 'Livello') }}
					{{ Form::selectRange('Livello', 1, 5, Input::old('Livello'), ['class'=>'form-control']) }}
				</div>

				
		        <div class="form-group">
					{{Form::label('Base', 'Base')}}
					{{ Form::checkbox('Base', 1, Input::old('Base'))}}
				</div>

					
		        <div class="form-group">
					{{ Form::label('Descrizione', 'Descrizione') }}
					{{ Form::textarea('Descrizione', Input::old('Descrizione'), ['class'=>'form-control', 'placeholder' => 'Descrizione dell\'incanto']) }}
				</div>
		
		        <div class="form-group">
					{{ Form::submit('Aggiungi incanto', array('class' => 'btn btn-primary')) }}
				</div>
				{{ Form::close() }}
	
			</div>
		</div>
	@show
	
	
			
@stop
