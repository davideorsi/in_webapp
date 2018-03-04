@extends('admin')
	
	@section('content')
	<div class='row'>
		<div class="col-md-12 col-md-offset-0">
			<h3>Mercato dei Preziosi</h3>
			@if($master)
			<div class="btn-group" style='margin-bottom:10px; clear:both;'>
				<a class="btn btn-success btn-sm" href="{{ URL::to('admin/preziosi/create') }}">Inserisci oggetto</a>
				{{ Form::open(array('id'=>'delete_prezioso','url' => 'admin/preziosi/vendita_random', 'style'=>'display:inline-block; margin-left: -2px','onsubmit'=>"return confirm('Sei sicuro di voler procedere?');")) }}
				{{ Form::hidden('_method', 'PUT') }}
				{{ Form::submit('Vendita Casuale', array('class' => 'btn btn-primary btn-sm','title'=>$Numero.' oggetti al '.$Percentuale.'%')) }}
				{{ Form::close() }}			
			</div>
			@endif
			<p>
				Questi oggetti sono attualmente in vendita presso il mercato dei Preziosi del Ducato di Parma, Piacenza e Guastalla.</br> 
				@if(!$master)
				L'asta si chiuderà qualche giorno prima del prossimo Evento Live.
				@endif
			</p>
			
			
			@if ( Session::has('message'))
				<div class="alert alert-info" id="info">
					{{ Session::get('message') }}
				</div>
			@endif
			
			@foreach($Preziosi as $key=>$prezioso)
				<div title="" style='border:1px solid #ea0; border-left: 5px solid #ea0; padding:5px; margin-right:1%; margin-bottom:5px; width:31%; float:left; '>
					<h4>{{$key+1}}) {{$prezioso['Nome'];}}</h4>
					<p>{{$prezioso['Aspetto'];}}</p>
					<p>	
						@if($master)
						<b>Venditore:</b> {{$prezioso['Venditore'];}}</br>
						<b>Creatore:</b> {{$prezioso['Creatore'];}}</br>
						@endif
						<b>In vendita dal:</b> {{$prezioso['Data'];}}</br>
						<b>Base d'asta:</b> {{INtools::convertiMonete($prezioso['BaseAsta']);}}</br>
						@if($valutare)
							<b>Valore:</b> {{INtools::convertiMonete($prezioso['Valore']);}}</br>
							<b>Materiali:</b> {{$prezioso['Materiali'];}}</br>
						@endif
						@if($master)
							@if($prezioso['OffertaMassima'])
								<b>Offerta Massima:</b> {{INtools::convertiMonete($prezioso['OffertaMassima']['Offerta']);}} ({{$prezioso['OffertaMassima']['Nome'];}})</br>
							@endif
						@else
							@if($offertepg[$key])
								<b>Offerta corrente:</b> {{INtools::convertiMonete($offertepg[$key]);}}</br>
							@endif
						@endif
						
					</p>	
					@if($master)	
						<div class="btn-group" style='margin-bottom:10px;'>	
						@if($prezioso['OffertaMassima'])
						{{ Form::open(array('id'=>'vendita_prezioso','url' => 'admin/preziosi/'.$prezioso['ID'].'/vendita/'.$prezioso['OffertaMassima']['PG'].'/'.$prezioso['OffertaMassima']['Offerta'], 'style'=>'display:inline-block; margin-left: -2px', 'onsubmit'=>"return confirm('Sei sicuro di voler procedere?');")) }}
						@else
						{{ Form::open(array('id'=>'vendita_prezioso','url' => 'admin/preziosi/'.$prezioso['ID'].'/vendita', 'style'=>'display:inline-block; margin-left: -2px', 'onsubmit'=>"return confirm('Sei sicuro di voler procedere?');")) }}
						@endif
						{{ Form::hidden('_method', 'PUT') }}
						{{ Form::submit('Venduto', array('class' => 'btn btn-primary btn-xs')) }}
						{{ Form::close() }}
						{{ Form::open(array('id'=>'delete_prezioso','url' => 'admin/preziosi/'.$prezioso['ID'], 'style'=>'display:inline-block; margin-left: -2px', 'onsubmit'=>"return confirm('Sei sicuro di voler procedere?');")) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Elimina', array('class' => 'btn btn-warning btn-xs')) }}
						{{ Form::close() }}
						</div>
					@else
						<a href="#" onclick="fai_offerta({{$prezioso['ID'];}});" class="btn btn-warning btn-xs">Inserisci offerta</a>
						@if($offertepg[$key])
							{{ Form::open(array('url' => 'preziosi/'.$prezioso['ID'].'/rimuovi_offerta', 'style'=>'display:inline-block; margin-left: -2px', 'onsubmit'=>"return confirm('Sei sicuro di voler procedere?');")) }}
							{{ Form::hidden('_method', 'DELETE') }}
							{{ Form::submit('Elimina Offerta', array('class' => 'btn btn-danger btn-xs')) }}
							{{ Form::close() }}
						@endif
					@endif
				</div>
				@if(($key+1)% 3 == 0)
					<div style='clear:both'></div>
				@endif
			@endforeach
	
			

		</div>
	</div>
@stop
@section('Scripts')

@stop
