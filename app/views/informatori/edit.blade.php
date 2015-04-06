@extends('admin')

	
	@section('content')
		<div class="pure-u-1">
			<h3>Modifica Informazione</h3>
		
			{{ Form::model($info, array('method' => 'PUT', 'url' => 'admin/informatori/'.$info->ID)) }}

				<div class="form-group">
					{{ Form::label('IDEvento', 'Evento') }}
					{{ Form::select('IDEvento', $selectEventi, null, array('class'=>'form-control'))}}
				</div>
				
				<div class="form-group">
					{{ Form::label('Categoria', 'Categoria') }}
					{{ Form::select('Categoria', $selectCategoria, null,['class'=>'form-control']) }}
				</div>
				
		        
		        <div class="form-group">
					{{ Form::label('Testo', 'Testo') }}
					{{ Form::textarea('Testo', null, array('class'=>'form-control','placeholder' => "Testo dell'informazione")) }}
				</div>
				
		
		        <div class="form-group">
					{{ Form::submit('Modifica Informazione', array('class' => 'btn btn-primary')) }}
				</div>
			{{ Form::close() }}
	
		</div>
	@show
	
	
			
@stop
