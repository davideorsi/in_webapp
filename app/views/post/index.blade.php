@extends('layouts.master')

	@section('content')
		<div class="col-sm-6 col-sm-offset-3">
			<h3>Post di Ambientazione</h3>
			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
			
			{{ Form::open(array('class'=>'pure-form pure-form-aligned')) }}

			
			<div class="form-group">
			{{ Form::label('posts','Posts') }}
			{{ Form::select('posts', $posts, 1, ['class'=>'form-control selectform', 'id'=>'posts']) }}
			</div>
			{{ Form::close() }}
			
			
			<div class="btn-group" style='margin-bottom:10px;'>
			<a id='editpost' class="btn btn-primary" href="{{ URL::to('admin/post/') }}">Modifica</a>
			<a class="btn btn-success" href="{{ URL::to('admin/post/create') }}">Nuovo</a>
			{{ Form::open(array('id'=>'delpost','url' => 'admin/post/', 'style'=>'display:inline-block; margin-left: -2px')) }}
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
				$('#editpost').attr('href', 'post/'+$(this).val()+'/edit');
				$('#delpost').attr('action', 'post/'+$(this).val());
			});
			$('#editpost').attr('href', 'post/'+$('.selectform').val()+'/edit');
			$('#delpost').attr('action', 'post/'+$('.selectform').val());
		});
@stop
