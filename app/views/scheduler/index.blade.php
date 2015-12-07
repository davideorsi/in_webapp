
@extends('admin')

	@section('CSS')
	{{ HTML::style('css/jquery-ui.min.css');}}
	{{ HTML::style('css/scheduler.css');}}
	@stop
	
	@section('content')
	<div class='row'>
		<div class="col-sm-6  col-md-5 ">
			<h3>Scaletta Evento</h3>


			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
	
			<div class='form-group'>
			{{ Form::open() }}
			{{ Form::select('evento', $selectEventi, null, ['class'=>'form-control', 'id'=>'selectevento']) }}
			{{ Form::close() }}
			</div>
	
			
		</div>
	</div>
	
	<div class='row'>
		<div id="schedule" class='col-sm-12'></div>
	</div>	
	
	<!-- AGGIUNGI ELEMENTO -->
	<div class="overlay" id="overlay" style="display:none;"></div>
	<div id="edit_element" class="box row">		
		<h4 style='margin-left:10px'>Modifica Elemento</h4>
		{{ Form::model('', array('method' => 'PUT', 'url' => 'vicenda/' ,'class'=>'pure-form pure-form-aligned','id'=>'form_edit' )) }}
		<div class='row'>
		        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12 ">
					{{ Form::label('text', 'Titolo') }}
					{{ Form::text('text',Input::old('text'), ['class'=>'form-control']) }}
				</div>
		</div>

		<div class='row'>
		        <div class="form-group col-sm-5 col-sm-offset-1">
					{{ Form::label('start', 'Inizio') }}
					{{ Form::text('start','', ['class'=>'form-control']) }}
				</div>

		        <div class="form-group col-sm-5 ">
					{{ Form::label('end', 'Fine') }}
					{{ Form::text('end','', ['class'=>'form-control']) }}
				</div>
		</div>		
		

        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12 ">
			{{ Form::hidden('vicenda', '', ['id'=>'vicenda'])}}
		</div>

		<div class='row'>
		        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12">
					{{ Form::textarea('data', Input::old('data'), ['id'=>'data','class'=>' form-control']) }}
				</div>
		</div>
		
        <div class="form-group col-sm-offset-1">
			{{ Form::submit('Modifica', array('class' => 'btn btn-primary')) }}
		</div>
		{{ Form::close() }}
        <p class="chiudi">X</p>    
	</div> 
	

	<div id="insert_element" class="box row">		
		<h4 style='margin-left:10px'>Inserisci Elemento</h4>
		{{ Form::open(array('url'=>'elemento','class'=>'pure-form pure-form-aligned', 'id'=>'form_insert')) }}
		
		<div class='row'>
		        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12 ">
					{{ Form::label('text', 'Titolo') }}
					{{ Form::text('text',Input::old('text'), ['class'=>'form-control']) }}
				</div>
		</div>

		<div class='row'>
		        <div class="form-group col-sm-5 col-sm-offset-1">
					{{ Form::label('start', 'Inizio') }}
					{{ Form::text('start','', ['class'=>'form-control']) }}
				</div>

		        <div class="form-group col-sm-5 ">
					{{ Form::label('end', 'Fine') }}
					{{ Form::text('end','', ['class'=>'form-control']) }}
				</div>
		</div>		
		

        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12 ">
			{{ Form::hidden('vicenda', '', ['id'=>'vicenda'])}}
		</div>

		<div class='row'>
		        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12">
					{{ Form::textarea('data', Input::old('data'), ['id'=>'data','class'=>' form-control']) }}
				</div>
		</div>
		
        <div class="form-group col-sm-offset-1">
			{{ Form::submit('Aggiungi', array('class' => 'btn btn-success')) }}
		</div>
		{{ Form::close() }}
        <p class="chiudi">X</p>    
	</div> 
@stop

@section('JS')
{{ HTML::script('js/jquery-ui.min.js');}}
{{ HTML::script('js/jq.schedule.js');}}
@stop

@section('Scripts')
		$(function(ready) {
			$('#selectevento').change( function() {
				$("#schedule").empty()
				initialize_scheduler("#schedule");
			});
			
		    initialize_scheduler("#schedule");
			
			$(".chiudi").click(
				function(){
				$('#overlay').fadeOut('fast');
				$('.box').hide();
		    });
			
		});
@stop
