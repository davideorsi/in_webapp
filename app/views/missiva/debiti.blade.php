@extends('layouts.master')

@section('content')

<div class='col-md-offset-2 col-md-8'>
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
@stop
