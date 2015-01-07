@extends('admin')

	
	@section('content')
		<div class="pure-u-1">
			<h3>Modifica PG Famoso</h3>
		
			{{ Form::model($famoso, array('files'=>true, 'method' => 'PUT', 'url' => 'admin/famoso/'.$famoso->ID)) }}

		
		        <div class="form-group row">
					<div class='col-sm-1'>
						{{ Form::label('Nome', 'Nome') }}
					</div>
					<div class='col-sm-5'>
						{{ Form::text('Nome', null,['class'=>'form-control']) }}
					</div>
				</div>

				<div class="form-group row">
					<div class='col-sm-1'>
					{{ Form::label('Foto', 'Foto') }}
					</div>
					<div class='col-sm-5'>
					{{ Form::file('Foto', ['class'=>'form-control']) }}
					</div>
				</div>
					
		        <div class="form-group">
					{{ Form::label('Storia', 'Storia') }}
					{{ Form::textarea('Storia', null,['class'=>'form-control']) }}
				</div>
						
		        <div class="form-group">
					{{ Form::submit('Modifica PG famoso', array('class' => 'btn btn-primary')) }}
				</div>
			{{ Form::close() }}
	
		</div>
	@show
	
	
			
@stop
