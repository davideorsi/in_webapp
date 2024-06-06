
function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n\r\n|\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');

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
// ricerca voci di Locanda
function get_list_voci(){
var data = $( "form" ).serializeArray();
$.ajax({
	type: "GET",
	url:  "voci/search",
	data: data,
	success: function(output){

		var $el = $("#selectvoce");
		$el.empty(); // remove old options
		$.each(output, function(key,value) {
		$el.prepend($("<option></option>")
			.attr("value", key).text(value));
		});
		$("#selectvoce").val($("#selectvoce option:first").val());
		get_voce_master($("#selectvoce").val());
		}
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

function get_evento_master(pos){
$.ajax({
	type: "GET",
	url:  "evento/"+pos+"/list",
	async: true,
	success: function(output){
		var testo="";
		for (var key in output) {
			testo+= "<b>"+ key+"</b></br>";
			for(var pg in output[key]){
				testo += output[key][pg] + "<br>";
			}
		}
		$("#evento_testo").html(testo);
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

function get_incanto_PG(pos){
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

function get_licenza(pos){
$.ajax({
	type: "GET",
	url:  "licenza/"+pos,
	async: false,
	success: function(output){
		$("#licenza_nome").text(output.Nome);
		$("#licenza_prezzo").html(output.Prezzo);
		$("#licenza_disponibili").html(output.Disponibili);
		$("#licenza_durata").html(output.Durata);
		$("#licenza_permette").html(output.Permette);
		$("#licenza_limitazioni").html(output.Limitazioni);
		$("#licenza_tassazione").html(output.Tassazione);
	},
	dataType: "json"
});
}


function get_rotte(pos,id_evento){
$.ajax({
	type: "GET",
	url:  "rotte/"+pos+"/"+id_evento,
	async: false,
	success: function(output){
		$("#tabella_rotte").html(output.tabella);
	},
	dataType: "json"
});
}

function add_mat_sintesi(tableID){
  var table = document.getElementById(tableID);

  var rowCount = table.rows.length;
  var row = table.insertRow(rowCount);

  var cell1 = row.insertCell(0);
  cell1.width = '70%';
  var element1 = document.createElement("input");
  element1.type = "text";
  element1.name="materiale_sintesi[]";
  element1.className="form-control";
  element1.value="";
  cell1.appendChild(element1);

  var cell2 = row.insertCell(1);
  var element2 = document.createElement("input");
  element2.type = "number";
  element2.name="qta_sintesi[]";
  element2.className="form-control";
  element2.value="1";
  element2.disabled=true;
  cell2.appendChild(element2);

  var cell3 = row.insertCell(2);
  cell3.style ="text-align: center;";
  cell3.innerHTML = '<a class="glyphicon glyphicon-remove-sign" style="font-size: 30px;" href="#" onclick="del_mat_sintesi('+rowCount+',\''+tableID+'\')"></a>';


  /*
  var cell3 = row.insertCell(2);
  cell3.style ="text-align: center;";
  cell3.innerHTML = '<a class="glyphicon glyphicon-plus-sign" style="font-size: 30px;" href="#" onclick="add_mat_sintesi(\''+tableID+'\')"></a>';

  var prevCount = rowCount-1;
  var prevRow = table.rows[prevCount];
  var cell = prevRow.cells[2];
  cell.innerHTML = '<a class="glyphicon glyphicon-remove-sign" style="font-size: 30px;" href="#" onclick="del_mat_sintesi('+prevCount+',\''+tableID+'\')"></a>';
  */

}

function del_mat_sintesi(rowNumber,tableID){
  var table = document.getElementById(tableID);
  table.deleteRow(rowNumber);

  var count = table.rows.length;
  //var count = table.rows.count;
  //count = count-1;
  var i = 0;
  for(;i<count;i++) {
    var row = table.rows[i];
    var cell = row.cells[2];
    cell.innerHTML='<a class="glyphicon glyphicon-remove-sign" style="font-size: 30px;" href="#" onclick="del_mat_sintesi('+i+',\''+tableID+'\')"></a>';
    /*
    if (i==count-1){
      cell.innerHTML='<a class="glyphicon glyphicon-remove-sign" style="font-size: 30px;" href="#" onclick="del_mat_sintesi('+i+',\''+tableID+'\')"></a>';
    }else{
      cell.innerHTML = '<a class="glyphicon glyphicon-plus-sign" style="font-size: 30px;" href="#" onclick="add_mat_sintesi(\''+tableID+'\')"></a>';
    }
    */
  }


}

function add_rotta(tableID){
      var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var cell1 = row.insertCell(0);
			var element1 = document.createElement("input");
			element1.type = "number";
			element1.name="numero[]";
      element1.className="form-control";
      element1.style="width:60px";
      element1.value="0";
			cell1.appendChild(element1);
      var element2 = document.createElement("input");
			element2.type = "hidden";
			element2.name="ID[]";
      element2.value="-1";
			cell1.appendChild(element2);
      var element2 = document.createElement("input");
      element2.type = "hidden";
      element2.name="oggetto[]";
      element2.value="-1";
      cell1.appendChild(element2);
      var element3 = document.createElement("input");
      element3.type = "hidden";
      element3.name="numero_old[]";
      element3.value="0";
      cell1.appendChild(element3);

      var element4 = document.createElement("input");
      element4.type = "hidden";
      element4.name="evento[]";
      element4.value="";
      cell1.appendChild(element4);

			var cell2 = row.insertCell(1);
      var element5 = document.createElement("input");
			element5.type = "text";
			element5.name="nome[]";
      element5.className="form-control";
      element5.value="";
			cell2.appendChild(element5);

      var cell3 = row.insertCell(2);
			cell3.innerHTML = "0";

			var cell4 = row.insertCell(3);
			var element6 = document.createElement("input");
			element6.type = "number";
			element6.name = "costo[]";
      element6.className= "form-control";
      element6.style="width:60px";
      element6.value= "0";
			cell4.appendChild(element6);
      var element7 = document.createElement("input");
      element7.type = "hidden";
      element7.name = "cos_old[]";;
      element7.value= "0";
      cell4.appendChild(element7);

      var cell5 = row.insertCell(4);
			var element8 = document.createElement("input");
			element8.type = "number";
			element8.name = "disponibile[]";
      element8.className= "form-control";
      element8.style="width:60px";
      element8.value= "0";
			cell5.appendChild(element8);
      var element9 = document.createElement("input");
      element9.type = "hidden";
      element9.name = "disp_old[]";
      element9.value= "0";
      cell5.appendChild(element9);

      var cell6 = row.insertCell(5);
      cell6.innerHTML = '<a class="with_margin_icon glyphicon glyphicon-remove-sign" href="#" onclick="deleteRow('+rowCount+','+tableID+')"></a>';
}

function deleteRow(rowNumber,tableID){
    var table = document.getElementById(tableID);
    table.deleteRow(rowNumber);
}
/*
function modifica_rotte(pg){
  $.ajax({
    type: "PUT",
    url:  "rotte/modifica/"+pg,
    async: false,
    success: function(output){
      get_rotte(pg);
    },
    dataType: "json"
  });
}
*/
function rigenera_rotte(pg,id_evento){
$.ajax({
	type: "GET",
	url:  "rotte/rigenera/"+pg,
	async: false,
	success: function(output){
    get_rotte(pg,id_evento);
	},
	dataType: "html"
});
}
/*
function rigenera_rotte(pg){
$.ajax({
	type: "PUT",
	url:  "rotte/rigenera/"+pg,
	async: false,
	success: function(output){
    get_rotte(pg);
	},
	dataType: "json"
});
}
*/
function destroy_rotta(id,pg,id_evento){
	var conf = confirm("Cancello la rotta n°"+id+"?");
	if (conf){
		$.ajax({
			type: 'POST',
			url:  "rotte/"+id,
			data: { _method:"DELETE" },
			success: function(){
				//location.reload();
        get_rotte(pg,id_evento);
				$("#info").html('Rotta Cancellata con Successo!');
			},
			dataType: "html"
		});
	}
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

function get_abilita_PG(pos){
$.ajax({
	type: "GET",
	url:  "abilita/"+pos,
	async: false,
	success: function(output){
		$("#abilita_desc").html(output.Descrizione+'</br>');
	},
	dataType: "json"
});
}


function get_list_missive(page,show_delete,idpg){
var data = $( "form" ).serializeArray();
data.push({name: 'page', value: page});
$.ajax({
	type: "GET",
	url:  "missive/search",
	data: data,
	success: function(output){
		$('#pagine').bootpag({
			total: output.last_page,
			maxVisible: 7
		}).on("page", function(event, num){get_list_missive(num,show_delete,idpg)} );
		var masters = [" ","varo","ordaldm","maximilien","birzzum","filippo","loyankee"];
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
			var masterCombo = "<select name='master' id='"+missiva.id+"' class='dropdown' onchange='update_master("+missiva.id+")'>" ;
			for (var i=0; i<masters.length; i++)
			{
   			 if (masters[i] == missiva.Master){
   				 masterCombo = masterCombo + "<option value='"+masters[i]+"' selected = 'selected'>"+masters[i]+"</option>";
   			 }else {
   				 masterCombo = masterCombo + "<option value='"+masters[i]+"'>"+masters[i]+"</option>";
   			 }
			}
			masterCombo = masterCombo + "</select>";

			testo=$('<p></p>').addClass('visible-xs justified');
			icon_area=$('<div></div>').addClass('icon_area');

			main.append(media);
			media.append(mediacollapse);
			mediacollapse.append(icon_area);
			// se sei un master
			if (show_delete) {
				// Aggiungi bottone per cancellare missiva, come glyph
				icon_area.append("<a class='with_margin_icon glyphicon glyphicon-remove-sign' href='#' onclick='destroy_missiva("+missiva.id+")'></a>");
				// Aggiungi Toggle Rispondere
				if (missiva.rispondere==1){
				icon_area.append("<a class='with_margin_icon glyphicon glyphicon-check' href='#' onclick='toggle_rispondere("+missiva.id+")' style='color: #f00'></a>");
				}
				if (missiva.rispondere==0){
				icon_area.append("<a class='with_margin_icon glyphicon glyphicon-check' href='#' onclick='toggle_rispondere("+missiva.id+")'></a>");
				}
				if (missiva.costo > 0){
				// Aggiungi bottone per inoltrare missiva, come glyph
					if (missiva.tipo_mittente == "PG") {
						icon_area.append("<a class='with_margin_icon glyphicon glyphicon-circle-arrow-right' href='#' title='Inoltra' onclick='inoltra("+missiva.id+")'></a>");
					}
					if (missiva.Firma_Mitt != 0){
						icon_area.append("<a class='with_margin_icon glyphicon glyphicon-circle-arrow-left' href='#' title='Rispondi' onclick='rispondi("+missiva.id+")'></a>");
					}
					icon_area.append(masterCombo); //dentro al controllo (se costo >0)
				}
			}

			//per Giocatori
			if (!show_delete && missiva.destinatario == idpg && missiva.Firma_Mitt != 0){
				icon_area.append("<a class='with_margin_icon glyphicon glyphicon-circle-arrow-left' href='#' onclick='rispondi("+missiva.id+")'></a>");
			}

			mediacollapse.append(header);
			header.append("<input type='hidden' name='id' value='"+missiva.id+"' />");

			// Aggiungi icone con il tipo di missiva, come glyph
			header.append("<span class='icona_tipo_missiva "+missiva.tipo['icon']+"' ></span>");
			if (missiva.intercettato==1 && show_delete){
				header.append("<span class='icona_interc_missiva glyphicon glyphicon-flash'>");
				}

			header.append("<span style='font-weight:bold; margin-right:5px;'> ("+missiva.data+") </span>")
			header.append(missiva.mitt);
			header.append("<span class='with_margin glyphicon glyphicon-arrow-right' ></span>")
			header.append(missiva.dest);
			mediacollapse.append(body);
			body.append(testo);
			testo.append((missiva.testo));

		});
		$('.media .media-heading').on('click', function(e) {
			e.preventDefault();
			$('.media-heading').removeClass('missiva_clicked');
			$(this).addClass('missiva_clicked');

			get_missiva($(this).children('[name="id"]').val(),idpg);
			var HH=$('#parent-list').height();
			var WW=$('#parent-list').width();
			$('#panel_missiva').css('min-height',HH);
			$('#panel_missiva').css('width',WW);
			$('#panel_missiva').toggle(0); // show panel with missiva
			var pos=$('#parent-list').offset();
			window.scrollTo(pos.left, pos.top-100);
		});
		$('#panel_missiva').hide();
	},
	dataType: "json"
});
}



function get_missiva(id,idpg){
$.ajax({
	type: "GET",
	url:  "missive/"+id,
	async: false,
	success: function(output){

		$("#missiva_icon_bar").html("<a class='with_margin_icon_left glyphicon glyphicon-remove' href='#' title='Ritorna alla lista delle missive' onclick='hide_missiva()'></a>");
		$("#missiva_icon_bar").append("<a class='pdfbutton with_margin_icon_left glyphicon glyphicon-print' title='Genera PDF stampabile' href='missive/"+id+"'></a>");
		if (idpg == 0) {
			if (output.costo > 0){
				if (output.Firma_Mitt != 0){
					$("#missiva_icon_bar").append("<a class='pdfbutton with_margin_icon_left glyphicon glyphicon-circle-arrow-left' href='#' title='Rispondi' onclick='rispondi("+id+")'></a>");
				}
				if (output.tipo_mittente == "PG") {
					$("#missiva_icon_bar").append("<a class='pdfbutton with_margin_icon_left glyphicon glyphicon-circle-arrow-right' href='#' title='Inoltra' onclick='inoltra("+id+")'></a>");
				}
			}
		}
		if (output.destinatario == idpg && output.Firma_Mitt != 0){
			$("#missiva_icon_bar").append("<a class='pdfbutton with_margin_icon_left glyphicon glyphicon-circle-arrow-left' href='#' title='Rispondi al Mittente' onclick='rispondi("+id+")'></a>");
		}

		$("#missiva_icon_bar").append("<h4 class='data_missiva' >"+output.data+"</h4>");

		$("#mittente_sm").html(' Da: '+output.mitt);
		$("#destinatario_sm").html(' Per: '+output.dest);
		$("#testo_sm").html(output.testo);
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


function update_master(id){
    var e = document.getElementById(id);
    var strMaster = e.options[e.selectedIndex].value;
    $.ajax({
   		 type: 'POST',
   		 url:  "missive/"+id+"/"+strMaster+"/aggiorna_master",
   		 success: function(){
			// questi sono commentati per non ricaricare la pagina, altrimenti dopo ogni selezione bisognerebbe tornare a cercare le missive da aggiornare. il combo rimane impostato comunque
   			 //location.reload();
   			 //$("#info").html('Missiva Aggiornata con Successo!');
   		 },
   		 dataType: "html"
   	 });
}

function rispondi(id){
		window.location.href = "missive/"+id+"/rispondi";

	}

function inoltra(id){
	window.location.href = "missive/"+id+"/inoltra";
}

function azzera_debito(id,alla_banca){
	if (alla_banca==1) {
	    var conf = confirm("Accredito il debito sul conto?");
	    if (conf){
	       $.ajax({
	                type: 'POST',
					async: false,
	                url:  "debito/"+id+"/1",
	                success: function(){
	                    location.reload();
	                },
	                dataType: "json"
	        });
	    }

	} else if (alla_banca==0) {
	    var conf = confirm("Debito pagato in contanti?");
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
}

function azzera_spesa(id,alla_banca){
	if (alla_banca==1) {
	    var conf = confirm("Accredito la spesa sul conto?");
	    if (conf){
	       $.ajax({
	                type: 'POST',
					async: false,
	                url:  "spesa/"+id+"/1",
	                success: function(){
	                    location.reload();
	                },
	                dataType: "json"
	        });
	    }
	} else if (alla_banca==0) {
	    var conf = confirm("Spesa pagata in contanti?");
	    if (conf){
	       $.ajax({
	                type: 'POST',
					async: false,
	                url:  "spesa/"+id,
	                success: function(){
	                    location.reload();
	                },
	                dataType: "json"
	        });
	    }
	}
}

function azzera_conto(id){
    var conf = confirm("Chiudo il conto?");
    if (conf){
       $.ajax({
                type: 'POST',
				async: false,
                url:  "conto/"+id,
                success: function(){
                    location.reload();
                },
                dataType: "json"
        });
     }
}

function aggiorna_interessi(id){
    var conf = confirm("Aggiorno gli interessi del conto?");
    if (conf){
		$.ajax({
			type: 'POST',
			url:  "interessi/"+id,
			success: function(){
				location.reload();
				$("#info").html('Interessi Calcolati con Successo!');
			},
			dataType: "html"
		});
    }
}

function get_conto(pos) {
    var tmp = null;
    $.ajax({
		type: "GET",
		url:  "conto/"+pos,
		async: false,
		success: function(output){
			tmp=output;
		},
		dataType: "json"
	});
    return tmp;
};


function edit_conto(id) {

	var conto=get_conto(id);
	if ($('#edit_conto').is(":visible"))
	{
		$('#edit_conto').slideUp();
	}
	else {
		$('#edit_conto').slideDown();

		$('#form_edit').attr('action','conto/'+conto.ID);
		$('#form_edit #PG').html(conto.personaggio.Nome);
		$('#form_edit #Importo').val(conto.Importo);
		$('#form_edit #Interessi').val(conto.Interessi);
		$('#form_edit #Intestatario').val(conto.Intestatario);
	}
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
	if (evento.ID==54){
		 var Start=evento.Data+" 19:00";
		 var Stop=mm.add(2,"d").format("YYYY-MM-DD")+" 02:00";
		} else if (evento.ID==58){
		 var Start=evento.Data+" 12:00";
		 var Stop=mm.add(1,"d").format("YYYY-MM-DD")+" 00:00";
		} else if (evento.ID==59){
		 var Start=evento.Data+" 11:00";
		 var Stop=mm.add(1,"d").format("YYYY-MM-DD")+" 00:30";
		} else {
		 var Start=evento.Data+" 14:00";
		 var Stop=mm.add(1,"d").format("YYYY-MM-DD")+" 02:00";
		}
	$(string).timeSchedule({
		startTime: Start, // schedule start time(HH:ii)
		endTime: Stop,   // schedule end time(HH:ii)
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
            var posL=$(".sc_main_box").scrollLeft();
            var posT=$(window).scrollTop();
            $("#schedule").empty();
			initialize_scheduler("#schedule");
			$(".sc_main_box").scrollLeft(posL);
            $(window).scrollTop(posT);
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
            var posL=$(".sc_main_box").scrollLeft();
            var posT=$(window).scrollTop();
            $("#schedule").empty();
			initialize_scheduler("#schedule");
			$(".sc_main_box").scrollLeft(posL);
            $(window).scrollTop(posT);
		},
		change: function(node,data){
			var param = $.param({'start':data.start, 'end':data.end});
			$.ajax({
                type: "POST",
                cache: false,
                data: param,
                url: "elemento/"+data.id
            });
            var posL=$(".sc_main_box").scrollLeft();
            var posT=$(window).scrollTop();
            $("#schedule").empty();
			initialize_scheduler("#schedule");
			$(".sc_main_box").scrollLeft(posL);
            $(window).scrollTop(posT);
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

//#####################################################################
//########### MEDICINA ################################################

function get_cicatrici_evento(pos){
$.ajax({
	type: "GET",
	url:  "medicina/evento/"+pos,
	async: true,
	success: function(output){
		var html=$('<div></div>');

		for (var key in output) {
      // elenco delle malattie da DB
      if (key == "malattie"){

      }else {
  			// header con nome Famiglia
  			html.append("<h4>"+ key+"</h4>");

  			var table=$('<table id="'+key.replace(/\s/g, '')+'"></table>').addClass("table");
  			table.append('<tr><th>PG</th><th>Cicatrici</th><th>Cicatrici Rimaste</th>'+
  						 '<th>%</th><th>Cibo<br><a href="javascript:$(\'.cibocheck\',\'#'+key.replace(/\s/g, '')+'\').prop(\'checked\', true).change();">Tutti</a></th>'+
  						 //'<th>Armi<br><a href="javascript:$(\'.armicheck\',\'#'+key.replace(/\s/g, '')+'\').prop(\'checked\', true).change();">Tutti</a></th>'+
               '<th>Terapia<br><a href="javascript:$(\'.terapiacheck\',\'#'+key.replace(/\s/g, '')+'\').prop(\'checked\', true).change();">Tutti</a></th>'+
               '<th>Cura<br><a href="javascript:$(\'.curacheck\',\'#'+key.replace(/\s/g, '')+'\').prop(\'checked\', true).change();">Tutti</a></th>'+
               '<th>Contatto con Malattia<br></th></tr>');
  			// elenco PG con cicatrici e cibo;
  			for(var idpg in output[key]){
  				var pg = output[key][idpg];
  				var Perc=0.1*Math.round(1000*pg['CicatriciRimaste']/pg['Cicatrici']);
  				var tablecolor='';
  				if (Perc<50) {tablecolor='warning';}
  				if (Perc<25) {tablecolor='danger';}

  				var rowpg = $('<tr class="'+tablecolor+'"></tr>');
  				rowpg.append('<td><input type="hidden" name="pg[]" value="'+pg['ID']+'"></input>' +pg['Nome'] + ' (' +pg['NomeGiocatore'] + ")</td>");
  				rowpg.append('<td>' +pg['Cicatrici'] + "</td>");
  				rowpg.append('<td><input style="max-width:60px;" class="form-control" name="cicatrici[]" type="number" value="'+pg['CicatriciRimaste']+'"> </td>');
  				rowpg.append('<td>'+Perc+'%</td>');
  				//rowpg.append('<td><input style="max-width:60px;" class="form-control" name="cibo[]"      type="number" value="'+pg['Cibo']+'" ></input></td>');
  				if (pg['Cibo']==1) {var ValCibo='checked';} else {var ValCibo='';}
  				rowpg.append('<td><input class="checkbox cibocheck" name="cibo[]"  type="checkbox" '+ValCibo+' value="'+pg['ID']+'" ></input></td>');
  				//if (pg['Armi']==1) {var ValArmi='checked';} else {var ValArmi='';}
  				//rowpg.append('<td><input class="checkbox armicheck" name="armi[]"  type="checkbox" '+ValArmi+' value="'+pg['ID']+'" ></input></td>');
          if (pg['Terapia']==1) {var ValTerapia='checked';} else {var ValTerapia='';}
  				rowpg.append('<td><input class="checkbox terapiacheck" name="terapia[]"  type="checkbox" '+ValTerapia+' value="'+pg['ID']+'" ></input></td>');
          if (pg['Cura']==1) {var ValCura='checked';} else {var ValCura='';}
          rowpg.append('<td><input class="checkbox curacheck" name="cura[]"  type="checkbox" '+ValCura+' value="'+pg['ID']+'" ></input></td>');

          var elencoMalattie ='<option value="0">...</option>';
          for (var idmalattia in output['malattie']){
            var malattia = output['malattie'][idmalattia];
            if(malattia['ID']==pg['Malattia']){
              elencoMalattie=elencoMalattie+('<option value="'+malattia['ID']+'" selected>'+malattia['Nome']+'</option>');
            }else {
              elencoMalattie=elencoMalattie+('<option value="'+malattia['ID']+'" >'+malattia['Nome']+'</option>');
            }
          }

          rowpg.append('<td><select class="fomr-control" name="malattia[]">'+elencoMalattie+'</select></td>');

          table.append(rowpg);
  			}
  			html.append(table);
      }
		}
		$("#evento_testo").html(html);
		$('.checkbox').bootstrapToggle({on: 'Si',off: 'No'});
	},
	dataType: "json"
});

}
// MERCATO DEI PREZIOSI
function fai_offerta(id){
var offerta = prompt("Inserisci la tua offerta in monete di rame. Ogni offerta preesistente verrà sovrascritta. L'offerta è valida solo se pari o superiore alla base d'asta.", "0");

if (offerta == null || offerta == "") {
    alert('Offerta non valida!');
} else {
	$.ajax({
		type: "POST",
		async: true,
		url: "preziosi/"+id+"/offerta/"+offerta,
		success: function(){
			location.reload();
			$("#info").html('Iscrizione Cancellata con Successo!');
		}
	});
}
}


function get_oggetto_prezioso(pos){
$.ajax({
	type: "GET",
	url:  "preziosi/"+pos,
	async: true,
	success: function(output){
		$("#venduto_Nome").html("Nome: "+output.Nome);
		$("#venduto_Aspetto").html("Aspetto: "+output.Aspetto);
		$("#venduto_Materiali").html("Materiali: "+output.Materiali);
		$("#venduto_Valore").html("Valore: "+output.Valore);
		$("#venduto_Acquirente").html("Acquirente: "+output.Acquirente);
	},
	dataType: "json"
});
}

////// DOMANDE FREQUENTI

function get_domanda_master(pos){
$.ajax({
	type: "GET",
	url:  "domanda/"+pos,
	async: true,
	success: function(output){
		$("#domanda_domanda").html(output.Domanda);
		$("#domanda_risposta").html(output.Risposta);
	},
	dataType: "json"
});
}

function get_domanda(pos){
$.ajax({
	type: "GET",
	url:  "domanda/"+pos,
	async: true,
	success: function(output){
		$("#domanda_domanda").html(output.Domanda);
		$("#domanda_risposta").html(output.Risposta);
	},
	dataType: "json"
});
}

////// ERRATA CORRIGE

function get_errata_master(pos){
$.ajax({
	type: "GET",
	url:  "errata/"+pos,
	async: true,
	success: function(output){
		$("#errata_errata").html(output.Titolo);
		$("#errata_risposta").html(output.Testo);
	},
	dataType: "json"
});
}

function get_errata(pos){
$.ajax({
	type: "GET",
	url:  "errata/"+pos,
	async: true,
	success: function(output){
		$("#errata_errata").html(output.Titolo);
		$("#errata_risposta").html(output.Testo);
	},
	dataType: "json"
});
}

////// SOSTANZE

function get_list_sostanze(page){
  var data = $( "form" ).serializeArray();
  data.push({name: 'page', value: page});
  $.ajax({
  	type: "GET",
  	url:  "sostanze/search",
  	data: data,
  	success: function(output){
  		$('#pagine').bootpag({
  			total: output.last_page,
  			maxVisible: 7
  		}).on("page", function(event, num){get_list_sostanze(num)} );
  		var sostanze=output.data;
  		//var main=$('#results');
      var main=$('#accordion');
  		main.html('');
  		$.each(sostanze, function(index, sostanza){

        var cromodinamica = sostanza.cromodinamica;
        var id_coll = 'collapse_'+sostanza.id_sostanza;
        var materiali = sostanza.materiali;

        panelDefault =$('<div></div>').addClass('panel panel-default');
        header= $('<div></div>').addClass('panel-heading');
        title=$('<h4></h4>').addClass('panel-title');
        collapse=$('<div id='+id_coll+'></div>').addClass('panel-collapse collapse');
        body=$('<div></div>').addClass('panel-body');
        icon_area=$('<div></div>');
        button=$('<a data-toggle="collapse" data-parent="#accordion" href="#'+id_coll+'"></a>');
        //bodybox=$("<div class='col-sm-12'>	</div>");
        bodycol1=$("<div class='col-sm-6'>	</div>");
        bodycol2=$("<div class='col-sm-6'>	</div>");


        main.append(panelDefault);
        panelDefault.append(header);

        //icon_area.append(sostanza.cancellata);

        if(sostanza.cancellata==0){
          icon_area.append("<a class='with_margin_icon glyphicon glyphicon-remove-sign' href='#' onclick='destroy_sostanza("+sostanza.id_sostanza+")'></a>");
          icon_area.append("<a class='with_margin_icon glyphicon glyphicon-check' href='sostanze/"+sostanza.id_sostanza+"/edit' style='color: #f00'></a>");
        }

        header.append(icon_area);
        header.append(button);
        button.append(title);
        title.append("<span class='icona_tipo_missiva "+sostanza.tipo['icon']+"' ></span>");
        title.append("<span style='font-weight:bold; margin-right:5px;'>"+sostanza.nome+"</span>" );

          panelDefault.append(collapse);
          collapse.append(body);
          body.append(  bodycol1);
          body.append(  bodycol2);

          stat =$('<div class="row-sm-12"></div>');
          bodycol1.append(stat);
          stat1=$('<div class="col-sm-6"></div>');
          stat.append(stat1);
          stat1.append('<label for="diluizione_'+sostanza.id_sostanza+'">Diluizione</label>');
          stat1.append('<input class="form-control" id="diluizione_'+sostanza.id_sostanza+'" name="diluizione" type="number" value="'+sostanza.diluizione+'" disabled>');

          stat2=$('<div class="col-sm-6"></div>');
          stat.append(stat2);
          stat2.append('<label for="cromodinamica_'+sostanza.id_sostanza+'">Cromodinamica</label>');
          stat2.append('<input class="form-control" id="cromodinamica_'+sostanza.id_sostanza+'" name="cromodinamica" type="text" value="'+sostanza.cd+'" disabled><br>');

          bodycol1.append('<br><label for="Effetti">Effetti</label>');
          bodycol1.append('<textarea class="form-control" name="Effetti" cols="50" rows="2" id="Descrizione_'+sostanza.id_sostanza+'" disabled>'+sostanza.effetti+'</textarea>');


          bodycol2.append('<label for="Matrice">Matrice</label>');
          matrice=$('<div class="input-group"></div>');
          bodycol2.append(matrice);
					matrice.append('<span class="input-group-addon danger" id="sizing-addon1"><span class="glyphicon glyphicon-leaf "></span></span>');
					matrice.append('<input id="Rosse_'+sostanza.id_sostanza+'" class="form-control" aria-describedby="sizing-addon1" name="Rosse" type="text" value="'+sostanza.R+'" disabled>');
					matrice.append('<span class="input-group-addon success" id="sizing-addon2"><span class="glyphicon glyphicon-leaf"></span>	</span>');
					matrice.append('<input id="Verdi_'+sostanza.id_sostanza+'" class="form-control" aria-describedby="sizing-addon2" name="Verdi" type="text" value="'+sostanza.V+'" disabled>');
					matrice.append('<span class="input-group-addon primary" id="sizing-addon3"><span class="glyphicon glyphicon-leaf"></span></span>');
					matrice.append('<input id="Blu_'+sostanza.id_sostanza+'" class="form-control" aria-describedby="sizing-addon3" name="Blu" type="text" value="'+sostanza.B+'" disabled>');


          bodycol2.append('<br><label for="Materiali">Materiali</label>');
          matDiv =$('<div class="form-group"></div>');
          bodycol2.append(matDiv);

          matTab=$('<table class="table table-striped"></table>');
          matBody=$('<tbody></tbody>');
          matDiv.append(matTab);
          matTab.append(matBody);

          	$.each(materiali, function(index, materiale){

                matBody.append("<tr><td>"+materiale.Nome +"</td><td>"+materiale.pivot.quantita +"</td><tr>");

            });
  		});

  		$('#panel_sostanza').hide();

  	},
  	dataType: "json"
  });

}

function destroy_sostanza(id){
  var conf = confirm("Cancello la Sostanza n°"+id+"?");
  if (conf){
    $.ajax({
      type: 'POST',
      url:  "sostanze/"+id,
      data: { _method:"DELETE" },
      success: function(){
        //$("#info").html('Sostanza Cancellata con Successo!');
        //location.reload();
      },
      dataType: "html"
    });
  }
}

function destroy_mat_sostanza(id_mat, id_sostanza){
  $.ajax({
    type: 'POST',
    url:  "/admin/sostanze/materiale/"+id_mat+"/"+id_sostanza,
    data: { _method:"DELETE" },
    success: function(){
      location.reload();
      //get_rotte(pg);
      $("#info").html('Materiale cancellato!');
    },
    dataType: "html"
  });
}

function add_mat_sostanza(id_sostanza){
  var data = $( "form" ).serializeArray();
  $.ajax({
    type: 'PUT',
    url:  "/admin/sostanze/materiale/"+id_sostanza,
    data: data,
    success: function(){
      location.reload();

      $("#info").html('Materiale aggiunto!');
    },
    dataType: "html"
  });
}

function add_mat_sostanza_new(){
  var table = document.getElementById('tab-mat-sostanza');
  var idMat= $('#SelMateriali').val();
  var selMat = document.getElementById('SelMateriali');
  var nomeMat=selMat.options[selMat.selectedIndex].text;
  var qtaMat=$('#qtaMat').val();

  var rowCount = table.rows.length;
  var row = table.insertRow(rowCount);

  var cell1 = row.insertCell(0);
  var element0 = document.createElement("input");
  element0.type = "hidden";
  element0.name="mat_id[]";
  //element1.className="form-control";
  element0.value=idMat;
  cell1.appendChild(element0);

  //var cell1 = row.insertCell(0);
  var element1 = document.createElement("input");
  element1.type = "text";
  element1.name="mat_nome[]";
  element1.className="form-control";
  element1.value=nomeMat;
  cell1.appendChild(element1);

  var cell2 = row.insertCell(1);
  var element2 = document.createElement("input");
  element2.type = "number";
  element2.name="mat_qta[]";
  element2.className="form-control";
  element2.value=qtaMat;
  cell2.appendChild(element2);

  var cell3 = row.insertCell(2);
  cell3.style ="text-align: center;";
  cell3.innerHTML = '<a class="glyphicon glyphicon-remove-sign" style="font-size: 30px;" href="#" onclick="destroy_mat_sostanza_new('+rowCount+')"></a>';

}

function destroy_mat_sostanza_new(rowNumber){
  var table = document.getElementById('tab-mat-sostanza');
  table.deleteRow(rowNumber);
}

function change_color_cromodinamica(id_cd){
  $.ajax({
  	type: "GET",
  	url:  "/admin/sostanze/cromodinamica/"+id_cd,
  	async: true,
  	success: function(output){
      var hexR = output.cromo_R.toString(16);
      var hexV = output.cromo_V.toString(16);
      var hexB = output.cromo_B.toString(16);
      var hexCromo = '#'+hexR+hexV+hexB;
      var selCD = document.getElementById('cromodinamica');
      selCD.style.backgroundColor = hexCromo;
  		//$("#cromodinamica").setAttribute('style','background-color:rgb('+output.cromo_R+','+output.cromo_V+','+output.cromo_B+');');
  	},
  	dataType: "json"
  });
}
  function get_matrice(){
    var data = $( "form" ).serializeArray();
    dil=$('#diluizione').val();
    id_cd=$('#cromodinamica').val();
    $.ajax({
    	//type: "GET",
      type: "PUT",
    	url:  "/admin/sostanze/matrice/"+id_cd+"/"+dil,
      data: data,
    	//async: true,
    	success: function(output){
          //location.reload();
        var rosse = document.getElementById("rosse");
        rosse.value = output.R;

        var verdi = document.getElementById("verdi");
        verdi.value = output.V;

        var blu = document.getElementById("blu");
        blu.value = output.B;

        //inserire con js il blocco dei messaggi.
      },
    	dataType: "json"
    });
}

//// MATERIALI

function get_list_materiali(page){
  var data = $( "form" ).serializeArray();
  data.push({name: 'page', value: page});
  $.ajax({
  	type: "GET",
  	url:  "materiali/search",
  	data: data,
  	success: function(output){
  		$('#pagine').bootpag({
  			total: output.last_page,
  			maxVisible: 7
  		}).on("page", function(event, num){get_list_materiali(num)} );
  		var materiali=output.data;
  		//var main=$('#results');
      var main=$('#accordion');
  		main.html('');
  		$.each(materiali, function(index, materiale){

        var cromodinamica = materiale.cromodinamica;
        var id_coll = 'collapse_'+materiale.ID;


        panelDefault =$('<div></div>').addClass('panel panel-default');
        header= $('<div></div>').addClass('panel-heading');
        title=$('<h4></h4>').addClass('panel-title');
        collapse=$('<div id='+id_coll+'></div>').addClass('panel-collapse collapse');
        body=$('<div></div>').addClass('panel-body');
        icon_area=$('<div></div>');
        button=$('<a data-toggle="collapse" data-parent="#accordion" href="#'+id_coll+'"></a>');
        //bodybox=$("<div class='col-sm-12'>	</div>");
        bodycol1=$("<div class='col-sm-6'>	</div>");
        bodycol2=$("<div class='col-sm-6'>	</div>");


        main.append(panelDefault);
        panelDefault.append(header);

        header.append(icon_area);

        if(materiale.cancellata==0){
          icon_area.append("<a class='with_margin_icon glyphicon glyphicon-remove-sign' href='#' onclick='destroy_materiale("+materiale.ID+")'></a>");
          icon_area.append("<a class='with_margin_icon glyphicon glyphicon-check' href='materiali/"+materiale.ID+"/edit' style='color: #f00'></a>");
        }

        header.append(button);
        button.append(title);
        //title.append("<span class='icona_tipo_missiva "+sostanza.tipo['icon']+"' ></span>");
        title.append("<span style='font-weight:bold; margin-right:5px;'>"+materiale.Nome+"</span>" );

          panelDefault.append(collapse);
          collapse.append(body);
          body.append(  bodycol1);
          body.append(  bodycol2);

          stat =$('<div class="row-sm-12"></div>');
          bodycol1.append(stat);
          stat1=$('<div class="col-sm-6"></div>');
          stat.append(stat1);
          stat1.append('<label for="categoria_'+materiale.ID+'">Categoria</label>');
          stat1.append('<input class="form-control" id="categoria_'+materiale.ID+'" name="categoria" type="text" value="'+materiale.cat.Descrizione+'" disabled>');

          stat2=$('<div class="col-sm-6"></div>');
          stat.append(stat2);
          stat2.append('<label for="stagione_'+materiale.ID+'">Stagione</label>');
          stat2.append('<input class="form-control" id="stagione_'+materiale.ID+'" name="stagione" type="text" value="'+materiale.stg+'" disabled>');


          cd =$('<div class="row-sm-12"></div>');
          bodycol1.append(cd);
          cd1=$('<div class="col-sm-12"></div>');
          cd.append(cd1);
          cd1.append('<label for="cromodinamica_'+materiale.ID+'">Cromodinamica</label>');
          cromodinamica = '';
          crom_name = materiale.ID;
          if(materiale.cd!=null){
            cromodinamica = materiale.cd.DESC;
            crom_name = materiale.cd.DESC;
          }
          cd1.append('<input class="form-control" id="cromo_'+crom_name+'" name="cromodinamica" type="text" value="'+cromodinamica+'" disabled><br>');

          dat =$('<div class="row-sm-12"></div>');
          bodycol1.append(dat);
          dat2=$('<div class="col-sm-6"></div>');
          dat.append(dat2);
          dat2.append('<label for="valore_'+materiale.ID+'">Valore</label>');
          dat2.append('<input class="form-control" id="valore_'+materiale.ID+'" name="valore" type="number" value="'+materiale.ValoreBase+'" disabled><br>');

          dat3=$('<div class="col-sm-6"></div>');
          dat.append(dat3);
          dat3.append('<label for="quantita_'+materiale.ID+'">Q.ta</label>');
          dat3.append('<input class="form-control" id="quantita_'+materiale.ID+'" name="quantita" type="number" value="'+materiale.Quantita+'" disabled><br>');

          rar1 =$('<div class="row-sm-12"></div>');
          bodycol2.append(rar1);
          rl=$('<div class="col-sm-12"></div>');
          rar1.append(rl);
          rl.append('<label for="RL_'+materiale.ID+'">Rarità Locale</label>');
          rl.append('<input class="form-control" id="RL_'+materiale.ID+'" name="RL" type="text" value="'+materiale.rl.Descrizione+'" disabled>');

          rar2 =$('<div class="row-sm-12"></div>');
          bodycol2.append(rar2);
          ro=$('<div class="col-sm-12"></div>');
          rar2.append(ro);
          ro.append('<label for="RO_'+materiale.ID+'">Rarità Oltremare</label>');
          ro.append('<input class="form-control" id="RO_'+materiale.ID+'" name="RO" type="text" value="'+materiale.ro.Descrizione+'" disabled><br>');

          rar3 =$('<div class="row-sm-12"></div>');
          bodycol2.append(rar3);
          rn=$('<div class="col-sm-12"></div>');
          rar3.append(rn);
          rn.append('<label for="RN_'+materiale.ID+'">Rarità Mercato Nero</label>');
          rn.append('<input class="form-control" id="RN_'+materiale.ID+'" name="RN" type="text" value="'+materiale.rn.Descrizione+'" disabled><br>');


  		});

  		$('#panel_materiale').hide();

  	},
  	dataType: "json"
  });

}

function destroy_materiale(id){
  var conf = confirm("Cancello il materiale n°"+id+"?");
  if (conf){
    $.ajax({
      type: 'POST',
      url:  "materiali/"+id,
      data: { _method:"DELETE" },
      success: function(){
        //$("#info").html('Sostanza Cancellata con Successo!');
        //location.reload();
      },
      dataType: "html"
    });
  }
}

function get_verifica_cura(){
  var data = $( "form" ).serializeArray();
  //data.push({name: 'page', value: page});
$.ajax({
	type: "GET",
	url:  "malattie/verificaCura",
  data: data,
	//async: true,
	success: function(output){
    var verifica=output;

    var main=$('#resultsCura');
    main.html(output);

    var row = $('<div></div>');
    if(verifica.esito=='Cura'){
      row.addClass("row bs-callout bs-callout-success");
    }else if(verifica.esito=='Pagliativo'){
      row.addClass("row bs-callout bs-callout-warning");
    }else{
      row.addClass("row bs-callout bs-callout-danger");
    }

    esito = $('<div></div>');
    esito.append('<label for="esito_cura">Esito</label>');
    esito.append('<input id="esito_cura" class="form-control" aria-describedby="sizing-addon3" name="esito_cura" type="text" value="'+verifica.esito+'" disabled>');
    row.append(esito);

    effetti = $('<div></div>');
    effetti.append('<label for="effetti_cura">Effetti</label>');
    effetti.append('<textarea id="effetti_cura" class="form-control" aria-describedby="sizing-addon3" name="effetti_cura">'+verifica.effetto+'</textarea>');
    row.append(effetti);

    main.append(row);

	},
	dataType: "json"
});
}

function get_list_sintesi(page){
var data = $( "form" ).serializeArray();
data.push({name: 'page', value: page});
$.ajax({
	type: "GET",
	url:  "sintesi/search",
	data: data,
	success: function(output){
		$('#pagine').bootpag({
			total: output.last_page,
			maxVisible: 7
		}).on("page", function(event, num){get_list_sintesi(num)} );
		var sintesi=output.data;
		var main=$('#results');
		main.html('');
		$.each(sintesi, function(index, esperimento){

      row = $('<div></div>');

      main.append(row);


      if(esperimento.diluizione!=0){
        row.addClass('row bs-callout bs-callout-warning');
      }else{
        if(esperimento.id_sostanza!=null){
          row.addClass('row bs-callout bs-callout-success');
        }else{
          row.addClass('row bs-callout bs-callout-danger');
        }
      }

      var pg = '';

      if(esperimento.id_pg==0){
        pg = 'Master';
      }else{
        pg = esperimento.nomePG;
      }

      row.append('<label for="Personaggio">Personaggio</label>');
      row.append('<input class="form-control" id="pg_'+esperimento.id_pg+'" name="pg" type="text" value="'+pg+'" disabled><br>');
      row.append('<label for="Matrice">Matrice</label>');
      matrice=$('<div class="form-inline"></div>');
      group=$('<div class="input-group col-sm-9"></div>')
      row.append(matrice);
      matrice.append(group);
      group.append('<span class="input-group-addon danger" id="sizing-addon1"><span class="glyphicon glyphicon-leaf "></span></span>');
      group.append('<input id="r_'+esperimento.id_sintesi+'" class="form-control" aria-describedby="sizing-addon1" name="Rosse" type="text" value="'+esperimento.R_matrice+'" disabled> ');
      group.append('<span class="input-group-addon success" id="sizing-addon2"><span class="glyphicon glyphicon-leaf"></span>	</span>');
      group.append('<input id="Verdi_'+esperimento.id_sintesi+'" class="form-control" aria-describedby="sizing-addon2" name="Verdi" type="text" value="'+esperimento.V_matrice+'" disabled> ');
      group.append('<span class="input-group-addon primary" id="sizing-addon3"><span class="glyphicon glyphicon-leaf"></span></span>');
      group.append('<input id="Blu_'+esperimento.id_sintesi+'" class="form-control" aria-describedby="sizing-addon3" name="Blu" type="text" value="'+esperimento.B_matrice+'" disabled> ');

      row.append('<br>');

      var materiali = esperimento.componenti;
      if(materiali!=null){
        row.append('<label for="Materiali">Materiali</label>');
        matTable = $('<table></table>');
        $.each(materiali, function(index, materiale){
          matTable.append('<tr><td>'+materiale.Nome+'</td><td>'+materiale.Quantita+'</td></tr>');
        });
        row.append(matTable);
        row.append('<br>');
      }


      //cromod = $('<div class="input-group col-sm-6"></div>')
      //cromod.append('<label for="Cromodinamica">Cromodinamica</label>');
      row.append('<label for="Cromodinamica">Cromodinamica</label>');
      //color =$('<div class="form-inline"></div>');
      var cd = '';
      if (esperimento.cromodinamica!=null){
        cd = esperimento.cromodinamica.DESC;
      }
      //cromod.append('<input id="cromo_'+cd+'" class="form-control" aria-describedby="sizing-addon3" name="cromo_'+cd+'" type="text" value="'+cd+'" disabled>');
      row.append('<input id="cromo_'+cd+'" class="form-control" aria-describedby="sizing-addon3" name="cromo_'+cd+'" type="text" value="'+cd+'" disabled>');
      //color.append('<input id="cromo_'+cd+'" class="form-control" aria-describedby="sizing-addon3" name="cromo_'+cd+'" type="text" value="'+cd+'" disabled>');
      //cromod.append(color);
      //row.append(cromod);


        if(esperimento.diluizione!=0){
          if(esperimento.diluizione<0){
            cerchioW = $('<div></div>').addClass('circleW');
            //color.append(cerchioW);
            //cromod.append(cerchioW);
            row.append(cerchioW);
          }else{
            cerchioB = $('<div></div>').addClass('circleB');
            //color.append(cerchioB);
            //cromod.append(cerchioB);
            row.append(cerchioB);
          }
          if(esperimento.rubedo==1){
            cerchioR = $('<div></div>').addClass('circleR');
            row.append(cerchioR);
          }
        }else{
          if(esperimento.id_sostanza!=null){
            row.append('<br>');
            sostanza = $('<div class="input-group col-sm-9"></div>');
            effetti = $('<div></div>');
            effetti.append('<label for="effetti_'+esperimento.id_sintesi+'">Effetti</label>');
            effetti.append('<input id="effetti_'+esperimento.id_sintesi+'" class="form-control" aria-describedby="sizing-addon3" name="effetti_'+esperimento.id_sintesi+'" type="text" value="'+esperimento.sostanza.effetti+'" disabled>');
            sostanza.append(effetti);
            nome = $('<div></div>');
            nome.append('<label for="sostanza_'+esperimento.id_sintesi+'">Sostanza</label>');
            nome.append('<input id="sostanza_'+esperimento.id_sintesi+'" class="form-control" aria-describedby="sizing-addon3" name="sostanza_'+esperimento.id_sintesi+'" type="text" value="'+esperimento.sostanza.nome+'" disabled>');
            sostanza.append(nome);
            row.append(sostanza);
          }else{
            if(esperimento.rubedo==1){
              cerchioR = $('<div></div>').addClass('circleR');
              row.append(cerchioR);
            }
          }
        }

    });
  },
  dataType: "json"
});
}
