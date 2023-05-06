@extends('layouts.master')

@section('content')

<div class="row">
<div class='col-sm-10 col-sm-offset-1' >
	<div class="text-justify">
		<p>Per visualizzare ciascun argomento, cliccare sul titolo della sezione.</p>
	</div>
	<div id="output" class="text-justify">
		{{$economia}}
	</div>
</div>
</div>

@stop

@section('JS')
	{{ HTML::script('js/marked.min.js');}}
@stop

@section('Scripts')
$(document).ready(function(){
    var text=$('#output').html();
    $('#output').html(marked.parse(text));
	
	$("h2").click(function(){
		$(this).nextUntil("h1,h2").slideToggle();	
	});
	$("h2").nextUntil("h1,h2").hide();
	$("h1").css({"color":"#00308F"});
	$("h1").css({"text-align":"center"});
	$( "<hr></hr>" ).insertBefore( "h1" );
});
@stop