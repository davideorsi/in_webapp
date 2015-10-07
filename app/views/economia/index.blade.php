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
	
		<div class='col-xs-5 col-xs-offset-0'>
			<h4>{{$Fazioni[0]['Fazione']}}</h4>
			<div class="input-group" style='margin-bottom:5px;'>
				<span class="input-group-addon primary" id="sizing-addon3" style='min-width:120px; text-align:right;'>
					<b>Condizione</b>
				</span>
					{{ Form::select('Condizione[0]', $selCondizione, $Fazioni[0]['Condizione'], ['class'=>'form-control']) }}
			</div>
			<div class="input-group" style='margin-bottom:5px;'>
				<span class="input-group-addon primary" id="sizing-addon3" style='min-width:120px; text-align:right;'>
					<b>Influenza</b>
				</span>
					{{ Form::input('number','Influenza[0]', $Fazioni[0]['Influenza'], ['class'=>'form-control']) }}
			</div>
			<div class="input-group">
				<span class="input-group-addon primary" id="sizing-addon3" style='min-width:120px; text-align:right;'>
					<b>Ricchezza</b>
				</span>
					{{ Form::input('number','Ricchezza[0]', $Fazioni[0]['Ricchezza'], ['class'=>'form-control']) }}
			</div>
		</div>
		
		<div class='col-xs-5 col-xs-offset-2'>
			<h4>{{$Fazioni[1]['Fazione']}}</h4>
			<div class="input-group" style='margin-bottom:5px;'>
				<span class="input-group-addon danger" id="sizing-addon3" style='min-width:120px; text-align:right;'>
					<b>Condizione</b>
				</span>
					{{ Form::select('Condizione[1]', $selCondizione, $Fazioni[1]['Condizione'], ['class'=>'form-control']) }}
			</div>
			<div class="input-group" style='margin-bottom:5px;'>
				<span class="input-group-addon danger" id="sizing-addon3" style='min-width:120px; text-align:right;'>
					<b>Influenza</b>
				</span>
				{{ Form::input('number','Influenza[1]', $Fazioni[1]['Influenza'], ['class'=>'form-control']) }}
			</div>
			<div class="input-group">
				<span class="input-group-addon danger" id="sizing-addon3" style='min-width:120px; text-align:right;'>
					<b>Ricchezza</b>
				</span>
					{{ Form::input('number','Ricchezza[1]', $Fazioni[1]['Ricchezza'], ['class'=>'form-control']) }}
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
					<span class="input-group-addon info" id="sizing-addon3" style='min-width:100px; text-align:right;'>
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
		

