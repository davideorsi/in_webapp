@extends('admin')

	
	@section('content')
	<div class='row'>
		<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
			<h3>Eventi</h3>


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
	
			<?php $keys= array_keys($selectEventi); ?>

			<div class="form-group" style='margin-bottom:10px;'>
			<a id='editevento' class="btn btn-primary" href="{{ URL::to('admin/evento/'.$keys[0].'/edit') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('admin/evento/create') }}">Nuovo</a>
			{{ Form::open(array('id'=>'delevento','url' => 'admin/evento/' . $keys[0], 'style'=>'display:inline-block; margin: -2px')) }}
			{{ Form::hidden('_method', 'DELETE') }}
			{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}
			</div>
		</div>
	</div>
@stop
@section('Scripts')
		$(function(ready) {
			$('#selectevento').change( function() {
				$('#editevento').attr('href', 'evento/'+$(this).val()+'/edit');
				$('#delevento').attr('action', 'evento/'+$(this).val());
			});
		});
@stop
