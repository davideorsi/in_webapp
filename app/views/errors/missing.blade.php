@extends('layouts.master')

@section('content')

	@if ( Session::has('message'))
		<div class="pure-u-1 alert alert-info" style='margin-bottom:10px;'>
			{{ Session::get('message') }}
		</div>
	@endif

	
	<div class="container">
	<div class="row">
		<div class='col-sm-6 col-sm-offset-3'>
			
			<img class="center-block img-responsive" src={{ URL::to('/img/404.jpg') }} />
			<p class="caption center-block">"Quel che cerchi, non è più; o non è mai stato..."</p>
		</div>
		
	</div>


@stop

@section('Scripts')
@stop
