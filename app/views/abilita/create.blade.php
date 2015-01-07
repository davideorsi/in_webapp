@extends('admin')

	
	@section('content')
		<div class='row'>
			<div class='col-sm-6'>
				<h3>Crea Abilità</h3>
			</div>
		</div>
		
		{{ Form::open(array('url'=>'admin/abilita','class'=>'pure-form pure-form-aligned')) }}
		
		<div class='row'>
		        <div class="form-group col-sm-6 ">
					{{ Form::label('Ability', 'Ability') }}
					{{ Form::text('Ability', Input::old('Ability'), ['class'=>'form-control']) }}
				</div>

						
		        <div class="form-group col-sm-6">
					{{ Form::label('Categoria', 'Categoria') }}
					{{ Form::select('Categoria', $categorieSelect, Input::old('Categoria'), ['class'=>'form-control'])}}
				</div>
		</div>
		<div class='row'>
						
		        <div class="form-group col-xs-3">
					{{ Form::label('PX', 'PX') }}
					{{ Form::selectRange('PX', -5, 12, Input::old('PX'), ['class'=>'form-control']) }}
				</div>

		        <div class="form-group col-xs-3">
					{{ Form::label('CartelliniPotere', 'Cart. Pot.') }}
					{{ Form::selectRange('CartelliniPotere', 0, 20, Input::old('CartelliniPotere'), ['class'=>'form-control']) }}
				</div>

				<div class="form-group col-xs-3">
					{{ Form::label('Erbe', 'Erbe') }}
					{{ Form::selectRange('Erbe', 0, 20, Input::old('Erbe'), ['class'=>'form-control']) }}
				</div>
					
				<div class="form-group col-xs-3">
					{{ Form::label('Rendita', 'Rendita') }}
					{{ Form::selectRange('Rendita', 0, 100, Input::old('Rendita'), ['class'=>'form-control']) }}
				</div>
		</div>
		<div class='row'>
		        <div class="form-group col-md-6">
					{{ Form::label('Descrizione', 'Descrizione') }}
					{{ Form::textarea('Descrizione', Input::old('Descrizione'), ['class'=>'form-control', 'placeholder' => 'Descrizione dell\'abilita']) }}
				</div>

		        <div class="form-group col-md-6">
					{{ Form::label('Note', 'Note') }}
					{{ Form::textarea('Note', Input::old('Note'), ['class'=>'form-control', 'placeholder' => 'Note (compaiono sulla scheda PG)']) }}
				</div>
		</div>
		
        <div class="form-group">
			{{Form::label('Generica', 'Generica')}}
			{{ Form::checkbox('Generica', 1 ,Input::old('Generica'))}}
		</div>
		
        <div class="form-group">
			{{ Form::submit('Aggiungi abilità', array('class' => 'btn btn-primary')) }}
		</div>
		{{ Form::close() }}
	
	@show
	
	
			
@stop
