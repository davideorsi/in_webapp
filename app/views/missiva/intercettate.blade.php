@extends('layouts.master')

@section('content')


<h3>Inoltro Missive Intercettate</h3>

{{ Form::open(array('url'=>'admin/intercettate','class'=>'form-inline')) }}

<div class='col-md-6'>
	<h4>Ultime missive intercettate</h4>
	<p class='justified'>Qui sotto sono elencate le missive intercettate nel corso del mese precedente a quello della voce di locanda corrente.</p>
	<p class='justified'>Ad ogni personaggio con "Infiltrato" è stata assegnata casualmente una missiva, senza controlli: è necessario verificare di non mandare una missiva intercettata
	al suo mittente o destinatario.</p>
	<div>
	@foreach($missive as $key => $missiva)
	<ul class='media-list' id='results'>
		<li class='media gray_border'>
			<div class='collapse-group'>
				<div class='media-heading gray_border' style='width:100%'>
					<b style='font-size: 120%;'>{{$key+1}}</b>  ({{$missiva['data']}}) Da: {{$missiva['mitt']}} A: {{$missiva['dest']}}
				</div>
				<div class='collapse'>
					<p class='justified'>
					{{nl2br($missiva['testo'])}}
					</p>
					
					{{ Form::hidden('idmissiva[]', $missiva['id']) }}
					{{ Form::label('nota[]', 'Note del master') }}
					{{ Form::textarea('nota[]',NULL, array('class'=>'form-control selectform', 'placeholder' => 'Eventuale nota del master relativa alla missiva.')) }}
					
				</div>
				
			</div>
		</li>
	</ul>
	@endforeach
	</div>
	<hr></hr>
</div>    

<div class='col-md-6'>
	<h4>Destinatari</h4>
	
			
	@foreach($PG as $pers)
	<div class="form-group">
		{{ Form::hidden('PG[]', $pers['ID'] ) }}
		{{ Form::label('missiva[]', $pers['Nome'].' - '.$pers['NomeGiocatore'],['style'=>'margin-right:10px;']) }}
		{{ Form::select('missiva[]', $selMissiva, $pers['missiva'],['class'=>'form-control','style'=>'width:60px']) }}	
	</div>
	@endforeach
	<br>
	<div class="form-group">
		{{ Form::submit('Invia Missive', array('class' => 'btn btn-primary', "onclick"=>"if(!confirm('Sei sicuro di voler inviare?')){return false;};")) }}
	</div>
</div>    

{{ Form::close() }}


@stop

@section('Scripts')
	
	$( document ).ready(function() {
		
		$('.media .media-heading').on('click', function(e) {
	    e.preventDefault();
	    $('.media-heading').removeClass('missiva_clicked');
	    $(this).addClass('missiva_clicked');

	    var collapse = $(this).closest('.collapse-group').find('.collapse');
		collapse.collapse('toggle');
		
		});

	});
	
@stop
