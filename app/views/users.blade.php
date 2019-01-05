@extends('layouts.master')

@section('content')

	@if ( Session::has('message'))
		<div class="pure-u-1 alert alert-info" style='margin-bottom:10px;'>
			{{ Session::get('message') }}
		</div>
	@endif

	
	<div class="col-xs-12">
			<h3>Master</h3>
			<table class='table table-striped table-condensed'>
				<thead>
					<th>Username</th>
					<th>Email</th>
					<th></th>
				</thead>
				<tbody>
			@foreach($Users as $user)
			@if($user['usergroup'] == 7)
				<tr>
					<td>{{$user['username']}}</td>
					<td>{{$user['email']}}</td>
					<td>
					{{ Form::model($user, array('files'=>true, 'method' => 'DELETE', 'url' => 'users/'.$user['id'], 'class'=>'pure-form')) }}
					{{ Form::submit("X", array('class' => 'btn btn-warning btn-xs')) }}
					{{ Form::close()}}
					</td>
				</tr>
			@endif
			@endforeach			
			</tbody>
			</table>
			
			<h3>Aiuto Master</h3>
			<table class='table table-striped table-condensed'>
				<thead>
					<th>Username</th>
					<th>Email</th>
					<th></th>
				</thead>
				<tbody>
			@foreach($Users as $user)
			@if($user['usergroup'] == 15)
				<tr>
					<td>{{$user['username']}}</td>
					<td>{{$user['email']}}</td>
					<td>
					{{ Form::model($user, array('files'=>true, 'method' => 'DELETE', 'url' => 'users/'.$user['id'], 'class'=>'pure-form')) }}
					{{ Form::submit("X", array('class' => 'btn btn-warning btn-xs')) }}
					{{ Form::close()}}
					</td>
				</tr>
			@endif
			@endforeach		
			</tbody>
			</table>
			
			
			<h3>Giocatori</h3>
			<table class='table table-striped table-condensed'>
				<thead>
					<th>Username</th>
					<th>Email</th>
					<th></th>
					<th></th>
				</thead>
				<tbody>
			@foreach($Users as $user)
			@if($user['usergroup'] != 7 & $user['usergroup'] != 15)
				<tr>
					<td>{{$user['username']}}</td>
					<td>{{$user['email']}}</td>
					<td>{{$user['PG']}}</td>
					<td>
					{{ Form::model($user, array('files'=>true, 'method' => 'DELETE', 'url' => 'users/'.$user['id'], 'class'=>'pure-form')) }}
					{{ Form::submit("X", array('class' => 'btn btn-warning btn-xs')) }}
					{{ Form::close()}}
					</td>
				</tr>
			@endif
			@endforeach		
			</tbody>
			</table>

		
	</div>


@stop

@section('Scripts')
@stop
