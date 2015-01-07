@extends('admin')

	
	@section('content')
		<div class='row'>
			<div class='col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3'>
				<h3>Nuova Voce di Locanda</h3>
			
				{{ Form::open(array('url'=>'admin/voce')) }}
		
		        <div class="form-group">
					{{ Form::label('Data', 'Data') }}
					{{ Form::input('date','Data', Input::old('Data'), array('class'=>'form-control')) }}
				</div>
		
		        <div class="form-group">
					{{ Form::label('Testo', 'Testo') }}
					{{ Form::textarea('Testo', Input::old('Testo'), array('class'=>'form-control', 'placeholder' => 'Il testo della voce')) }}
				</div>
				
		        <div class="form-group">
					{{ Form::label('Chiusa', 'Chiusa') }}
					{{ Form::text('Chiusa', Input::old('Chiusa'), array('class'=>'form-control', 'placeholder' => 'Luogo in cui la voce avviene')) }}
				</div>
				
		        <div class="form-group">
					{{Form::label('Bozza', 'Bozza')}}
					{{ Form::checkbox('Bozza', 1, Input::old('Bozza'))}}
				</div>
		
		        <div class="form-group">
					{{ Form::submit('Aggiungi voce', array('class' => 'btn btn-primary')) }}
				</div>
				{{ Form::close() }}
	
			</div>
		</div>
	@show
	
@stop
