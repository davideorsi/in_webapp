@extends('admin')


	@section('CSS')
	{{ HTML::style('css/jquery-te-1.4.0.css');}}
	@stop
		
	@section('content')
		<h3>Griglia degli avvenimenti <a href="{{ URL::previous() }}" class='btn btn-success'><span class='glyphicon glyphicon-arrow-left' aria-hidden="true"></span></a></h3>
		<p style="margin-bottom:20px;">Porta il mouse sopra la griglia per vedere i dettagli di ogni elemento.</p>
		
		<div id='griglia' style='position:relative; width=100%'>
			<table class='table table-striped'>
				<!--### HEADER DELLA TABELLA ########-->
				<thead>
					<tr>
						<th style='width:10%'>Ore:</th>
						@foreach ($data['Masters'] as $master)
							<th style='width:18%'>{{$master->username}}</th>
						@endforeach
						<th style='width:18%'>Altro</th>
					</tr>
			    </thead>
			    <tbody>
					<!--### CREAZIONE DELLA GRIGLIA DELLE ORE ########-->
					<?php  $date = Datetime::createFromFormat('Y-m-d H:i','2000-01-01 13:30'); ?>
					@for ($i = 0; $i < 25; $i++)
					<tr style='height:90px'>	
						<?php  $date = $date->add(new DateInterval('PT30M')); ?>
						<th>{{ $date->format('H:i'); }}</th>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					@endfor
				</tbody>	
			</table>
			
			<!--### INSERIMENTO DEGLI ELEMENTI #######################-->
			@foreach ($data['Attivita'] as $key=>$per_master)
				@foreach ($per_master as $elemento)
				<?php $keyVicenda = array_search($elemento['Vicenda'], INtools::select_column($data['Vicende'], 'ID')); ?>
				<div 
					class='griglia' 
					style="background-color:{{$data['Vicende'][$keyVicenda]['color']}}; top:{{$elemento['Start']*3+38}}px; left:{{$key*18+10}}%; height:{{($elemento['End']-$elemento['Start'])*3}}px"
				>
					<h5
						data-toggle="tooltip" title="{{strip_tags($elemento['Info'])}}" 
						data-placement="bottom" 
					>{{$elemento['Titolo']}}</h5>
					
					<p>PNG: {{$elemento['Png']}}</br>
					<span class='small'>Vicenda: {{$data['Vicende'][$keyVicenda]['title']}}</span>
					</p>
				</div>
				@endforeach
			@endforeach
			
		
		</div>

	@show
	
			
@stop

@section('Scripts')
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip(); 
	});	
@stop
