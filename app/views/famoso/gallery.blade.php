@extends('layouts.master')

@section('content')

	<div class='withcolumns justified'>
		<p>
			In questa sezione sono raccolte le storie di alcuni personaggi
			che hanno, nel bene e nel male, fatto la storia di Intempesta Noctis.
			Pensiamo sia utile e interessante leggere le loro gesta, perchè
			è possibile trovarsi a che fare con la loro storia, incrociando chi
			li ha conosciuti, chi li ha amati, chi li ha odiati. <br>
			Le informazioni che troverai qui sono, per certi versi, ormai di pubblico
			dominio. Sono storie raccontate nelle locande del ducato, davanti a una scodella di vino, oppure narrate ai bambini per spaventarli o educarli, per insegnare loro come vivere. Sebbene queste persone siano scomparse
			da lungo tempo dal Ducato, non sono state dimenticate...
		</p>
	</div>

	<div class="separator">
				{{ HTML::image('img/divider.png') }}
	</div>

	@foreach($famosi as $famoso)

	<div class="col-xs-6 col-sm-3 col-ds-2" style='margin-bottom:10px'>
		<a href="famoso/{{$famoso['ID']}}">
			<div class='panel panel-default' >
				<div class='panel-title'>
					<h5 style='text-align:center;'>{{$famoso['Nome']}}</h5>
				</div>
			</div>
		</a>
	</div>

	@endforeach

@stop
