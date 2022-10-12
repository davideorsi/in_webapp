@extends('layouts.master')
  <style>
		table {
				border-collapse: collapse;
				width: 100%;
				}

		th, td {
		text-align: left;
		padding: 8px;
		}

		tr:nth-child(even) {background-color: #f2f2f2;}

	 </style>

	@section('content')
	<h3>Rotte Commerciali</h3>

	<div class='row'>
		<div class='col-sm-12'>



			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif


			<div class='form-group'>
				<?php $keys= array_keys($selectMercanti); ?>

				@if (Auth::user()->usergroup == 7)

				{{ Form::open(array('method' => 'PUT', 'url' => 'admin/rotte/genera', 'class'=>'form-inline')) }}
				{{ Form::submit('Genera Rotte per Tutti', array('class' => 'btn btn-success')) }}
				{{ Form::select('selectMercanti', $selectMercanti, $keys[0], ['class'=>'form-control', 'id'=>'selectMercanti']) }}
				{{ Form::close() }}
				@endif

				<br>
				<p id='tabella_rotte'>
				@if (Auth::user()->usergroup != 7)
				{{ Form::model([], array('files'=>true, 'method' => 'PUT', 'url' => 'rotte', 'class'=>'form-inline')) }}

				<table>

						<tr><th>Acquistati</th><th>Oggetto</th><th>Costo</th><th>Disponibili</th></tr>

							@foreach($sel as $opt)
								<tr>
										<td>

											{{ Form::input('number','numero[]',$opt['Acquistati'], ['class'=>'form-control','style'=>'width:60px;']) }}

											{{ Form::hidden('ID[]',$opt['ID'])}}
											{{ Form::hidden('number_old[]',$opt['Acquistati'])}}
											{{ Form::hidden('oggetto[]',$opt['Opzione'])}}
											{{ Form::hidden('costo[]',$opt['Costo'])}}
											{{ Form::hidden('disponibile[]',$opt['Disponibili'])}}
											{{ Form::hidden('evento[]',$opt['evento'])}}
										</td>
										<td>{{$opt['Opzione']}}</td>
										<td>{{ INtools::convertiMonete($opt['Costo'])}}</td>
										<td>{{$opt['Disponibili']}}</td>
									</tr>
							@endforeach



				</table>
				{{ Form::submit('Conferma', array('class' => 'btn btn-success')) }}
				{{ Form::close() }}

				@else

				@endif

				</p>
				@if (Auth::user()->usergroup == 7)
				<p id = 'btn_rigenera'>
					<a id='rigeneraRotta' class="btn btn-primary" href="#" onclick='rigenera_rotte()'>Ri-Genera Rotte per questo PG</a>
				</p>
				@endif
			</div>

		</div>

	</div>
@stop


@section('Scripts')
		$(function(ready) {
			$('#selectMercanti').change( function() {
				$('#rigeneraRotta').attr('onclick', 'rigenera_rotte('+$(this).val()+')');

				get_rotte($(this).val());
			});
			get_rotte($('#selectMercanti').val());
		});
@stop
