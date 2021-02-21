@extends('admin')

	
@section('content')

<!-- SEARCH LATERAL MENU -->
		<div class='col-sm-4'>
			
			<h2 class='hidden-xs'>Ricerca</h2>
			
			{{Form::open(array('onsubmit'=>'get_list_voci(); return false;')) }}
	
				<div class="form-group" > 
					<div class="input-group margin-bottom">
					<span class="input-group-addon" id="basic-addon-testo">Testo</span>	
					{{ Form::text('Testo', Input::old('testo'), ['class'=>'form-control','describedby'=>"basic-addon-testo",'placeholder'=>'Parole chiave, es: "spia"']) }}
					</div>
				</div>
			
			<div id="other_inputs" class="hidden-xs">
				
				<div class="form-group" > 
					<div class="input-group margin-bottom">
					<span class="input-group-addon" id="basic-addon-testo">Chiusa</span>	
					{{ Form::text('Chiusa', Input::old('chiusa'), ['class'=>'form-control','describedby'=>"basic-addon-testo",'placeholder'=>'Parole chiave, es: "Borgo"']) }}
					</div>
				</div>				
				<div class="form-group" > 
					<div class="input-group margin-bottom">
					<span class="input-group-addon" id="basic-addon-data">Data</span>	
					{{ Form::text('Data', Input::old('inizio'), ['class'=>'form-control','describedby'=>"basic-addon-data"]) }}
					</div>
				</div>

	
			</div>

			<div class='btn-group'> 
				<a class='btn btn-primary visible-xs-block' title='Mostra ricerca avanzata'><span class='glyphicon glyphicon-plus' href='#' onclick='mostra_controlli();'></span></a> 
				{{ Form::submit('Cerca', array('class' => 'btn btn-success ')) }}
			</div>

				{{Form::close()}}
		</div>

	
	



	
	{{--##### LIST OF ELEMENTS ###########################################--}}
	<div class='col-sm-8' style='position:relative;'>
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

		<div>
			<p id="voce_data" class='floatleft'></p>
			<p id="voce_testo" class='justified initialcap'></p>
			
			<footer>
				<p id="voce_chiusa"></p>
			</footer>
		</div>
		
	</div>

@stop

@section('JS')
	{{ HTML::script('js/jquery-ui.min.js');}}
@stop

@section('Scripts')
		$(function(ready) {
			get_voce_master($('#selectvoce').val());
			$('#selectvoce').change( function() {
				get_voce_master($(this).val());
			});
		});
		
		function mostra_controlli() {
			$('#other_inputs').toggle().removeClass('hidden-xs');
		}

@stop
		

