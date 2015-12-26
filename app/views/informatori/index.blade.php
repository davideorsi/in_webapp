@extends('admin')

	
	@section('content')
	<div class='row'>
		<div class="col-sm-6 col-sm-offset-3 col-md-3 col-md-offset-6">
			<h3>Informatori</h3>


			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
	
			<div class='form-group'>
			{{ Form::open() }}
			{{ Form::select('informatori', $selectInfo, null, ['class'=>'form-control', 'id'=>'selectinformatori']) }}
			{{ Form::close() }}
			</div>
	
			<?php 
				$keys0= array_keys($selectInfo);
				$keys= array_keys($selectInfo[$keys0[0]]);
			 ?>
			
			<div class='form-group' style='margin-bottom:20px;'>
				<h5 id="info_evento"></h5>
				<h6 id="info_cat"></h6>
				<p id="info_testo" class='justified'></p>
			</div>

			<div class="form-group" style='margin-bottom:10px;'>
			<a id='editinformatori' class="btn btn-primary" href="{{ URL::to('admin/informatori/'.$keys[0].'/edit') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('admin/informatori/create') }}">Nuovo</a>
			{{ Form::open(array('id'=>'delinformatori','url' => 'admin/informatori/' . $keys[0], 'style'=>'display:inline-block; margin: -2px')) }}
			{{ Form::hidden('_method', 'DELETE') }}
			{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}
			</div>
		</div>
	</div>
@stop
@section('Scripts')
		$(function(ready) {
			get_info($('#selectinformatori').val());
			$('#selectinformatori').change( function() {
				$('#editinformatori').attr('href', 'informatori/'+$(this).val()+'/edit');
				$('#delinformatori').attr('action', 'informatori/'+$(this).val());
				get_info($(this).val());
			});
		});
@stop
