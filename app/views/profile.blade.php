@extends('layouts.master')

@section('content')

	<div style='margin-top: -20px;'>
		<h2 class='nomepg'>{{$PG['Nome']}}<br></h2>
	</div>

	@if ( Session::has('message'))
		<div class="pure-u-1 alert alert-info" style='margin-bottom:10px;'>
			{{ Session::get('message') }}
		</div>
	@endif
	
	<!--######## INFORMAZIONI GENERALI-->
	
	<div class='row'>
		<div class='col-sm-6 col-lg-4'>
			<table class='table table-striped'>
				<thead>
					<tr><th colspan='4'>Status</th></tr>
				</thead>
				<tbody>
					<tr><th>Affiliazione:</th><td>{{ $PG['Affiliazione'] }}
						</td><th>Sesso:</th><td>{{ $PG['Sesso'] }}</td></tr>
					<tr><th>PX totali:</th><td>{{ $PG['Px'] }}</td>
						<th>PX rimasti:</th><td>{{ $PG['Px Rimasti'] }}</td></tr>
					<tr><th>Erbe:</th><td>{{ $PG['Erbe'] }}</td>
						<th>Cart. Potere:</th><td>{{ $PG['CartelliniPotere'] }}</td></tr>	
					<tr><th>Rendita:</th><td colspan='3'>{{ $PG['Monete'] }}</td></tr>	
					<tr><th>Note:</th><td colspan='3'>{{ $PG['Note'] }}</td></tr>		
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
				<!-- DISABILITATO PER LIVE -->
				@if (!app('prelive'))
					<tr>
						<td colspan='1'>
							{{ Form::model($PG, array('files'=>true, 'method' => 'PUT', 'url' => 'pg', 'class'=>'pure-form')) }}
							{{ Form::hidden('ID',$PG['ID'])}}
							{{ Form::select('sel_abilita', $PG['abilita_unlocked'], null, ['class'=>'form-control']) }}
						</td>	
						<td colspan='1'>
							{{ Form::submit('Aggiungi', array('class' => 'btn btn-primary')) }}
							{{ Form::close()}}
						</td>
					</tr>
				@endif
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
	</div>
		@endif
		<!-- Background #################################-->

		<div >
			<table class='table table-striped'>
				<thead>
					<tr><th>Background</th></tr>
				</thead>
				<tbody>
					<tr><td><p class='justified initialcap'>{{ $PG['background'] }}</p></td></tr>
				</tbody>
			</table>		
		</div>

		
@stop
