@extends('admin')

	
	@section('content')
		<div class='row'>
			<div class='col-sm-6'>
				<h3>Modifica Rotte Commerciali</h3>
				@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
				@endif
			</div>
		</div>
	
	<div class='form-group'>
		
		<table >
				<tr><th colspan=4></th></tr>
				<tr><td>Numero</td><td>Oggetto</td><td>Costo</td><td>Disponibili</td></tr>
				
				
		</table>
				
	</div>
	
	
			
@stop
