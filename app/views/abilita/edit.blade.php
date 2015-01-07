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
						
		        <div class="form-group col-xs-3">
					{{ Form::label('PX', 'PX') }}
					{{ Form::selectRange('PX', -5, 12, null, ['class'=>'form-control']) }}
				</div>

		        <div class="form-group col-xs-3">
					{{ Form::label('CartelliniPotere', 'Cart. Pot.') }}
					{{ Form::selectRange('CartelliniPotere', 0, 20, null, ['class'=>'form-control']) }}
				</div>

				<div class="form-group col-xs-3">
					{{ Form::label('Erbe', 'Erbe') }}
					{{ Form::selectRange('Erbe', 0, 20, null, ['class'=>'form-control']) }}
				</div>
					
				<div class="form-group col-xs-3">
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
