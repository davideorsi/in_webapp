@extends('admin')

	
	@section('content')
	<div class='row'>
		<div class='col-sm-6 col-sm-offset-3'>
			<h3>Incanti</h3>
	
			
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
	
		</div>
	</div>

@stop
@section('Scripts')
		$(function(ready) {
			$('#selectincanto').change( function() {
				get_incanto_PG($(this).val());
			});
			get_incanto_PG(1);
		});
@stop
		

