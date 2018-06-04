function registrar() {
	var Nombre 		= $('#Nombre').val();
	var email 		= $('#email').val();
	var noMayorista = $('#noMayorista').val();
	var canal 		= $('#canal').val();
	var numFactura  = $('#numFactura').val();
	var monto		= $('#monto').val();

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
		msj('error', 'Ingrese el nombre del mayorista');
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
	$.ajax({
		data  : { Nombre 	  : Nombre,
				  email 	  : email,
				  noMayorista : noMayorista,
				  fecha		  : newdate,
				  canal 	  : canal,
				  numFactura  : numFactura,
				  monto		  : monto ,
				  noProducto1 : noProducto1,
				  noProducto2 : noProducto2 ,
				  noProducto3 : noProducto3,
				  noProducto4 : noProducto4 ,
				  cantidadWSEE: cantidadWSEE,
				  cantidadWSSE: cantidadWSSE ,
				  cantidadWSDE: cantidadWSDE,
				  cantidadCAL : cantidadCAL },
		url   : 'c_solicitud/registrar',
		type  : 'POST'
	}).done(function(data){
		try{
        	data = JSON.parse(data);
        	if(data.error == 0){
        		modal('ModalQuestion');
				limpiarCampos();
        	}else {return;}
      } catch (err){
        msj('error',err.message);
      }
	});
}

function limpiarCampos(){
	$('#Nombre').val(null);
	$('#apellido').val(null);
	$('#email').val(null);
	$('#correo').val(null);
	$('#rol').val(null);
	$('#canal').val(null);
	$('#oportunidad').val(null);
	$('#cliente').val(null);
	$('#productos').val('0');
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
