@extends('admin')

@section('content')

	<div style='margin-top: -20px;'>
		<h2 class='nomepg'>{{$PNG['Nome']}}<br></h2>
	</div>
	
	<!--######## INFORMAZIONI GENERALI-->
	<div class='row'>
		<div class='col-sm-6 col-lg-4'>
			<table class='table table-striped'>
				<thead>
					<tr><th colspan='2'>Status</th></tr>
				</thead>
				<tbody>
					<tr><th>Ruolo:</th><td>{{ $PNG['Ruolo'] }}</td></tr>
					<tr><th>PX totali:</th><td>{{ $PNG['Px'] }}</td></tr>
					<tr><th>Rendita:</th><td>{{ $PNG['Monete'] }}</td></tr>	
					<tr><th>Cart. Potere:</th><td>{{ $PNG['CartelliniPotere'] }}</td></tr>	
					<tr><th>Erbe:</th><td>{{ $PNG['Erbe'] }}</td></tr>		
				</tbody>
			</table>

			<table class='table table-striped'>
				<thead>
					<tr><th colspan='2'>Descrizione</th></tr>
				</thead>
				<tbody>			
					<tr><td>{{ $PNG['Descrizione'] }}</td></tr>
				</tbody>
			</table>
			
		</div>

		<!--######## ABILITA'-->
		@if(count($PNG['Abilita'])>0)
		<div class='col-sm-6 col-lg-4'>
			
			<table class='table table-striped'>
				<thead>
					<th colspan='2'>Abilità</th>
				</thead>
				<tbody>
				@foreach ($PNG['Abilita'] as $abilita)
					<tr>
						<td>{{ $abilita['Ability'] }}</td>
						<td>( {{$abilita['PX'] }} px )</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		@endif
		
	<!--######## INCANTI-->
		<div class='col-sm-6 col-lg-4'>


			<table class='table table-striped'>
				<thead>
					<th colspan='1'>Classi di Abilità</th>
				</thead>
				<tbody>
				@foreach ($PNG['Categorie'] as $categoria)
					<tr>
						<td>{{ $categoria['Categoria'] }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			
		@if (count($PNG['Incanti'])>0)
			<table class='table table-striped'>
				<thead>
					<th colspan='3'>Incanti</th>
				</thead>
				<tbody>
				@foreach ($PNG['Incanti'] as $incanto)
					<tr><td>{{ $incanto['Nome'] }} ({{$incanto['Livello']}})</td>
					<td><i>{{ $incanto['Formula'] }}</i></td></tr>
				@endforeach
				</tbody>
			</table>
			@endif
		</div>

	</div>		

	
			
@stop
