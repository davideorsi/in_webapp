@extends('admin')

	
	@section('content')
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
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
			
			<div>
			<p>
			<h4>Probabilità di ammalarsi</h4>
			Non tutte le patologie hanno un’alta incidenza. Quando un pg risulta essersi ammalato, se la trama non prevede diversamente, allora subirà un ulteriore tiro di dado percentuale per stabilire la malattia.
			Influenza virale: da 1% a 50%. <br>
			Infezione batterica: da 50% a 70%. <br>
			Tubercolosi: da 71% a 85%. <br>
			Sifilide: da 86% a 95%. <br>
			Peste bubbonica: da 96% a 100%.<br>
			</p>
			</div>

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
		

