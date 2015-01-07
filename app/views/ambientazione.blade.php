@extends('layouts.master')

@section('content')
<div id='div_post' class='col-sm-6'>				
	<article id='post'>
		<!-- FORM DI NAVIGAZIONE TRA LE CRONACHE ANNUALI-->
		<header id='post_header' class='post_bcg'  style="text-align: center;">
			<div style='position: relative;'>
				<h4 style='margin: 5px 0px 5px 0px;'>Cronache dal Passato</h4>
				<div class="text-center" role="toolbar" style="margin-bottom: 10px;">
				<div class="nav-gallery">
					<button class="btn-left" id='post_next'  onclick="">
						<span class='glyphicon glyphicon-step-backward'></span>
					</button>
					<span id='post_info' class='post_info'></span>
					<button class="btn-right" id='post_prev'  onclick="">
						<span class='glyphicon glyphicon-step-forward'></span>
					</button>
	
				</div>
			</div>
			</div>
		</header>
		
		<p id="post_testo" class='justified'></p>
		

	</article>

	<div class="separator visible-xs-block">
		{{ HTML::image('img/divider.png') }}
	</div>
	
</div>

<!-- FORM DI NAVIGAZIONE TRA I PERSONAGGI-->
<div  class='col-sm-6'>
	<div id='div_pers'>				
	<article id='pers' style='height: 320px; display: block;'>
		<div class="nav-gallery-full">
				<button class="btn-left" id='pers_next'  onclick="">
					<span class='glyphicon glyphicon-step-backward'></span>
				</button>

				<button class="btn-right" id='pers_prev'  onclick="">
					<span class='glyphicon glyphicon-step-forward'></span>
				</button>

			<footer>
				<h5 id='pers_info' class='pers_info' style='text-align: center;'></h5>
	
				<h4 id="pers_testo" style='text-align: center;'></h4>
			</footer>
		</div>
	</article>
	</div>
</div>

<div  class='col-sm-6'>
	<div class="separator" style='margin-top:20px;'>
		{{ HTML::image('img/divider.png') }}
	</div>
</div>
	<!-- FORM DI NAVIGAZIONE TRA LE VOCI-->
<div  class='col-sm-6'>
	<div id='div_desc'>				
		<article id='desc'>
			<header id='desc_header' class='voce_bcg'  style="text-align: center;">
				<div style='position: relative;'>
					<h3 id='desc_info' style='margin: 15px 0px 5px 0px;'></h3>
					<div class="text-center" role="toolbar" style="margin-bottom: 10px;">
					<div class="nav-gallery">
						<button class="btn-left" id='desc_next'  onclick="">
							<span class='glyphicon glyphicon-step-backward'></span>
						</button>
						<button class="btn-right" id='desc_prev'  onclick="">
							<span class='glyphicon glyphicon-step-forward'></span>
						</button>
		
					</div>
				</div>
				</div>
			</header>
			
			<p id="desc_testo" class='justified'></p>
			
	
		</article>
	</div>
	
	
</div>



@stop

@section('Scripts')
	@parent

	i=1
	function inc_pers(){
		i = i % 360 + 1;
		get_personaggio(i);
		}

	
	$(document).ready( function(){
		get_anno(1);
		get_desc(1);
		get_personaggio(1);
		timer=setInterval(inc_pers, 10000);	
		
	});

	$('#div_pers').hover(function(){
			clearInterval(timer);
		}, function(){
			timer = setInterval( inc_pers, 10000);
		});


	
	
@stop
