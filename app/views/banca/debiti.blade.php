@extends('layouts.master')

@section('content')

<div class='col-md-offset-2 col-md-8'>

    <h3>Spese effettuate <span id="toggle_spesa" class='btn btn-primary'>Aggiungi</span></h3>
    
    <div class="col-sm-12" id="aggiungi_spesa" style='display:none;'>
		<div class='row panel panel-default' style='padding:10px; margin: 0px'>
		<!-- AGGIUNGI MANUALMENTE UNA ISCRIZIONE -->
		{{ Form::model([], array('files'=>true, 'method' => 'POST', 'url' => 'admin/spesa/', 'class'=>'pure-form')) }}
			
			<div class='col-xs-12 col-sm-12 col-md-6'>
			{{ Form::label('PG', 'Personaggio',['style'=>'width:100%']) }}
			{{ Form::select('PG', $selVivi, null, ['class'=>'form-control selectform', 'id'=>'selVivi']) }}
			</div>
			<div class='col-xs-12 col-sm-12 col-md-6'>
			{{ Form::label('Causale','Causale',['style'=>'width:100%']) }}		
			{{ Form::input('text','Causale','', ['class'=>'form-control'])}}
			</div>
			<div class='col-xs-12 col-sm-4 col-md-3'>
			{{ Form::label('Importo','Importo (in monete di Rame)',['style'=>'width:100%']) }}		
			{{ Form::input('number','Importo','10', ['class'=>'form-control'])}}
			</div>
			<div class='col-xs-4 col-sm-2 col-md-2'>
			{{ Form::submit('Aggiungi spesa', array('class' => 'btn btn-success','style'=>'margin-top: 24px;')) }}
			{{ Form::close()}}
			</div>
		</div>
	</div>
    
    <table class='table table-striped'>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Importo</th>
            <th>Causale</th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>    
        @foreach ($spese as $elem)	
        <tr>
            <td>{{$elem['Nome']}}<br><small>{{$elem['NomeGiocatore']}}</small></td>
            <td>{{$elem['Spesa']}}</td>
            <td>{{$elem['Causale']}}</td>
            <td>        
                <span style='font-size: 24px' class='del glyphicon glyphicon-remove-sign'  onclick="azzera_spesa({{$elem['ID']}})"></span>
            </td>
        </tr>	
	
		@endforeach
	</tbody>
	</table>
	
	
	
    <h3>Debiti per missive inviate</h3>
    <table class='table table-striped'>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Debito Missive</th>
            <th></th>
        </tr>
    </thead>
    <tbody>    
        @foreach ($lista as $elem)
        <tr>
            <td>{{$elem['Nome']}}<br><small>{{$elem['NomeGiocatore']}}</small></td>
            <td>{{$elem['debito']}}</td>
            <td>        
                <span style='font-size: 24px' class='del glyphicon glyphicon-remove-sign'  onclick="azzera_debito({{$elem['ID']}})"></span>
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
</div>    
@stop

@section('Scripts')
$(document).ready(function(){
    $("#toggle_spesa").click(function(){
        $("#aggiungi_spesa").slideToggle();
    });
});

@stop
