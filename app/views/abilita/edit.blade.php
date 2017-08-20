@extends('admin')

	
	@section('content')
		<div class='row'>
			<div class='col-sm-6'>
				<h3>Modifica Abilità</h3>
				@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
			</div>
		</div>
				{{ Form::model($abilita, array('method' => 'PUT', 'url' => 'admin/abilita/'.$abilita->ID)) }}

		<div class='row'>
		        <div class="form-group col-sm-6 ">
					{{ Form::label('Ability', 'Ability') }}
					{{ Form::text('Ability', null, ['class'=>'form-control']) }}
				</div>

						
		        <div class="form-group col-sm-6">
					{{ Form::label('Categoria', 'Categoria') }}
					{{ Form::select('Categoria', $categorieSelect, null, ['class'=>'form-control'])}}
				</div>
		</div>
		<div class='row'>
						
		        <div class="form-group col-xs-2">
					{{ Form::label('PX', 'PX') }}
					{{ Form::selectRange('PX', -5, 12, null, ['class'=>'form-control']) }}
				</div>

		        <div class="form-group col-xs-2">
					{{ Form::label('CartelliniPotere', 'Cart. Pot.') }}
					{{ Form::selectRange('CartelliniPotere', 0, 20, null, ['class'=>'form-control']) }}
				</div>

				<div class="form-group col-xs-2">
					{{ Form::label('Erbe', 'Erbe') }}
					{{ Form::selectRange('Erbe', 0, 20, null, ['class'=>'form-control']) }}
				</div>
				
				<div class="form-group col-xs-2">
					{{ Form::label('Oggetti', 'Oggetti') }}
					{{ Form::selectRange('Oggetti', 0, 20, null, ['class'=>'form-control']) }}
				</div>
					
				<div class="form-group col-xs-2">
					{{ Form::label('Rendita', 'Rendita') }}
					{{ Form::selectRange('Rendita', 0, 100, null, ['class'=>'form-control']) }}
				</div>
		</div>
		<div class='row'>
		        <div class="form-group col-md-6">
					{{ Form::label('Descrizione', 'Descrizione') }}
					{{ Form::textarea('Descrizione', null, ['size' => '50x5', 'class'=>'form-control', 'placeholder' => 'Descrizione dell\'abilita']) }}

					{{ Form::label('Note', 'Note') }}
					{{ Form::textarea('Note', null, ['size' => '50x5', 'class'=>'form-control', 'placeholder' => 'Note (compaiono sulla scheda PG)']) }}

					<div class="form-group">
						{{Form::label('Generica', 'Generica')}}
						{{ Form::checkbox('Generica', 1 )}}
					</div>
			
			        <div class="form-group">
						{{ Form::submit('Modifica abilità', array('class' => 'btn btn-primary')) }}
					</div>
					{{ Form::close() }}
				</div>

				
				<!--############## REQUISITI ABILITA'############################ -->
		        <div class="form-group col-md-6">
					<table class='table table-striped'>
						<thead>
							<th >Requisiti</th>
							<th class='center_tx'>Elimina</th>
						</thead>
						<tbody>
						
						@foreach ($abilita['Requisiti'] as $req)
							<tr>
								<td>{{$req['Ability']}}</td>
								<td class='center_tx'>
								{{ Form::model($req, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin/abilita_requisito', 'class'=>'pure-form')) }}
								{{ Form::hidden('Req',$req['ID'])}}
								{{ Form::hidden('ID',$abilita['ID']) }}
								{{ Form::submit('Elimina', array('class' => 'btn btn-warning')) }}
								{{ Form::close()}}
								</td>
							</tr>
						
						@endforeach	

							<tr>
								<td colspan='1'>
									{{ Form::model($abilita, array('files'=>true, 'method' => 'POST', 'url' => 'admin/abilita_requisito', 'class'=>'pure-form')) }}
									{{ Form::select('Req', $tutte, null, ['class'=>'form-control']) }}
									{{ Form::hidden('ID',$abilita['ID'])}}
								</td>
								<td colspan='1'>
									{{ Form::submit('Aggiungi', array('class' => 'btn btn-success')) }}
									{{ Form::close()}}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				
				<!--############## ESCLUDI ABILITA'############################ -->
		        <div class="form-group col-md-6">
					<table class='table table-striped'>
						<thead>
							<th >Abilità escluse</th>
							<th class='center_tx'>Elimina</th>
						</thead>
						<tbody>
						
						@foreach ($abilita['Esclusi'] as $esc)
							<tr>
								<td>{{$esc['Ability']}}</td>
								<td class='center_tx'>
								{{ Form::model($esc, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin/abilita_esclusa', 'class'=>'pure-form')) }}
								{{ Form::hidden('Esc',$esc['ID'])}}
								{{ Form::hidden('ID',$abilita['ID']) }}
								{{ Form::submit('Elimina', array('class' => 'btn btn-warning')) }}
								{{ Form::close()}}
								</td>
							</tr>
						
						@endforeach	

							<tr>
								<td colspan='1'>
									{{ Form::model($abilita, array('files'=>true, 'method' => 'POST', 'url' => 'admin/abilita_esclusa', 'class'=>'pure-form')) }}
									{{ Form::select('Esc', $tutte, null, ['class'=>'form-control']) }}
									{{ Form::hidden('ID',$abilita['ID'])}}
								</td>
								<td colspan='1'>
									{{ Form::submit('Aggiungi', array('class' => 'btn btn-success')) }}
									{{ Form::close()}}
								</td>
							</tr>
						</tbody>
					</table>
				</div>	
					
				<!--############## OPZIONI ABILITA'############################ -->	
		        <div class="form-group col-md-6">
					<table>
						<thead>
							<tr>
								<th>Opzione</th>
								<th>Costo (in Rame)</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($abilita->Opzioni as $opzione)
								<tr>
									<td>{{$opzione['Opzione']}}</td>
									<td>{{$opzione['Costo']}}</td>
									<td>
								{{ Form::model($abilita, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin/abilita_opzione', 'class'=>'pure-form')) }}
								{{ Form::hidden('Abilita',$abilita['ID']) }}
								{{ Form::hidden('Opzione',$opzione['ID']) }}
								{{ Form::submit('X', array('class' => 'btn btn-warning')) }}
								{{ Form::close()}}
									</td>
								</tr>
							@endforeach
							
								{{ Form::model($abilita, array('files'=>true, 'method' => 'POST', 'url' => 'admin/abilita_opzione', 'class'=>'pure-form')) }}
									{{ Form::hidden('Abilita',$abilita['ID']) }}
								<tr>
									<td>
										{{ Form::text('Opzione', null, ['class'=>'form-control']) }}
									</td>
									<td>
										{{ Form::input('number','Costo', 0, ['class'=>'form-control', 'style'=>'max-width:100px;']) }}
									</td>
									<td>
										{{ Form::submit('+', array('class' => 'btn btn-success')) }}
									</td>
								</tr>
								{{ Form::close()}}

						</tbody>
					</table>
		        </div>
		</div>
		


	@show
	
	
			
@stop
