@extends('layouts.master')

@section('content')

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
            <td>{{$elem['Nome']}}</td>
            <td>{{substr($elem['debito'],0,-1)}}</td>
            <td>        
                <a class='glyphicon glyphicon-remove-sign' href='#' onclick='azzera_debito({{$elem['ID']}})'></a>
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
@stop

