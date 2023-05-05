@extends('layouts.master')

@section('content')

<div class="row">
<div class='col-sm-10 col-sm-offset-1' >
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
});
@stop