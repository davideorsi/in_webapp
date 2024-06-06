@extends('admin')


	@section('content')
	<div class="row bs-callout bs-callout-defaults">
			<a id='editParametri' class="btn btn-default" href="{{ URL::to('admin/malattie/parametri/show') }}">MODIFICA PARAMETRI</a>
		<div class="col-sm-6 col-sm-offset-3">

					<h3>Malattie</h3>

			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif

			{{ Form::open(array('class'=>'pure-form pure-form-aligned')) }}


			<div class="form-group">
			{{ Form::label('malattie','Malattie') }}
			{{ Form::select('malattie', $selMalattie, null, ['class'=>'form-control selectform', 'id'=>'selVivi']) }}
			</div>


			{{ Form::close() }}


			<div class="btn-group" style='margin-bottom:10px;'>
			<a id='showmalattia' class="btn btn-default" href="{{ URL::to('admin/malattie/') }}">Status</a>
			<a id='editmalattia' class="btn btn-primary" href="{{ URL::to('admin/malattie/') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('admin/malattie/create') }}">Nuovo</a>
			{{ Form::open(array('id'=>'delmalattia','url' => 'admin/malattie/', 'style'=>'display:inline-block; margin-left: -2px')) }}
			{{ Form::hidden('_method', 'DELETE') }}
			{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}
			</div>

		</div>

		<div class="col-sm-6 col-sm-offset-3">
			<br>
			<br>
			<!--Elenco degli ammalati-->
					<h4>PG Ammalati</h4>
			<table class="table table-striped">
				<thead class="thead-inverse">
					<tr><th>PG</th><th>Malattia</th><th>Stadio</th><th></th></tr>
				</thead>
			@foreach($selMalati as $Malati)
				<tr>
					<td>{{$Malati['Nome']}}</td>
					<td>{{$Malati['Malattia']}}</td>
					<td>{{$Malati['Stadio']}}</td>
					<td>
						{{ Form::model($Malati, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin/stadiopg', 'class'=>'pure-form')) }}
						{{ Form::hidden('PG',$Malati['ID'])}}
						{{ Form::hidden('Stadio',$Malati['StadioID']) }}
						{{ Form::submit("x", array('class' => 'btn btn-warning')) }}
						{{ Form::close()}}

					</td>
				</tr>
			@endforeach
				<tr>
					{{ Form::open(array('class'=>'form form-horizontal','method'=>'POST','url' => 'admin/stadiopg')) }}
					<td>{{ Form::select('pg_vivi', $selVivi, null, ['class'=>'form-control selectform', 'id'=>'selVivi']) }}</td>
					<td colspan="2">{{ Form::select('malattia', $selStadi, null, ['class'=>'form-control selectform', 'id'=>'selVivi']) }}</td>
					<td>{{ Form::submit("+", array('class' => 'btn btn-primary')) }}</td>
					{{ Form::close()}}
				</tr>
			</table>
			<div class="form-group">
				<div class="btn-group" style='margin-bottom:10px;'>
					{{ Form::open(array('class'=>'btn-group','method'=>'POST','url' => 'admin/malattie/aggiornaMalati')) }}
					{{ Form::submit("Aggiorna", array('class' => ' btn btn-success')); }}
					{{ Form::close()}}
					<a id='stampaReport' class="btn btn-primary" href="{{ URL::to('admin/malattie/stampaMalati') }}">Stampa</a>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-sm-offset-3">
			<br>
			<div class="form-group">
						<h4>Verifica Cura</h4>
					  {{Form::open(array('onsubmit'=>'get_verifica_cura();return false;')) }}
						<!--{{ Form::open(array('class'=>'form form-horizontal','method'=>'GET','url' => 'admin/malattie/verificaCura')) }}-->
							<!--scegli PG-->
						{{ Form::label('pg_malati','Personaggio Malato') }}
						{{ Form::select('pg_malati', $pgMalati, 0, ['class'=>'form-control selectform', 'id'=>'pg_malati']) }}
							<!--indica matrice-->
							<br>
						{{ Form::label('Matrice', 'Matrice') }}
						<div class="form-group" id="Matrice">
							<div class="input-group">

								<span class="input-group-addon danger" id="sizing-addon1">
									<span class='glyphicon glyphicon-leaf '></span>
								</span>
								{{Form::input('number', 'Rosse', Input::old('Rosse'),['id'=>'Rosse', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon1"])}}

								<span class="input-group-addon success" id="sizing-addon2">
									<span class='glyphicon glyphicon-leaf'></span>
								</span>
								{{Form::input('number', 'Verdi', Input::old('Verdi'),['id'=>'Verdi', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon2"])}}
								<span class="input-group-addon primary" id="sizing-addon3">
									<span class='glyphicon glyphicon-leaf'></span>
								</span>
								{{Form::input('number', 'Blu'  , Input::old('Blu'),['id'=>'Blu', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon3"])}}
							</div>
						</div>
							<!--indica componenti-->
							{{ Form::label('MaterialeCura', 'Materiale') }}
								<div>Il Siero Medico non va inserito: si da per scontato che ci sia, se manca l'esito è negativo.</div>
							{{ Form::select('MaterialeCura', $selMateriali, null, ['class'=>'form-control selectform', 'id'=>'MaterialeCura']) }}
							<!--pulsante verifica-->
							<br>
							{{ Form::submit("Verifica", array('class' => ' btn btn-success')); }}
							{{ Form::close()}}
							<!--risultati del Check-->
							<div id='resultsCura'>
							</div>



			</div>
		</div>

		<div class="col-sm-6 col-sm-offset-3">
			<br>
			<br>
			<div class="form-group">

				<h4>Cure delle Malattie (VECCHIA GESTIONE)</h4>
				<table class="table table-striped">
					<thead class="thead-inverse">
						<tr><th>Malattia</th><th>Estratto</th><th>Matrice</th></tr>
					</thead>
				@foreach($Cure as $Cura)
					<tr title="Effetti: {{$Cura['Effetti']}}">
						<td>{{$Cura['NomeMalattia']['Nome']}}</td>
						<td>{{$Cura['Estratto']}}</td>
						<td>
							Siero Medico, <br>
							<div class="input-group">
							<span class="input-group-addon danger" id="sizing-addon3">
								{{$Cura['Rosse']}}
							</span>
							<span class="input-group-addon success" id="sizing-addon3">
								{{$Cura['Verdi']}}
							</span>
							<span class="input-group-addon primary" id="sizing-addon3">
								{{$Cura['Blu']}}
							</span>
							</div>
						</td>
					</tr>
				@endforeach
				</table>
			</div>
		</div>
	</div>

@stop

@section('Scripts')
		$(function(ready) {
			$('.selectform').change( function() {
				$('#editmalattia').attr('href', 'malattie/'+$(this).val()+'/edit');
				$('#delmalattia').attr('action', 'malattie/'+$(this).val());
				$('#showmalattia').attr('href', 'malattie/'+$(this).val());
			});
		});
@stop
