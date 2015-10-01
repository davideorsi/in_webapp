@extends('admin')

@section('CSS')

{{ HTML::style('css/jquery.jqplot.min.css');}}

@stop

@section('content')
<div>
		<h3>{{$Evento['Titolo']}} <small>{{$Evento['Data']}}</small></h2>
</div>


	<!-- ################## RIASSUNTO ############################-->
	<div class='col-sm-10 col-sm-offset-1'>

		<div class="panel panel-default">
		<div class="panel-heading">Amministrazione	</div>
			<div class="panel-body">
				<div class="input-group">
					<span class="input-group-addon">Schede iscritti</span>
					{{ HTML::link('/admin/schede', 'Genera!', array('class' => 'btn btn-primary form-control'), false)}}
				</div>
			</div>
		
			<table class='table table-striped'>
				<thead>
					<tr>
						<td></td>
						<th>Iscritti</th>
						<th>Cenano</th>
						<th>Pernotto</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td>{{count($Evento['PG'])}}</td>
						<td>{{$Evento['cenano']}}</td>
						<td>{{$Evento['pernottano']}}</td>
					</tr>
				</tbody>
				
				<hr>
				<hr>
				
				<thead>
					<tr>
						<td></td>
						<th>Nottingham</th>
						<th>La Rochelle</th>
						<th>Non Affiliati</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>Iscritti</th>
						<td>{{$affiliazione['Nottingham']}}</td>
						<td>{{$affiliazione['La Rochelle']}}</td>
						<td>{{$affiliazione['Non Affiliati']}}</td>
					</tr>
					<tr>
						<th>Rendite<br/>Fazione</th>
						<td>{{$secondaria['Nottingham']}}</td>
						<td>{{$secondaria['La Rochelle']}}</td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>



	<div class="col-sm-10 col-sm-offset-1">
		<div class='row panel panel-default' style='padding:10px; margin: 0px'>
		<!-- AGGIUNGI MANUALMENTE UNA ISCRIZIONE -->
		{{ Form::model([], array('files'=>true, 'method' => 'POST', 'url' => 'admin', 'class'=>'pure-form')) }}
			
			<div class='col-xs-12 col-sm-12 col-md-6'>
			{{ Form::label('PG', 'Personaggio',['style'=>'width:100%']) }}
			{{ Form::select('PG', $selVivi, null, ['class'=>'form-control selectform', 'id'=>'selVivi']) }}
			{{ Form::hidden('Evento',$Evento['ID']) }}
			</div>
			<div class='col-xs-12 col-sm-12 col-md-6'>
			{{ Form::label('Note','Note',['style'=>'width:100%']) }}		
			{{ Form::input('text','Note','', ['class'=>'form-control'])}}
			</div>
			<div class='col-xs-12 col-sm-4 col-md-3'>
			{{ Form::label('Arrivo','Arrivo',['style'=>'width:100%']) }}		
			{{ Form::input('time','Arrivo','14:00', ['class'=>'form-control'])}}
			</div>
			<div class='col-xs-4 col-sm-3 col-md-2'>
			{{ Form::label('Cena', 'Cena',['style'=>'width:100%']) }}
			{{ Form::checkbox('Cena',1,null,['class'=>'checkbox']) }}
			</div>
			<div class='col-xs-4 col-sm-3 col-md-2'>
			{{ Form::label('Pernotto', 'Pernotto',['style'=>'width:100%']) }}
			{{ Form::checkbox('Pernotto',1,null,['class'=>'checkbox']) }}
			</div>
			<div class='col-xs-4 col-sm-2 col-md-2'>
			{{ Form::submit('Iscrivi', array('class' => 'btn btn-success','style'=>'margin-top: 24px;')) }}
			{{ Form::close()}}
			</div>
		</div>
	</div>
	
	<div class="col-sm-10 col-sm-offset-1">	
		<h5><strong>Elenco degli iscritti</strong></h5>
		<table class='table table-striped table-condensed'>
			<thead>
				<th>Nome</th>
				<th>Arrivo</th>
				<th>Cena</th>
				<th>Pernotto</th>
				<th>Rendita<br>Totale</th>
				<th>Debiti<br>Missive</th>
				<th>Denaro&nbsp;in<br>Busta</th>
				<th>Oggetti&nbsp;in<br>Busta</th>
				<th>Note-Altro</th>
				<th>Pagato</th>
				<th></th>
			</thead>
			
		<tbody>
		<!-- ISCRIZIONI -->			
		@foreach ($Evento['PG'] as $PG)
	
			<tr>
				<td>{{$PG['Nome']}}<br><small>{{$PG['NomeGiocatore']}}</small></td>
				<td align = "center">{{$PG['pivot']['Arrivo']}}</td>
				<td align = "center">
					@if ($PG['pivot']['Cena'])
						<span class='glyphicon glyphicon-ok'></span>
					@endif
				</td>
				<td align = "center">
					@if ($PG['pivot']['Pernotto'])
						<span class='glyphicon glyphicon-ok'></span>
					@endif
				</td>
				<td>{{$PG['Rendita_tot']}}</td>
				<td>{{$PG['Debiti_tot']}}</td>
				<td class='{{$PG['class_denaro']}}'>{{$PG['Denaro_busta']}}</td>
				<td>
					@if($PG->Erbe()>0)
					{{$PG->Erbe()}}&nbsp;erbe
					<br>
					@endif
					@if($PG->CartelliniPotere()>0)
					{{$PG->CartelliniPotere()}}&nbsp;potere
					@endif
				</td>
				<td>
					@if (!empty($PG['pivot']['Note']))
						{{$PG['pivot']['Note']}}
					@endif
				</td>
				
				<td align = "center">
					{{ Form::model($PG, array('files'=>true, 'method' => 'PUT', 'url' => 'admin', 'class'=>'pure-form')) }}
					{{ Form::hidden('PG',$PG['ID'])}}
					{{ Form::hidden('Evento',$Evento['ID']) }}
					{{ Form::hidden('Pagato',!$PG['pivot']['Pagato'])}}
					@if ($PG['pivot']['Pagato']=='1')
						{{ Form::submit('Si', array('class' => 'btn btn-success btn-xs')) }}
					@else
						{{ Form::submit('No', array('class' => 'btn btn-default btn-xs')) }}
					@endif
					{{ Form::close()}}
				</td>
				
				<td align = "center">
					{{ Form::model($PG, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin', 'class'=>'pure-form')) }}
					
					{{ Form::hidden('PG',$PG['ID'])}}
					{{ Form::hidden('Evento',$Evento['ID']) }}
					{{ Form::submit("x", array('class' => 'btn btn-warning btn-xs')) }}
					{{ Form::close()}}

				</td>
			</tr>
		@endforeach
		</tbody>
		</table>
	</div>





@stop

@section('JS')
	
@stop

@section('Scripts')
@stop
