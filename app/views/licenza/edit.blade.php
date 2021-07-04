@extends('admin')

	
	@section('content')
	
	<div class='row'>
		<div class='col-sm-6 col-sm-offset-3'>
			
				<h3>Modifica Licenza</h3>
			
				{{ Form::model($Licenza, array('method' => 'PUT', 'url' => 'admin/licenza/'.$Licenza->ID)) }}
		
		
		        <div class="form-group">
					{{ Form::label('Nome', 'Nome') }}
					{{ Form::text('Nome', null, ['class'=>'form-control']) }}
				</div>

						
		        <div class="form-group">
					{{ Form::label('Disponibili', 'Disponibili') }}
					{{ Form::text('Disponibili', null, ['class'=>'form-control']) }}
				</div>
				
				
		        <div class="form-group">
					{{ Form::label('Prezzo', 'Prezzo') }}
					{{ Form::text('Prezzo', null, ['class'=>'form-control']) }}
				</div>

					
		        <div class="form-group">
					{{ Form::label('Permette', 'Permette') }}
					{{ Form::textarea('Permette', null, ['class'=>'form-control', 'placeholder' => 'La Licenza consente di...']) }}
				</div>
				
				
		        <div class="form-group">
					{{ Form::label('Limitazioni', 'Limitazioni') }}
					{{ Form::textarea('Limitazioni', null, ['class'=>'form-control', 'placeholder' => 'La licenza non consente di...']) }}
				</div>
				
				
		        <div class="form-group">
					{{ Form::label('Tassazione', 'Tassazione') }}
					{{ Form::text('Tassazione',null, ['class'=>'form-control']) }}
				</div>
				
				
		        <div class="form-group">
					{{ Form::label('Durata', 'Durata') }}
					{{ Form::text('Durata', Input::old('Durata'), ['class'=>'form-control']) }}
				</div>
				
		        <div class="form-group">
					{{ Form::submit('Modifica Licenza', array('class' => 'btn btn-primary')) }}
				</div>
			{{ Form::close() }}
	
		</div>
	</div>
	@show
	
	
			
@stop
