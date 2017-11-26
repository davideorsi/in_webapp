@extends('admin')

	
	@section('content')
	<div class='row'>
		<div class='col-sm-6 col-sm-offset-3'>
			<h3>Incanti</h3>


			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
	
			
			<div class="form-group">
				{{ Form::open() }}
				{{ Form::select('incanto', $selectIncanti, null, ['class'=>'form-control', 'id'=>'selectincanto']) }}
				{{ Form::close() }}
			</div>
			<?php $keys= array_keys($selectIncanti); ?>

			<div class="form-group">
				<h5  id='incanto_formula'></h5>
				<p id='incanto_desc'></p>
			</div>
	
			<div class="btn-group" style='margin-bottom:10px;'>
			<a id='printincanto' class="btn btn-default" href="{{ URL::to('admin/incanto/'.$keys[0]) }}">Stampa</a>
			<a id='editincanto' class="btn btn-primary" href="{{ URL::to('admin/incanto/'.$keys[0].'/edit') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('admin/incanto/create') }}">Nuova</a>
			{{ Form::open(array('id'=>'delincanto','url' => 'admin/incanto/' . $keys[0], 'style'=>'display:inline-block; margin-left: -2px;')) }}
			{{ Form::hidden('_method', 'DELETE') }}
			{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}
			</div>
		</div>
	</div>

@stop
@section('Scripts')
		$(function(ready) {
			$('#selectincanto').change( function() {
				$('#printincanto').attr('href', 'incanto/'+$(this).val());
				$('#editincanto').attr('href', 'incanto/'+$(this).val()+'/edit');
				$('#delincanto').attr('action', 'incanto/'+$(this).val());
				get_incanto($(this).val());
			});
			get_incanto(1);
		});
@stop
		

