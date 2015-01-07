@extends('admin')

	
	@section('content')
	
	<div class='row'>
		<div class='col-sm-6 col-sm-offset-3'>
			
				<h3>Modifica Incanto</h3>
			
				{{ Form::model($incanto, array('method' => 'PUT', 'url' => 'admin/incanto/'.$incanto->ID)) }}
		
		
		        <div class="form-group">
					{{ Form::label('Nome', 'Nome') }}
					{{ Form::text('Nome', null, ['class'=>'form-control']) }}
				</div>

						
		        <div class="form-group">
					{{ Form::label('Formula', 'Formula') }}
					{{ Form::text('Formula', null, ['class'=>'form-control']) }}
				</div>

						
		        <div class="form-group">
					{{ Form::label('Livello', 'Livello') }}
					{{ Form::selectRange('Livello', 1, 5, null, ['class'=>'form-control']) }}
				</div>

				
		        <div class="form-group">
					{{Form::label('Base', 'Base')}}
					{{ Form::checkbox('Base', 1, null)}}
				</div>

					
		        <div class="form-group">
					{{ Form::label('Descrizione', 'Descrizione') }}
					{{ Form::textarea('Descrizione', null, ['class'=>'form-control', 'placeholder' => 'Descrizione dell\'incanto']) }}
				</div>
				
		        <div class="form-group">
					{{ Form::submit('Modifica incanto', array('class' => 'btn btn-primary')) }}
				</div>
			{{ Form::close() }}
	
		</div>
	</div>
	@show
	
	
			
@stop
