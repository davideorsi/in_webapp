@extends('admin')

	@section('CSS')
	{{ HTML::style('css/jquery-te-1.4.0.css');}}
	@stop

@section('content')

	<!-- ################## FORM MAIL ############################-->
	<div class='col-sm-12'>
		
		<h2>Invia Mail agli Utenti</h2>

		@if ( Session::has('message'))
			<div id='info' class="alert alert-info">
				{{ Session::get('message') }}
			</div>
		@endif
	
		{{ Form::open(array('url'=>'mail')) }}


        <div class="form-group">
			{{ Form::label('destinatari', 'Destinatari: tutti i giocatori...') }}
			{{ Form::select('destinatari', array('0'=>"Con un PG vivo",'1'=>"Con PG vivo, Iscritti all'evento corrente",'2'=>"Con PG vivo, Non iscritti all'evento corrente") , null, ['class'=>'form-control selectform']) }}
		</div>

        <div class="form-group">
			{{ Form::label('oggetto', 'Oggetto') }}
			{{ Form::text('oggetto', null, ['class'=>'form-control']) }}
		</div>
				
		
		
        <div class="form-group">
			{{ Form::label('testo', 'Testo') }}
			{{ Form::textarea('testo', Input::old('testo'), array('class'=>'form-control selectform', 'placeholder' => 'Il testo della missiva')) }}
		</div>


        <div class="form-group">
			{{ Form::submit('Invia Mail', array('class' => 'btn btn-primary')) }}
		</div>
		{{ Form::close() }}
	
		
	</div>
@stop

@section('JS')
{{ HTML::script('js/jquery-te-1.4.0.min.js');}}
@stop

@section('Scripts')
		$(function(ready) {
			$("textarea").jqte();			
		});
@stop


