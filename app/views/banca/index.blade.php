@extends('layouts.master')

@section('content')

<div class='col-md-offset-2 col-md-8'>

    <h3>Conti in Banca </h3>
    
    <div class="col-sm-12">
	    <div class="btn-group" role="group">
			<span id="toggle_conto" class='btn btn-primary'>Aggiungi</span>
	    </div>
    </div>
    
    
    
    <div class="col-sm-12" id="aggiungi_conto" style='display:none; margin:15px;'>
		<div class='row panel panel-default' style='padding:10px; margin: 0px'>
		<!-- AGGIUNGI MANUALMENTE UN CONTO -->
		{{ Form::model([], array('files'=>true, 'method' => 'POST', 'url' => 'admin/conto/', 'class'=>'pure-form')) }}
			
			<div class='col-xs-12 col-sm-12'>
			{{ Form::label('PG', 'Personaggio',['style'=>'width:100%']) }}
			{{ Form::select('PG', $selVivi, null, ['class'=>'form-control selectform', 'id'=>'selVivi']) }}
			</div>
			<div class='col-xs-12 col-sm-12'>
			{{ Form::label('Intestatario','Intestatario',['style'=>'width:100%']) }}		
			{{ Form::input('text','Intestatario','', ['class'=>'form-control'])}}
			</div>
			<div class='col-xs-12 col-sm-4 col-md-6'>
			{{ Form::label('Importo','Importo (in monete di Rame)',['style'=>'width:100%']) }}		
			{{ Form::input('number','Importo','10', ['class'=>'form-control'])}}
			</div>
			<div class='col-xs-12 col-sm-4 col-md-6'>
			{{ Form::label('Interessi','Interessi (in monete di Rame)',['style'=>'width:100%']) }}		
			{{ Form::input('number','Interessi','0', ['class'=>'form-control'])}}
			</div>
			<div class='col-xs-4 col-sm-2 col-md-2'>
			{{ Form::submit('Aggiungi conto', array('class' => 'btn btn-success','style'=>'margin-top: 24px;')) }}
			{{ Form::close()}}
			</div>
		</div>
	</div>
	
	<div class="col-sm-12" id="edit_conto" style='display:none; margin:15px;'>
		<div class='row panel panel-default' style='padding:10px; margin: 0px'>
		<!-- EDITA MANUALMENTE UN CONTO -->
			{{ Form::model([], array('files'=>true, 'method' => 'PUT', 'url' => 'admin/conto/', 'class'=>'pure-form', 'id'=>'form_edit')) }}
				
			<div class='col-xs-12 col-sm-12'>
			<h4 id='PG'></h4>
			</div>
			<div class='col-xs-12 col-sm-12 '>
			{{ Form::label('Intestatario','Intestatario',['style'=>'width:100%']) }}		
			{{ Form::input('text','Intestatario','', ['class'=>'form-control'])}}
			</div>
			<div class='col-xs-12 col-sm-4 col-md-6'>
			{{ Form::label('Importo','Importo (in monete di Rame)',['style'=>'width:100%']) }}		
			{{ Form::input('number','Importo','10', ['class'=>'form-control'])}}
			</div>
			<div class='col-xs-12 col-sm-4 col-md-6'>
			{{ Form::label('Interessi','Interessi (in monete di Rame)',['style'=>'width:100%']) }}		
			{{ Form::input('number','Interessi','0', ['class'=>'form-control'])}}
			</div>
			<div class='col-xs-4 col-sm-2 col-md-2'>
			{{ Form::submit('Modifica conto', array('class' => 'btn btn-success','style'=>'margin-top: 24px;')) }}
			{{ Form::close()}}
			</div>
		</div>
	</div>
    
    <table class='table'>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Intestatario</th>
            <th>Importo</th>
            <th>Interessi</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>    
        @foreach ($conti as $elem)	
        <tr class="{{$elem['Colore']}}">
            <td>{{$elem['Nome']}}<br><small>{{$elem['NomeGiocatore']}}</small></td>
            <td>{{$elem['Intestatario']}}</td>
            <td>{{$elem['Importo']}}</td>    
            <td>{{$elem['Interessi']}}</td>        
            <td>        
                <span style='font-size: 24px;' title='aggiorna gli interessi' class='del glyphicon glyphicon-refresh'  onclick="aggiorna_interessi({{$elem['ID']}})"></span>
            </td>
            <td>        
                <span style='font-size: 24px;' title='modifica il conto' class='del glyphicon glyphicon-edit'  onclick="edit_conto({{$elem['ID']}})"></span>
            </td>
            <td>        
                <span style='font-size: 24px' title='elimina il conto' class='del glyphicon glyphicon-remove-sign'  onclick="azzera_conto({{$elem['ID']}})"></span>
            </td>
        </tr>	
	
		@endforeach
	</tbody>
	</table>
	
	
	
    
</div>    
@stop

@section('Scripts')
$(document).ready(function(){
    $("#toggle_conto").click(function(){
        $("#aggiungi_conto").slideToggle();
    });
});

@stop
