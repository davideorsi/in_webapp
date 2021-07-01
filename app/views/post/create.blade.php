@extends('layouts.master')

	@section('content')
		<div class='row'>
			<div class='col-sm-6'>
				<h3>Crea Post di Ambientazione</h3>
			</div>
		</div>
		
		{{ Form::open(array('url'=>'admin/post','class'=>'pure-form pure-form-aligned')) }}
		<div class='col-sm-6 col-sm-offset-3'>
		<div class="form-group  ">
			{{ Form::label('titolo', 'Titolo') }}
			{{ Form::text('titolo', Input::old('titolo'), ['class'=>'form-control']) }}
		</div>
		
		<div class="form-group ">
			{{ Form::label('tag', 'Tipologia') }}
			{{ Form::select('tag', $tags, Input::old('tag'), ['class'=>'form-control'])}}
		</div>


        <div class="form-group ">
			{{ Form::label('testo', 'Testo') }}
			{{ Form::textarea('testo', Input::old('testo'), ['class'=>'form-control', 'placeholder' => 'Testo principale del post di ambientazione']) }}
		</div>
	
        <div class="form-group">
			{{ Form::submit('Aggiungi post', array('class' => 'btn btn-primary')) }}
		</div>
		</div>
		{{ Form::close() }}
	
	@show

@stop
