@extends('layouts.master')

	
	@section('content')
		<div>
			<h3>{{$evento['Tipo']}} - {{$evento['Titolo']}}</h3>
		
			<p class='floatleft'>{{$evento['Data']}}</p>
			<p class='justified initialcap'>{{$evento['Orari']}}</p>
			
			<p class='justified initialcap'>{{$evento['Info']}}</p>
	
		</div>
	@show
	
	
			
@stop
