@extends('admin')


	@section('CSS')
		{{ HTML::style('css/jquery-ui.min.css');}}
	@show
	
	@section('content')
		<div class='row'>
			<div class='col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3'>
				<h3>Nuovo Oggetto Prezioso</h3>
			
				{{ Form::open(array('url'=>'admin/preziosi')) }}
				<div class="form-group">
					{{ Form::label('Nome', 'Nome') }}
					{{ Form::text('Nome', Input::old('Nome'), array('class'=>'form-control', 'placeholder' => "Nome dell'oggetto")) }}
				</div>
				
				<div class="form-group">
					{{ Form::label('Creatore', 'Creatore') }}
					{{ Form::select('Creatore', $selOrafi, null, ['class'=>'form-control selectform']) }}
				</div>
				<div class="form-group">
					{{ Form::label('Venditore', 'Venditore') }}
					{{ Form::select('Venditore', $selVivi, null, ['class'=>'form-control selectform']) }}
				</div>
		
		        <div class="form-group">
					{{ Form::label('Data', 'Data di arrivo nel mercato') }}
					{{ Form::input('date','Data', $data, array('class'=>'form-control')) }}
				</div>
		
		        <div class="form-group">
					{{ Form::label('Materiali', 'Materiali') }}
					{{ Form::textarea('Materiali', Input::old('Materiali'), array('class'=>'form-control', 'placeholder' => "Elenco dei Materiali usati per la creazione dell'oggetto.")) }}
				</div>
				
				<div class="form-group">
					{{ Form::label('Valore', 'Valore (in MR)') }}
					{{ Form::input('number','Valore', Input::old('Valore'),['class'=>'form-control']) }}
				</div>				
				
				<div class="form-group">
					{{ Form::label('BaseAsta', "Base d'Asta (in MR)") }}
					{{ Form::input('number','BaseAsta', Input::old('BaseAsta'),['class'=>'form-control']) }}
				</div>
		
		
		        <div class="form-group">
					{{ Form::label('Aspetto', 'Aspetto') }}
					{{ Form::textarea('Aspetto', Input::old('Aspetto'), array('class'=>'form-control', 'placeholder' => "Breve descrizione dell'aspetto esteriore dell'oggetto.")) }}
				</div>
		
		        <div class="form-group">
					{{ Form::submit('Aggiungi oggetto', array('class' => 'btn btn-primary')) }}
				</div>
				{{ Form::close() }}
	
			</div>
		</div>
	@show
	
	
@section('JS')

{{ HTML::script('js/jquery-ui.min.js');}}

@show
@section('Scripts')	
	$("input[type=date]").each(function() {
	    if  (this.type != 'date' ) $(this).datepicker({ dateFormat: 'yy-mm-dd' });
	});
@show
@stop
