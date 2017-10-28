@extends('admin')

	@section('content')
		<div>
			<h3>Modifica Malattia</h3>

			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
		</div>	
		
		
		
		<div class="row bs-callout bs-callout-default">
			{{ Form::model($Malattia, array('files'=>true, 'method' => 'PUT', 'url' => 'admin/malattie/'.$Malattia['ID'])) }}
			<div class="col-md-6 col-md-offset-0">
		        <div class="form-group">
					{{ Form::label('Nome', 'Nome') }}
					{{ Form::text('Nome', $Malattia['Nome'],['class'=>'form-control']) }}
				</div>	

		        <div class="btn-group">
					{{ Form::submit('Modifica Nome', array('class' => 'btn btn-primary')) }}
				</div>
			</div>
			{{ Form::close() }}	
		</div>

		<!-- Edita uno stadio della malattia-->
		@foreach($Malattia['Stadi'] as $Stadio)
		<div class="row bs-callout bs-callout-primary">
			
			{{ Form::model('',array('method' => 'PUT','url' => 'admin/stadio/'.$Stadio['ID'])) }}
			<div class="col-md-12">
			        <div class="form-group">
						{{ Form::label('Numero', 'Stadio') }}
						{{ Form::input('number','Numero',$Stadio['Numero'],['class'=>'form-control']) }}
					</div>	
			        <div class="form-group">
						{{ Form::label('Descrizione', 'Descrizione') }}
						{{ Form::textarea('Descrizione', $Stadio['Descrizione'], ['size'=>'50x4','class'=>'form-control']) }}
					</div>	
			        <div class="form-group">
						{{ Form::label('Effetti', 'Effetti') }}
						{{ Form::textarea('Effetti',$Stadio['Effetti'], ['size'=>'50x2','class'=>'form-control']) }}
					</div>	
			        <div class="form-group">
						{{ Form::label('Contagio', 'Contagio') }}
						{{ Form::textarea('Contagio', $Stadio['Contagio'], ['size'=>'50x2','class'=>'form-control']) }}
					</div>	
			</div>
			<div class="col-md-12">
		        <div class="btn-group">
					{{ Form::submit('Modifica Stadio', array('class' => 'btn btn-primary')) }}		
			{{ Form::close() }}	
					{{ Form::open(array('url' => 'admin/stadio/'.$Stadio['ID'], 'style'=>'display:inline-block; margin-left: -2px')) }}
					{{ Form::hidden('_method', 'DELETE') }}
					{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
					{{ Form::close() }}
				</div>
			</div>
		</div>
		@endforeach

		
		<!-- Aggiungi un nuovo stadio della malattia-->
		<div class="row bs-callout bs-callout-warning">
			{{ Form::open(array('url'=>'admin/malattie/nuovo_stadio')) }}
	        <div class="col-md-12">
			        <div class="form-group">
						{{ Form::label('Numero', 'Stadio') }}
						{{ Form::input('number','Numero', count($Malattia['Stadi'])+1,['class'=>'form-control']) }}
					</div>	
			        <div class="form-group">
						{{ Form::input('hidden','Malattia',$Malattia['ID'],['class'=>'form-control']) }}
					</div>	
			        <div class="form-group">
						{{ Form::label('Descrizione', 'Descrizione') }}
						{{ Form::textarea('Descrizione', null, ['size'=>'50x4','class'=>'form-control']) }}
					</div>	
			        <div class="form-group">
						{{ Form::label('Effetti', 'Effetti') }}
						{{ Form::textarea('Effetti', null, ['size'=>'50x2','class'=>'form-control']) }}
					</div>	
			        <div class="form-group">
						{{ Form::label('Contagio', 'Contagio') }}
						{{ Form::textarea('Contagio', null, ['size'=>'50x2','class'=>'form-control']) }}
					</div>	
			</div>
			
			<div class="col-md-12">
		        <div class="btn-group">
					{{ Form::submit('Aggiungi Stadio', array('class' => 'btn btn-warning')) }}
				</div>
			</div>
			{{ Form::close() }}
		</div>

@show
	
	
			
@stop

@section('Scripts')
@stop
