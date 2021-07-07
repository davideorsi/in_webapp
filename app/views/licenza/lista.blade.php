@extends('admin')

	
	@section('content')
	<div class='row'>
		<div class='col-sm-offset-3 col-sm-6'>
			<h3>Licenze Commerciali<h3>


			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
	
			
			<div class="form-group">
				{{ Form::open() }}
				{{ Form::select('licenza', $selectLicenze, null, ['class'=>'form-control', 'id'=>'selectlicenza']) }}
				{{ Form::close() }}
			</div>
			<?php $keys= array_keys($selectLicenze); ?>

			<div class="form-group">
				<h4  id='licenza_nome'></h4>
				<h5>Prezzo:  <span id='licenza_prezzo'></span></h5>
				<h5>Disponibilità:  <span id='licenza_disponibili'></span></h5>
				<h5>Durata:  <span id='licenza_durata'></span></h5>
				<h5>Permette:  <span id='licenza_permette'></span></h5>
				<h5>Limitazioni:  <span id='licenza_limitazioni'></span></h5>
				<h5>Tassazione:  <span id='licenza_tassazione'></span></h5>
			</div>
	
		</div>
	</div>
	
	
@stop
@section('Scripts')
		$(function(ready) {
			$('#selectlicenza').change( function() {
				get_licenza($(this).val());
			});
			get_licenza(1);
		});
@stop
		

