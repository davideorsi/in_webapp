@extends('admin')

	
	@section('content')
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<h3>Personaggi Non Giocanti</h3>
			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
			
			{{ Form::open(array('class'=>'pure-form pure-form-aligned')) }}

			
			<div class="form-group">
			{{ Form::label('png_vivi','Vivi') }}
			{{ Form::select('png_vivi', $selVivi, null, ['class'=>'form-control selectform', 'id'=>'selVivi']) }}
			</div>

			<div class="form-group">
			{{ Form::label('png_morti','Morti o Inattivi') }}
			{{ Form::select('png_morti', $selMorti, null, ['class'=>'form-control selectform', 'id'=>'selMorti']) }}
			</div>
			
			{{ Form::close() }}
			
			
			<div class="btn-group" style='margin-bottom:10px;'>
			<a id='showpng' class="btn btn-default" href="{{ URL::to('admin/png/') }}">Status</a>
			<a id='editpng' class="btn btn-primary" href="{{ URL::to('admin/png/') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('admin/png/create') }}">Nuovo</a>
			{{ Form::open(array('id'=>'delpng','url' => 'admin/png/', 'style'=>'display:inline-block; margin-left: -2px')) }}
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
				$('#editpng').attr('href', 'png/'+$(this).val()+'/edit');
				$('#delpng').attr('action', 'png/'+$(this).val());
				$('#showpng').attr('href', 'png/'+$(this).val());
			});
		});
@stop
		

