function ingresar(){
	var usuario  = $('#usuario').val();
	var password = $('#password').val();
  if($('#remember').is(':checked') == true){
    sessionStorage.setItem('CHECK', '1');
    sessionStorage.setItem('USERNAME', usuario);
    sessionStorage.setItem('PASS', password);
  }else{
    sessionStorage.setItem('CHECK', '0');
  }
	if(usuario == null || usuario == ''){
    msj('error', 'Ingrese su usuario');
    return;
  }
	if(password == null || password == ''){
    msj('error', 'Ingrese su contraseña');
		return;
	}
	$.ajax({
		data : {usuario  : usuario,
				    password : password},
		url  : 'Login/ingresar',
		type : 'POST'
	}).done(function(data){
		try{
        data = JSON.parse(data);
        if(data.error == 0){
        	$('#usuario').val("");
        	$('#password').val("");
          console.log(data);
          if(data.rol == 1) {
            location.href = 'Solicitud';
          } else if(data.rol == 0) {
            location.href = 'Champion';
          }
        }else {
          if(data.pass == null || data.pass == '') {
            msj('error', 'alguno de sus datos son incorrectos');
          }else {
            msj('error', data.pass);
          }
        	return;
        }
      }catch(err){
        msj('error',err.message);
      }
	});
}
$("#showpass").click(function(){
	$(this).find('i').toggleClass("mdi-remove_red_eye mdi-visibility_off");
    var input = $(this).parent().find('.mdl-textfield__input');
    if (input.attr("type") == "password"){
    	input.attr("type", "text");
    }else{
      input.attr("type", "password");
    }
});
function soloLetras(e){
    key 	     = e.keyCode || e.which;
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
    patron      =/[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}
function validateEmail(email){
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function verificarDatos(e){
	if(e.keyCode === 13){
		e.preventDefault();
		ingresar();
    }
}
function cerrarCesion(){
  $.ajax({
    url  : 'login/cerrarCesion',
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