@extends('admin')

	
	@section('content')
	<h3>Trame Multilive</h3>
	
	<div class='row'>
		<div class='col-sm-12'>



			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
	

			<div class='form-group'>
				<?php $keys= array_keys($selectTrama);?>
				{{ Form::open() }}
				{{ Form::select('trama', $selectTrama, $keys[0], ['class'=>'form-control', 'id'=>'selectTrama']) }}
				{{ Form::close() }}
			</div>
	
			<div class="btn-group" style='margin-bottom:10px;'>
			<a id='edittrama' class="btn btn-primary" href="{{ URL::to('trama/'.$keys[0].'/edit') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('trama/create') }}">Nuova</a>
			{{ Form::open(array('id'=>'deltrama','url' => 'tramas/' . $keys[0], 'style'=>'display:inline-block; margin-left: -2px;')) }}
			{{ Form::hidden('_method', 'DELETE') }}
			{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}
			</div>
		</div>

		<div class='col-sm-12'>
			<div >
				<h4>Descrizione</h4>
				<div id='trama_desc'></div>
			</div>
		</div>
	</div>
@stop


@section('Scripts')
		$(function(ready) {
			$('#selecttrama').change( function() {
				$('#edittrama').attr('href', 'trama/'+$(this).val()+'/edit');
				$('#deltrama').attr('action', 'trama/'+$(this).val());
				get_trama($(this).val());
			});
			get_trama($('#selectTrama').val());
		});
@stop
