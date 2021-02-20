@extends('layouts.master')


	@section('content')
		<div class="famoso" style='margin-top: 0px'>
			<h4  id='famoso_nome'>{{$famoso['Nome']}}</h4>
			
			<div  class='initialcap justified withcolumns'>
				<img id='famoso_img' src={{'../images/famoso/'.$famoso['ID']}}></img>
				{{$famoso['Storia'][0]}}
				<br>
				{{$famoso['Storia'][1]}}
			</div>
	
		</div>
	@show
			
@stop
