var total_list 		= 5;
var filter_by 		= 2;
var order 			= "asc";
var order_by		= "id_post";

$("#form-search").submit(function( event ) {
	/*$('#btn-del-girl').attr("disabled", true);*/
	var parametros = $(this).serialize();
	load(1);
	event.preventDefault();
});

$('.select-show .dropdown-menu').find('a').click(function(e) {
	e.preventDefault();
	var param 	= $(this).attr("href").replace("#","");
	var concept = $(this).text();
	$('#spn-list-show').html(concept);
	total_list = param;
	load(1);
});

$('.search-panel .dropdown-menu').find('a').click(function(e) {
	e.preventDefault();
	var param 		= $(this).attr("href").replace("#","");
	var concept 	= $(this).html();
	$('#btn-search-on').html(concept);
	filter_by = param;
	load(1);
});

function load(page) {
	var search = $("#txt-search").val();
	$.ajax({
		type: "POST",
		url: base_url+"pcheckbox/loadPosts",
		method: "POST",
		dataType: 'JSON',
		data: {
			page: page,
			search: search,
			filter: filter_by,
			limite: total_list,
			order: 	order,
			order_by: order_by,
		},
		beforeSend: function(objeto) {
			$("#btn-search").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Buscando...');
		},
		success: function(response) {
			$("#div-cnt-load").html(response.data);
			$("#h5-cnt-total").html(response.total);
			$("#btn-search").html('<i class="text-primary fas fa-search"></i>');
		}
	});
}

$(document).on("click", ".table th.th-link", function () {
	if (order=="asc") {
		order 	= "desc";
	}else{
		order 	= "asc";
	}
	order_by = $(this).attr("data-field");
	load(1);
});

$(document).on("click", ".mdl-del-reg", function () {
	//$("#form-del-reg").trigger("reset");
	$("#txt-id-reg-del").val($(this).data('idreg'));
	$("#txt-nom-reg").text('"'+$(this).data('nomreg')+'"');
});

$("#form-del-reg").submit(function( event ) {
	$('#btn-del-reg').attr("disabled", true);
	var idreg 		= $("#txt-id-reg-del").val();
	$.ajax({
		type: 		"POST",
		method: 	"POST",
		url: 		base_url+"pcheckbox/delReg",
		data: {
			list_ids: idreg,
		},
		dataType: 	"json",
		beforeSend: function(objeto){
			$("#btn-del-reg").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Eliminando');
		},
		success: function(datos){
			$("#btn-del-reg").html('<i class="fa fa-trash-alt"></i> Eliminar');
			$('#btn-del-reg').attr("disabled", false);
			$("#btn-close-mdl-del-reg").trigger("click");
			notify_msg(datos.icon, " ", datos.msg, "#", datos.tipo);
			load(0);
		},
		error: function(data) {
			$("#form-del-reg")[0].reset();
			$("#btn-del-reg").html('<i class="fa fa-trash-alt"></i> Eliminar');
			$("#div-cnt-del-reg").html('<div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-circle"></i> Error de comunicación con el servidor. Intenta más tarde.</div>');
		}
	});
	event.preventDefault();
});

$("#form-add-reg").submit(function( event ) {
	$('#btn-add-reg').attr("disabled", true);
	var parametros = $(this).serialize();
	$.ajax({
		type: "POST",
		dataType: 	"json",
		url:base_url+"pcheckbox/addReg",
		data: parametros,
		beforeSend: function(objeto){
			$("#btn-add-reg").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Agregando');
		},
		success: function(datos){
			notify_msg(datos.icon, " ", datos.msg, "#", datos.tipo);
			$("#btn-add-reg").html('<i class="fa fa-check"></i> Agregar');
			$('#btn-add-reg').attr("disabled", false);
			$("#form-add-reg")[0].reset();
			$("#btn-close-mdl-add-reg").trigger("click");
			load(0);
		},
		error: function(data) {
			$("#form-add-reg")[0].reset();
			$("#btn-add-reg").html('<i class="fa fa-check"></i> Agregar');
			$("#div-cnt-del-reg").html('<div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-circle"></i> Error de comunicación con el servidor. Intenta más tarde.</div>');
		}
	});
	event.preventDefault();
});

/**
 * For delete seleceted list
 */

/**
 * [On clic fuction active all check box set for deleted]
 */
$(document).on("click", "#chk-all-regs", function() {
	$(".chks-regs").prop("checked", this.checked);
	var lista_regs = [];
	$(".chks-regs:checked").each(function() {
		lista_regs.push($(this).data('iddel'));
	});

	if (lista_regs.length >= 1) {
		$("#spn-del").html(lista_regs.length);
		$("#btn-del-list").prop("disabled", false);
	}else{
		$("#spn-del").html('');
		$("#btn-del-list").prop("disabled", true);
	}
});

$(document).on("click", ".chks-regs", function() {
	if ($(".chks-regs:checked").length == $(".chks-regs").length) {
		$("#chk-all-regs").prop("checked", true);
	} else {
		$("#chk-all-regs").prop("checked", false);
	}
	
	var lista_regs = [];
	$(".chks-regs:checked").each(function() {
		lista_regs.push($(this).data('iddel'));
	});

	if (lista_regs.length >= 1) {
		$("#spn-del").html(lista_regs.length);
		$("#btn-del-list").prop("disabled", false);
	}else{
		$("#spn-del").html('');
		$("#btn-del-list").prop("disabled", true);
	}
});

$(document).on("click", ".mdl-del-regs", function () {
	var lista_regs = [];
	$(".chks-regs:checked").each(function() {
		lista_regs.push($(this).data('iddel'));
	});

	if (lista_regs.length >= 1) {
		$("#btn-del-regs").prop("disabled", false);
		if (lista_regs.length==1) {
			$("#div-cnt-del-regs").html('<h5>¿Está seguro de eliminar 1 registro?</h5>');
		}else{
			$("#div-cnt-del-regs").html('<h5>¿Está seguro de eliminar '+lista_regs.length+' registros?</h5>');
		}
	}else{
		$("#div-cnt-del-regs").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> Por favor seleccione al menos un registro.</div>');
		$("#btn-del-regs").prop("disabled", true);
	}
});

$("#form-del-regs").submit(function( event ) {
	$('#btn-del-list').attr("disabled", true);
	var list_ids = [];
	$(".chks-regs:checked").each(function() {
		list_ids.push($(this).data('iddel'));
	});
	var ids = list_ids.join(",");
	$.ajax({
		type: 		"POST",
		url: 		base_url+"pcheckbox/delReg",
		data: {
			list_ids: ids,
		},
		dataType: 	"json",
		beforeSend: function(objeto){
			$("#btn-del-regs").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Eliminando');
		},
		success: function(datos){
			$("#btn-del-regs").html('<i class="fa fa-trash-alt"></i> Eliminar');
			$('#btn-del-regs').attr("disabled", false);
			$("#btn-close-mdl-del-regs").trigger("click");
			notify_msg(datos.icon, " ", datos.msg, "#", datos.tipo);
			$("#form-del-regs")[0].reset();
			load();
		},
		error: function(data) {
			$("#form-del-regs")[0].reset();
			$("#btn-del-regs").html('<i class="fa fa-trash-alt"></i> Eliminar');
			$("#div-cnt-del-regs").html('<div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-circle"></i> Error de comunicación con el servidor. Intenta más tarde.</div>');
		}
	});
	event.preventDefault();
});