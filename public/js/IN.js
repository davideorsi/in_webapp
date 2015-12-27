
function nl2br (str, is_xhtml) {   
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

// SCRIPT HOMEPAGE ####################################################/
// popola il div #Famosi con un personaggio famoso di IN



function get_famoso(num,path){
if(typeof(path)==='undefined') path = '../';
$.ajax({
	type: "GET",
	url:  "famoso/"+num,
	async: true,
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
	async: true,
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
	async: true,
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
var testo = $('#testo_voce').val();
if (!testo) {testo='%20';}
$.ajax({
	type: "GET",
	url:  "voce?testo="+testo+"&page="+pos,
	async: true,
	success: function(output){
		var next = output.current_page-1;
		var prev = output.current_page+1;
		if (next<=0) {next=1};
		if (prev>=output.last_page) {prev=output.last_page};
		if (output.data.length==0) {
			
				$("#voce_data").html("");
				$("#voce_testo").html("La ricerca non ha fornito un risultato.");
				$("#voce_chiusa").text("");
				
				$("#voce_data1").html("");
				$("#voce_testo1").html("");
				$("#voce_chiusa1").text("");
		} else {
			$("#voce_first").attr("onclick","javascript:get_voce(1)");
			$("#voce_next").attr("onclick","javascript:get_voce("+next+")");
			$("#voce_prev").attr("onclick","javascript:get_voce("+prev+")");
			$("#voce_last").attr("onclick","javascript:get_voce("+output.last_page+")");
			$("#voce_first").attr("title","Pagina 1 di "+output.last_page);
			$("#voce_next").attr("title","Pagina "+next+" di "+output.last_page);
			$("#voce_prev").attr("title","Pagina "+prev+" di "+output.last_page);
			$("#voce_last").attr("title","Pagina "+output.last_page+" di "+output.last_page);
			$("#voce_data").html(output.data[0].Data);
			$("#voce_testo").html(output.data[0].Testo);
			$("#voce_chiusa").text(output.data[0].Chiusa);
			var perc=100*output.current_page/output.last_page;
			$(".progress-bar").attr("aria-valuenow",perc);
			$(".progress-bar").css("width",perc+"%");
			if (output.data.length>1) {
				$("#voce_data1").html(output.data[1].Data);
				$("#voce_testo1").html(output.data[1].Testo);
				$("#voce_chiusa1").text(output.data[1].Chiusa);
			} else {
				$("#voce_data1").html("");
				$("#voce_testo1").html("");
				$("#voce_chiusa1").text("");
			}
		}
	},  
	dataType: "json"
});


}

function get_voce_master(pos){
$.ajax({
	type: "GET",
	url:  "voce/"+pos,
	async: true,
	success: function(output){
		$("#voce_data").html(output.Data);
		$("#voce_testo").html(output.Testo);
		$("#voce_chiusa").text(output.Chiusa);
	},  
	dataType: "json"
});
}

// popola il div con un informatori
function get_info(pos){
$.ajax({
	type: "GET",
	url:  "informatori/"+pos,
	async: false,
	success: function(output){
		$("#info_evento").html(output.Evento);
		$("#info_testo").html(output.Testo);
		$("#info_cat").text(output.Categoria);
	},  
	dataType: "json"
});
}

// popola il div #Prossimo con la descrizione del prossimo evento
function get_evento(){
$.ajax({
	type: "GET",
	url:  "evento/1",
	async: true,
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
				
			media=$('<li></li>').addClass('media '+clr);
			mediacollapse=$('<div></div>').addClass(' collapse-group');
			header=$('<div></div>').addClass('media-heading '+clr);
			body=$('<div></div>').addClass('collapse');
			testo=$('<p></p>').addClass('visible-xs justified');
			icon_area=$('<div></div>').addClass('icon_area');
			
			main.append(media);
			media.append(mediacollapse);
			mediacollapse.append(icon_area);
			// se sei un master
			if (show_delete) {
				// Aggiungi bottone per cancellare missiva, come glyph
				icon_area.append("<a class='with_margin_icon glyphicon glyphicon-remove-sign' href='#' onclick='destroy_missiva("+missiva.id+")'></a>");
				// Aggiungi bottone per cancellare missiva, come glyph
			}
			if (missiva.rispondere==1 && show_delete){
			icon_area.append("<a class='with_margin_icon glyphicon glyphicon-check' href='#' onclick='toggle_rispondere("+missiva.id+")' style='color: #f00'></a>");
			} 
			if (missiva.rispondere==0 && show_delete){
			icon_area.append("<a class='with_margin_icon glyphicon glyphicon-check' href='#' onclick='toggle_rispondere("+missiva.id+")'></a>");	
			}
			if (missiva.intercettato==1 && show_delete){
				icon_area.append("<span class='pull-right glyphicon glyphicon-flash' style='font-size: 1.4em; color:#FF6600; margin-top: 2px;'>");
				}

			// Aggiungi PDF print button
			icon_area.append("<a class='pdfbutton with_margin_icon glyphicon glyphicon-print' ' href='missive/"+missiva.id+"'></a>")
			
				
			mediacollapse.append(header);
			header.append("<input type='hidden' name='id' value='"+missiva.id+"' />");
			
			// Aggiungi icone con il tipo di missiva, come glyph
			header.append("<span class='"+missiva.tipo['icon']+"' style='margin-top: 3px; font-size: 1.4em'></span>");
			
			header.append(' ('+missiva.data+') ');
			header.append(missiva.mitt);
			header.append("<span class='with_margin glyphicon glyphicon-arrow-right' ></span>")
			header.append(missiva.dest);
			mediacollapse.append(body);
			body.append(testo);
			testo.append(nl2br(missiva.testo));
			
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

function toggle_rispondere(id){
	var conf = confirm("Cambio lo stato della missiva n°"+id+"?");
	if (conf){
		$.ajax({
			type: 'POST',
			url:  "missive/"+id+"/toggle",
			success: function(){
				location.reload();
				$("#info").html('Missiva Aggiornata con Successo!');
			},  
			dataType: "html"
		});
	}
}

function azzera_debito(id){
    var conf = confirm("Azzero il debito?");
    if (conf){
       $.ajax({
                type: 'POST',
				async: false,
                url:  "debito/"+id,
                success: function(){
                    location.reload();
                },
                dataType: "json"
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


// cancella iscrizione a personaggio
function unsubscribe(){
	var conf = confirm("Vuoi veramente cancellare l'iscrizione?");
	if (conf){
		$.ajax({
			type: 'POST',
			url:  "",
			data: { _method:"DELETE" },
			success: function(){
				location.reload();
				$("#info").html('Iscrizione Cancellata con Successo!');
			},  
			dataType: "html"
		});
	}
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

//###### POZIONI ####################################################

function get_info_pozioni(){
idpoz=$('#selectpozioni').val();
ideff=$('#selectveleni').val();
$.ajax({
	type: "GET",
	url:  "infopozioni/",
	data: { pozione: idpoz, veleno: ideff },
	async: false,
	success: function(output){
		$("#rosse").val(output.rosse);
		$("#verdi").val(output.verdi);
		$("#blu").val(output.blu);		
		$("#nome").html('Pozione '+output.nome);		
		$("#effetto").html(output.effetto);		
	},  
	dataType: "json"
});
}

function get_ricetta(){
rosse=$('#rosse').val();
verdi=$('#verdi').val();
blu=$('#blu').val();

$.ajax({
	type: "GET",
	url:  "ricetta/",
	data: { 'rosse': rosse, 'verdi': verdi, 'blu': blu },
	success: function(output){
		if (!jQuery.isEmptyObject(output)) {
			$("#selectpozioni").val(output.PID);		
			$("#selectveleni").val(output.VID);	
			if ($('#selectveleni').val()==1 | $('#selectveleni').val()==null){
				$('#selettoreEffetti').hide();
			} else {
				$('#selettoreEffetti').show();
			}
			get_info_pozioni()
		}	else {
			
			$("#nome").html('Errore!');
			$("#effetto").html('Nessuna pozione trovata con questa ricetta.' );	
		}
	},  
	dataType: "json"
});
}

//###### TRAME ###############################################

function get_trama(pos){
$.ajax({
	type: "GET",
	url:  "trama/"+pos,
	async: false,
	success: function(output){
		$("#trama_desc").html(output.body);
	},  
	dataType: "json"
});
}

function get_vicenda(pos){
$.ajax({
	type: "GET",
	url:  "vicenda/"+pos,
	async: false,
	success: function(output){
		$("#vicenda_desc").html(output.body);
	},  
	dataType: "json"
});
}

function get_elemento(pos) {
    var tmp = null;
    $.ajax({
		type: "GET",
		url:  "elemento/"+pos,
		async: false,
		success: function(output){
			tmp=output;
		},  
		dataType: "json"
	});
    return tmp;
};

function return_data_to_scheduler(pos) {
    var tmp = null;
    $.ajax({
		type: "GET",
		url:  "vicende/"+pos,
		async: false,
		success: function(output){
			tmp=output;
		},  
		dataType: "json"
	});
    return tmp;
};

function return_infoevento_to_scheduler(pos) {
    var tmp = null;
    $.ajax({
		type: "GET",
		url:  "evento_info/"+pos,
		async: false,
		success: function(output){
			tmp=output;
		},  
		dataType: "json"
	});
    return tmp;
};	

function initialize_scheduler(string){
	var evento=return_infoevento_to_scheduler($('#selectevento').val());
	var m0=moment(evento.Data,"YYYY-MM-DD");
	var mm=m0.clone();
	$(string).timeSchedule({
		startTime: evento.Data+" 14:00", // schedule start time(HH:ii)
		endTime: mm.add(1,"d").format("YYYY-MM-DD")+" 02:00",   // schedule end time(HH:ii)
		widthTime:15*60,  // cell timestamp example 15 minutes
		timeLineY:100,       // height(px)
		verticalScrollbar:20,   // scrollbar (px)
		timeLineBorder:0,   // border(top and bottom)
		debug:"#debug",     // debug string output elements
		rows : return_data_to_scheduler($('#selectevento').val()),
		on_drop: function(data,png) {
			var param = $.param({'PNG':png});
			$.ajax({
                type: "POST",
                cache: false,
                data: param,
                url: "elemento_png/"+data.id
            });
            $("#schedule").empty();
			initialize_scheduler("#schedule");
		},
		on_out: function(data,png,minore) {
			if (!minore){
				var param = $.param({'PNG':png});
				$.ajax({
	                type: "POST",
	                cache: false,
	                data: param,
	                url: "elemento_png_remove/"+data
	            });
			} else {
				$.ajax({
	                type: "POST",
	                cache: false,
	                url: "elemento_png_minor_remove/"+png
	            });				
			}
            $("#schedule").empty();
			initialize_scheduler("#schedule");
		},
		change: function(node,data){
			var param = $.param({'start':data.start, 'end':data.end});
			$.ajax({
                type: "POST",
                cache: false,
                data: param,
                url: "elemento/"+data.id
            });
            $("#schedule").empty();
			initialize_scheduler("#schedule");
            
		},
		click: function(node,data){
			var elemento=get_elemento(data.id);
			$('#overlay').fadeIn('fast');
			$('#edit_element').fadeIn('slow');
			
			$('#form_edit').attr('action','elemento/'+elemento.ID);
			$('#form_edit #delete').attr('action', 'elemento/'+elemento.ID);
			$('#form_edit #text').val(elemento.text);
			$('#form_edit #data').val(elemento.data);
			$('#form_edit #start').val(elemento.start);
			$('#form_edit #end').val(elemento.end);
			$('#form_edit #vicenda').val(elemento.vicenda);
			
			$('#form_png_minori').attr('action','elemento_png_minor/'+elemento.ID);
				
		},
		time_click: function(time,data,vicenda){

				$('#overlay').fadeIn('fast');
				$('#insert_element').fadeIn('slow');
				
				$('#form_insert #start').val(data);
				$('#form_insert #end').val(moment(data,"YYYY-MM-DD HH:mm").add(30,"m").format("YYYY-MM-DD HH:mm"));
				$('#form_insert #vicenda').val(vicenda);
		}	
	});	
};		
