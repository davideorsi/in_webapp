@extends('layouts.master')

@section('CSS')

	{{ HTML::style('css/justifiedGallery.min.css');}}
@stop

@section('content')

@if (Auth::guest())
	<div>
		<article class='justified text-muted withcolumns'>
			<p>
			Intempesta Noctis, gioco di ruolo dal vivo, ha avuto inizio come playtest per un ristretto gruppo di amici alla fine del 2009. La sua storia prosegue tuttora, coinvolgendo circa 30 giocatori ad ogni episodio.<br> La scansione di giorni e mesi è quella reale; tuttavia, il tempo di gioco e il tempo della vita di tutti i giorni non sono i medesimi. I.N. trasporta i giocatori nella prima metà del diciannovesimo secolo, dopo il Congresso di Vienna, quando l’Impero Francese e le idee rivoluzionarie avevano ormai lasciato spazio alla Restaurazione. Dopo la caduta di Napoleone la nobiltà ha ripreso in mano le sorti dell’Europa, governandola legittimata dal diritto divino.
			<br>La storia dei giocatori di Intempesta Noctis cominciò alla fine del 1818, quando per tutto il mondo era invece il 2009. Il gioco è ambientato principalmente a Borgo San Donnino -oggi conosciuto come Fidenza- nel ducato di Parma, Piacenza e Guastalla governato dalla Duchessa Maria Luigia d'Austria.
			</p>
		</article>

		<div class="separator">
				{{ HTML::image('img/divider.png') }}
		</div>
	</div>
@endif
<div class='row'>

	<div id='div_voce' class='col-sm-6'>
				
		<article id='voce'>
			<!-- FORM DI NAVIGAZIONE TRA LE VOCI-->
			<header id='voce_header' class='voce_bcg'  style="text-align: center;">
				<div style='position: relative;'>
					<h4 style='margin: 5px 0px 5px 0px;'>VOCI DI LOCANDA</h4>
					<div class="text-center" role="toolbar" style="margin-bottom: 10px;">
					<div class="nav-gallery">
						<button class="btn-left" id='voce_first' onclick="">
							<span class='glyphicon glyphicon-fast-backward'></span>
						</button>
						<button class="btn-left" id='voce_next'  onclick="">
							<span class='glyphicon glyphicon-step-backward'></span>
						</button>
						<span id='voce_num' class='voce_num'></span>
						<button class="btn-right" id='voce_last'  onclick="">
							<span class='glyphicon glyphicon-fast-forward'></span>
						</button>
						<button class="btn-right" id='voce_prev'  onclick="">
							<span class='glyphicon glyphicon-step-forward'></span>
						</button>

					</div>
				</div>
				</div>
			</header>

			<div>
				<p id="voce_data" class='floatleft'></p>
				<p id="voce_testo" class='justified'></p>
				
				<footer>
					<p id="voce_chiusa"></p>
				</footer>
			</div>

			<div class="separator" id='voce_separator'>
				{{ HTML::image('img/divider.png') }}
			</div>

			<div>
				<p id="voce_data1" class='floatleft'></p>
				<p id="voce_testo1" class='justified'></p>
				
				<footer>
					<p id="voce_chiusa1"></p>
				</footer>
			</div>
		</article>
		
		<div class="separator">
			{{ HTML::image('img/divider.png') }}
		</div>
	</div>

	<div class='col-sm-6'>
		<a href={{ URL::to('evento/1') }}>
		<article class='evento_bcg boxed'>
			<header class='evento_header'>
				<h2>Prossimamente</h2>
				<span id='prossimo_tipo' class='tipo'></span>
				<span id='prossimo_titolo' class='titolo'></span>
			</header>
			<div class='orari'>
				<p id=prossimo_orari></p>
			</div>
			<div class='luogo'>
				<span id='prossimo_data'></span>
				<br>
				<span id='prossimo_luogo'></span>
			</div>
		</article>
		</a>

		<div id="carousel" class="carousel slide " style='margin-top:20px; margin-bottom:0px;'>
			
			<div id="Gallery"class="carousel-inner" role="listbox" >
			</div>
			
			<a class="left carousel-control" href="#" role="button">
		      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		      <span class="sr-only">Previous</span>
		    </a>
		    <a class="right carousel-control" href="#" role="button">
		      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		      <span class="sr-only">Next</span>
		    </a>
		</div>
		
		<article class='famoso boxed'>
			<header class='famoso_bcg'>
				<div>
					<h4 class='tipo' style='margin-top: 10px;'>NOTABILI DEL DUCATO</h4>
					<h4  id='famoso_nome' class='tipo'></h4>
				</div>
			</header>
			<img id='famoso_img'></img>
			<span><p id='famoso_storia' class='justified initialcap'></p></span>
			<a href={{ URL::to('famoso/'.$famoso) }}>
			<p style='color: #2a3;'>Prosegui la lettura.</p>
			</a>
		</article>

		
	</div>
</div>	
@stop

@section('JS')
	{{ HTML::script('js/jflickrfeed.min.js');}}
@stop

@section('Scripts')
	@parent

		$('#Gallery').jflickrfeed({
		limit: 50,
		feedapi: 'photos_public.gne',
		qstrings: {
			id: '130216040@N08'
		},
		useTemplate: false,
		itemCallback: function(item){
			$(this).append("<div class='item "+item.class+"'><img src='" + item.image_m + "' alt='' class='center-block img-responsive'/></div>");
		}
		});	
	
	
	$(document).ready( function(){
		pageload({{$famoso}});
	
		
	$("#carousel ").carousel({interval:10000});
	    // Enable Carousel Controls
    $(".left").click(function(){
        $("#carousel").carousel("prev");
    });
    $(".right").click(function(){
        $("#carousel").carousel("next");
    });
    
    
	
	});
	
@stop
