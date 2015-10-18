@extends('admin')

	
	@section('content')
	<div>
		<h3>Economia</h3>

		@if ( Session::has('message'))
			<div class="alert alert-info">
				{{ Session::get('message') }}
			</div>
		@endif
	</div>
	{{ Form::model('', array('files'=>false, 'method' => 'PUT', 'url' => 'admin/economia')) }}

	
	<div class='row'>
	
		<div class='col-xs-6 col-xs-offset-0'>
			<h4>{{$Fazioni[0]['Fazione']}}</h4>
			<div class="input-group" style='margin-bottom:5px;'>
				<span class="input-group-addon primary" id="sizing-addon3" style='min-width:140px; text-align:right;'>
					<b>Condizione</b>
				</span>
					{{ Form::select('Condizione[0]', $selCondizione, $Fazioni[0]['Condizione'], ['class'=>'form-control']) }}
			</div>
			<div class="input-group" style='margin-bottom:5px;'>
				<span class="input-group-addon primary" id="sizing-addon3" style='min-width:140px; text-align:right;'>
					<b>Influenza</b>
				</span>
					{{ Form::input('number','Influenza[0]', $Fazioni[0]['Influenza'], ['class'=>'form-control']) }}
			</div>
			<div class="input-group" style='margin-bottom:5px;'>
				<span class="input-group-addon primary" id="sizing-addon3" style='min-width:140px; text-align:right;'>
					<b>Penalità* (MR)</b>
				</span>
					{{ Form::input('number','Sovratassa[0]', $Fazioni[0]['Sovratassa'], ['class'=>'form-control']) }}
			</div>
			<div class="input-group" style='margin-bottom:5px;'>
				<span class="input-group-addon primary" id="sizing-addon3" style='min-width:140px; text-align:right;'>
					<b>Ricchezza&dagger; (MO)</b>
				</span>
					{{ Form::input('number','Ricchezza[0]', $Fazioni[0]['Ricchezza'], ['class'=>'form-control','min'=>'0', 'max'=>'3']) }}
			</div>
		</div>
		
		<div class='col-xs-6 col-xs-offset-0'>
			<h4>{{$Fazioni[1]['Fazione']}}</h4>
			<div class="input-group" style='margin-bottom:5px;'>
				<span class="input-group-addon danger" id="sizing-addon3" style='min-width:140px; text-align:right;'>
					<b>Condizione</b>
				</span>
					{{ Form::select('Condizione[1]', $selCondizione, $Fazioni[1]['Condizione'], ['class'=>'form-control']) }}
			</div>
			<div class="input-group" style='margin-bottom:5px;'>
				<span class="input-group-addon danger" id="sizing-addon3" style='min-width:140px; text-align:right;'>
					<b>Influenza</b>
				</span>
				{{ Form::input('number','Influenza[1]', $Fazioni[1]['Influenza'], ['class'=>'form-control']) }}
			</div>
			<div class="input-group" style='margin-bottom:5px;'>
				<span class="input-group-addon danger" id="sizing-addon3" style='min-width:140px; text-align:right;'>
					<b>Penalità* (MR)</b>
				</span>
					{{ Form::input('number','Sovratassa[1]', $Fazioni[1]['Sovratassa'], ['class'=>'form-control']) }}
			</div>
			<div class="input-group" style='margin-bottom:5px;'>
				<span class="input-group-addon danger" id="sizing-addon3" style='min-width:140px; text-align:right;'>
					<b>Ricchezza&dagger; (MO)</b>
				</span>
					{{ Form::input('number','Ricchezza[1]', $Fazioni[1]['Ricchezza'], ['class'=>'form-control','min'=>'0', 'max'=>'3']) }}
			</div>
			
		</div>
		<div class='col-xs-12'>
			<p>* Penalità: deficit di monete, espresso in monete di Rame,
			dovuto ad un eccessivo prelievo di denaro -con mancato reinvestimento- 
			nei territori. Se alla fine del live il denaro presente nei territori
			è inferiore al minimo dato dalla propria Condizione, il deficit è 
			scalato dal denaro disponibile al live successivo.</p>
			<p>&dagger; Ricchezza: surplus, espresso in monete d'Oro, al 
			denaro disponibile nel territorio
			assegnato per motivi di regolamento o trama. 
			Minimo:0 MO. Massimo: 3MO.</p>
		
		</div>
		
		<div class="col-xs-12">
			<div class="col-xs-6" style='padding-left:0px;'>
				<div class="panel panel-info">
				  <div class="panel-heading">
				    <h3 class="panel-title">Status La Rochelle</h3>
				  </div>
				  <div class="panel-body">
					<dl class="dl-horizontal">
					  <dt>Ricchezza Complessiva</dt>
					  <dd>{{$Fazioni[0]['Totale']}}</dd>
					</dl>
					<dl class="dl-horizontal">
					  <dt>Minimo da reinvestire</dt>
					  <dd>{{$Fazioni[0]['Minimo']}}</dd>
					</dl>
				  </div>
				</div>
			</div>
			<div class="col-xs-6 col-xs-offset-0" style='padding-right:0px;'>
				<div class="panel panel-danger">
				  <div class="panel-heading">
				    <h3 class="panel-title">Status Nottingham</h3>
				  </div>
				  <div class="panel-body">
					<dl class="dl-horizontal">
					  <dt>Ricchezza Complessiva</dt>
					  <dd>{{$Fazioni[1]['Totale']}}</dd>
					</dl>
					<dl class="dl-horizontal">
					  <dt>Minimo da reinvestire</dt>
					  <dd>{{$Fazioni[1]['Minimo']}}</dd>
					</dl>
				  </div>
				</div>
			</div>
		</div>
	<br>
	<hr>
	<div class='row'>
			<div class='col-xs-4'>
				<h4>Indici Rarità</h4>
				@foreach($Beni as $Bene)
				<div class="input-group">
					<span class="input-group-addon info" id="sizing-addon3" style='min-width:110px; text-align:right;'>
						<b>{{$Bene['Nome']}}</b>
					</span>
					{{ Form::input('number','IR[]', $Bene['IR'], ['class'=>'form-control', 'min'=>'0', 'max'=>'3', 'step'=>'0.1']) }}
				</div>
				@endforeach
			</div>
			
			<div class='col-xs-7 col-xs-offset-1'>
				<table class='table table-striped'>
				<tr>
					<th>N° Beni:<br>{{$Nbeni}}</th>
					<th>Il Mercato<br>VENDE a</th>
					<th>Il Mercato<br>COMPRA a</th>
				</tr>
				@foreach($Beni as $Bene)
					<tr>
						<th>{{$Bene['Nome']}}</th>
						<td>{{$Bene['PV']}}</td>
						<td>{{$Bene['PA']}}</td>
					</tr>
				@endforeach
				</table>
			</div>
	</div>
	
	<div class='row'>
		<div class="form-group btn-group">
		{{ Form::submit('Aggiorna', array('class' => 'btn btn-success')) }}
		</div>
	</div>
	
	{{ Form::close() }}

@stop
@section('Scripts')
		$(function(ready) {
			
		});
@stop
		

