@extends('admin')

	@section('content')
	<div class='row'>
		<div class='col-sm-6 col-sm-offset-3'>
			<h3>Connessioni Utenti - PG</h3>


			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif


			<table class='table table-striped'>
				<thead>
					<th >Utente</th>
					<th >Personaggio</th>
					
					<th></th>
					<th></th>
					
				</thead>
				<tbody>
					<tr>
						<!--### FORM DI AGGIUNTA -->
						{{ Form::model($freeUser, array('files'=>true, 'method' => 'POST', 'url' => 'admin/userpg', 'class'=>'pure-form')) }}
						<td>
							{{ Form::select('User', $freeUser, [], ['class'=>'form-control']) }}
						</td>
						<td>
							{{ Form::select('PG', $selVivi, [], ['class'=>'form-control']) }}
						</td>
						<td>
							{{ Form::submit('Aggiungi', array('class' => 'btn btn-success')) }}
						</td>
						{{ Form::close()}}

					</tr>

					
						<!--### CONNESSIONI ESISTENTI-->
					@foreach ($selUser as $User)
						<tr>
							<td>{{ $User['nome'] }}</td>
							
							<td>{{ $User['nomepg'] }}</td>
							<td>
								{{ Form::model($User, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin/userpg/'.$User['id'], 'class'=>'pure-form')) }}
								{{ Form::hidden('PG',$User['idpg']) }}
								{{ Form::submit('Elimina', array('class' => 'btn btn-warning')) }}
								{{ Form::close()}}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>			

		</div>
	</div>
	@stop
