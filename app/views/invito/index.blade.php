@extends('admin')

	
@section('content')
<div class='row'>
	<div class='col-sm-6 col-sm-offset-3'>
		<h3>Inviti a registrarsi al sito</h3>


		@if ( Session::has('message'))
			<div class="alert alert-info">
				{{ Session::get('message') }}
			</div>
		@endif

		<div class='row panel panel-default' style='padding:10px; margin: 0px'>
		<!-- AGGIUNGI MANUALMENTE UNA ISCRIZIONE -->
			{{ Form::model([], array('files'=>true, 'method' => 'POST', 'url' => 'admin/invito', 'class'=>'pure-form')) }}
			
			<div class='col-xs-8 col-sm-10 col-md-10'>
			{{ Form::label('Email',"Email dell'utente da invitare",['style'=>'width:100%']) }}		
			{{ Form::input('text','Email','', ['class'=>'form-control'])}}
			</div>
			
			<div class='col-xs-4 col-sm-2 col-md-2'>
			{{ Form::submit('Invita', array('class' => 'btn btn-success','style'=>'margin-top: 24px;')) }}
			{{ Form::close()}}
			</div>
		</div>
		
		@if (!empty($Inviti))
		<h5><strong>Elenco degli Inviti Attivi</strong></h5>
		<table class='table table-striped table-condensed'>
			<thead>
				<th>Email</th>
				<th></th>
				<th></th>
			</thead>
			
		<tbody>
		<!-- INVITI -->			
		@foreach ($Inviti as $Invito)
			<tr>
				<td>{{$Invito['Email']}}</td>
				<td>
					{{ Form::model($Invito, array('files'=>true, 'method' => 'PUT', 'url' => 'admin/invito/'.$Invito['ID'], 'class'=>'pure-form')) }}
					{{ Form::submit("Reinvia", array('class' => 'btn btn-primary btn-xs')) }}
					{{ Form::close()}}
				</td>
				</td>
				
				<td align = "center">
					{{ Form::model($Invito, array('files'=>true, 'method' => 'DELETE', 'url' => 'admin/invito/'.$Invito['ID'], 'class'=>'pure-form')) }}
					{{ Form::submit("Elimina", array('class' => 'btn btn-warning btn-xs')) }}
					{{ Form::close()}}
				</td>
				
			</tr>
		@endforeach
		</tbody>
		</table>
		@endif
	</div>
</div>
@stop

@section('Scripts')
@stop
		

