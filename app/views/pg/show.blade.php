@extends('admin')

@section('content')

	<div style='margin-top: -20px;'>
		<h2 class='nomepg'>{{$PG['Nome']}}<br></h2>
	</div>

	
	<!--######## INFORMAZIONI GENERALI-->
	<div class='row'>
		<div class='col-sm-6 col-lg-4'>
			<table class='table table-striped'>
				<thead>
					<tr><th colspan='2'>Status</th></tr>
				</thead>
				<tbody>
					<tr><th>Affiliazione:</th><td>{{ $PG['Affiliazione'] }}</td></tr>
					<tr><th>Sesso:</th><td>{{ $PG['Sesso'] }}</td></tr>
					<tr><th>PX totali:</th><td>{{ $PG['Px'] }}</td></tr>
					<tr><th>PX rimasti:</th><td>{{ $PG['Px Rimasti'] }}</td></tr>
					<tr><th>Rendita:</th><td>{{ $PG['Monete'] }}</td></tr>	
					<tr><th>Cart. Potere:</th><td>{{ $PG['CartelliniPotere'] }}</td></tr>	
					<tr><th>Erbe:</th><td>{{ $PG['Erbe'] }}</td></tr>	
					<tr><th>Note:</th><td>{{ $PG['Note'] }}</td></tr>		
				</tbody>
			</table>

			<table class='table table-striped'>
				<thead>
					<th colspan='1'>Classi di Abilità</th>
				</thead>
				<tbody>
				@foreach ($PG['Categorie'] as $categoria)
					<tr>
						<td>{{ $categoria['Categoria'] }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>			
		</div>

		<!--######## ABILITA'-->
		@if(count($PG['Abilita'])>0)
		<div class='col-sm-6 col-lg-4'>
			
			<table class='table table-striped'>
				<thead>
					<th colspan='2'>Abilità</th>
				</thead>
				<tbody>
				@foreach ($PG['Abilita'] as $abilita)
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
		@if (count($PG['Incanti'])>0)
		<div class='col-sm-6 col-lg-4'>
			<table class='table table-striped'>
				<thead>
					<th colspan='3'>Incanti</th>
				</thead>
				<tbody>
				@foreach ($PG['Incanti'] as $incanto)
					<tr><td>{{ $incanto['Nome'] }} ({{$incanto['Livello']}})</td>
					<td><i>{{ $incanto['Formula'] }}</i></td></tr>
				@endforeach
				</tbody>
			</table>
		</div>
		@endif
	</div>		

	<hr></hr>
	<div  class='initialcap justified withcolumns'>
		<p>{{ $bg }}</p>
	</div>
	
			
@stop
