@extends('admin')

	
	@section('content')
	<div class='row'>
		<div class='col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4'>
			<h3>PG Famosi</h3>


			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
	
			<div class='form-group'>
				{{ Form::open() }}
				{{ Form::select('selectfamoso', $selectFamosi, null, ['class'=>'form-control', 'id'=>'selectfamoso']) }}
				{{ Form::close() }}
				<?php $keys= array_keys($selectFamosi); ?>
			</div>
			
			<div class="btn-group" style='margin-bottom:10px;'>
			<a id='editfamoso' class="btn btn-primary" href="{{ URL::to('admin/famoso/'.$keys[0].'/edit') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('admin/famoso/create') }}">Nuova</a>
			{{ Form::open(array('id'=>'delfamoso','url' => 'admin/famoso/' . $keys[0], 'style'=>'display:inline-block;margin-left: -2px')) }}
			{{ Form::hidden('_method', 'DELETE') }}
			{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}
			</div>


			<h4  id='famoso_nome'></h4>
			<img id='famoso_img' class='floatleft'></img>
			<p id='famoso_storia'></p>
		</div>
	</div>
@stop

@section('Scripts')
		$(function(ready) {
			$('#selectfamoso').change( function() {
				$('#editfamoso').attr('href', 'famoso/'+$(this).val()+'/edit');
				$('#delfamoso').attr('action', 'famoso/'+$(this).val());
				get_famoso($(this).val());
			});
			get_famoso(1);
		});
@stop	

		

