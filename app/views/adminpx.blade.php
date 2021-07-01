@extends('admin')

@section('CSS')



@stop

@section('content')
<div>
		<h3>{{$Evento['Titolo']}} <small>{{$Evento['Data']}}</small></h2>
</div>

<div class='list-group'>
	

		
		<h5><strong>Elenco degli iscritti</strong></h5>
		
		{{ Form::open(array('url'=>'admin/px')); }}
		{{ Form:: submit('Assegna i PX',
			array("onclick"=>"if(!confirm('Sei sicuro di aver controllato tutto?')){return false;};",
			'class'=>'btn btn-primary',
			'style'=>'margin-bottom:10px;'));
		 }}
		
		<!-- ISCRIZIONI -->			
		@foreach ($Evento['PG'] as $PG)
			
		<div class='row list-group-item'>
			<div class='col-xs-8'>
			{{$PG['Nome']}}<br><small>{{$PG['NomeGiocatore']}}</small>
			</div>
			<div class='col-xs-2'>	
			{{$PG['Px']}} px
			</div>	
			<div class='col-xs-2'>
			{{Form::hidden('pg[]',$PG['ID'] )}}
			@if (strcmp($Evento['Tipo'], "EVENTO LIVE") == 0)
			{{Form::input('number','px[]','3',array('style'=>'max-width:40px;'))}}
			@else
			{{Form::input('number','px[]','1',array('style'=>'max-width:40px;'))}}
			@endif
			</div>
		</div>	
		
		@endforeach
		
		{{ Form::close() }}




@stop

@section('JS')
	
@stop

@section('Scripts')
@stop
