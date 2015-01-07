// SCRIPT HOMEPAGE ####################################################/
// popola il div #Famosi con un personaggio famoso di IN
function get_famoso(num,path){
if(typeof(path)==='undefined') path = '../';
$.ajax({
	type: "GET",
	url:  "famoso/"+num,
	async: false,
	success: function(output){
		$("#famoso_nome").text(output.Nome);
		$("#famoso_storia").html(output.Storia[0]);
		$("#famoso_storia_more").html(output.Storia[1]);
		$("#famoso_img").attr('src',path+'images/famoso/'+output.ID);
		$("#famoso_img").css('width','20%').css('margin-right','20px');
		
	},  
	dataType: "json"
});
}

// popola il div  con una POST CON LA CRONACA DI UN ANNO DI LIVE
function get_anno(pos){
$.ajax({
	type: "GET",
	url:  "post/anno/"+pos,
	async: false,
	success: function(output){
		var next= (pos - 1) % output.N ;
		if (next==0){next=output.N;}
		var prev = (pos) % output.N +1;
		$("#post_next").attr("onclick","javascript:get_anno("+next+")");
		$("#post_prev").attr("onclick","javascript:get_anno("+prev+")");
		$("#post_info").html('<strong>'+output.titolo+'</strong>');
		$("#post_testo").html(output.testo);
		$("#post_testo").removeClass('initialcap');
		$("#post_testo").addClass('initialcap');
	},  
	dataType: "json"
});
}

// popola il div  con una POST CON UNA DESCRIZIONE
function get_desc(pos){
$.ajax({
	type: "GET",
	url:  "post/descrizione/"+pos,
	async: false,
	success: function(output){
		var next= (pos - 1) % output.N ;
		if (next==0){next=output.N;}
		var prev = (pos) % output.N +1;
		$("#desc_next").attr("onclick","javascript:get_desc("+next+")");
		$("#desc_prev").attr("onclick","javascript:get_desc("+prev+")");
		$("#desc_info").html('<strong>'+output.titolo+'</strong>');
		$("#desc_testo").html(output.testo);
		$("#desc_testo").removeClass('initialcap');
		$("#desc_testo").addClass('initialcap');
	},  
	dataType: "json"
});
}

// popola il div  con una PERSONAGGIO
function get_personaggio(pos){
$.ajax({
	type: "GET",
	url:  "post/personaggio/"+pos,
	async: false,
	success: function(output){
		var next= (pos - 1) % output.N ;
		if (next==0){next=output.N;}
		var prev = (pos) % output.N +1;
		$("#pers_next").attr("onclick","javascript:get_personaggio("+next+")");
		$("#pers_prev").attr("onclick","javascript:get_personaggio("+prev+")");
		$("#pers_info").html('<strong>'+output.titolo+'</strong>');
		$("#pers_testo").html('<strong>'+output.testo.nome+'</strong><br><small>'+output.testo.titolo+'</small>');
		$("#pers_testo").removeClass();
		var imageUrl='img/ambientazione/'+output.testo.img;
		$(".nav-gallery-full").css('background-image', 'url(' + imageUrl + ')');
	},  
	dataType: "json"
});
}


// popola il div  con una voce di Locanda
function get_voce(pos){
$.ajax({
	type: "GET",
	url:  "voce/"+pos,
	async: false,
	success: function(output){
		var next=pos-1;
		if (next<1) {next=1};
		var prev = pos + 1;
		if (prev > output.N) {prev=pos;}
		$("#voce_first").attr("onclick","javascript:get_voce(1)");
		$("#voce_next").attr("onclick","javascript:get_voce("+next+")");
		$("#voce_prev").attr("onclick","javascript:get_voce("+prev+")");
		$("#voce_last").attr("onclick","javascript:get_voce("+output.N+")");
		$("#voce_num").html('<b>'+pos+'/'+output.N+'</b>');
		$("#voce_data").html(output.Data);
		$("#voce_testo").html(output.Testo);
		$("#voce_chiusa").text(output.Chiusa);
	},  
	dataType: "json"
});
}

function get_voce_master(pos){
$.ajax({
	type: "GET",
	url:  "voce/"+pos,
	async: false,
	success: function(output){
		$("#voce_data").html(output.Data);
		$("#voce_testo").html(output.Testo);
		$("#voce_chiusa").text(output.Chiusa);
	},  
	dataType: "json"
});
}

// popola il div #Prossimo con la descrizione del prossimo evento
function get_evento(){
$.ajax({
	type: "GET",
	url:  "evento/1",
	async: false,
	success: function(output){
		$('#prossimo_tipo').text(output.Tipo);
		$('#prossimo_titolo').text(output.Titolo);
		$('#prossimo_data').text(output.Data);
		$('#prossimo_luogo').text(output.Luogo);
		$('#prossimo_orari').html(output.Orari);
		$('#prossimo_info').html(output.Info);
	},  
	dataType: "json"
});
}

//popola il carosello di immagini
function riempi_carousel(directory) {
$.ajax({
	type: "GET",
	url:  "app/gallery.php",
	data: "dir="+directory,
	success: function(output){
		$(output).each( function(index, img) {
			$("#home_gallery").append("<div><img class='lazyOwl' data-src='"+img+"' src='"+img+"'></div>");
		});
		$("#home_gallery").owlCarousel({
			autoPlay : 10000,
			stopOnHover : true,
			navigation : false,
			items: 4,
			lazyLoad: true,
			pagination: false,
			paginationSpeed : 10000,
			goToFirstSpeed : 10000,
			singleItem : true,
			autoHeight : true,
			transitionStyle:"fade"
		});
	},  
	dataType: "json"
});
}

function get_incanto(pos){
$.ajax({
	type: "GET",
	url:  "incanto/"+pos,
	async: false,
	success: function(output){
		$("#incanto_formula").text(output.Formula);
		$("#incanto_desc").html(output.Descrizione);
	},  
	dataType: "json"
});
}

function get_abilita(pos){
$.ajax({
	type: "GET",
	url:  "abilita/"+pos,
	async: false,
	success: function(output){
		$("#abilita_desc").html(output.Descrizione+'</br><p>'+output.PG+'</p>');
	},  
	dataType: "json"
});
}

function get_list_missive(page,show_delete){
var data = $( "form" ).serializeArray();
data.push({name: 'page', value: page});
$.ajax({
	type: "GET",
	url:  "missive/search",
	data: data,
	success: function(output){
		$('#pagine').bootpag({
			total: output.last_page,
			maxVisible: 10
		}).on("page", function(event, num){get_list_missive(num,show_delete)} );
		
		var missive=output.data;
		var main=$('#results');
		main.html('');
		$.each(missive, function(index, missiva){
			if (missiva.tipo_mittente=='PNG') {
				var clr='blue_border';
			} else if  (missiva.tipo_destinatario=='PNG') {
				var clr='green_border';
			} else {
				var clr='gray_border';
			}
				
			media=$('<div></div>').addClass('media '+clr);
			mediacollapse=$('<div></div>').addClass('media-body collapse-group');
			header=$('<h5></h5>').addClass('media-heading '+clr);
			body=$('<div></div>').addClass('media-body collapse');
			testo=$('<p></p>').addClass('visible-xs justified');
						
			main.append(media);
			media.append(mediacollapse);
			
			// Aggiungi bottone per cancellare missiva, come glyph
			if (show_delete) {
				mediacollapse.append("<a class='with_margin_icon glyphicon glyphicon-remove-sign' href='#' onclick='destroy_missiva("+missiva.id+")'></a>");
			}

			// Aggiungi PDF print button
			mediacollapse.append("<a class='pdfbutton with_margin_icon glyphicon glyphicon-print' ' href='missive/"+missiva.id+"'></a>")
			
			// Aggiungi icone con il tipo di missiva, come glyph
			mediacollapse.append("<span class='with_margin_icon "+missiva.tipo['icon']+"' style='margin-top: 3px;'></span>");
			if (missiva.intercettato==1 && show_delete){
				mediacollapse.append("<span class='pull-right glyphicon glyphicon-flash' style='font-size: 1.6em; color:#FF6600; margin-top: 3px;'>");
				}

				
			mediacollapse.append(header);
			header.append("<input type='hidden' name='id' value='"+missiva.id+"' />");
			header.append('('+missiva.data+') ');
			header.append(missiva.mitt);
			header.append("<span class='with_margin glyphicon glyphicon-arrow-right'></span>")
			header.append(missiva.dest);
			mediacollapse.append(body);
			body.append(testo);
			testo.append(missiva.testo);
			
		});
		$('.media .media-heading').on('click', function(e) {
	    e.preventDefault();
	    $('.media-heading').removeClass('missiva_clicked');
	    $(this).addClass('missiva_clicked');
	    var is_small = $('#lateral_panel').css('display') == 'none';
	    if (is_small){
	    var collapse = $(this).closest('.collapse-group').find('.collapse');
			collapse.collapse('toggle');
		} else {
			get_missiva($(this).children('[name="id"]').val());
		}
});
	},  
	dataType: "json"
});
}

function destroy_missiva(id){
	var conf = confirm("Cancello la missiva n°"+id+"?");
	if (conf){
		$.ajax({
			type: 'POST',
			url:  "missive/"+id,
			data: { _method:"DELETE" },
			success: function(){
				location.reload();
				$("#info").html('Missiva Cancellata con Successo!');
			},  
			dataType: "html"
		});
	}
}

function get_missiva(id){
$.ajax({
	type: "GET",
	url:  "missive/"+id,
	success: function(output){
		$("#mittente_sm").html(' Da: '+output.mitt);
		$("#destinatario_sm").html(' Per: '+output.dest);
		$("#testo_sm").html(output.testo);
	},  
	dataType: "json"
});
}

// da far andare al caricamento della pagina
function pageload(famoso){
	get_voce(1);
	//var num=Math.floor((Math.random()*100)+1);
	get_famoso(famoso,'');
	get_evento();

	//riempi_carousel('fotogallery/ev19/');
    
	/*// per mostrare/nascondere i pulsanti di navigazione
	$('.gallery').hover(function() {
        $(this).find('.show_on_hover').show();
	},
    function () {
        $(this).find('.show_on_hover').hide();
    });*/
	
}
