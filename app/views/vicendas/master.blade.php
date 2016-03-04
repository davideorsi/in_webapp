@extends('admin')


	@section('CSS')
	{{ HTML::style('css/jquery-te-1.4.0.css');}}
	@stop
		
	@section('content')
		<h3>Dettagli della trama - {{$master['username']}} <a href="{{ URL::previous() }}" class='btn btn-success'><span class='glyphicon glyphicon-arrow-left' aria-hidden="true"></span></a></h3>
		</br>
	@foreach( $elementi as $elemento)	
		<div class='row'>
			
			<h4 class='center_title'>Dalle <span class='orario'>{{$elemento->start}}</span> alle <span class='orario'>{{$elemento->end}}</span>: {{$elemento->text}}</h4>
			<h4 class='center_title'>Vicenda:
				<a href="#" onclick="rollup('{{'e'.$elemento['ID'].'v'.$elemento['vicenda']}}');">
					{{$vicende[array_search($elemento['vicenda'],INtools::select_column($vicende,'ID'))]->title}}
				</a>
			</h4>
			
			<div id="{{'e'.$elemento['ID'].'v'.$elemento['vicenda']}}" class='vicenda col-xs-12 col-sm-offset-2 col-sm-8'>
			<p>{{$vicende[array_search($elemento['vicenda'],INtools::select_column($vicende,'ID'))]->body}}</p>
			</div>
			
			<div class='col-xs-12 col-sm-offset-1 col-sm-6'>
			<p>{{$elemento->data}}</p>
			</div>
			<div class='col-xs-12 col-sm-4'>
				<h5>PNG</h5>
				<ul>
					@foreach($elemento->png as $png)
						<li style='color: {{$png->color}}'><a style='color: {{$png->color}}' href="{{URL::to('admin/png/'.$png->ID)}}">{{$png->Nome}}</a> ({{$png->nomeuser}})</li>
					@endforeach
				</ul>
				<h5>PNG minori</h5>
				<ul>
					@foreach($elemento->pngminori as $png)
						<li style='color: {{$png->color}}'>{{$png->PNG}} ({{$png->nomeuser}})</li>
					@endforeach
				</ul>
			</div>
		</div>
		<div class="separator">
				{{ HTML::image('img/divider.png') }}
		</div>
		
		
	@endforeach
	
	@show
	
			
@stop

@section('Scripts')
	$(document).ready(function () {
		$('.orario').text(function(){
				return moment($(this).text(),"YYYY-MM-DD HH:mm").format("HH:mm");
			});
		$( ".vicenda" ).slideUp();	
	});
	
	function rollup(str) {
	  if ( $( "#"+str ).is( ":hidden" ) ) {
	    $( "#"+str ).slideDown();
	  } else {
	    $( "#"+str ).slideUp();
	  }
	}
	
	
@stop
