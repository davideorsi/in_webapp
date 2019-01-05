@extends('layouts.master')

@section('content')
	<div class='row'>
	<div class='col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4'>
    <h3>Imposta la tua nuova password</h3>

    {{ Form::open() }}
        <input type="hidden" name="token" value="{{ $token }}">

        <div class='form-group'>
            {{ Form::label('email', 'Email:') }}
            {{ Form::email('email', '',array('class'=>'form-control')) }}
        </div>

        <div  class='form-group'>
            {{ Form::label('password', 'Password:') }}
            {{ Form::password('password', array('class'=>'form-control')) }}
        </div>

        <div  class='form-group'>
            {{ Form::label('password_confirmation', 'Conferma la Password:') }}
            {{ Form::password('password_confirmation', array('class'=>'form-control')) }}
        </div>

        <div  class='form-group'>
            {{ Form::submit('Invia', ['class'=>'btn btn-lg btn-primary btn-block']) }}
        </div>
    </form>

    @if (Session::has('error'))
        <p style="color: red;">{{ Session::get('error') }}</p>
    @endif
    </div>
    </div>
@stop
