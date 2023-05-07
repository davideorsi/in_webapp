@extends('admin')
		
@section('content')
		<div class='row'>



		    <div class="col-sm-10 col-sm-offset-1 col-xs-12">
				<p>Clicca sui titoli per espandere il contenuto</p>
				<h2 style='color:#00308F' > Trama Multilive " {{$trama->title }} "</h2>
				<p  class='text-justify'>
					{{$trama->body}}
				</p>
			</div>	
			@foreach ($vicende as $vic)
			<div class="col-sm-10 col-sm-offset-1 col-xs-12">
				<hr>
				<h3>{{$vic->title}} ({{$vic->Evento}} - {{$vic->Data}})</h3>
				<p>{{ $vic->body }}</p>
			
	
				
				
				@foreach ($vic['schedule'] as $elemento)
					<div class="col-sm-11 col-sm-offset-1 col-xs-12">
						<hr>
						<h4>{{$elemento->text }}</h4>
						<p>Inizio: {{$elemento->start }} - Fine: {{$elemento->end }}</p>
						<p>{{$elemento->data }}</p>
						
						
						<div class="col-xs-offset-1 col-xs-5 ">
						<h6>PNG</h6>
						<ul>
							@foreach($elemento->png as $png)
							<li>{{$png->Nome}} ({{$png->nomeuser}})</li>
							@endforeach
						</ul>
						</div>
						<div class="col-xs-offset-1 col-xs-5 ">
						<h6>PNG secondari</h6>
						<ul>
							@foreach($elemento->pngminori as $png)
							<li>{{$png->PNG}} ({{$png->nomeuser}})</li>
							@endforeach
						</ul>
						</div>
						
					</div>	
				@endforeach
			</div>	
				
			@endforeach
			
			
			
			
		</div>

		

	
			
@stop

@section('Scripts')
$(document).ready(function(){
	$("h3").click(function(){
			$(this).nextUntil("h3").slideToggle();	
		});
	$("h3").nextUntil("h3").hide();
});
@stop
