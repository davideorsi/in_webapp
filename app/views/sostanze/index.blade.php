@extends('layouts.master')

@section('CSS')
<style>
	.circleB {
		height: 30px;
		width: 30px;
		background-color: #000;
		border-radius: 50%;
		border: 1px solid black;
	}
	.circleW {
		height: 30px;
		width: 30px;
		background-color: #FFF;
		border-radius:50%;
		border: 1px solid black;
	}
	.circleR {
		height: 30px;
		width: 30px;
		background-color: #F00;
		border-radius:50%;
		border: 1px solid black;
	}
	#cromo_Rosso{
			background-color: #ff0000;
	}
	#cromo_Verde{
			background-color: #00ff00;
	}
	#cromo_Blu{
			background-color: #0000ff;
	}
	#cromo_Magenta{
			background-color: #ff00ff;
	}
	#cromo_Giallo{
			background-color: #ffff00;
	}
	#cromo_Ciano{
			background-color: #00ffff;
	}
	#cromo_Viola{
			background-color: #8000ff;
	}
	#cromo_Azzurro{
			background-color: #0080ff;
	}
	#cromo_Primavera{
			background-color: #00ff80;
	}
	#cromo_Prato{
			background-color: #80ff00;
	}
	#cromo_Arancione{
			background-color: #ff8000;
	}
	#cromo_Bianco{
			background-color: #ffffff;
	}
	#cromo_Rosa{
			background-color: #ff0080;
	}
	#cromo_Nero{
			background-color: #000000;
	}

</style>
@stop
	@section('content')


	@if ( Session::has('message'))
		<div id='info' class="alert alert-info">
			{{ Session::get('message') }}
		</div>
	@endif

  <!-- Filtri -->
	<div class='col-sm-4'>

		<h2 class='hidden-xs'>Sostanze</h2>


			{{Form::open(array('onsubmit'=>'get_list_sostanze(1); return false;')) }}

			<div class="form-group" >
				<div class="input-group margin-bottom">
				<span class="input-group-addon" id="basic-addon-nome">Nome</span>
				{{ Form::text('nome', Input::old('nome'), ['class'=>'form-control','describedby'=>"basic-addon-Nome",'placeholder'=>'Nome della Sostanza']) }}
				</div>
			</div>

		<div id="other_inputs" class="hidden-xs">

			<div class="form-group" >
				<div class="input-group margin-bottom">
				<span class="input-group-addon" id="basic-addon-CD">Cromodinamica</span>
				{{ Form::select('CD', $selCD, Input::old('CD'), ['class'=>'form-control','describedby'=>"basic-addon-CD"]) }}
				</div>
			</div>

			<div class="form-group" >
				<div class="input-group margin-bottom">
				<span class="input-group-addon" id="basic-addon-effetti">Effetti</span>
				{{ Form::text('effetti', Input::old('effetto'), ['class'=>'form-control','describedby'=>"basic-addon-effetti",'placeholder'=>'Parole chiave, es: Veleno 1']) }}
				</div>
			</div>

			<div class="form-group" >
				<div class="input-group margin-bottom">
				<span class="input-group-addon" id="basic-addon-diluizione">Diluizione</span>
					{{ Form::input('number','diluizione', Input::old('diluizione'), ['class'=>'form-control','describedby'=>"basic-addon-diluizione"]) }}
				</div>
			</div>

			<div class="form-group" >
				<div class="input-group margin-bottom">
				<span class="input-group-addon" id="basic-addon-materiali">Materiali</span>
				{{ Form::text('materiali', Input::old('materiali'), ['class'=>'form-control','describedby'=>"basic-addon-materiali",'placeholder'=>'Parole chiave, es: Boletus Satanas']) }}
				</div>
			</div>

			<div class="form-group" >
				<div class="input-group">

					<span class="input-group-addon danger" id="sizing-addon1">
						<span class='glyphicon glyphicon-leaf '></span>
					</span>
					{{Form::input('number', 'Rosse', Input::old('rosse'),['id'=>'Rosse', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon1"])}}
					<span class="input-group-addon success" id="sizing-addon2">
						<span class='glyphicon glyphicon-leaf'></span>
					</span>
					{{Form::input('number', 'Verdi', Input::old('verdi'),['id'=>'Verdi', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon2"])}}
					<span class="input-group-addon primary" id="sizing-addon3">
						<span class='glyphicon glyphicon-leaf'></span>
					</span>
					{{Form::input('number', 'Blu'  , Input::old('blu'),['id'=>'Blu', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon3"])}}
				</div>
			</div>

			<div class="form-group">
				<div class="input-group margin-bottom">
				<span class="input-group-addon" id="basic-addon-cancellate">Mostra Cancellate</span>
					{{Form::checkbox('cancellate',1, Input::old('cancellate'), ['class'=>'checkbox','describedby'=>"basic-addon-cancellate"])}}
				</div>
			</div>

		</div>

		<div class='btn-group'>
			<a class='btn btn-primary' title='Mostra ricerca avanzata'><span class='glyphicon glyphicon-search' href='#' onclick='mostra_controlli();'></span></a>
			{{ Form::submit('Cerca', array('class' => 'btn btn-success ')) }}
			<a class="btn btn-warning" href="sostanze/create"><span class="glyphicon glyphicon-plus"></span> Aggiungi Sostanza</a>
		</div>

		{{ Form::close() }}
	</div>



	<div class='col-sm-8' style='position:relative;'>
		<div id='parent-list' style='position: absolute; top: 40px; left:0px; width:100%'>
			<div id='pagine' class='col-sm-8'></div>
			<div class='col-sm-12'>
				<ul class='media-list' id='results'></ul>
				<div class="panel-group" id="accordion"></div>
			</div>
		</div>

		<div id='panel_sostanza' style='position: absolute; top: 40px; left:10px; padding: 0px; background-color: #fff;'>


		</div>

	</div>



  @stop
	@section('JS')
		{{ HTML::script('js/jquery-ui.min.js');}}
	@stop

	@section('Scripts')
		$( document ).ready(function() {

			get_list_sostanze(1);

			$('.bodyfooter').hide();
		});

		function mostra_controlli() {
				$('#other_inputs').toggle().removeClass('hidden-xs');
			}

			function hide_sostanza() {
					$('#panel_sostanza').toggle(0);
				}
	@stop
