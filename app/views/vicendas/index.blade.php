@extends('admin')

	
	@section('content')
	<h3>Vicende</h3>
	
	<div class='row'>
		<div class='col-sm-12'>



			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
	

			<div class='form-group'>
				<?php $keys= array_keys($selectVicenda);?>
				{{ Form::open() }}
				{{ Form::select('vicenda', $selectVicenda, $keys[0], ['class'=>'form-control', 'id'=>'selectvicenda']) }}
				{{ Form::close() }}
			</div>
	
			<div class="btn-group" style='margin-bottom:10px;'>
			<a id='editvicenda' class="btn btn-primary" href="{{ URL::to('vicenda/'.$first.'/edit') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('vicenda/create') }}">Nuova</a>
			{{ Form::open(array('id'=>'delvicenda','url' => 'vicenda/' . $first, 'style'=>'display:inline-block; margin-left: -2px;')) }}
			{{ Form::hidden('_method', 'DELETE') }}
			{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}
			</div>
		</div>

		<div class='col-sm-12'>
			<div >
				<h4>Descrizione</h4>
				<div id='vicenda_desc'></div>
			</div>
		</div>
	</div>
@stop


@section('Scripts')
		$(function(ready) {
			$('#selectVicenda').change( function() {
				$('#editvicenda').attr('href', 'vicenda/'+$(this).val()+'/edit');
				$('#delvicenda').attr('action', 'vicenda/'+$(this).val());
				get_vicenda($(this).val());
			});
			get_vicenda( {{$first}} );
		});
@stop
