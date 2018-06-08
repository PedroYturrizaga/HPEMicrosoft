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
    if (!validateEmail(usuario)){
        msj('error', 'El formato de usuario ingresado es incorrecto');
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
            console.log(data.pass);
            if(data.error == 0){
            	$('#usuario').val("");
            	$('#password').val("");
                if(data.rol == 1) {
                    location.href = 'Solicitud';
                } else if(data.rol == 0) {
                    location.href = 'Champion';
                }
            }else {
                if(data.pass == null || data.pass == '') {
                    msj('error', 'alguno de sus datos son incorrectos');
                }else {
                    toastr.clear();
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

function openModalRecuperar() {
    modal('recuperaContrasena');
}

function openModalCambiar() {
    modal('cambioContrasena');
}

function openModalCrear() {
    modal('registroUsuario');
}

function recuperar() {
    var user = $('#usuarioRecupera').val();
    if (!validateEmail(user)){
        msj('error', 'El formato de usuario ingresado es incorrecto');
        return;
    }
    $.ajax({
        data : { user : user },
        url  : 'Login/sendGmail',
        type : 'POST'
    })
    .done(function(data) {
        data = JSON.parse(data);
        console.log(data);
        try {
            if(data.error == 0) {
                abrirCerrarModal('recuperaContrasena');
            } else { 
                toastr.clear();
                msj('error',data.msj);
                return; 
            }
        } catch (err){
            msj('error', err.message);
        }
    });
}

// POR CONFIRMAR SI SE USARÁ

// function cambiar() {
//     $.ajax({
//         data : {},
//         url  : '',
//         type : 'POST'
//     })
//     .done(function(data) {
//         data = JSON.parse(data);
//         try {
//             if(data.error == 0) {
//                 abrirCerrarModal('recuperaContrasena');
//             }
//         } catch (err){
//             msj('error', err.message);
//         }
//     });
// }

// function registrar() {
//     var nombre    = $('#nombre').val();
//     var apellidos = $('#apellidos').val();
//     var canal     = $('#canal').val();
//     var pais      = $('#pais').val();
//     var email     = $('#email').val();
//     var movil     = $('#movil').val();
//     var pass      = $('#pass').val();
//     var passRep   = $('#passRep').val();
//     if(nombre == '' || nombre == null) {
//         msj('error', 'Ingrese su nombre');
//         $('#nombre').css('border-color','red');
//         return;
//     }
//     if(apellidos == '' || apellidos == null) {
//         msj('error', 'Ingrese sus apellidos');
//         $('#apellidos').css('border-color','red');
//         return;
//     }
//     if(canal == '' || canal == null) {
//         msj('error', 'Ingrese su canal');
//         $('#canal').css('border-color','red');
//         return;
//     }
//     if(pais == '' || pais == null) {
//         msj('error', 'Ingrese su pais');
//         $('#pais').css('border-color','red');
//         return;
//     }
//     if(email == '' || email == null) {
//         msj('error', 'Ingrese su email');
//         $('#email').css('border-color','red');
//         return;
//     }
//     if(movil == '' || movil == null) {
//         msj('error', 'Ingrese su movil');
//         $('#movil').css('border-color','red');
//         return;
//     }
//     if(pass == '' || pass == null) {
//         msj('error', 'Ingrese su contraseña');
//         $('#pass').css('border-color','red');
//         return;
//     }
//     if(passRep == '' || passRep == null) {
//         msj('error', 'Ingrese la confimacion de contraseña');
//         $('#passRep').css('border-color','red');
//         return;
//     }
//     if(pass != passRep) {
//         msj('error', 'Las contraseñas no coinciden');
//         return;
//     }
//     $.ajax({
//         data : { nombre    : nombre,
//                  apellidos : apellidos,
//                  canal     : canal,
//                  pais      : pais,
//                  email     : email,
//                  movil     : movil,
//                  pass      : pass },
//         url  : 'login/registrarUsuario',
//         type : 'POST'
//     })
//     .done(function(data) {
//         data = JSON.parse(data);
//         console.log(data);
//         try {
//             if(data.error == 0) {
//                 abrirCerrarModal('recuperaContrasena');
//             } else { 
//                 toastr.clear();
//                 msj('error',data.msj);
//                 return; 
//             }
//         } catch (err){
//             msj('error', err.message);
//         }
//     });
// }
