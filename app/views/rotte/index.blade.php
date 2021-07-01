@extends('layouts.master')

	
	@section('content')
	<h3>Rotte Commerciali</h3>
	
	<div class='row'>
		<div class='col-sm-6'>



			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
	

			<div class='form-group'>
				<?php $keys= array_keys($selectMercanti); ?>
				
				@if (Auth::user()->usergroup == 7)
				
				{{ Form::open(array('method' => 'PUT', 'url' => 'admin/rotte/genera', 'class'=>'form-inline')) }}
				{{ Form::submit('Genera Rotte', array('class' => 'btn btn-success')) }}			
				{{ Form::select('selectMercanti', $selectMercanti, $keys[0], ['class'=>'form-control', 'id'=>'selectMercanti']) }}
				{{ Form::close() }}
				@endif
				
				<br>
				<p id='tabella_rotte'>
				@if (Auth::user()->usergroup != 7)
				{{ Form::model([], array('files'=>true, 'method' => 'PUT', 'url' => 'rotte', 'class'=>'form-inline')) }}
				<table >
						<tr><th colspan=4></th></tr>
						<tr><td>Numero</td><td>Oggetto</td><td>Costo</td><td>Disponibili</td></tr>
						
							@foreach($sel as $opt)
								<tr>
										<td>
											
											{{ Form::input('number','numero[]',$opt['Acquistati'], ['class'=>'form-control','style'=>'width:50px;']) }}
											
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
				<p id = 'btn_modifica'>
					<a id='editaRotta' class="btn btn-primary" href="{{ URL::to('admin/rotte/'.$keys[0].'/modifica') }}">Modifica</a>
				</p>
				@endif
			</div>
			
		</div>

	</div>
@stop


@section('Scripts')
		$(function(ready) {
			$('#selectMercanti').change( function() {
				$('#editaRotta').attr('href', 'rotte/'+$(this).val()+'/modifica');
				
				get_rotte($(this).val());
			});
			get_rotte($('#selectMercanti').val());
		});
@stop
		

