@extends('admin')

	
	@section('content')
	<div class='row'>
		<div class='col-sm-6 col-sm-offset-3'>
			<h3>Pozioni & Veleni</h3>


			@if ( Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif
	
			
			<div class="form-group">
				{{ Form::open() }}
				{{ Form::select('pozioni', $selectPozioni, null, ['class'=>'form-control', 'id'=>'selectpozioni']) }}
				{{ Form::close() }}
			</div>
			<div class="form-group" id="selettoreEffetti">
				{{ Form::open() }}
				{{ Form::select('veleni', $selectVeleni, null, ['class'=>'form-control', 'id'=>'selectveleni']) }}
				{{ Form::close() }}
			</div>
				<div class="btn-group" style='margin-bottom:10px;'>
				<a id='print_pozione' class="btn btn-default" href="{{ URL::to('admin/pozioni/1/stampa') }}">Stampa Cartellini</a>
			</div>
			<?php $keys_poz= array_keys($selectPozioni); ?>
			<?php $keys_vel= array_keys($selectVeleni); ?>


			<div class="form-inline">
				{{ Form::open() }}
				<div class="row" style='margin-left:00px;'>
				<div class="input-group col-sm-3">
					<span class="input-group-addon danger" id="sizing-addon1">
						<span class='glyphicon glyphicon-leaf '></span>
					</span>
					{{Form::input('number', 'rosse', null,['id'=>'rosse', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon1"])}}
				</div>
				<div class="input-group col-sm-3">
					<span class="input-group-addon success" id="sizing-addon2">
						<span class='glyphicon glyphicon-leaf'></span>
					</span>
					{{Form::input('number', 'verdi', null,['id'=>'verdi', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon2"])}}
				</div>
				<div class="input-group col-sm-3">
					<span class="input-group-addon primary" id="sizing-addon3">
						<span class='glyphicon glyphicon-leaf'></span>
					</span>
					{{Form::input('number', 'blu'  , null,['id'=>'blu', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon3"])}}
				</div>
				{{ Form::close() }}
							
				<span id='cerca_pozioni' class="btn btn-info col-sm-2" style='margin-right:5px;' onclick="javascript:get_ricetta()">Cerca</span>
				
				</div>
			</div>
	

			
			<hr>
			
			<h4 id='nome'></h4>
			<p id='effetto'></p>
			
			
		</div>
	</div>

@stop
@section('Scripts')
		$(function(ready) {
			$('#selettoreEffetti').hide();
			
			$('#selectpozioni').change(function(){
				id=$('#selectpozioni').val();
				if (id>=15 & id<=17) {
						$('#selettoreEffetti').show();
					}else{
						$('#selettoreEffetti').hide();
					}
				$('#selectveleni').val(1);
				get_info_pozioni();
				$('#print_pozione').attr('href', 'pozioni/'+$(this).val()+'/stampa');
			});
			
			$('#selectveleni').change(function(){
				get_info_pozioni()
			});
			
			get_info_pozioni()

		});
@stop
		

