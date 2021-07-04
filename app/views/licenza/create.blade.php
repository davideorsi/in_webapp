@extends('admin')

	
	@section('content')	
	<div class='row'>
		<div class='col-sm-6 col-sm-offset-3'>
				<h3>Nuova Licenza</h3>
			
				{{ Form::open(array('url'=>'admin/licenza','class'=>'pure-form pure-form-aligned')) }}
		
		        <div class="form-group">
					{{ Form::label('Nome', 'Nome') }}
					{{ Form::text('Nome', Input::old('Nome'), ['class'=>'form-control']) }}
				</div>

						
		        <div class="form-group">
					{{ Form::label('Disponibili', 'Disponibili') }}
					{{ Form::text('Disponibili', Input::old('Disponibili'), ['class'=>'form-control']) }}
				</div>
				
				
		        <div class="form-group">
					{{ Form::label('Prezzo', 'Prezzo') }}
					{{ Form::text('Prezzo', Input::old('Prezzo'), ['class'=>'form-control']) }}
				</div>

					
		        <div class="form-group">
					{{ Form::label('Permette', 'Permette') }}
					{{ Form::textarea('Permette', Input::old('Permette'), ['class'=>'form-control', 'placeholder' => 'La Licenza consente di...']) }}
				</div>
				
				
		        <div class="form-group">
					{{ Form::label('Limitazioni', 'Limitazioni') }}
					{{ Form::textarea('Limitazioni', Input::old('Limitazioni'), ['class'=>'form-control', 'placeholder' => 'La licenza non consente di...']) }}
				</div>
				
				
		        <div class="form-group">
					{{ Form::label('Tassazione', 'Tassazione') }}
					{{ Form::text('Tassazione', Input::old('Tassazione'), ['class'=>'form-control']) }}
				</div>
				
				
		        <div class="form-group">
					{{ Form::label('Durata', 'Durata') }}
					{{ Form::text('Durata', Input::old('Durata'), ['class'=>'form-control']) }}
				</div>
		
		        <div class="form-group">
					{{ Form::submit('Aggiungi Licenza', array('class' => 'btn btn-primary')) }}
				</div>
				{{ Form::close() }}
	
			</div>
		</div>
	@show
	
	
			
@stop
