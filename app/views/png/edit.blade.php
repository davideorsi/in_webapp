@extends('admin')

	
	@section('content')
		<div>
			<h3>Modifica PNG</h3>

			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
		</div>
		
		{{ Form::model($PNG, array('files'=>true, 'method' => 'PUT', 'url' => 'admin/png/'.$PNG->ID)) }}

		<div class="row">
	        <div class="col-md-6">
			        <div class="form-group">
						{{ Form::label('Nome', 'Nome') }}
						{{ Form::text('Nome', null,['class'=>'form-control']) }}
					</div>
	
			        <div class="form-group">
						{{ Form::label('Ruolo', 'Ruolo') }}
						{{ Form::text('Ruolo', null,['class'=>'form-control']) }}
					</div>

			        <div class="form-group">
						{{ Form::label('Master', 'Master') }}
						{{ 	Form::select('Master', $selMaster, null, ['class'=>'form-control']) }}					
					</div>
					
					<div class='row'>
						<div class="form-group col-xs-3">
							{{ Form::label('Px', 'Px') }}
							{{ Form::input('number','Px', null,['class'=>'form-control']) }}
						</div>

						<div class="form-group col-xs-3">
							{{ Form::label('Morto', 'Morto') }}
							{{ Form::checkbox('Morto', 1,null,['class'=>'checkbox']) }}
						</div>
		
					</div>

					<div class="form-group btn-group">
						{{ Form::submit('Modifica PNG', array('class' => 'btn btn-primary')) }}
						<a href={{ URL::to('admin/png') }} class='btn btn-default'> Torna all'elenco</a>
					</div>
				</div>
				
	            <div class="col-md-6">
			        <div class="form-group">
						{{ Form::label('Descrizione', 'Descrizione')}}
						{{ Form::textarea('Descrizione', null, ['size'=>'40x12']) }}
					</div>
				</div>
			</div>
			
			{{ Form::close() }}
				
				<!-- ABILITA'-->
			<div class='row'>	
				<div class="col-md-6">
					<table class='table table-striped'>
						<thead>
							<th >Abilità</th>
							<th class='center_tx'>Elimina</th>
						</thead>
						<tbody>
						@foreach ($PNG['Abilita'] as $abilita)
							<tr>
								<td>{{ $abilita['Ability'].' ('.$abilita['PX'].'px)' }} </td>
								<td class='center_tx'>
								{{ Form::model($PNG, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin/png_abilita', 'class'=>'pure-form')) }}
								{{ Form::hidden('ID',$PNG['ID'])}}
								{{ Form::hidden('Abilita',$abilita['ID']) }}
								{{ Form::submit('Elimina', array('class' => 'btn btn-warning')) }}
								{{ Form::close()}}
								</td>
							</tr>
						@endforeach

							<tr>
								<td colspan='1'>
									{{ Form::model($PNG, array('files'=>true, 'method' => 'PUT', 'url' => 'admin/png_abilita', 'class'=>'pure-form')) }}
									{{ 	Form::select('Abilita', $PNG['abilita_unlocked'], null, ['class'=>'form-control']) }}
									{{ Form::hidden('ID',$PNG['ID'])}}
								</td>
								<td colspan='1'>
									{{ Form::submit('Aggiungi', array('class' => 'btn btn-success')) }}
									{{ Form::close()}}
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				

				<div class="col-md-6">
					<!-- CATEGORIE-->
					<table class='table table-striped'>
						<thead>
							<th colspan='1'>Classi di Abilità</th>
							<th class='center_tx'>Elimina</th>
						</thead>
						<tbody>
						@foreach ($PNG['Categorie'] as $categoria)
							<tr>
								<td>{{ $categoria['Categoria'] }}</td>
								
								<td class='center_tx'>
									{{ Form::model($PNG, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin/png_categoria', 'class'=>'pure-form')) }}
									{{ Form::hidden('ID',$PNG['ID'])}}
									{{ Form::hidden('Categoria',$categoria['ID']) }}
									{{ Form::submit('Elimina', array('class' => 'btn btn-warning')) }}
									{{ Form::close()}}
								</td>
							</tr>
						@endforeach
						
						<tr>
							<td colspan='1'>
								{{ Form::model($PNG, array('files'=>true, 'method' => 'PUT', 'url' => 'admin/png_categoria', 'class'=>'pure-form')) }}
								{{ 	Form::select('Categoria', $PNG['categorie_unlocked'], null, ['class'=>'form-control']) }}
								{{ Form::hidden('ID',$PNG['ID'])}}
							</td>
							<td colspan='1'>
								{{ Form::submit('Aggiungi', array('class' => 'btn btn-success')) }}
								{{ Form::close()}}
							</td>
						</tr>
							
						</tbody>
					</table>

					<!-- INCANTI-->
					<table class='table table-striped'>
						<thead>
							<th >Incanti</th>
							<th class='center_tx'>Elimina</th>
						</thead>
						<tbody>
						@foreach ($PNG['Incanti'] as $incanto)
							<tr>
								<td>{{ $incanto['Nome'] }} ({{$incanto['Livello']}})</td>
								<td class='center_tx'>
									{{ Form::model($PNG, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin/png_incanto', 'class'=>'pure-form')) }}
									{{ Form::hidden('ID',$PNG['ID'])}}
									{{ Form::hidden('Incanto',$incanto['ID']) }}
									{{ Form::submit('Elimina', array('class' => 'btn btn-warning')) }}
									{{ Form::close()}}
								</td>
							</tr>
						@endforeach
							<tr>
								<td colspan='1'>
									{{ Form::model($PNG, array('files'=>true, 'method' => 'PUT', 'url' => 'admin/png_incanto', 'class'=>'pure-form')) }}
									{{ 	Form::select('Incanto', $PNG['incanti_unlocked'], null, ['class'=>'form-control']) }}
									{{ Form::hidden('ID',$PNG['ID'])}}
								</td>
								<td colspan='1'>
									{{ Form::submit('Aggiungi', array('class' => 'btn btn-success')) }}
									{{ Form::close()}}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>		
	

	
		</div>
	@show
	
	
			
@stop
