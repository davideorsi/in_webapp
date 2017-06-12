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
	
			<?php $keys= array_keys($selectEventi); $id=Auth::user()->id;?>

			<div class="form-group" style='margin-bottom:10px;'>
			<a id='viewevento' class="btn btn-primary" href="{{ URL::to('vicende/'.$keys[0].'/master/'.$id) }}">Modifica</a>
			</div>
			
		</div>
	</div>
@stop
@section('Scripts')
		$(function(ready) {
			$('#selectevento').change( function() {
				$('#viewevento').attr('href', 'vicende/'+$(this).val()+'/master/{{Auth::user()->id}}');
			});
		});
@stop
