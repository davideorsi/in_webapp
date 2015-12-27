@extends('layouts.master')

@section('content')


		
		<h2 >Missive</h2>
		@if ( Session::has('message'))
			<div id='info' class="alert alert-info">
				{{ Session::get('message') }}
			</div>
		@endif
		
		<div>
			@if (Auth::user()->usergroup == 7)
			{{Form::open(array('onsubmit'=>'get_list_missive(1,1); return false;')) }}
			@else
			{{Form::open(array('onsubmit'=>'get_list_missive(1,0); return false;')) }}
			@endif
			
				<div class='row'>
					<div class='form-group col-xs-12 col-sm-6'>
						<div class="input-group">
						<span class="input-group-addon" id="basic-addon-PG">PG</span>	
						{{ Form::select('PG', $selPG, Input::old('PG'), ['class'=>'form-control','describedby'=>"basic-addon-PG"]) }}
						</div>
					</div>
					
					<div class='form-group col-xs-12 col-sm-6 '>
						<div class="input-group">
						<span class="input-group-addon" id="basic-addon-PNG">PNG</span>	
						{{ Form::text('PNG', Input::old('PNG'), ['class'=>'form-control','describedby'=>"basic-addon-PNG",'placeholder'=>'Nome del PNG']) }}
						</div>
					</div>
					
					
					<div class='form-group col-xs-12 col-sm-6 '>
						<div class="input-group">
						<span class="input-group-addon" id="basic-addon-testo">Testo</span>	
						{{ Form::text('Testo', Input::old('testo'), ['class'=>'form-control','describedby'=>"basic-addon-testo",'placeholder'=>'Parole chiave, es: "spia"']) }}
						</div>
					</div>



					<div class='form-group  col-xs-12 col-sm-6' >
						<div class="input-group">
						<span class="input-group-addon" id="basic-addon-data">Data</span>	
						{{ Form::text('Data', Input::old('Data'), ['class'=>'form-control','describedby'=>"basic-addon-data"]) }}
						</div>
					</div>

					@if (Auth::user()->usergroup == 7)
					<div class='form-group col-xs-2 col-sm-2' title='Mostra solo le missive intercettate'>
						<div class="input-group">
						<span class="input-group-addon" id="basic-addon-intercettato"><span class="glyphicon glyphicon-flash" style="color:#FF6600;"></span></span>	
						{{ Form::checkbox('Intercettato',1, Input::old('intercettato'), ['class'=>'checkbox','describedby'=>"basic-addon-intercettato"]) }}
						</div>
					</div>
					<div class='form-group col-xs-2 col-sm-2' title='Mostra solo le missive a cui dobbiamo ancora rispondere'>
						<div class="input-group">
						<span class="input-group-addon" id="basic-addon-nonrisp">
							<span class="glyphicon glyphicon-check" style="color: #f00"></span>
						</span>	
						{{ Form::checkbox('Solononrisp',1, Input::old('rispondere'), ['class'=>'checkbox','describedby'=>'basic-addon-nonrisp']) }}
						</div>
					</div>
					@endif

					<div class='form-group col-xs-2 col-sm-2' title='Mostra solo le missive per PNG'>
						<div class="input-group">
						<span class="input-group-addon" id="basic-addon-solopng">
							Solo PNG
						</span>	
						{{ Form::checkbox('ConPNG',1, Input::old('ConPNG'), ['class'=>'checkbox','describedby'=>'basic-addon-solopng']) }}
					</div>
					</div>


					<div class='btn-group col-xs-12 col-sm-4'>
						{{ Form::submit('Cerca', array('class' => 'btn btn-success ')) }}
	
	
						<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#legenda">
						Legenda
						</button>
					</div>

				</div>
				<div class='row'>
					<div id="legenda" class="collapse col-xs-12">
						<div class='row'>
							<div class='col-xs-4 '>
								<p><span class=' pdfbutton glyphicon glyphicon-print'></span> Genera PDF</p>
							</div>
							<div class='col-xs-4 '>
								<p><span class=' glyphicon glyphicon-comment text-success'></span> Missiva tra PG</p>
							</div>
							<div class='col-xs-4 '>
								<p><span class=' glyphicon glyphicon-tower text-primary'></span> Nel Ducato</p>
							</div>
							<div class='col-xs-4 '>
								<p><span class=' glyphicon glyphicon-globe text-warning'></span> Missiva Estera</p>
							</div>
							<div class='col-xs-4 '>
								<p><span class=' glyphicon glyphicon-certificate text-danger'></span> Missiva Sicura</p>
							</div>
	
	
							@if (Auth::user()->usergroup == 7)
							<div class='col-xs-4 '>
								<p><span class='glyphicon glyphicon-flash' style='color:#FF6600;'></span> Intercettato</p>
							</div>
							@endif

						</div>
					</div>
				
				</div>
				{{Form::close()}}
		</div>
		<hr>
	
	{{--##### PAGINATOR ###########################################--}}
	<div id='pagine'></div>

	
	{{--##### LIST OF ELEMENTS ###########################################--}}
	<div class='row'>
		<div class='col-sm-6'>
			<ul class='media-list' id='results'></ul> 
		
		</div>
		<div id='lateral_panel' class='col-sm-6 hidden-xs'>
			<div class='media-body'>
				<header>
					<h5 id='mittente_sm'></h5>
					<h5 id='destinatario_sm'></h5>
				</header>
				
				<p id='testo_sm' class='justified '></p>
			</div>
		</div>
		
	</div>
	
@stop

@section('JS')
@stop

@section('Scripts')
	$( document ).ready(function() {
		@if (Auth::user()->usergroup == 7)
			var show_delete=true;
		@else
			var show_delete=false;
		@endif
		get_list_missive(1,show_delete);
		
	
	});


@stop
