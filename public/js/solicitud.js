$( window ).load(function(){
	setTimeout(function() {
		$('.mdl-layout__drawer-button i').empty();
		$('.mdl-layout__drawer-button i').removeClass('material-icons');
		$('.mdl-layout__drawer-button i').addClass('mdi mdi-menu');
	}, 250);
});
function registrar() {
	var Nombre 		= $('#Nombre').val();
	var email 		= $('#email').val();
	var idMayorista = $('#noMayorista').val();
	var canal 		= $('#canal').val();
	var numFactura  = $('#numFactura').val();
	var monto		= $('#monto').val();
	monto 			= monto.replace(",", "");
	var pais 		= $('#pais').val();
	var facturacion = $('#radioFacturacion').is(':checked');
	var cotizacion  = $('#radioCotizacion').is(':checked');
	var tipoDoc		= null;
	var puntos      = 0;
console.log(monto);
	factura = $('#archivo')[0].files[0];
	if(factura == undefined){
		msj('error', 'Seleccione una factura');
		return;
	}
	if($('#puntosWSEE').text() != " " || $('#puntosWSSE').text() != " ") {
		puntos += 50; 
	}
	if($('#puntosWSDE').text() != " " || $('#puntosCAL').text() != " ") {
		puntos += 100;
	}

	var noProducto1 = "Windows Server Essentials Edition";
	var cantidadWSEE= $('#cantidadWSEE').val();

	var noProducto2 = "Windows Server Standard Edition";
	var cantidadWSSE= $('#cantidadWSSE').val();

	var noProducto3 = "Windows Server Datacenter Edition";
	var cantidadWSDE= $('#cantidadWSDE').val();

	var noProducto4 = "CALs";
	var cantidadCAL = $('#cantidadCAL').val();
	
	var fecha		= $('#fecha').val();
	var newdate     = fecha.split("/").reverse().join("-");
	
	if(Nombre == '' && email == '' && noMayorista == '' && canal == '' && numFactura == '' && monto == '' && fecha == '' ){
		validarCampos();
	}
	if(Nombre == null || Nombre == ''){
		$('#Nombre').css('border-color','red');
		msj('error', 'Ingrese su nombre');
		return;
	}
	if(email == null || email == ''){
		msj('error', 'Ingrese su email');
		$('#email').css('border-color','red');
		return;
	}
	if (!validateEmail(email)){
		msj('error', 'El formato de email ingresado es incorrecto');
		$('#email').css('border-color','red');
		return;
	}else {
		$('#email').css('border-color','#C6C9CA');
	}
	if(noMayorista == null || noMayorista == ''){
		msj('error', 'seleccione el nombre del mayorista');
		$('#noMayorista').css('border-color','red');
		return;
	}
	if(canal == null || canal == ''){
		msj('error', 'Ingrese su canal');
		$('#canal').css('border-color','red');
		return;
	}
	if(numFactura == null || numFactura == ''){
		msj('error', 'Ingrese su número de Factura');
		$('#numFactura').css('border-color','red');
		return;
	}
	if(monto == null || monto == ''){
		msj('error', 'Ingrese el nombre del cliente');
		$('#cliente').css('border-color','red');
		return;
	}
	if(fecha == null || fecha == ''){
		msj('error', 'Ingrese la fecha de cierre');
		$('#fecha').css('border-color','red');
		return;
	}
	if(pais == null || pais == '') {
		msj('error', 'Ingrese un pais');
		$('#pais').css('border-color','red');
		return;		
	}
	if(facturacion == true){
		tipoDoc = 0;
	}
	if(cotizacion == true){
		tipoDoc = 1;
	}
	$.ajax({
		data  : { Nombre 	  : Nombre,
				  email 	  : email,
				  idMayorista : idMayorista,
				  fecha		  : newdate,
				  canal 	  : canal,
				  tipoDoc 	  : tipoDoc,
				  pais		  : pais,
				  numFactura  : numFactura,
				  monto		  : monto ,
				  noProducto1 : noProducto1,
				  noProducto2 : noProducto2 ,
				  noProducto3 : noProducto3,
				  noProducto4 : noProducto4 ,
				  cantidadWSEE: cantidadWSEE,
				  cantidadWSSE: cantidadWSSE ,
				  cantidadWSDE: cantidadWSDE,
				  cantidadCAL : cantidadCAL,
				  puntos 	  : puntos},
		url   : 'solicitud/registrar',
		type  : 'POST'
	}).done(function(data){
		try{
        	data = JSON.parse(data);
        	if(data.error == 0){
        		modal('ModalQuestion');
        		$('#bodyPuntaje').html(data.html);
        		$('#puntajeGeneral').html(data.puntosGeneral);
        		$('#bodyUltimaCotizacion').html(data.bodyCotizaciones);
        		$('#bodyCanales').html(data.bodyCanales);
        	} else { return; }
      } catch (err){
        msj('error',err.message);
      }
	});
}

function subirFactura(){
	$("#archivo").trigger("click");
}
$("#archivo").change(function(e) {
	var files = e.target.files,
	    filesLength = files.length;
	for (var i = 0; i < filesLength ; i++) {
		var f = files[i]
		var archivo = (f.name).replace(" ","");
		nombre = archivo;
	}
	$('#archivoDocumento').val(nombre);
});

function agregarDatos(){
var datos = new FormData();
  factura = $('#archivo')[0].files[0];
  if(factura == undefined){
    msj('error', 'Seleccione una factura');
    return;
  }
    datos.append('archivo',$('#archivo')[0].files[0]);
     $.ajax({
        type:"post",
        dataType:"json",
        url:"solicitud/cargarFact",
        contentType:false,
        data:datos,
        processData:false,
      }).done(function(respuesta){
      	if(data.error == 0) {
      		modal();
      		setTimeout(function() {
				modal('modalDetalles');
	    		$('#bodyPuntaje').html(data.html);
	    		$('#puntajeGeneral').html(data.puntosGeneral);
	    		$('#bodyUltimaCotizacion').html(data.bodyCotizaciones);
	    		$('#bodyCanales').html(data.bodyCanales);
			}, 250);
      		
      	} else {
        	msj('error', respuesta.mensaje);
      	}
        limpiarCampos();
        // setTimeout(function(){ location.href = 'Solicitud'; }, 1500);
    });
}

function limpiarCampos(){
	$('#Nombre').val(null);
	$('#email').val(null);
	$('#noMayorista').val(null);
	$('#canal').val(null);
	$('#numFactura').val(null);
	$('#monto').val(null);
	$('#pais').val(null);
	$('#cantidadWSEE').val(null);
	$('#cantidadWSSE').val(null);
	$('#cantidadWSDE').val(null);
	$('#cantidadCAL').val(null);
	$('#puntosWSEE').text('');
	$('#puntosWSSE').text('');
	$('#puntosWSDE').text('');
	$('#puntosCAL').text('');
	$('.selectpicker').selectpicker('refresh');
	$('#attach').val('0');
	$('.selectpicker').selectpicker('refresh');
	$('#fecha').val(null);
}

function soloLetras(e){
    key 	   = e.keyCode || e.which;
    tecla 	   = String.fromCharCode(key).toLowerCase();
    letras     = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = "8-37-39-46";
    tecla_especial = false
    for(var i in especiales){
        if(key == especiales[i]){
            tecla_especial = true;
            break;
        }
    }
    if(letras.indexOf(tecla)==-1 && !tecla_especial){
        return false;
    }
}
function valida(e){
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8){
        return true;
    }
    patron =/[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}
function validateEmail(email){
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function validarCampos(){
	var $inputs = $('form :input');
	var formvalido = true;
	$inputs.each(function() {
		if(isEmpty($(this).val())){
			$(this).css('border-color','red');
			$('.btn-default').css('border-color','#C6C9CA');
			$('#fecha').css('border-color','#C6C9CA');
			formvalido = false;
		}else{
			$(this).css('border-color','#C6C9CA');
			$('#fecha').css('border-color','#C6C9CA');
		}
	});
	return formvalido;
}
function isEmpty(val){
	if(jQuery.trim(val).length != 0)
    	return false;
		return true;
}

function calcularWSEE() {
	var WSEE = $('#cantidadWSEE').val();
	if(WSEE != '' && parseInt(WSEE)  > 0) {
 		$('#puntosWSEE').text('50');
	} else {
		$('#puntosWSEE').text('');
	}
}
function calcularWSSE() {
	var WSSE = $('#cantidadWSSE').val();
	if(WSSE != '' && parseInt(WSSE)  > 0) {
 		$('#puntosWSSE').text('50');
	} else {
		$('#puntosWSSE').text('');
	}
}
function calcularWSDE() {
	var WSDE = $('#cantidadWSDE').val();
	if(WSDE != '' && parseInt(WSDE)  > 0) {
 		$('#puntosWSDE').text('100');
	} else {
		$('#puntosWSDE').text('');
	}
}
function calcularCAL() {
	var CAL = $('#cantidadCAL').val();
	if(CAL != '' && parseInt(CAL) > 0) {
 		$('#puntosCAL').text('100');
	} else {
		$('#puntosCAL').text('');
	}
}
function goToMenu(id){
	var idLink    = $('#'+id);
	var idSection = $('#section-'+id)
	$('.mdl-navigation__link').removeClass('active');
	$('.js-section--menu').addClass('animated fadeOut');
	idSection.removeClass('animated fadeOut');
	idSection.addClass('animated fadeIn');
	idLink.addClass('active');
}
function cerrarSesion(){
	$.ajax({
		url  : 'Login/cerrarCesion',
		type : 'POST'
	}).done(function(data){
		try{
        data = JSON.parse(data);
        if(data.error == 0){
        	location.href = 'Login';
        }else {
        	return;
        }
      }catch(err){
        msj('error',err.message);
      }
	});
}