@extends('layouts.master')

@section('content')

<div class="row">
<div class='col-sm-10 col-sm-offset-1' >
    <h1>Intempesta Noctis - Lista delle Abilità</h1>
	<div class="text-justify">
		<p>Per mostrare una categoria, cliccare su di essa. <b>Per generare una versione stampabile della lista abilità, espandere tutte le categorie e poi usare la funzione "Stampa" del browser. </b>Alcune abilità compaiono più volte poichè diverse combinazioni di requisiti ne permettono l'acquisto.</p>
	</div>
	<div>
        @foreach ($AllAbilita as $index => $lista)
            <h2>{{$index}}</h2>
            @foreach ($lista as  $abilita)
                <h4>{{$abilita['Nome']}}</h4>
                {{$abilita['Descrizione']}}
            @endforeach
        @endforeach
	</div>
</div>
</div>

@stop

@section('JS')
	{{ HTML::script('js/marked.min.js');}}
@stop

@section('Scripts')
$(document).ready(function(){	
	$("h2").click(function(){
		$(this).nextUntil("h2").slideToggle();	
	});
	$("h2").nextUntil("h2").hide();
	$("h2").css({"color":"#00308F"});
	$("h2").css({"text-align":"center"});
	$("h1").css({"color":"#00308F"});
	$("h1").css({"text-align":"center"});
	$( "<hr></hr>" ).insertAfter( "h2" );
});
@stop