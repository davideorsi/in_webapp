@extends('layouts.master')

	
@section('content')
<div class='row'>
	<div class='col-sm-6 col-sm-offset-3'>
		<h3>Domande Frequenti</h3>


		@if ( Session::has('message'))
			<div class="alert alert-info">
				{{ Session::get('message') }}
			</div>
		@endif

		<div class='form-group'>
			{{ Form::open() }}
			{{ Form::select('domanda', $selectDomande, null, ['class'=>'form-control', 'id'=>'selectdomanda']) }}
			{{ Form::close() }}
		</div>
		<?php $keys= array_keys($selectDomande); ?>

		<div class="btn-group" style='margin-bottom:10px;'>
			<a id='editdomanda' class="btn btn-primary" href="{{ URL::to('admin/domanda/'.$keys[0].'/edit') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('admin/domanda/create') }}">Nuova</a>
			{{ Form::open(array('id'=>'deldomanda','url' => 'admin/domanda/' . $keys[0], 'style'=>'display:inline-block; margin-left: -2px')) }}
			{{ Form::hidden('_method', 'DELETE') }}
			{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}
		</div>

		<div>
			<h4 id="domanda_domanda" class='justified'></h4>
			<p id="domanda_risposta" class='justified '></p>
			
		</div>
	</div>
</div>
@stop

@section('Scripts')
		$(function(ready) {
			get_domanda_master($('#selectdomanda').val());
			$('#selectdomanda').change( function() {
				$('#editdomanda').attr('href', 'domanda/'+$(this).val()+'/edit');
				$('#deldomanda').attr('action', 'domanda/'+$(this).val());
				get_domanda_master($(this).val());
			});
		});
@stop
		

