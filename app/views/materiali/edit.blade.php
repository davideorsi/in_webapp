@extends('layouts.master')
@section('CSS')
<style>
	.circleB {
		height: 30px;
		width: 30px;
		background-color: #000;
		border-radius: 50%;
		border: 1px solid black;
	}
	.circleW {
		height: 30px;
		width: 30px;
		background-color: #FFF;
		border-radius:50%;
		border: 1px solid black;
	}
	.circleR {
		height: 30px;
		width: 30px;
		background-color: #F00;
		border-radius:50%;
		border: 1px solid black;
	}
	#cromo_Rosso{
			background-color: #ff0000;
	}
	#cromo_Verde{
			background-color: #00ff00;
	}
	#cromo_Blu{
			background-color: #0000ff;
	}
	#cromo_Magenta{
			background-color: #ff00ff;
	}
	#cromo_Giallo{
			background-color: #ffff00;
	}
	#cromo_Ciano{
			background-color: #00ffff;
	}
	#cromo_Viola{
			background-color: #8000ff;
	}
	#cromo_Azzurro{
			background-color: #0080ff;
	}
	#cromo_Primavera{
			background-color: #00ff80;
	}
	#cromo_Prato{
			background-color: #80ff00;
	}
	#cromo_Arancione{
			background-color: #ff8000;
	}
	#cromo_Bianco{
			background-color: #ffffff;
	}
	#cromo_Rosa{
			background-color: #ff0080;
	}
	#cromo_Nero{
			background-color: #000000;
	}

</style>
@stop
	@section('content')

	<div class='row'>
		<div class='col-sm-6'>
			@if ($edit)
		<h3>Modifica Materiale</h3>
		@else
		<h3>Nuovo Materiale</h3>
		@endif
			@if ( Session::has('message'))
			<div class="alert alert-info">
				{{ Session::get('message') }}
			</div>
		@endif
		</div>
	</div>
	<br>



	@if ($edit)
		{{ Form::open(array('files'=>true,'class'=>'form form-horizontal','method'=>'POST','url' => 'admin/materiali/update')) }}
  @else
		{{ Form::open(array('files'=>true,'class'=>'form form-horizontal','method'=>'POST','url' => 'admin/materiali/store')) }}
	@endif


  <div class="col-sm-6">
		  <div class="row-sm-12">
				  <div class="col-sm-12">
		{{ Form::hidden('ID',$materiale['ID'])}}
		{{ Form::label('Nome', 'Nome*') }}
		{{ Form::text('Nome', $materiale['Nome'],['class'=>'form-control']) }}
			<br>
			</div>
		</div>

    <div class="row-sm-12">
      <div class="col-sm-6">
        <label for="categoria">Categoria*</label>
					@if ($edit)
          	{{ Form::select('categoria', $selCat, $materiale['Categoria'], ['id'=>'categoria','class'=>'form-control']) }}
					@else
						{{ Form::select('categoria', $selCat, 0, ['id'=>'categoria','class'=>'form-control']) }}
					@endif
      </div>
      <div class="col-sm-6">
				<label for="stagione">Stagione*</label>
					@if ($edit)
						{{ Form::select('stagione', $selStg, $materiale['Stagione'], ['id'=>'stagione','class'=>'form-control']) }}
					@else
						{{ Form::select('stagione', $selStg, 0, ['id'=>'stagione','class'=>'form-control']) }}
					@endif
				<br>

      </div>
    </div>

		<div class="row-sm-12">
			<div class="col-sm-6">
				<label for="cromodinamica">Cromodinamica*</label>
						@if ($edit)
							{{ Form::select('cromodinamica', $selCD, $materiale['id_cromodinamica'], ['id'=>'cromodinamica','class'=>'form-control']) }}
						@else
							{{ Form::select('cromodinamica', $selCD, 0, ['id'=>'cromodinamica','class'=>'form-control']) }}
						@endif
					<br>
			</div>
      <div class="col-sm-3">
				<label for="stagione">Valore*</label>
				{{Form::input('number', 'valore', $materiale['ValoreBase'],['id'=>'valore', 'class'=>'form-control'])}}
				<br>
			</div>
      <div class="col-sm-3">
				<label for="stagione">Quantita*</label>
				{{Form::input('number', 'quantita', $materiale['Quantita'],['id'=>'quantita', 'class'=>'form-control'])}}
				<br>
			</div>
		</div>
  </div>

  <div class="col-sm-6">
		<div class="row-sm-12">
			<div class="col-sm-12">
				<label for="RL">Rarità Locale*</label>
						@if ($edit)
            	{{ Form::select('RL', $selR, $materiale['RaritàLoc'], ['id'=>'RL','class'=>'form-control']) }}
						@else
							{{ Form::select('RL', $selR, 0, ['id'=>'RL','class'=>'form-control']) }}
						@endif
						<br>
			</div>
		</div>
    <div class="row-sm-12">
      <div class="col-sm-12">
				<label for="RO">Rarità Oltremare*</label>
						@if ($edit)
							{{ Form::select('RO', $selR, $materiale['RaritaOM'], ['id'=>'RO','class'=>'form-control']) }}
						@else
							{{ Form::select('RO', $selR, 0, ['id'=>'RO','class'=>'form-control']) }}
						@endif
					<br>
      </div>
    </div>
		<div class="row-sm-12">
			<div class="col-sm-12">
        <label for="RN">Rarità Mercato Nero*</label>
						@if ($edit)
					  	{{ Form::select('RN', $selR, $materiale['RaritaMN'], ['id'=>'RN','class'=>'form-control']) }}
						@else
							{{ Form::select('RN', $selR, 0, ['id'=>'RN','class'=>'form-control']) }}
						@endif
      </div>
    </div>

	</div>
	<div class="col-sm-12">
 		 <br>
		 <div class="input-group">
 		 {{ Form::submit('Salva', array('class' => 'btn btn-success')) }}
		 <a class="btn btn-primary" href="/admin/materiali">Annulla</a>
		 </div>
 	</div>
 	{{ Form::close() }}
  @stop

	@section('Scripts')
		$(function(ready) {
			$('#cromodinamica').change( function() {
				change_color_cromodinamica($('#cromodinamica').val());
			});
		});
	@stop
