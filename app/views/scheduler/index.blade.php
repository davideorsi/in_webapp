
@extends('admin')

	@section('CSS')
	{{ HTML::style('css/jquery-ui.min.css');}}
	{{ HTML::style('css/scheduler.css');}}
	@stop
	
	@section('content_outside')
	<!-- ELENCO PNG E MASTER-->
	<div >
		<div id="png-sidebar" data-spy="affix">
		<div class='row'>
			<h4> Lista dei PNG</h4>
			<ul class="nav nav-tabs nav-stacked ">
			@foreach ($Masters as $key=>$Master)
				<li><a data-toggle="tab" href="#menu{{$key}}">{{$Master['username']}}</a></li>
			@endforeach
			</ul>	
		</div>	
			
			<div class="tab-content " >
			@foreach ($Masters as $key=>$Master)
				<div id="menu{{$key}}" class="tab-pane fade">
				<ul id='elencopng' style='list-style-type: none; padding:0; margin:10px'>
			
				@foreach($Master['PNG'] as $png)
					<li style='position:relative'>
						<p>
							<span class='glyphicon glyphicon-user todrag' style=' margin:0px; font-size:1.6em; color: {{$Master["color"]}}' title='{{$png["Nome"]}}'>
								<input type='hidden' value="{{$png['ID']}}" class='png'></input>
							</span>
							{{$png["Nome"]}} </br> <small>{{$png["Ruolo"]}}</small>		
						</p>
						
					</li>
				@endforeach
				
				</ul>
				</div>
			@endforeach
			</div>
		</div>		
	</div>
	
	
	@stop
	
	@section('content')
	<div class='row'>
		<div class="col-xs-offset-1 col-xs-11 ">
			<h3>Ora per Ora</h3>


			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
	
			<div class="input-group" style='margin-bottom:10px; '>
				{{ Form::select('evento', $selectEventi, null, ['class'=>'form-control', 'id'=>'selectevento']) }}
			</div>
			<div class="btn-group" style='margin-bottom:10px; '>
			<a id='showevento' class="btn btn-primary" href="{{ URL::to('vicende/##') }}">Dettagli</a>
			<a id='grigliaevento' class="btn btn-success" href="{{ URL::to('vicende/##/master/') }}">Griglia</a>
			@foreach($Masters as $master)
				<a id="{{$master->id}}" class="master_btn btn btn-default" href="{{ URL::to('vicende/##/master/'.$master->id) }}">{{$master->username}}</a>
			@endforeach
			</div>	
			
		</div>
	</div>
	


	
	<!-- SCHEDULER-->
	<div class='row'>
		<div id="schedule" class='col-xs-offset-1 col-xs-11'></div>
	
		<div class='col-xs-offset-1 col-xs-11' style='margin-top:5px;'>
			<a class="btn btn-success" href="{{ URL::to('vicenda/create') }}">Aggiungi Vicenda</a>
		</div>	
	</div>	
	
	
	<!-- MODIFICA ELEMENTO -->
	<div class="overlay" id="overlay" style="display:none;"></div>
	<div id="edit_element" class="box">	
		<div class='row'>
		    <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12 ">	
				<h4 >Modifica Elemento</h4>
			</div>
		</div>
		{{ Form::model('', array('method' => 'PUT', 'url' => 'elemento/' ,'class'=>'pure-form pure-form-aligned','id'=>'form_edit' )) }}
		<div class='row'>
		        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12 ">
					{{ Form::label('text', 'Titolo') }}
					{{ Form::text('text',Input::old('text'), ['class'=>'form-control']) }}
				</div>
		</div>

		<div class='row'>
		        <div class="form-group col-sm-5 col-sm-offset-1">
					{{ Form::label('start', 'Inizio') }}
					{{ Form::text('start','', ['class'=>'form-control']) }}
				</div>

		        <div class="form-group col-sm-5 ">
					{{ Form::label('end', 'Fine') }}
					{{ Form::text('end','', ['class'=>'form-control']) }}
				</div>
		</div>		
		

        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12 ">
			{{ Form::hidden('vicenda', '', ['id'=>'vicenda'])}}
		</div>

		<div class='row'>
		        <div class="form-group col-sm-5 col-sm-offset-1 col-xs-12">
					{{ Form::textarea('data', Input::old('data'), ['id'=>'data','class'=>' form-control', 'style'=>'width:100%']) }}

					<div class="btn-group" style='margin-bottom:10px;'>
	
					{{ Form::submit('Modifica', array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
				
					{{ Form::open(array('id'=>'delete','url' => 'elemento/', 'style'=>'display:inline-block; margin-left: -2px;')) }}
					{{ Form::hidden('_method', 'DELETE') }}
					{{ Form::submit('Elimina', array('class' => 'btn btn-warning')) }}
					{{ Form::close() }}
					</div>

				</div>
				
				
		        <div id='pngminori' class="col-sm-5  col-xs-12">
					{{ Form::model('', array('method' => 'POST' ,'url'=>'', 'class'=>'form-inline','id'=>'form_png_minori' )) }}
					<div class="form-group">
						
						{{ Form::label('Master', 'Master',['class'=>'sr-only']) }}
						{{ 	Form::select('Master', $selMaster, null, ['class'=>'form-control']) }}					
					</div>
					<div class="form-group">
						{{ Form::label('pngminori', 'Png minori',['class'=>'sr-only']) }}
						{{ 	Form::text('pngminori', NULL, ['class'=>'form-control','placeholder'=>"es: zombie, mercanti, ecc..."]) }}											
					</div>
					<div class="form-group">
					{{ Form::button('<span class="glyphicon glyphicon-plus"></span>', array('type'=>'submit','class' => 'btn btn-success')) }}
					{{ Form::close() }}
					
					
					</div>
				</div>
					
		</div>
		
		
        <p class="chiudi">X</p>    
	</div> 
	

	<div id="insert_element" class="box row">		
		<div class='row'>
		    <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12 ">	
				<h4 >Inserisci Elemento</h4>
			</div>
		</div>
		{{ Form::open(array('url'=>'elemento','class'=>'form-aligned', 'id'=>'form_insert')) }}
		
		<div class='row'>
		        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12 ">
					{{ Form::label('text', 'Titolo') }}
					{{ Form::text('text',Input::old('text'), ['class'=>'form-control']) }}
				</div>
		</div>

		<div class='row'>
		        <div class="form-group col-sm-5 col-sm-offset-1">
					{{ Form::label('start', 'Inizio') }}
					{{ Form::text('start','', ['class'=>'form-control']) }}
				</div>

		        <div class="form-group col-sm-5 ">
					{{ Form::label('end', 'Fine') }}
					{{ Form::text('end','', ['class'=>'form-control']) }}
				</div>
		</div>		
		

        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12 ">
			{{ Form::hidden('vicenda', '', ['id'=>'vicenda'])}}
		</div>

		<div class='row'>
		        <div class="form-group col-sm-10 col-sm-offset-1 col-xs-12">
					{{ Form::textarea('data', Input::old('data'), ['id'=>'data','class'=>' form-control']) }}
				</div>
		</div>
		
        <div class="form-group col-sm-offset-1">
			{{ Form::submit('Aggiungi', array('class' => 'btn btn-success')) }}
		</div>
		{{ Form::close() }}
        <p class="chiudi">X</p>    
	</div> 
@stop

@section('JS')
{{ HTML::script('js/jquery-ui.min.js');}}
{{ HTML::script('js/jq.schedule.js');}}
{{ HTML::script('js/jquery.mousewheel.min.js');}}
@stop



@section('Scripts')
		$(function(ready) {
			$('#selectevento').change( function() {
				var idevento=$(this).val();
				$("#schedule").empty()
				$('#showevento').attr('href', 'vicende/'+idevento);
				$('#grigliaevento').attr('href', 'vicende/'+idevento+'/master/');
				$('.master_btn').attr('href', function(){
					return 'vicende/'+idevento+'/master/'+$(this).attr('id')
					});
				initialize_scheduler("#schedule");
				$(".sc_main_box").mousewheel(function(event, delta) {
					this.scrollLeft -= (delta * 150);
					event.preventDefault();
				});			

			});
			
			
			$('.master_btn').attr('href', function(){
					return 'vicende/'+$('#selectevento').val()+'/master/'+$(this).attr('id')
					});
			$('#showevento').attr('href', 'vicende/'+$('#selectevento').val());
			$('#grigliaevento').attr('href', 'vicende/'+$('#selectevento').val()+'/master/');
		    initialize_scheduler("#schedule");
		    $(".sc_main_box").mousewheel(function(event, delta) {
					this.scrollLeft -= (delta * 150);
					event.preventDefault();
				});	
							
				
			
			$(".chiudi").click(
				function(){
				$('#overlay').fadeOut('fast');
				$('.box').hide();
		    });
		    
		    $("#elencopng .glyphicon").draggable({ 
				containment: "window",
				revert: 'invalid', 
				helper: 'clone',
				appendTo: '.container'
				}).tooltip();
			
		});
@stop
