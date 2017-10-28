@extends('admin')

	
	@section('content')
		<div>
			<h3>Nuova malattia</h3>
		</div>		

		
		<div class="row">
			{{ Form::open(array('url'=>'admin/malattie')) }}
	        <div class="col-md-12">
			        <div class="form-group">
						{{ Form::label('Nome', 'Nome') }}
						{{ Form::text('Nome', Input::old('Nome'),['class'=>'form-control']) }}
					</div>	
			</div>
			<div class="col-md-12">
		        <div class="btn-group">
					{{ Form::submit('Aggiungi malattia', array('class' => 'btn btn-primary')) }}
				</div>
			</div>
			{{ Form::close() }}
		</div>
	@show
	
	
			
@stop

@section('Scripts')
@stop
