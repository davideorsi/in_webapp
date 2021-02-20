@extends('layouts.master')
@section('MenuBar')
	@parent

@stop	

@section('content')
<div class='row'>
	<div class='col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4'>
		<h3>Recupero Password</h3>
		<p>
			Inserisci l'email che usi per il login: ti verrà inviata una mail con il link per reimpostare la password. 
		</p>
	
		<form action="{{ action('RemindersController@postRemind') }}" method="POST">
			<div class="form-group">
		    <input type="email" name="email" class="form-control">
		    </div>
		    <div class="form-group">
		    <input type="submit" value="Invia Email" class="btn btn-lg btn-primary btn-block">
		    </div>
		</form>
	</div>
</div>
{{ Form::close() }}
@stop
