@extends('layouts.master')

@section('content')

	@if ( Session::has('message'))
		<div class="pure-u-1 alert alert-info" style='margin-bottom:10px;'>
			{{ Session::get('message') }}
		</div>
	@endif

	
	<div class='account_bcg img-rounded' style='margin-bottom: 20px; max-width: 960px; margin-left:auto; margin-right:auto;'>
		

		<div style='padding: 5px; margin:5px;'>
			<h3>Informazioni Account</h3>

			<div class='row' style='margin-left:5px; margin-right:5px;'>

				<div class='col-sm-12'>
					<div class='img-rounded' style='color: #000; background: rgba(255,255,255,0.7); padding:5px; margin-bottom: 10px'>

					{{ Form::model([], array('files'=>false, 'method' => 'PUT', 'url' => 'info', 'class'=>'form-inline')) }}

					{{ Form::label('username','Username',['style'=>'width:100%']) }}
					{{ Form::text('username',$username, ['class'=>'form-control'])}}
					
					{{ Form::label('email','Email',['style'=>'width:100%']) }}
					{{ Form::email('email',$email, ['class'=>'form-control'])}}
					<p style='margin-top: 5px;'>Modifica qui l'email del tuo account. Essa viene usata per <strong>il login e per l'invio delle notifiche</strong> di ricezione di missive, pertanto ti consigliamo di inserire una mail che controlli normalmente.</p>
					{{ Form::submit('Modifica', array('class' => 'btn btn-primary', 'style'=>'margin-top:5px;')) }}
					{{ Form::close()}}
	
					</div>
				</div>
			</div>
		</div>
	</div>


@stop

@section('Scripts')
@stop
