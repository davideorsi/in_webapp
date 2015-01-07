@extends('admin')

	
	@section('content')
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<h3>Personaggi</h3>
			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
			
			{{ Form::open(array('class'=>'pure-form pure-form-aligned')) }}

			
			<div class="form-group">
			{{ Form::label('pg_vivi','Personaggi Vivi') }}
			{{ Form::select('pg_vivi', $selVivi, null, ['class'=>'form-control selectform', 'id'=>'selVivi']) }}
			</div>

			<div class="form-group">
			{{ Form::label('pg_morti','Personaggi Morti') }}
			{{ Form::select('pg_morti', $selMorti, null, ['class'=>'form-control selectform', 'id'=>'selMorti']) }}
			</div>

			<div class="form-group">
			{{ Form::label('pg_morti','Personaggi in Limbo') }}
			{{ Form::select('pg_limbo', $selLimbo, null, ['class'=>'form-control selectform', 'id'=>'selLimbo']) }}
			</div>
			
			{{ Form::close() }}
			
			
			<div class="btn-group" style='margin-bottom:10px;'>
			<a id='showpg' class="btn btn-default" href="{{ URL::to('admin/pg/') }}">Status</a>
			<a id='editpg' class="btn btn-primary" href="{{ URL::to('admin/pg/') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('admin/pg/create') }}">Nuovo</a>
			{{ Form::open(array('id'=>'delpg','url' => 'admin/pg/', 'style'=>'display:inline-block; margin-left: -2px')) }}
			{{ Form::hidden('_method', 'DELETE') }}
			{{ Form::submit('Cancella', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}
			</div>

		</div>
	</div>
@stop

@section('Scripts')
		$(function(ready) {
			$('.selectform').change( function() {
				$('#editpg').attr('href', 'pg/'+$(this).val()+'/edit');
				$('#delpg').attr('action', 'pg/'+$(this).val());
				$('#showpg').attr('href', 'pg/'+$(this).val());
			});
		});
@stop
		

