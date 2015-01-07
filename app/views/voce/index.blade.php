@extends('admin')

	
@section('content')
<div class='row'>
	<div class='col-sm-6 col-sm-offset-3'>
		<h3>Voci di Locanda</h3>


		@if ( Session::has('message'))
			<div class="alert alert-info">
				{{ Session::get('message') }}
			</div>
		@endif

		<div class='form-group'>
			{{ Form::open() }}
			{{ Form::select('voce', $selectVoci, null, ['class'=>'form-control', 'id'=>'selectvoce']) }}
			{{ Form::close() }}
		</div>
		<?php $keys= array_keys($selectVoci); ?>

		<div class="btn-group" style='margin-bottom:10px;'>
			<a id='editvoce' class="btn btn-primary" href="{{ URL::to('admin/voce/'.$keys[0].'/edit') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('admin/voce/create') }}">Nuova</a>
			{{ Form::open(array('id'=>'delvoce','url' => 'admin/voce/' . $keys[0], 'style'=>'display:inline-block; margin-left: -2px')) }}
			{{ Form::hidden('_method', 'DELETE') }}
			{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}
		</div>

		<div>
			<p id="voce_data" class='floatleft'></p>
			<p id="voce_testo" class='justified initialcap'></p>
			
			<footer>
				<p id="voce_chiusa"></p>
			</footer>
		</div>
	</div>
</div>
@stop

@section('Scripts')
		$(function(ready) {
			get_voce_master($('#selectvoce').val());
			$('#selectvoce').change( function() {
				$('#editvoce').attr('href', 'voce/'+$(this).val()+'/edit');
				$('#delvoce').attr('action', 'voce/'+$(this).val());
				get_voce_master($(this).val());
			});
		});
@stop
		

