@extends('layouts.master')

@section('content')


		
		@if ( Session::has('message'))
			<div id='info' class="alert alert-info">
				{{ Session::get('message') }}
			</div>
		@endif
		
		<!-- SEARCH LATERAL MENU -->
		<div class='col-sm-4'>
			
			<h2 class='hidden-xs'>Missive</h2>
			
			@if (Auth::user()->usergroup == 7)
			{{Form::open(array('onsubmit'=>'get_list_missive(1,1); return false;')) }}
			@else
			{{Form::open(array('onsubmit'=>'get_list_missive(1,0); return false;')) }}
			@endif
	
			<div class="form-group" >
				<div class="input-group margin-bottom">
				<span class="input-group-addon" id="basic-addon-PG">PG</span>	
				{{ Form::select('PG', $selPG, Input::old('PG'), ['class'=>'form-control','describedby'=>"basic-addon-PG"]) }}
				</div>
			</div>
			
			<div id="other_inputs" class="hidden-xs">
				<div class="form-group" > 
					<div class="input-group margin-bottom">
					<span class="input-group-addon" id="basic-addon-PNG">PNG</span>	
					{{ Form::text('PNG', Input::old('PNG'), ['class'=>'form-control','describedby'=>"basic-addon-PNG",'placeholder'=>'Nome del PNG']) }}
					</div>
				</div>
				
				
				<div class="form-group" > 
					<div class="input-group margin-bottom">
					<span class="input-group-addon" id="basic-addon-testo">Testo</span>	
					{{ Form::text('Testo', Input::old('testo'), ['class'=>'form-control','describedby'=>"basic-addon-testo",'placeholder'=>'Parole chiave, es: "spia"']) }}
					</div>
				</div>
	
	
	
				<div class="form-group" > 
					<div class="input-group margin-bottom">
					<span class="input-group-addon" id="basic-addon-data">Data</span>	
					{{ Form::text('Data', Input::old('Data'), ['class'=>'form-control','describedby'=>"basic-addon-data"]) }}
					</div>
				</div>
	
				@if (Auth::user()->usergroup == 7)
				<div   class="form-group"  title='Mostra solo le missive intercettate'>
					<div class="input-group margin-bottom">
					<span class="input-group-addon" id="basic-addon-intercettato"><span class="glyphicon glyphicon-flash" style="color:#FF6600;"></span></span>	
					{{ Form::checkbox('Intercettato',1, Input::old('intercettato'), ['class'=>'checkbox','describedby'=>"basic-addon-intercettato"]) }}
					</div>
				</div>
				<div  class="form-group"   title='Mostra solo le missive a cui dobbiamo ancora rispondere'>
					<div class="input-group margin-bottom">
					<span class="input-group-addon" id="basic-addon-nonrisp">
						<span class="glyphicon glyphicon-check" style="color: #f00"></span>
					</span>	
					{{ Form::checkbox('Solononrisp',1, Input::old('rispondere'), ['class'=>'checkbox','describedby'=>'basic-addon-nonrisp']) }}
					</div>
				</div>
				@endif
	
				<div  class="form-group" title='Mostra solo le missive per PNG'>
					<div class="input-group ">
					<span class="input-group-addon" id="basic-addon-solopng">
						Solo PNG
					</span>	
					{{ Form::checkbox('ConPNG',1, Input::old('ConPNG'), ['class'=>'checkbox','describedby'=>'basic-addon-solopng']) }}
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
		<div id='parent-list' style='position: absolute; top: 40px; left:0px; width:100%'>
			<div id='pagine' class='col-sm-8'></div>
			<div class='col-sm-12'>
				<ul class='media-list' id='results'></ul> 
			</div>
		</div>
		<div id='panel_missiva' style='position: absolute; top: 40px; left:10px; padding: 0px; background-color: #fff;'>
			<div class='col-sm-12' class='media-body'>
				
				
				<div id='missiva_icon_bar'></div>
				<header>
					<h4 id='mittente_sm'></h4>
					<h4 id='destinatario_sm'></h4>
				</header>
				
				<p id='testo_sm' class='justified '></p>
			</div>
		</div>
		
	</div>
	
@stop

@section('JS')
	{{ HTML::script('js/jquery-ui.min.js');}}
@stop

@section('Scripts')
	$( document ).ready(function() {
		@if (Auth::user()->usergroup == 7)
			var show_delete=true;
		@else
			var show_delete=false;
		@endif
		get_list_missive(1,show_delete);
		$('#panel_missiva').toggle(0);
		$('.bodyfooter').hide()
	});
	
	function hide_missiva() {
			$('#panel_missiva').toggle(0);
		}

	function mostra_controlli() {
			$('#other_inputs').toggle().removeClass('hidden-xs');
		}

@stop
