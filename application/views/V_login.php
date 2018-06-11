<!DOCTYPE html>
<html lang="en">
    <head>
    	<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible"  content="IE=edge">
        <meta name="viewport"               content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
        <meta name="description"            content="Registro de Oportunidades DCN">
        <meta name="keywords"               content="Registro de Oportunidades DCN">
        <meta name="robots"                 content="Index,Follow">
        <meta name="date"                   content="Febrero 15, 2018"/>
        <meta name="language"               content="es">
        <meta name="theme-color"            content="#000000">
    	<title>HPE Microsoft</title>
    	<link rel="shortcut icon" href="<?php echo RUTA_IMG?>logo/favicon.ico">
    	<link rel="stylesheet"    href="<?php echo RUTA_PLUGINS?>toaster/toastr.min.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo RUTA_PLUGINS?>bootstrap-select/css/bootstrap-select.min.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo RUTA_PLUGINS?>bootstrap/css/bootstrap.min.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo RUTA_PLUGINS?>mdl/material.min.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo RUTA_FONTS?>font-awesome.min.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo RUTA_FONTS?>material-icons.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo RUTA_FONTS?>metric.css?v=<?php echo time();?>">
    	<link rel="stylesheet"    href="<?php echo RUTA_CSS?>m-p.min.css?v=<?php echo time();?>">
    	<!-- <link rel="stylesheet"    href="<?php echo RUTA_CSS?>index.css?v=<?php echo time();?>"> -->
        <link rel="stylesheet"    href="<?php echo RUTA_CSS?>style.css?v=<?php echo time();?>">
    </head>
    <body>
        <div class="js-header js-header--login">
            <div class="js-header--left">
                <img class="js-partner" src="<?php echo RUTA_IMG?>logo/hpe-logo.svg">
                <img src="<?php echo RUTA_IMG?>logo/microsoft-logo.png">
            </div>
            <div class="js-header--right">
                <p>Registro de Oportunidades Centroam&eacute;rica</p>
            </div>
        </div>
        <section class="js-section js-height">
            <div class="js-fondo--login"></div>
            <div class="js-container js-flex">
                <div class="js-login">
                    <h2>Acceso a la Herramienta</h2>
                    <div class="col-xs-12 js-input m-0">
                        <label for="usuario">Usuario</label>
                        <input type="text" id="usuario" onkeyup="verificarDatos(event);">
                    </div>
                    <div class="col-xs-12 js-input m-0">
                        <label for="password">Contrase&ntilde;a</label>
                        <input type="password" id="password" onkeyup="verificarDatos(event);">
                    </div>
                    <div class="col-xs-12 p-0">
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect js-button js-button--login" onclick="ingresar()">Login</button>
                    </div>
                    <div class="col-xs-12 js-middle">
                        <div class="js-middle--left">
                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="remember">
                                <input type="checkbox" id="remember" class="mdl-checkbox__input">
                                <span class="mdl-checkbox__label">Remember me</span>
                            </label>
                        </div>
                        <div class="js-middle--right">
                            <a onclick="openModalRecuperar()">¿Olvidaste tu contrase&ntilde;a?</a>
                        </div>
                    </div>
                    <!-- <div class="col-xs-12 mdl-card__actions text-left" onclick="openModalCambiar()">
                        <span>Cambiar contraseña</span>
                    </div>
                    <div class="col-xs-12 mdl-card__actions text-left" onclick="openModalCrear()">
                        <span >Registrarse</span>
                    </div> -->
                </div>
            </div>
        </section>

        <!-- MODAL RECUPERAR CONTRASEÑA -->
        <div class="modal fade" id="recuperaContrasena" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="mdl-card">
                        <div class="mdl-card__title">
                            <h2>Recuperar Contrase&ntilde;a</h2>
                            <p>Comp&aacute;rtenos tu correo y en breve te enviaremos un correo con tu contrase&ntilde;a</p>
                        </div>
                        <div class="mdl-card__supporting-text">
                            <div class="col-xs-12 js-input">
                                <label for="usuarioRecupera">Usuario</label>
                                <input type="text" id="usuarioRecupera" onkeyup="verificarDatos(event);">
                            </div>
                        </div> 
                        <div class="mdl-card__actions text-right">
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect js-button js-button--default" data-dismiss="modal">Cancelar</button>
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect js-button" onclick="recuperar()" >Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!--MODAL CAMBIO CONTRASEÑA -->
        <div class="modal fade" id="cambioContrasena" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm text-center">
                <div class="modal-content">
                    <div class="mdl-card">
                        <div class="mdl-card__supporting-text">
                            <h2>CAMBIAR CONTRASE&Ntilde;A</h2>
                            <div class="col-xs-12 form-group js-input">
                                <label for="usuario">Usuario</label>
                                <input type="text" id="usuarioCambio" onkeyup="verificarDatos(event);">
                            </div>
                            <div class="col-xs-12 form-group js-input">
                                <label for="password">Nueva contrase&ntilde;a</label>
                                <input type="password" id="newPassword" onkeyup="verificarDatos(event);">
                            </div>
                            <div class="col-xs-12 form-group js-input">
                                <label for="confirmPassword">Confirmar contrase&ntilde;a</label>
                                <input type="confirmPassword" id="confirmPassword" onkeyup="verificarDatos(event);">
                            </div>
                        </div> 
                        <div class="mdl-card__actions">
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" data-dismiss="modal">Cancelar</button>
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="cambiar()">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--MODAL REGISTRAR NUEVO USUARIO -->
        <div class="modal fade" id="registroUsuario" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md text-center">
                <div class="modal-content">
                    <div class="mdl-card">
                        <div class="mdl-card__supporting-text">
                            <h2>REGISTRAR USUARIO</h2>
                            <div class="form-group col-xs-12 p-0">
                                <input type="text" class="form-control" id="nombre" placeholder="Nombre" onchange="validarCampos()">
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <input type="text" class="form-control" id="apellidos" placeholder="Apellidos" onchange="validarCampos()">
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <input type="text" class="form-control" id="canal" placeholder="Canal" onchange="validarCampos()">
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <input type="text" class="form-control" id="pais" placeholder="Pais" onchange="validarCampos()">
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <input type="email" class="form-control" id="email" placeholder="Email" onchange="validarCampos()">
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <input type="text" class="form-control" id="movil" placeholder="M&oacute;vil" onchange="validarCampos()">
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <input type="password" class="form-control" id="pass" placeholder="Contrase&ntilde;a" onchange="validarCampos()">
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <input type="password" class="form-control" id="passRep" placeholder="Repetir contrase&ntilde;" onchange="validarCampos()">
                            </div>
                        </div> 
                        <div class="mdl-card__actions">
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" data-dismiss="modal">Cancelar</button>
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="registrar()">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <section class>
            <div class="header">
                <div class="mdl-container row">
                    <div class="col-xs-12">
                        <div class="col-xs-6 text-left p-0">
                            <img src="<?php echo RUTA_IMG?>logo/logo_header.png">
                        </div>
                        <div class="col-xs-6 text-right p-0">
                            <p>Registro de oportunidades HPE</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="center-login">
                <div class="mdl-card mdl-card-login">
                    <div class="mdl-card__supporting-text">
                        <div class="col-xs-12 form-group mdl-input">
                            <label for="usuario">Username</label>
                            <input type="text" id="usuario" placeholder="" onkeyup="verificarDatos(event);">
                        </div>
                        <div class="col-xs-12 form-group mdl-input">
                            <label for="password">Password</label>
                            <input type="password" id="password" onkeyup="verificarDatos(event);">
                        </div>
                        <div class="col-xs-12 mdl-label">
                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="remember">
                                <input type="checkbox" id="remember" class="mdl-checkbox__input">
                                <span class="mdl-checkbox__label">Remember me</span>
                            </label>
                        </div>
                    </div>
                    <div class="mdl-card__actions p-0">
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="ingresar()">Login</button>
                    </div>
                    <div class="col-xs-12 mdl-create">
                        <div class="col-xs-6">
                            <a href="">Forgot password</a>
                        </div>
                        <div class="col-xs-6">
                            <a href="Registro">Create an account</a>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <script src="<?php echo RUTA_JS?>jquery-3.2.1.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_JS?>jquery-1.11.2.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_PLUGINS?>bootstrap/js/bootstrap.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_PLUGINS?>bootstrap-select/js/bootstrap-select.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_PLUGINS?>bootstrap-select/js/i18n/defaults-es_ES.min.js?v=<?php echo time();?>"></script> 
        <script src="<?php echo RUTA_PLUGINS?>mdl/material.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_PLUGINS?>toaster/toastr.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_JS?>Utils.js?v=<?php echo time();?>"></script>
        <script src="<?php echo RUTA_JS?>login.js?v=<?php echo time();?>"></script>
        <script type="text/javascript">
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
                $('select').selectpicker('mobile');
            } else {
                $('select').selectpicker();
            }
            $(document).ready(function(){
            let CHECK = sessionStorage.getItem('CHECK');
            let USERNAME = sessionStorage.getItem('USERNAME');
            let PASS = sessionStorage.getItem('PASS');
           if(CHECK == 1) {
                $('#remember').prop('checked', true);
                $('#usuario').val(USERNAME);
                $('#password').val(PASS);
           }else {
                $('#remember').prop('checked', false);
                $('#usuario').val('');
                $('#password').val('');
           }
        });
        </script>
    </body>
</html>