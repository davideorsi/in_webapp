@extends('layouts.master')

@section('content')

	@if ( Session::has('message'))
		<div class="pure-u-1 alert alert-info" style='margin-bottom:10px;'>
			{{ Session::get('message') }}
		</div>
	@endif

	<div class='col-sm-3-offset'></div>
	<div class='col-sm-6'>
	<div class='account_bcg img-rounded' style='margin-bottom: 20px; max-width: 960px; margin-left:auto; margin-right:auto;'>
		

		<div style='padding: 5px; margin:5px;'>
			<h3>Nessun evento programmato!</h3>
			<h5></h5>
		</div>
		
		<div class='row' style='margin-left:10px; margin-right:10px;'>
		
			<div class='col-sm-5 img-rounded' style='color: #000; background: rgba(255,255,255,0.7); padding:5px; margin:5px'>
			<p>
				Al momento, Intempesta Noctis non prevede alcun nuovo evento!
				Questo però non ti impedisce di continuare a vivere nel nostro mondo... segui le voci di Locanda, invia missive, aggiungi abilità, e preparati alla prossima avventura!
				
			</p>
		
		</div>
	</div>
	</div>


@stop
