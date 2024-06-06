@extends('layouts.master')

	@section('content')

	<div class='row'>
		<div class='col-sm-6'>
				@if ($edit)
			<h3>Modifica Sostanza</h3>
			@else
			<h3>Nuova Sostanza</h3>
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
		{{ Form::open(array('files'=>true,'class'=>'form form-horizontal','method'=>'POST','url' => 'admin/sostanze/update')) }}
  @else
		{{ Form::open(array('files'=>true,'class'=>'form form-horizontal','method'=>'POST','url' => 'admin/sostanze/store')) }}
	@endif


  <div class="col-sm-6">
		  <div class="row-sm-12">
				  <div class="col-sm-12">
		{{ Form::hidden('ID',$sostanza['id_sostanza'])}}
		{{ Form::label('Nome', 'Nome*') }}
		{{ Form::text('Nome', $sostanza['nome'],['class'=>'form-control']) }}
			<br>
			</div>
		</div>

    <div class="row-sm-12">
      <div class="col-sm-6">
        <label for="" diluizione""="">Diluizione*</label>
          {{ Form::input('number', 'diluizione', $sostanza['diluizione'], ['id'=>'diluizione','class'=>'form-control']) }}
      </div>
      <div class="col-sm-6">
        <label for="cromodinamica">Cromodinamica*</label>
					{{ Form::select('cromodinamica', $selCd, $sostanza['id_cromodinamica'], ['id'=>'cromodinamica','class'=>'form-control']) }}
					<br>
      </div>
    </div>

		<div class="row-sm-12">
			<div class="col-sm-12">
				<label for="effetti">Effetti*</label>
				{{ Form::textArea('effetti', $sostanza['effetti'], ['id'=>'effetti','class'=>'form-control','describedby'=>"basic-addon-testo", "col"=>"50", "rows"=>"4"]) }}
				<br>
			</div>
		</div>
  </div>

  <div class="col-sm-6">
		<div class="row-sm-12">
			<div class="col-sm-8">
		<label for="Matrice">Matrice</label>
			</div>
		</div>
		<div class="row-sm-12">
			<div class="col-sm-9">

		    <div class="input-group">
		      <span class="input-group-addon danger" id="sizing-addon1">
		        <span class="glyphicon glyphicon-leaf "></span>
		      </span>
		      	{{Form::input('number', 'rosse', $sostanza['R'],['id'=>'rosse', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon1"])}}
		      <span class="input-group-addon success" id="sizing-addon2">
		        <span class="glyphicon glyphicon-leaf"></span>
		      </span>
		        {{Form::input('number', 'verdi', $sostanza['V'],['id'=>'verdi', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon2"])}}
		      <span class="input-group-addon primary" id="sizing-addon3">
		        <span class="glyphicon glyphicon-leaf"></span>
		      </span>
		        {{Form::input('number', 'blu'  , $sostanza['B'],['id'=>'blu', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon3"])}}
		    </div>

			</div>
			<div class="col-sm-3">

				<a id='calcolaMatrice' class="btn btn-primary" href="#" onclick='get_matrice()'>Calcola Matrice</a>

			</div>

		</div>
		<div class="row-sm-12">
				<div class="col-sm-12">
						 <br>
					<label for="Materiali">Materiali</label>
					<table class="table table-striped" id="tab-mat-sostanza">
						<tbody>
							<tr>
								<td>
										{{ Form::select('SelMateriali', $materiali, 0, ['id'=>'SelMateriali','class'=>'form-control']) }}
								</td>
								<td>
										{{ Form::input('number', 'qtaMat', 1, ['id'=>'qtaMat','class'=>'form-control']) }}
								</td>
								<td>
									@if ($edit)
										<a class="btn btn-info glyphicon glyphicon-plus" href="#" onclick="add_mat_sostanza({{$sostanza['id_sostanza']}})"></a>
									@else
										<a class="btn btn-info glyphicon glyphicon-plus" href="#" onclick="add_mat_sostanza_new()"></a>
									@endif
								</td>
							</tr>
							@foreach ($matSos as $mat)
							<tr>
								<td>
										{{ Form::hidden('mat_id[]',$mat['ID'])}}
										{{ Form::input('text', 'mat_nome[]', $mat['Nome'], ['class'=>'form-control']) }}

									</td>
									<td>
										 {{ Form::hidden('mat_qta_old[]',$mat['pivot']->quantita)}}
										 {{ Form::input('number', 'mat_qta[]', $mat['pivot']->quantita, ['class'=>'form-control']) }}
									</td>
									<td>

											<a class="with_margin_icon glyphicon glyphicon-remove-sign" href="#" onclick="destroy_mat_sostanza({{$mat['ID']}},{{$sostanza['id_sostanza']}})">

									</td>
								</tr>

							@endforeach

						</tbody>
					</table>
				</div>
		</div>
	</div>
	<div class="col-sm-12">
 		 <br>
		 <div class="input-group">
 		 {{ Form::submit('Salva', array('class' => 'btn btn-success')) }}
		 <a class="btn btn-primary" href="/admin/sostanze">Annulla</a>
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
