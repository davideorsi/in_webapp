@extends('admin')

	
	@section('content')
		<div>
			<h3>Modifica PG</h3>

			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
		</div>
		
		{{ Form::model($PG, array('files'=>true, 'method' => 'PUT', 'url' => 'admin/pg/'.$PG->ID)) }}

		<div class="row">
	        <div class="col-md-6">
			        <div class="form-group">
						{{ Form::label('Nome', 'Nome') }}
						{{ Form::text('Nome', null,['class'=>'form-control']) }}
					</div>
	
			        <div class="form-group">
						{{ Form::label('NomeGiocatore', 'Nome Giocatore') }}
						{{ Form::text('NomeGiocatore', null,['class'=>'form-control']) }}
					</div>
					
					<div class="form-group">
						{{ Form::label('Email', 'Email') }}
						{{ Form::email('Email', null,['class'=>'form-control']) }}
					</div>
	
					<div class="form-group">
						{{ Form::label('Affiliazione', 'Fazione') }}
						{{ Form::select('Affiliazione', $sel_affiliazione, null, ['class'=>'form-control']) }}
					</div>

					<div class='row'>
						<div class="form-group col-xs-3">
							{{ Form::label('Px', 'Px (liberi: '.$PG['PxRimasti'].')') }}
							{{ Form::input('number','Px', null,['class'=>'form-control']) }}
						</div>
		
						<div class="form-group col-xs-3">
							{{ Form::label('Sesso', 'Sesso') }}
							{{ Form::select('Sesso', array('M'=>'Uomo','F'=>'Donna'), null, ['class'=>'form-control']) }}
						</div>
						<div class="form-group col-xs-3">
							{{ Form::label('Morto', 'Morto') }}
							{{ Form::checkbox('Morto', 1,null,['class'=>'checkbox']) }}
						</div>
		
						<div class="form-group col-xs-3">
							{{ Form::label('InLimbo', 'In Limbo') }}
							{{ Form::checkbox('InLimbo', 1,null,['class'=>'checkbox']) }}
						</div>
					</div>

					<div class="form-group btn-group">
						{{ Form::submit('Modifica PG', array('class' => 'btn btn-primary')) }}
						<a href={{ URL::to('admin/pg') }} class='btn btn-default'> Torna all'elenco</a>
					</div>
					
				</div>
	            <div class="col-md-6">
			        <div class="form-group">
						{{ Form::label('background', 'Background')}}
						{{ Form::textarea('background', null, ['size'=>'50x16']) }}
					</div>
				</div>

							
			{{ Form::close() }}
				
			</div>
				
			<!-- ABILITA'-->
			<div class='row'>	
				<div class="col-md-6">
					<table class='table table-striped'>
						<thead>
							<th >Abilità</th>
							<th class='center_tx'>Elimina</th>
						</thead>
						<tbody>
						@foreach ($PG['Abilita'] as $abilita)
							<tr>
								<td>{{ $abilita['Ability'].' ('.$abilita['PX'].'px)' }} </td>
								<td class='center_tx'>
								{{ Form::model($PG, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin/pg_abilita', 'class'=>'pure-form')) }}
								{{ Form::hidden('ID',$PG['ID'])}}
								{{ Form::hidden('Abilita',$abilita['ID']) }}
								{{ Form::submit('Elimina', array('class' => 'btn btn-warning')) }}
								{{ Form::close()}}
								</td>
							</tr>
						@endforeach

							<tr>
								<td colspan='1'>
									{{ Form::model($PG, array('files'=>true, 'method' => 'PUT', 'url' => 'admin/pg_abilita', 'class'=>'pure-form')) }}
									{{ 	Form::select('Abilita', $PG['abilita_unlocked'], null, ['class'=>'form-control']) }}
									{{ Form::hidden('ID',$PG['ID'])}}
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
						@foreach ($PG['Categorie'] as $categoria)
							<tr>
								<td>{{ $categoria['Categoria'] }}</td>
								
								<td class='center_tx'>
									{{ Form::model($PG, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin/pg_categoria', 'class'=>'pure-form')) }}
									{{ Form::hidden('ID',$PG['ID'])}}
									{{ Form::hidden('Categoria',$categoria['ID']) }}
									{{ Form::submit('Elimina', array('class' => 'btn btn-warning')) }}
									{{ Form::close()}}
								</td>
							</tr>
						@endforeach
						@if (!empty($PG['categorie_unlocked']))
							<tr>
							<td colspan='1'>
								{{ Form::model($PG, array('files'=>true, 'method' => 'PUT', 'url' => 'admin/pg_categoria', 'class'=>'pure-form')) }}
								{{ 	Form::select('Categoria', $PG['categorie_unlocked'], null, ['class'=>'form-control']) }}
								{{ Form::hidden('ID',$PG['ID'])}}
							</td>
							<td colspan='1'>
								{{ Form::submit('Aggiungi', array('class' => 'btn btn-success')) }}
								{{ Form::close()}}
							</td>
							</tr>
						@endif	
						</tbody>
					</table>

					<!-- ####### ABILITA' SPECIALI SBLOCCATE ########-->
					<table class='table table-striped'>
						<thead>
							<th >Abilità Speciali Sbloccate</th>
							<th class='center_tx'>Elimina</th>
						</thead>
						<tbody>
						@foreach ($PG['Sbloccate'] as $ab)
							<tr>
								<td>{{ $ab['Ability'].' ('.$ab['PX'].'px)' }} </td>
								<td class='center_tx'>
								{{ Form::model($PG, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin/pg_sbloccate', 'class'=>'pure-form')) }}
								{{ Form::hidden('ID',$PG['ID'])}}
								{{ Form::hidden('Abilita',$ab['ID']) }}
								{{ Form::submit('Elimina', array('class' => 'btn btn-warning')) }}
								{{ Form::close()}}
								</td>
							</tr>
						@endforeach

							<tr>
								<td colspan='1'>
									{{ Form::model($PG, array('files'=>true, 'method' => 'PUT', 'url' => 'admin/pg_sbloccate', 'class'=>'pure-form')) }}
									{{ 	Form::select('Abilita', $PG['speciali_unlocked'], null, ['class'=>'form-control']) }}
									{{ Form::hidden('ID',$PG['ID'])}}
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
						@foreach ($PG['Incanti'] as $incanto)
							<tr>
								<td>{{ $incanto['Nome'] }} ({{$incanto['Livello']}})</td>
								<td class='center_tx'>
									{{ Form::model($PG, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin/pg_incanto', 'class'=>'pure-form')) }}
									{{ Form::hidden('ID',$PG['ID'])}}
									{{ Form::hidden('Incanto',$incanto['ID']) }}
									{{ Form::submit('Elimina', array('class' => 'btn btn-warning')) }}
									{{ Form::close()}}
								</td>
							</tr>
						@endforeach
							<tr>
								<td colspan='1'>
									{{ Form::model($PG, array('files'=>true, 'method' => 'PUT', 'url' => 'admin/pg_incanto', 'class'=>'pure-form')) }}
									{{ 	Form::select('Incanto', $PG['incanti_unlocked'], null, ['class'=>'form-control']) }}
									{{ Form::hidden('ID',$PG['ID'])}}
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

@section('Scripts')
$(".checkbox").bootstrapSwitch('size','mini');
@stop
