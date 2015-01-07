@extends('layouts.master')

	@section('content')
		<div class='row'>
			<div class='col-sm-6'>
				<h3>Edita Post di Ambientazione</h3>
			</div>
		</div>
		
		{{ Form::model($post, array('method' => 'PUT', 'url' => 'admin/post/'.$post->id)) }}


		<div class='col-sm-6 col-sm-offset-3'>
		<div class="form-group  ">
			{{ Form::label('titolo', 'Titolo') }}
			{{ Form::text('titolo', null, ['class'=>'form-control']) }}
		</div>
		
		<div class="form-group ">
			{{ Form::label('tag', 'Tipologia') }}
			{{ Form::select('tag', $tags, null, ['class'=>'form-control'])}}
		</div>


        <div class="form-group ">
			{{ Form::label('testo', 'Testo') }}
			{{ Form::textarea('testo', null, ['class'=>'form-control', 'placeholder' => 'Testo principale del post di ambientazione']) }}
		</div>
	
        <div class="form-group">
			{{ Form::submit('Modifica post', array('class' => 'btn btn-primary')) }}
		</div>
		</div>
		{{ Form::close() }}
	
	@show

@stop
