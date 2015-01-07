@extends('layouts.master')
@section('MenuBar')
	@parent

@stop	

@section('content')
<div class='row'>
	<div class='col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4'>
		{{ Form::open(array('url' => 'login')) }}
		<h3>Login</h3>
		<p>
			Effettua l'accesso utilizzando le credenziali del tuo account del Forum.
		</p>
	
		<!-- if there are login errors, show them here -->
		<div class="form-group">
			{{ $errors->first('email') }}
			{{ $errors->first('password') }}
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
			{{ Form::label('remember', 'Ricordami ') }}
			{{ Form::checkbox('remember',true,false,array('class'=>'checkbox')) }}
		</div>
	
	
		<div class="form-group">
			{{ Form::submit('Login!', ['class'=>'btn btn-lg btn-primary btn-block']) }}
		</div>
	</div>
</div>
{{ Form::close() }}
@stop
