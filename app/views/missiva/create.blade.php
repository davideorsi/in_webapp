@extends('layouts.master')

	@section('CSS')
	{{ HTML::style('css/jquery-te-1.4.0.css');}}
	@stop
	@section('content')
		<div class='row'>
			<div class='col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2'>
				<h3>Nuova Missiva</h3>
				@if ( Session::has('message'))
					<div id='info' class="alert alert-info">
						{{ Session::get('message') }}
					</div>
				@endif
			
				{{ Form::open(array('url'=>'missive')) }}
				{{ Form::hidden('missivaOriginale', $Missiva, ['class'=>'form-control']) }}
		        <div class="form-group">
					@if (Auth::user()->usergroup == 7)
					{{ Form::label('mittente', 'Mittente') }}
					{{ Form::text('mittente', null, ['class'=>'form-control']) }}
					@else
					{{ Form::label('destinatario_PNG', 'Destinatario (PNG)') }}
					{{ Form::text('destinatario_PNG', null, ['class'=>'form-control']) }}
					@endif
				</div>
							
		        <div class="form-group">
					{{ Form::label('destinatario', 'Destinatario (PG)') }}
					{{ Form::select('destinatario', $selVivi, null, ['class'=>'form-control selectform']) }}
				</div>
						
		        <div class="form-group">
					{{ Form::label('tipo', 'Tipo') }}
					{{ Form::select('tipo', $costo, 2, ['class'=>'form-control']) }}
				</div>
	        
				<p class="alert alert-success">{{ 'Data di invio: '}}<strong>{{$data}}</strong></p>
							
		        <div class="form-group">
					{{ Form::label('testo', 'Testo') }}
					{{ Form::textarea('testo', Input::old('testo'), array('class'=>'form-control selectform', 'placeholder' => 'Il testo della missiva')) }}
				</div>
				
				<div class="form-group">
					@if (Auth::user()->usergroup == 7)
						{{ Form::label('firma', 'Identità Destinatario') }}
					@else
						{{ Form::label('firma', 'Firma') }}
					@endif
					{{ Form::select('firma', $firme, null, ['class'=>'form-control selectform']) }}
				</div>
						
		        <div class="form-group">
					{{ Form::submit('Invia Missiva', array('class' => 'btn btn-primary')) }}
				</div>
				{{ Form::close() }}
	
			</div>
		</div>
	@show
	
@stop
@section('JS')
{{ HTML::script('js/jquery-te-1.4.0.min.js');}}
@stop

@section('Scripts')
		$(function(ready) {
			$("textarea").jqte({ol: false, ul:false, sup:false, sub:false, link:false, unlink:false, source:false});			
		
			
		$('#destinatario').change(() => {
			if ($(this).val() !== '0') { // check input value
				$('#tipo').val('0');
				$('#destinatario_PNG').val('');
				$('#tipo > option[value="0"]').show();
				$('#tipo > option[value="1"]').hide();
				$('#tipo > option[value="3"]').hide();
				$('#tipo > option[value="10"]').hide();
			}
		});
		
		$('#destinatario_PNG').on("input", function(){
			if ($(this).val() !== '') { // check input value
				$('#destinatario').val('0');
				$('#tipo > option[value="0"]').hide();
				$('#tipo > option[value="1"]').show();
				$('#tipo > option[value="3"]').show();
				$('#tipo > option[value="10"]').show();
				$('#tipo').val('3');
			}
		});
		
		});
		
@stop
