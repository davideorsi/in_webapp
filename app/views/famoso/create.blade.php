@extends('admin')

	
	@section('content')
		<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
			<h3>Nuovo PG famoso</h3>
		
			{{ Form::open(array('files'=>true, 'url'=>'admin/famoso')) }}
		
		        <div class="form-group row">
					<div class='col-sm-1'>
					{{ Form::label('Nome', 'Nome') }}
					</div>
					<div class='col-sm-5'>
					{{ Form::text('Nome', Input::old('Nome'), ['class'=>'form-control']) }}
					</div>
				</div>

						
		        <div class="form-group row">
					<div class='col-sm-1'>
					{{ Form::label('photo', 'Foto') }}
					</div>
					<div class='col-sm-5'>
					{{ Form::file('photo', ['class'=>'form-control']) }}
					</div>
				</div>
					
		        <div class="form-group">
					{{ Form::label('Storia', 'Storia') }}
					{{ Form::textarea('Storia', Input::old('Storia'), ['class'=>'form-control']) }}
				</div>
		
		        <div class="form-group">
					{{ Form::submit('Aggiungi PG famoso', array('class' => 'btn btn-primary')) }}
				</div>
			{{ Form::close() }}
	
		</div>
	@show
	
	
			
@stop
