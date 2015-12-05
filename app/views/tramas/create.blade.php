@extends('admin')


	@section('CSS')
	{{ HTML::style('css/jquery-te-1.4.0.css');}}
	@stop
		
	@section('content')
		<div class='row'>
			<div class='col-sm-6'>
				<h3>Crea Trama Multilive</h3>
			</div>
		</div>
		
		{{ Form::open(array('url'=>'trama','class'=>'pure-form pure-form-aligned')) }}
		
		<div class='row'>
		        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12 ">
					{{ Form::label('title', 'Titolo') }}
					{{ Form::text('title', Input::old('title'), ['class'=>'form-control']) }}
				</div>
		</div>

		<div class='row'>
		        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12">
					{{ Form::textarea('body', Input::old('body'), ['class'=>' editor']) }}
				</div>
		</div>

		
        <div class="form-group col-sm-offset-1">
			{{ Form::submit('Aggiungi', array('class' => 'btn btn-primary')) }}
		</div>
		{{ Form::close() }}
	
	@show
	
			
@stop

@section('JS')
{{ HTML::script('js/jquery-te-1.4.0.min.js');}}
@stop

@section('Scripts')
		$(function(ready) {
			$("textarea").jqte();			
		});
@stop
