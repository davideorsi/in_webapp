@extends('layouts.master')

	
@section('content')
<div class='row'>
	<div class='col-sm-6 col-sm-offset-3'>
		<h3>Errata Corrige</h3>


		@if ( Session::has('message'))
			<div class="alert alert-info">
				{{ Session::get('message') }}
			</div>
		@endif

		<div class='form-group'>
			{{ Form::open() }}
			{{ Form::select('errata', $selectErrati, null, ['class'=>'form-control', 'id'=>'selecterrata']) }}
			{{ Form::close() }}
		</div>
		<?php $keys= array_keys($selectErrati); ?>

		<div class="btn-group" style='margin-bottom:10px;'>
			<a id='editerrata' class="btn btn-primary" href="{{ URL::to('admin/errata/'.$keys[0].'/edit') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('admin/errata/create') }}">Nuova</a>
			{{ Form::open(array('id'=>'delerrata','url' => 'admin/errata/' . $keys[0], 'style'=>'display:inline-block; margin-left: -2px')) }}
			{{ Form::hidden('_method', 'DELETE') }}
			{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}
		</div>

		<div>
			<h4 id="errata_errata" class='justified'></h4>
			<p id="errata_risposta" class='justified '></p>
			
		</div>
	</div>
</div>
@stop

@section('Scripts')
		$(function(ready) {
			get_errata_master($('#selecterrata').val());
			$('#selecterrata').change( function() {
				$('#editerrata').attr('href', 'errata/'+$(this).val()+'/edit');
				$('#delerrata').attr('action', 'errata/'+$(this).val());
				get_errata_master($(this).val());
			});
		});
@stop
		

