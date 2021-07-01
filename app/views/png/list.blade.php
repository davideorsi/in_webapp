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
			{{ Form::label('png','PNG') }}
			{{ Form::select('png', $selPNG, null, ['class'=>'form-control selectform', 'id'=>'selPNG']) }}
			</div>
			
			{{ Form::close() }}
			
			
			<div class="btn-group" style='margin-bottom:10px;'>
				<a id='showpng' class="btn btn-default" href="{{ URL::to('png/') }}">Status</a>
			</div>

		</div>
	</div>
@stop

@section('Scripts')
		$(function(ready) {
			$('.selectform').change( function() {
				$('#showpng').attr('href', 'png/'+$(this).val());
			});
		});
@stop
		

