@extends('admin')

	
	@section('content')
	<h3>Abilità</h3>
	
	<div class='row'>
		<div class='col-sm-6'>



			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
	

			<div class='form-group'>
				<?php $keys= array_keys($selectAbilita['Armi']); ?>
				{{ Form::open() }}
				{{ Form::select('abilita', $selectAbilita, $keys[0], ['class'=>'form-control', 'id'=>'selectabilita']) }}
				{{ Form::close() }}
				
			</div>
	
			<div class="btn-group" style='margin-bottom:10px;'>
			<a id='editabilita' class="btn btn-primary" href="{{ URL::to('admin/abilita/'.$keys[0].'/edit') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('admin/abilita/create') }}">Nuova</a>
			{{ Form::open(array('id'=>'delabilita','url' => 'admin/abilita/' . $keys[0], 'style'=>'display:inline-block; margin-left: -2px;')) }}
			{{ Form::hidden('_method', 'DELETE') }}
			{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}
			</div>
		</div>

		<div class='col-sm-6'>
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
				$('#editabilita').attr('href', 'abilita/'+$(this).val()+'/edit');
				$('#delabilita').attr('action', 'abilita/'+$(this).val());
				get_abilita($(this).val());
			});
			get_abilita($('#selectabilita').val());
		});
@stop
		

