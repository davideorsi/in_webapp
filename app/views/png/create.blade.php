@extends('admin')

	
	@section('content')
		<div>
			<h3>Nuovo PNG</h3>
		</div>		
			{{ Form::open(array('url'=>'admin/pg')) }}

		
<div class="row">
	        <div class="col-md-6">
			        <div class="form-group">
						{{ Form::label('Nome', 'Nome') }}
						{{ Form::text('Nome', Input::old('Nome'),['class'=>'form-control']) }}
					</div>


			        <div class="form-group">
						{{ Form::label('Ruolo', 'Ruolo') }}
						{{ Form::text('Ruolo', Input::old('Ruolo'),['class'=>'form-control']) }}
					</div>
	
					<div class='row'>

						<div class="form-group col-xs-9">
							{{ Form::label('Master', 'Master') }}
							{{ 	Form::select('Master', $selMaster, null, ['class'=>'form-control']) }}					
						</div>
					
						<div class="form-group col-xs-3">
							{{ Form::label('Morto', 'Morto') }}
							{{ Form::checkbox('Morto', 1,Input::old('Morto'),['class'=>'checkbox']) }}
						</div>
		
					</div>
				</div>
	            <div class="col-md-6">
			        <div class="form-group">
						{{ Form::label('Descrizione', 'Descrizione') }}
						{{ Form::textarea('Descrizione', Input::old('Descrizione'), ['size'=>'50x14']) }}
					</div>
				</div>
			</div>
			<div class='justified'>
				<p>Al momento, inserisci solo le informazioni di base. Successivamente, modifica il personaggio inserito per aggiungere  classi di abilità, abilità e incanti conosciuti.</p>
			</div>
			
	        <div class="btn-group">
				{{ Form::submit('Aggiungi PG', array('class' => 'btn btn-primary')) }}
			</div>
			{{ Form::close() }}
	
		</div>
	@show
	
	
			
@stop
