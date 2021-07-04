@extends('admin')

	
	@section('content')
	<div class='row'>
		<div class='col-sm-6'>
			<h3>Licenze Commerciali<h3>


			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
	
			
			<div class="form-group">
				{{ Form::open() }}
				{{ Form::select('licenza', $selectLicenze, null, ['class'=>'form-control', 'id'=>'selectlicenza']) }}
				{{ Form::close() }}
			</div>
			<?php $keys= array_keys($selectLicenze); ?>

			<div class="form-group">
				<h4  id='licenza_nome'></h4>
				<h5>Prezzo:  <span id='licenza_prezzo'></span></h5>
				<h5>Disponibilità:  <span id='licenza_disponibili'></span></h5>
				<h5>Durata:  <span id='licenza_durata'></span></h5>
				<h5>Permette:  <span id='licenza_permette'></span></h5>
				<h5>Limitazioni:  <span id='licenza_limitazioni'></span></h5>
				<h5>Tassazione:  <span id='licenza_tassazione'></span></h5>
			</div>
	
			<div class="btn-group" style='margin-bottom:10px;'>
			<a id='printlicenza' class="btn btn-default" href="{{ URL::to('admin/licenza/'.$keys[0]) }}">Stampa</a>
			<a id='editlicenza' class="btn btn-primary" href="{{ URL::to('admin/licenza/'.$keys[0].'/edit') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('admin/licenza/create') }}">Nuova</a>
			{{ Form::open(array('id'=>'dellicenza','url' => 'admin/licenza/' . $keys[0], 'style'=>'display:inline-block; margin-left: -2px;')) }}
			{{ Form::hidden('_method', 'DELETE') }}
			{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}
			</div>
		</div>
		<div class='col-sm-6'>
			<h3>Assegna Licenza a PG<h3>
			<div class="form-group">
				{{ Form::open(array('id'=>'assegnalicenza','files'=>true, 'method' => 'PUT','url' => 'admin/licenza-pg/', 'style'=>'display:inline-block; margin-left: -2px;')) }}
				{{ Form::select('IDlicenza', $selectLicenze, null, ['class'=>'form-control', 'id'=>'listlicenza']) }}
				{{ Form::select('IDpg', $selectPG, null, ['class'=>'form-control', 'id'=>'listpg']) }}
				{{ Form::select('Data', $selectEventi, null, ['class'=>'form-control', 'id'=>'listEvento']) }}
				<h5>{{ Form::label('Prezzo', 'Prezzo') }}</h5>{{ Form::text('Prezzo', null, ['class'=>'form-control']) }}
				{{ Form::submit('Assegna', array('class' => 'btn btn-primary')) }}
				{{ Form::close() }}
			</div>				
		</div>
	</div>
	
	<div class='row'>
		<div class='col-sm-12'>
			<h5><strong>Elenco delle Licenze attive</strong></h5>
		<table class='table table-striped table-condensed'>
			<thead>
				<th>Licenza</th>
				<th>Nome PG</th>
				<th>Inizio</th>
				<th>Ultimo Rinnovo</th>
				<th>Numero Rinnovi</th>
				<th>Prezzo</th>
				<th>Prezzo al rinnovo</th>
				<th></th>
				<th></th>
			</thead>
			
		<tbody>
			@foreach($listalicenze as $lic)
			<tr>
				<td>{{$lic['Licenza'];}}</td>
				<td>{{$lic['NomePG'];}}</td>
				<td>{{$lic['Inizio'];}}</td>
				<td>{{$lic['UltimoRinnovo'];}}</td>
				<td>{{$lic['Rinnovi'];}}</td>
				<td>{{$lic['Prezzo'];}}</td>
				<td>
					{{ Form::open(array('id'=>'rinnovalicenza','files'=>true, 'method' => 'PUT','url' => 'admin/rinnova-licenza-pg/', 'style'=>'display:inline-block; margin-left: -2px;')) }}
					{{ Form::hidden('IDpg',$lic['IDPG'])}}
					{{ Form::hidden('IDLicenza',$lic['IDLicenza']) }}
					{{ Form::text('PrezzoRinnovo', null, ['class'=>'form-control']) }}
				</td>
				<td>	
					{{ Form::hidden('DataRinnovo',$datacorrente)}}
					{{ Form::hidden('Rinnovi',$lic['Rinnovi'])}}
					{{ Form::submit('Rinnova', array('class' => 'btn btn-success')) }}
					{{ Form::close()}}
				</td>
				<td>
					{{ Form::open(array('id'=>'scadelicenza','files'=>true, 'method' => 'PUT','url' => 'admin/licenza-pg-scaduta/', 'style'=>'display:inline-block; margin-left: -2px;')) }}
					{{ Form::hidden('IDpg',$lic['IDPG'])}}
					{{ Form::hidden('IDLicenza',$lic['IDLicenza']) }}
					{{ Form::submit('Scaduta', array('class' => 'btn btn-warning')) }}
					{{ Form::close()}}
				</td>
			</tr>	
			@endforeach				
			
		</tbody>
		</table>
		</div>
	</div>
	
@stop
@section('Scripts')
		$(function(ready) {
			$('#selectlicenza').change( function() {
				$('#printlicenza').attr('href', 'licenza/'+$(this).val());
				$('#editlicenza').attr('href', 'licenza/'+$(this).val()+'/edit');
				$('#dellicenza').attr('action', 'licenza/'+$(this).val());
				get_licenza($(this).val());
			});
			get_licenza(1);
		});
@stop
		

