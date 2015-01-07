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
					<div class='form-group col-sm-5 col-xs-12'>
						{{ Form::label('PG', 'Personaggio') }}
					{{ Form::select('PG', $selPG, Input::old('PG'), ['class'=>'form-control']) }}
					</div>
					
					<div class='form-group col-sm-7 col-xs-6'>
						{{ Form::label('Testo', 'Testo') }}
						{{ Form::text('Testo', Input::old('testo'), ['class'=>'form-control','placeholder'=>'Cerca tra le missive usando parole chiave, es: "spia"']) }}
					</div>

					<div class='form-group col-sm-5 col-xs-6'>
						{{ Form::label('PNG', 'PNG') }}
						{{ Form::text('PNG', Input::old('PNG'), ['class'=>'form-control']) }}
					</div>

					<div class='form-group col-sm-2 col-xs-4'>
						{{ Form::label('Data', 'Data') }}
						{{ Form::text('Data', Input::old('Data'), ['class'=>'form-control']) }}
					</div>

					@if (Auth::user()->usergroup == 7)
					<div class='form-group col-xs-3 col-sm-3'>
						{{ Form::label('Intercettato', 'Intercettata') }}
						{{ Form::checkbox('Intercettato',1, Input::old('intercettato'), ['class'=>'checkbox']) }}
					</div>
					@endif

					<div class='form-group col-xs-3 col-sm-3' style='min-width:105px;'>
						{{ Form::label('ConPNG', 'Da/Per PNG') }}
						{{ Form::checkbox('ConPNG',1, Input::old('ConPNG'), ['class'=>'checkbox']) }}
					</div>

				</div>
				<div class='row'>

					<div class='btn-group class=col-sm-4 col-xs-6'>
						{{ Form::submit('Cerca', array('class' => 'btn btn-success ')) }}
	
	
						<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#legenda">
						Legenda
						</button>
					</div>

					<div id="legenda" class="collapse col-sm-8 col-xs-6">
						<div class='row'>
						<div class='col-md-4 col-sm-6 col-xs-12'>
							<p><span class=' pdfbutton glyphicon glyphicon-print'></span> Genera PDF</p>
						</div>
						<div class='col-md-4 col-sm-6 col-xs-12'>
							<p><span class=' glyphicon glyphicon-comment text-success'></span> Missiva tra PG</p>
						</div>
						<div class='col-md-4 col-sm-6 col-xs-12'>
							<p><span class=' glyphicon glyphicon-tower text-primary'></span> Missiva nel Ducato</p>
						</div>
						<div class='col-md-4 col-sm-6 col-xs-12'>
							<p><span class=' glyphicon glyphicon-globe text-warning'></span> Missiva Estera</p>
						</div>
						<div class='col-md-4 col-sm-6 col-xs-12'>
							<p><span class=' glyphicon glyphicon-certificate text-danger'></span> Missiva Sicura</p>
						</div>


						@if (Auth::user()->usergroup == 7)
						<div class='col-md-4 col-sm-6 col-xs-12'>
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
		<div class='col-sm-6' id='results'>
		
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
