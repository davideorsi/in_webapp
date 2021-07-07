@extends('admin')


	@section('CSS')
	{{ HTML::style('css/jquery-te-1.4.0.css');}}
	@stop
		
	@section('content')
		<?php $widthperc=90/(count($data['Masters'])+1); ?>
		<h3>Griglia degli avvenimenti <a href="{{ URL::previous() }}" class='btn btn-success'><span class='glyphicon glyphicon-arrow-left' aria-hidden="true"></span></a></h3>
		<p style="margin-bottom:20px;">Porta il mouse sopra la griglia per vedere i dettagli di ogni elemento.</p>
		
		<div id='griglia' style='position:relative; width=100%'>
			<table class='table table-striped'>
				<!--### HEADER DELLA TABELLA ########-->
				<thead>
					<tr>
						<th style='width:10%'>Ore:</th>
						@foreach ($data['Masters'] as $master)
							<th style="width:{{$widthperc}}%">{{$master->username}}</th>
						@endforeach
						<th style="width:{{$widthperc}}%">Altro</th>
					</tr>
			    </thead>
			    <tbody>
					<!--### CREAZIONE DELLA GRIGLIA DELLE ORE ########-->
					<?php 
						if($data['ID']==54){$date = Datetime::createFromFormat('Y-m-d H:i','2000-01-01 18:30'); $NN=63;} 
						else if($data['ID']==58){$date = Datetime::createFromFormat('Y-m-d H:i','2000-01-01 11:30'); $NN=25;} 
						else if($data['ID']==59){$date = Datetime::createFromFormat('Y-m-d H:i','2000-01-01 10:30'); $NN=27;} 
						else {$date = Datetime::createFromFormat('Y-m-d H:i','2000-01-01 13:30'); $NN=25;} 
						
					?>
					@for ($i = 0; $i < $NN; $i++)
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
					class='griglia master{{$key}}' 
					data-toggle="tooltip" title="<b>{{$elemento['Titolo']}}</b></br>{{strip_tags($elemento['Info'])}}" 
					data-placement="auto left"
					style="background-color:{{$data['Vicende'][$keyVicenda]['color']}}; width:{{$widthperc-0.1}}%; top:{{$elemento['Start']*3+38}}px; left:{{$key*$widthperc+10}}%; height:{{($elemento['End']-$elemento['Start'])*3-2}}px">
					<h5>{{$elemento['Titolo']}}</h5>
					
					<p>PNG: {{$elemento['Png']}}</br>
					<span class='small'>Vicenda: {{$data['Vicende'][$keyVicenda]['title']}}</span>
					</p>
				</div>
				@endforeach
			@endforeach
			
		
		</div>

	@show
	
			
@stop


@section('JS')
	{{ HTML::script('js/jquery.overlaps.js');}}
@stop

@section('Scripts')
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip({html: true}); 
	    
	    for (var jMaster=0; jMaster<5; jMaster++){
		    var list= $('.griglia.master'+jMaster).overlaps();
		    
			for (var i=0; i<list.length; i++){
					list.eq(i).width(0.5*list.eq(i).width()-1);
				if (i%2) {
					var pos=list.eq(i).position();
					var posleft=pos.left / list.eq(i).parent().width() * 100;
					list.eq(i).css({top: pos.top, left: posleft+{{$widthperc/2}}+'%'});
				}
			}
			
			
		}
	});	
	
	
@stop
