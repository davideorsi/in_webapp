@extends('layouts.master')

	@section('content')

@section('CSS')
	<style>

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

	@if ( Session::has('message'))
		<div id='info' class="alert alert-info">
			{{ Session::get('message') }}
		</div>
	@endif

  <!-- Filtri -->
	<div class='col-sm-4'>

		<h2 class='hidden-xs'>Materiali</h2>


	{{Form::open(array('onsubmit'=>'get_list_materiali(1); return false;')) }}
			<!--	{{ Form::open(array('files'=>true,'class'=>'form form-horizontal','method'=>'GET','url' => 'admin/materiali/search')) }}-->
			<div class="form-group" >
				<div class="input-group margin-bottom">
				<span class="input-group-addon" id="basic-addon-nome">Nome</span>
				{{ Form::text('nome', Input::old('nome'), ['class'=>'form-control','describedby'=>"basic-addon-Nome",'placeholder'=>'Nome del Materiale']) }}
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
				<span class="input-group-addon" id="basic-addon-CD">Rarità Locale</span>
				{{ Form::select('RL', $selRL, Input::old('RL'), ['class'=>'form-control','describedby'=>"basic-addon-RL"]) }}
				</div>
			</div>

			<div class="form-group" >
				<div class="input-group margin-bottom">
				<span class="input-group-addon" id="basic-addon-CD">Rarità Oltremare</span>
				{{ Form::select('RO', $selRO, Input::old('RO'), ['class'=>'form-control','describedby'=>"basic-addon-RO"]) }}
				</div>
			</div>

			<div class="form-group" >
				<div class="input-group margin-bottom">
				<span class="input-group-addon" id="basic-addon-CD">Rarità Mercato Nero</span>
				{{ Form::select('RN', $selRN, Input::old('RN'), ['class'=>'form-control','describedby'=>"basic-addon-RN"]) }}
				</div>
			</div>

			<div class="form-group" >
				<div class="input-group margin-bottom">
				<span class="input-group-addon" id="basic-addon-CD">Categoria</span>
				{{ Form::select('categoria', $selCat, Input::old('categoria'), ['class'=>'form-control','describedby'=>"basic-addon-Categoria"]) }}
				</div>
			</div>

			<div class="form-group" >
				<div class="input-group margin-bottom">
				<span class="input-group-addon" id="basic-addon-CD">Stagione</span>
				{{ Form::select('stagione', $selStg, Input::old('stagione'), ['class'=>'form-control','describedby'=>"basic-addon-Stagione"]) }}
				</div>
			</div>

			<div class="form-group" >
				<div class="input-group margin-bottom">
				<span class="input-group-addon" id="basic-addon-diluizione">Valore Base</span>
					{{ Form::input('number','valore', Input::old('valore'), ['class'=>'form-control','describedby'=>"basic-addon-valore"]) }}
				</div>
			</div>

			<div class="form-group" >
				<div class="input-group margin-bottom">
				<span class="input-group-addon" id="basic-addon-diluizione">Quantità Disponibile</span>
					{{ Form::input('number','quantita', Input::old('quantita'), ['class'=>'form-control','describedby'=>"basic-addon-quantita"]) }}
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
			<a class="btn btn-warning" href="materiali/create"><span class="glyphicon glyphicon-plus"></span> Aggiungi Materiale</a>
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

		<div id='panel_materiali' style='position: absolute; top: 40px; left:10px; padding: 0px; background-color: #fff;'>


		</div>

	</div>



  @stop

	@section('JS')
		{{ HTML::script('js/jquery-ui.min.js');}}
	@stop

	@section('Scripts')
		$( document ).ready(function() {

			get_list_materiali(1);

			$('.bodyfooter').hide();
		});

		function mostra_controlli() {
				$('#other_inputs').toggle().removeClass('hidden-xs');
			}


	@stop
