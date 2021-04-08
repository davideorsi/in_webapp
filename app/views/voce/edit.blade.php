@extends('admin')

	@section('CSS')
		{{ HTML::style('css/jquery-ui.min.css');}}
	@show
	
	
	@section('content')
		<div class='row'>
			<div class='col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3'>
				<h3>Modifica Voce di Locanda</h3>
		
				{{ Form::model($voce, array("method" => "PUT", "url" => "admin/voce/".$id)) }}

		
		        <div class="form-group">
					{{ Form::label('Data', 'Data') }}
					{{ Form::input('date','Data', null, array('class'=>'form-control')) }}
				</div>
		
		        <div class="form-group">
					{{ Form::label('Testo', 'Testo') }}
					{{ Form::textarea('Testo', null, array('class'=>'form-control', 'placeholder' => 'Il testo della voce')) }}
				</div>
				
		        <div class="form-group">
					{{ Form::label('Chiusa', 'Chiusa') }}
					{{ Form::text('Chiusa', null, array('class'=>'form-control', 'placeholder' => 'Luogo in cui la voce avviene')) }}
				</div>
				
		        <div class="form-group">
					{{Form::label('Bozza', 'Bozza')}}
					{{ Form::checkbox('Bozza', '1', null)}}
				</div>
		
		        <div class="form-group">
					{{ Form::submit('Modifica voce', array('class' => 'btn btn-primary')) }}
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
