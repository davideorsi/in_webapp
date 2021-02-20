@extends('layouts.master')

	
@section('content')
<div class='row'>
	<div class='col-sm-8 col-sm-offset-2'>
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

		<div>
			<h4 id="errata_errata" class='justified'></h4>
			<p id="errata_risposta" class='justified '></p>
			
		</div>
	</div>
</div>
@stop

@section('Scripts')
		$(function(ready) {
			get_errata($('#selecterrata').val());
			$('#selecterrata').change( function() {
				get_errata($(this).val());
			});
		});
@stop
		

