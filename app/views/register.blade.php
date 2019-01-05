@extends('layouts.master')
@section('MenuBar')
	@parent

@stop	

@section('content')
<div class='row'>
	<div class='col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4'>
		{{ Form::open(array('method' => 'POST','url' => 'registrazione/'.$chiave)) }}
		<h3>Registrazione Giocatore</h3>
		<p>
			Inserisci email e password che userai per il login. 
		</p>
		<p>
			La mail viene usata per tenere i contatti con te ed inviarti alcune notifiche: inserisci una mail che controlli con regolarità.
			La password deve avere almeno 8 caratteri.
		</p>
	
		<!-- if there are login errors, show them here -->
		<div class="form-group">
			{{ $errors->first('username') }}
			{{ $errors->first('email') }}
			{{ $errors->first('password') }}
		</div>
	
		<div class="form-group">
			{{ Form::label('username', 'Username') }}
			{{ Form::text('username', Input::old('username'), array('placeholder' => 'Maria Luigia','class'=>'form-control')) }}
		</div>
		<div class="form-group">
			{{ Form::label('email', 'Email') }}
			{{ Form::email('email', Input::old('email'), array('placeholder' => 'marialuigia@ducato.pr','class'=>'form-control')) }}
		</div>
	
		<div class="form-group">
			{{ Form::label('password', 'Password') }}
			{{ Form::password('password', array('class'=>'form-control')) }}
		</div>
	
	
		<div class="form-group">
			{{ Form::submit('Registrati!', ['class'=>'btn btn-lg btn-primary btn-block']) }}
		</div>
	</div>
</div>
{{ Form::close() }}
@stop
