@extends('admin')


	@section('CSS')
	{{ HTML::style('css/jquery-te-1.4.0.css');}}
	@stop
		
	@section('content')
		<h3>Dettagli della trama <a href="{{URL::to('scheduler')}}" class='btn btn-success'><span class='glyphicon glyphicon-arrow-left' aria-hidden="true"></span></a></h3>
		</br>
	@foreach( $vicende as $vicenda)	
		{{ Form::model($vicenda, array('method' => 'PUT', 'url' => 'vicenda/'.$vicenda->ID ,'class'=>'pure-form pure-form-aligned')) }}
		
		<div class='row' style='position:relative; border-left: 5px solid {{$vicenda->color}}; margin-bottom:20px;'>
	        <div class="form-group col-xs-1 ">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span>', array('type'=>'submit','class' => 'btn btn-default btn-flat')) }}
			</div>
			
	        <div class="form-group col-xs-6 ">
	        <div class="input-group">
				<span class="input-group-addon" id="basic-addon-titolo">Titolo</span>
				{{ Form::text('title',null, ['class'=>'form-control','describedby'=>"basic-addon-titolo"]) }}
				{{ Form::hidden('live',null) }}
			</div>
			</div>

	        <div class="form-group col-xs-5 ">
	        <div class="input-group">
				<span class="input-group-addon" id="basic-addon-trama">Trama</span>
				{{ Form::select('trama', $selectTrama, null, ['class'=>'form-control','describedby'=>"basic-addon-trama"])}}
			</div>
			</div>
			
	        <div class="form-group col-xs-12" style='position:relative; top:-25px;'>
				{{ Form::textarea('body', null, ['class'=>' editor', 'style'=>'height:auto']) }}	
			</div>
			
		{{ Form::close() }}
			<!-- ELEMENTI #########################################-->
			@foreach($vicenda->schedule as $elemento)
				<div class='col-xs-12' style='position:relative; top:-50px; margin-bottom:-50px;'>
					{{ Form::model($elemento, array('method' => 'PUT', 'url' => 'elemento/'.$elemento->ID ,'class'=>'pure-form pure-form-aligned','id'=>'form_edit' )) }}
					<div class="form-group col-xs-offset-1 col-xs-1 " style='border-left: solid 5px #ccc; padding-bottom:5px;'>
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span>', array('type'=>'submit','class' => 'btn btn-default btn-flat')) }}
					</div>
					<div class="form-group col-xs-10 " style=' padding-bottom:5px;'>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon-titolo">Titolo</span>
							{{ Form::text('text',Input::old('text'), ['class'=>'form-control','describedby'=>"basic-addon-titolo"]) }}
						</div>
					</div>
					<div class="form-group col-xs-offset-1 col-xs-5 " style='border-left: solid 5px #ccc; top:-16px;'>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon-inizio">Inizio</span>
							{{ Form::text('start',Input::old('start'), ['class'=>'form-control','describedby'=>"basic-addon-inizio"]) }}
						</div>
					</div>
					<div class="form-group col-xs-offset-1 col-xs-5 " style=' top:-16px;'>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon-fine">Fine</span>
							{{ Form::text('end',Input::old('end'), ['class'=>'form-control','describedby'=>"basic-addon-fine"]) }}
						</div>
					</div>
					
					<div class="form-group col-xs-offset-1 col-xs-11 " style='border-left: solid 5px #ccc; top:-55px;'>
					{{ Form::hidden('vicenda', $vicenda->ID, ['id'=>'vicenda'])}}
					{{ Form::textarea('data', Input::old('data'), ['id'=>'data','class'=>' form-control', 'style'=>'width:100%; margin-bottom:0px']) }}
					</div>
				
					{{ Form::close() }}
					
					
					<!--################# PNG #####################-->
					<div class="form-group col-xs-offset-1 col-xs-5 " style='position:relative; top:-50px;'>
						<h6>PNG</h6>
						<ul>
							@foreach($elemento->png as $png)
							<li style='color: {{$png->color}}'>{{$png->Nome}} ({{$png->nomeuser}})</li>
							@endforeach
						</ul>
					</div>
					<div class="form-group col-xs-offset-1 col-xs-5 " style='position:relative; top:-50px;'>
						<h6>PNG secondari</h6>
						<ul>
							@foreach($elemento->pngminori as $png)
							<li style='color: {{$png->color}}'>{{$png->PNG}} ({{$png->nomeuser}})</li>
							@endforeach
						</ul>
					</div>
					
				</div>
			@endforeach
			</div>
	@endforeach
	
	@show
	
			
@stop

@section('JS')
{{ HTML::script('js/jquery-te-1.4.0.min.js');}}
@stop

@section('Scripts')
		$(function(ready) {
			$("textarea").jqte();			
		});
@stop
