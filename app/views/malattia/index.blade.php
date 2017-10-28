@extends('admin')

	
	@section('content')
	<div class="row bs-callout bs-callout-defaults">
		<div class="col-sm-6 col-sm-offset-3 ">
			<h3>Malattie</h3>
			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
			
			{{ Form::open(array('class'=>'pure-form pure-form-aligned')) }}

			
			<div class="form-group">
			{{ Form::label('malattie','Malattie') }}
			{{ Form::select('malattie', $selMalattie, null, ['class'=>'form-control selectform', 'id'=>'selVivi']) }}
			</div>

			
			{{ Form::close() }}
			
			
			<div class="btn-group" style='margin-bottom:10px;'>
			<a id='showmalattia' class="btn btn-default" href="{{ URL::to('admin/malattie/') }}">Status</a>
			<a id='editmalattia' class="btn btn-primary" href="{{ URL::to('admin/malattie/') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('admin/malattie/create') }}">Nuovo</a>
			{{ Form::open(array('id'=>'delmalattia','url' => 'admin/malattie/', 'style'=>'display:inline-block; margin-left: -2px')) }}
			{{ Form::hidden('_method', 'DELETE') }}
			{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}
			</div>
		</div>
	</div>
	<div class="row bs-callout bs-callout-default">	
		<div class="col-sm-6 col-sm-offset-3">
	
			<!--Elenco degli ammalati-->
			<h4>Ammalati</h4>
			<table class="table table-striped">
				<thead class="thead-inverse">
					<tr><th>PG</th><th>Malattia</th><th>Stadio</th><th></th></tr>
				</thead>
			@foreach($selMalati as $Malati)
				<tr>
					<td>{{$Malati['Nome']}}</td>
					<td>{{$Malati['Malattia']}}</td>
					<td>{{$Malati['Stadio']}}</td>
					<td>
						{{ Form::model($Malati, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin/stadiopg', 'class'=>'pure-form')) }}
						{{ Form::hidden('PG',$Malati['ID'])}}
						{{ Form::hidden('Stadio',$Malati['Stadio']) }}
						{{ Form::submit("x", array('class' => 'btn btn-warning')) }}
						{{ Form::close()}}

					</td>
				</tr>
			@endforeach
				<tr>
					{{ Form::open(array('class'=>'form form-horizontal','method'=>'POST','url' => 'admin/stadiopg')) }}
					<td>{{ Form::select('pg_vivi', $selVivi, null, ['class'=>'form-control selectform', 'id'=>'selVivi']) }}</td>
					<td colspan="2">{{ Form::select('malattia', $selStadi, null, ['class'=>'form-control selectform', 'id'=>'selVivi']) }}</td>
					<td>{{ Form::submit("+", array('class' => 'btn btn-primary')) }}</td>
					{{ Form::close()}}			
				</tr>
			</table>
		</div>
	</div>
	<div class='row bs-callout bs-callout-default'>						
		<div class="col-sm-6 col-sm-offset-3">
			<p>
			<h4>Probabilità di ammalarsi</h4>
			Non tutte le patologie hanno un’alta incidenza. Quando un pg risulta essersi ammalato, se la trama non prevede diversamente, allora subirà un ulteriore tiro di dado percentuale per stabilire la malattia.</br>
			Influenza virale: da 1% a 50%. <br>
			Infezione batterica: da 50% a 70%. <br>
			Tubercolosi: da 71% a 85%. <br>
			Sifilide: da 86% a 95%. <br>
			Peste bubbonica: da 96% a 100%.<br>
			</p>
		</div>

	</div>
@stop

@section('Scripts')
		$(function(ready) {
			$('.selectform').change( function() {
				$('#editmalattia').attr('href', 'malattie/'+$(this).val()+'/edit');
				$('#delmalattia').attr('action', 'malattie/'+$(this).val());
				$('#showmalattia').attr('href', 'malattie/'+$(this).val());
			});
		});
@stop
		

