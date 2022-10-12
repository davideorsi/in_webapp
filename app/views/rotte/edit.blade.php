@extends('admin')


@section('content')
	<div class='row'>
		<div class='col-sm-6'>
			<h3>Modifica Rotte Commerciali</h3>
			@if ( Session::has('message'))
			<div class="alert alert-info">
				{{ Session::get('message') }}
			</div>
			@endif
		</div>
	</div>

<div class='form-group'>

	{{ Form::open(array('method' => 'PUT', 'url' => 'admin/rotte/genera_singolo', 'class'=>'form-inline')) }}
			{{ Form::submit('Ri-Genera Rotte', array('class' => 'btn btn-success')) }}
			{{ Form::select('selectMercanti', $selectMercanti, $keys[0], ['class'=>'form-control', 'id'=>'selectMercanti']) }}
			{{ Form::close() }}

	{{ Form::model([], array('files'=>true, 'method' => 'PUT', 'url' => 'rotte', 'class'=>'form-inline')) }}
	<table >
			<tr><th colspan=4></th></tr>
			<tr><td>Numero</td><td>Oggetto</td><td>Costo(Ramelle)</td><td>Disponibili</td><td>Cancella</td></tr>
			@foreach($sel as $opt)
				<tr>
						<td>

							{{ Form::input('number','numero[]',$opt['Acquistati'], ['class'=>'form-control','style'=>'width:50px;']) }}

							{{ Form::hidden('ID[]',$opt['ID'])}}
							{{ Form::hidden('number_old[]',$opt['Acquistati'])}}
							{{ Form::hidden('oggetto[]',$opt['Opzione'])}}
							{{ Form::hidden('costo[]',$opt['Costo'])}}
							{{ Form::hidden('disponibile[]',$opt['Disponibili'])}}
							{{ Form::hidden('evento[]',$opt['evento'])}}
						</td>
						<td>{{$opt['Opzione']}}</td>
						<td>{{ Form::input('number','numero[]',$opt['Costo'], ['class'=>'form-control','style'=>'width:50px;']) }}</td>
						<td>{{ Form::input('number','numero[]',$opt['Disponibili'], ['class'=>'form-control','style'=>'width:50px;']) }}</td>
						<td><a id='aggiungi' class="btn btn-primary" href="{{ URL::to('admin/rotte/'.$keys[0].'/modifica') }}">Aggiungi</a></td>
					</tr>
			@endforeach

			<p id = 'btn_aggiungi'>
				<a id='aggiungi' class="btn btn-primary" href="{{ URL::to('admin/rotte/'.$keys[0].'/modifica') }}">Aggiungi</a>
			</p>

	</table>
	<p></p>
			{{ Form::submit('Conferma', array('class' => 'btn btn-success')) }}
			{{ Form::close() }}
</div>



@stop
