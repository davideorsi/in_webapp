@extends('admin')


	@section('CSS')
	{{ HTML::style('css/jquery-te-1.4.0.css');}}
	@stop
		
	@section('content')
		<div class='row'>
			<div class='col-sm-6'>
				<h3>Modifica Trama Multilive</h3>
			</div>
		</div>
		
		{{ Form::model($trama, array('method' => 'PUT', 'url' => 'trama/'.$trama->ID ,'class'=>'pure-form pure-form-aligned')) }}
		
		<div class='row'>
		        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12 ">
					{{ Form::label('title', 'Titolo') }}
					{{ Form::text('title',null, ['class'=>'form-control']) }}
				</div>
		</div>

		<div class='row'>
		        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12">
					{{ Form::textarea('body', null, ['class'=>' editor']) }}
				</div>
		</div>

		
        <div class="form-group col-sm-offset-1">
			{{ Form::submit('Modifica', array('class' => 'btn btn-primary')) }}
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
