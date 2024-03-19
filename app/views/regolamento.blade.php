@extends('layouts.master')

@section('content')

<div>
	<p class='justified initialcap withcolumns' >
		Intempesta Noctis nasce dal desiderio di due persone di offrire ai propri amici un gioco diverso che non avevano mai provato. Questo gioco è di interpretazione, ma senza accostarsi al teatro dove l’attore ha una parte ben definita. Nel gioco di ruolo il giocatore è attore, ma ha la libertà (e la difficoltà) di crearsi la parte e di recitare come desidera solamente rispettando una regola auto-imposta sul carattere del proprio personaggio. <br>
		Per capire questo mondo è necessario leggere il <strong>"Tomo delle Regole"</strong>, che fornisce le indicazioni necessarie per capire quello che si deve letteralmente fare per interagire tra giocatori e con l’ambientazione.<br>
		Il <strong>"Tomo della Economia"</strong> contiene una serie di approfondimenti al regolamento base che potrebbero interessarti, soprattutto se il tuo personaggio ama il denaro... 
	</p>
	<div class="separator">
		{{ HTML::image('img/divider.png') }}
	</div>

</div>
<div class="row">
<div class='col-sm-4' style='text-align: center;'>

	<a href={{URL::to('tomo_regole')}}>
	{{ HTML::image('img/regole.jpg','Regolamento',array('style'=>'width:100%; max-width: 300px;'))}}
	</a>

</div>
<div class='col-sm-4' style='text-align: center;'>
<a href={{URL::to('tomo_abilita')}}>
{{ HTML::image('img/abilita.jpg','Lista delle Abilità',array('style'=>'width:100%; max-width: 300px;'))}}
</a>
</div>

<div class='col-sm-4' style='text-align: center;'>
	<a href={{URL::to('tomo_economia')}}>
	{{ HTML::image('img/economia.jpg','Economia',array('style'=>'width:100%; max-width: 300px;'))}}
	</a>

</div>

</div>
</br>
<div class="row">
<div class='col-sm-4' style='text-align: center;'>
	<a href={{URL::to('files/codice_penale_ducale_1827.pdf')}}>
	{{ HTML::image('img/codice_penale.png','Codice Penale',array('style'=>'width:100%; max-width: 300px;'))}}
	</a>

</div>
<div class='col-sm-4' style='text-align: center;'>
	<a href={{URL::to('files/Gli_eserciti_di_Intempesta_Noctis.pdf')}}>
	{{ HTML::image('img/eserciti.png','Codice Penale',array('style'=>'width:100%; max-width: 300px;'))}}
	</a>

</div>
</div>

@stop
