@extends('admin')

	
	@section('content')
	
	<div class='row'>
		<div class='col-sm-offset-3  col-sm-6'>

			<h3>Abilità</h3>


			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
	

			<div class='form-group'>
				<?php $keys= array_keys($selectAbilita['Generiche']); ?>
				{{ Form::open() }}
				{{ Form::select('abilita', $selectAbilita, $keys[0], ['class'=>'form-control', 'id'=>'selectabilita']) }}
				{{ Form::close() }}
				
			</div>
	
		</div>
	</div>

	<div class='row'>
		<div class='col-sm-offset-3 col-sm-6'>
			<div >
				<h4>Descrizione</h4>
				<p id='abilita_desc'></p>
			</div>
		</div>
	</div>
@stop


@section('Scripts')
		$(function(ready) {
			$('#selectabilita').change( function() {
				get_abilita_PG($(this).val());
			});
			get_abilita_PG($('#selectabilita').val());
		});
@stop
		

