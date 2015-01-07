@extends('admin')

	
	@section('content')
		<div>
			<h3>Nuovo PG</h3>
		</div>		
			{{ Form::open(array('url'=>'admin/pg')) }}

		
<div class="row">
	        <div class="col-md-6">
			        <div class="form-group">
						{{ Form::label('Nome', 'Nome') }}
						{{ Form::text('Nome', Input::old('Nome'),['class'=>'form-control']) }}
					</div>
	
			        <div class="form-group">
						{{ Form::label('NomeGiocatore', 'Nome Giocatore') }}
						{{ Form::text('NomeGiocatore', Input::old('NomeGIocatore'),['class'=>'form-control']) }}
					</div>
					
					<div class="form-group">
						{{ Form::label('Email', 'Email') }}
						{{ Form::email('Email', Input::old('Email'),['class'=>'form-control']) }}
					</div>
	
					<div class="form-group">
						{{ Form::label('Affiliazione', 'Fazione') }}
						{{ Form::select('Affiliazione', $sel_affiliazione, Input::old('Affiliazione'), ['class'=>'form-control']) }}
					</div>

					<div class='row'>
						<div class="form-group col-xs-3">
							{{ Form::label('Px', 'Px') }}
							{{ Form::input('number','Px', Input::old('Px'),['class'=>'form-control']) }}
						</div>
		
						<div class="form-group col-xs-3">
							{{ Form::label('Sesso', 'Sesso') }}
							{{ Form::select('Sesso', array('M'=>'Uomo','F'=>'Donna'), Input::old('Sesso'), ['class'=>'form-control']) }}
						</div>
						<div class="form-group col-xs-3">
							{{ Form::label('Morto', 'Morto') }}
							{{ Form::checkbox('Morto', 1,Input::old('Morto'),['class'=>'checkbox']) }}
						</div>
		
						<div class="form-group col-xs-3">
							{{ Form::label('InLimbo', 'In Limbo') }}
							{{ Form::checkbox('InLimbo', 1,Input::old('InLimbo'),['class'=>'checkbox']) }}
						</div>
					</div>
				</div>
	            <div class="col-md-6">
			        <div class="form-group">
						{{ Form::label('background', 'Background') }}
						{{ Form::textarea('background', Input::old('background'), ['size'=>'50x16']) }}
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

@section('Scripts')
$(".checkbox").bootstrapSwitch('size','mini');
@stop
