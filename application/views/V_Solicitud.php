<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"  content="IE=edge">
    <meta name="viewport"               content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="description"            content="Registro de Cotizaciones HPE">
    <meta name="keywords"               content="Registro de Cotizaciones HPE">
    <meta name="robots"                 content="Index,Follow">
    <meta name="date"                   content="June 1, 2018"/>
    <meta name="language"               content="es">
    <meta name="theme-color"            content="#000000">
    <title>Registro de Cotizaciones HPE</title>
    <link rel="shortcut icon" href="<?php echo RUTA_IMG?>favicon.png">
    <link rel="stylesheet"    href="<?php echo RUTA_PLUGINS?>toaster/toastr.min.css?v=<?php echo time();?>">
    <link rel="stylesheet"    href="<?php echo RUTA_PLUGINS?>bootstrap-select/css/bootstrap-select.min.css?v=<?php echo time();?>">
    <link rel="stylesheet"    href="<?php echo RUTA_PLUGINS?>bootstrap/bootstrap.min.css?v=<?php echo time();?>">
    <link rel="stylesheet"    href="<?php echo RUTA_PLUGINS?>mdl/material.min.css?v=<?php echo time();?>">
    <link rel="stylesheet"    href="<?php echo RUTA_PLUGINS?>datetimepicker/css/bootstrap-material-datetimepicker.css?v=<?php echo time();?>">
    <link rel="stylesheet"    href="<?php echo RUTA_FONTS?>font-awesome.min.css?v=<?php echo time();?>">
    <link rel="stylesheet"    href="<?php echo RUTA_FONTS?>material-icons.css?v=<?php echo time();?>">
    <link rel="stylesheet"    href="<?php echo RUTA_FONTS?>metric.css?v=<?php echo time();?>">
    <link rel="stylesheet"    href="<?php echo RUTA_CSS?>m-p.min.css?v=<?php echo time();?>">
    <link rel="stylesheet"    href="<?php echo RUTA_CSS?>index.css?v=<?php echo time();?>">
    <link rel="stylesheet"    href="<?php echo RUTA_CSS?>style.css?v=<?php echo time();?>">
</head>
<body>
    <div class="js-header js-relative">
        <div class="js-header--left">
            <img src="<?php echo RUTA_IMG?>logo/hpe-logo.png">
            <img src="<?php echo RUTA_IMG?>logo/microsoft-logo.png">
        </div>
        <div class="js-header--right">
            <p>Registro de Oportunidades Centroam&eacute;rica</p>
        </div>
    </div>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer">
        <div class="mdl-layout__drawer">
            <span class="mdl-layout-title">Title</span>
            <nav class="mdl-navigation">
                <a class="mdl-navigation__link" href="">Ingresar una nueva cotizaci&oacute;n</a>
                <a class="mdl-navigation__link" href="">Ver puntaje acumulado</a>
                <a class="mdl-navigation__link" href="">T&eacute;rminos y Condiciones</a>
                <a class="mdl-navigation__link" href="">Escribir al Champion</a>
            </nav>
        </div>
        <main class="mdl-layout__content">
            <section class="section">
                <div class="js-container">
                    <!-- INGRESO DE NUEVA SOLICITUD -->
                    <div class="col-sm-12 col-xs-12" id="solicitud">
                        <div class="col-sm-6 col-xs-12"> 
                            <h2 class="title-formulario">Nuevo ingreso</h2>
                            <div class="form-group col-xs-12 p-0">
                                <!-- <label for="apellido">Nombre</label> -->
                                <input type="text" class="form-control" id="Nombre" placeholder="Nombre del vendedor" onchange="validarCampos()">
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <!-- <label for="email">Email</label> -->
                                <input type="email" class="form-control" id="email" placeholder="Email" onchange="validarCampos()">
                            </div>
                            <!-- Simple Select -->
                            <div class="form-group col-xs-12 p-0">
                                <select name="noMayorista" id="noMayorista"> 
                                    <?php echo $option ?>
                                </select>
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <!-- <label for="correo">Confirmar email</label> -->
                                <input type="text" class="form-control" id="canal" placeholder="Canal al que cotiza" onchange="validarCampos()">
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <!-- <label for="correo">Confirmar email</label> -->
                                <input type="text" class="form-control" id="pais" placeholder="Pais" onchange="validarCampos()">
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <!-- <label for="correo">Confirmar email</label> -->
                                <label> Tipo Documento:</label>
                                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="radioCotizacion">
                                    <input type="radio" id="radioCotizacion" class="mdl-radio__button" name="option1" value="1" onchange="validarCampos()">
                                    <span class="mdl-radio__label">Cotizaci&oacute;n</span>
                                </label>
                                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="radioFacturacion">
                                    <input type="radio" id="radioFacturacion" class="mdl-radio__button" name="option1" value="0" onchange="validarCampos()">
                                    <span class="mdl-radio__label">Factura</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group col-xs-12 p-0">
                            <input type="text" class="form-control" id="numFactura" placeholder="# Factura" onchange="validarCampos()">
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <div class="form-group">
                                    <div class="mdl-input">
                                        <div class="mdl-icon">
                                            <button type="button" class="mdl-button mdl-js-button mdl-button--icon">
                                                <i class="mdi mdi-date_range"></i>
                                            </button>
                                        </div>
                                        <input class="form-control" type="text" id="fecha" name="fecha" maxlength="10" placeholder="dd/mm/aaaa" value="" style="pointer-events: none">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <!-- <label for="rol">Rol</label> -->
                                <input type="text" class="form-control" id="monto" placeholder="Monto" onchange="validarCampos()">
                            </div>
                            <h2 class="title-formulario">Productos</h2>
                            <table id="tbProductos" >
                                <thead>
                                    <tr>
                                        <th>Licencia Microsoft</th>
                                        <th>Unidades</th>
                                        <th>Puntos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="product1">Windows Server Essentials Edition</td>
                                        <td><input type="text" id="cantidadWSEE" name="cantidadWSEE" onchange="calcularWSEE()" /></td>
                                        <td> <span id="puntosWSEE"> </span> </td>
                                    </tr>
                                    <tr>
                                        <td id="product2">Windows Server Standard Edition</td>
                                        <td><input type="text" id="cantidadWSSE" name="cantidadWSSE" onchange="calcularWSSE()"/></td>
                                        <td> <span id="puntosWSSE"> </span> </td>
                                    </tr>
                                    <tr>
                                        <td id="product3">Windows Server Datacenter Edition</td>
                                        <td><input type="text" id="cantidadWSDE" name="cantidadWSDE" onchange="calcularWSDE()"/></td>
                                        <td> <span id="puntosWSDE"> </span> </td>
                                    </tr>
                                    <tr>
                                        <td id="product4">CALs</td>
                                        <td><input type="text" id="cantidadCAL" name="cantidadCAL" onchange="calcularCAL()"/></td>
                                        <td> <span id="puntosCAL"> </span> </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mdl-register col-xs-12 p-0">
                                <button type="button" name="boton" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="registrar()">Registrar Oportunidad</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <!-- <section id="principal">
        <div class="container">
            <div class="row">
                <div class="formulario col-sm-12 col-xs-12 m-t-20">
                    <div class="col-sm-12 col-xs-12" id="puntaje">
                        <h2 class="title-formulario">&Uacute;ltimos 4 ingresos del trimestre</h2>
                        <div class="col-sm-8 col-xs-12">
                            <table id="tbUltimosIngresos" >
                                <thead>
                                    <tr> 
                                        <th class="col-spam-3 col-sm-2 "> <strong>Puntaje</strong> </th>
                                    </tr>
                                    <tr>
                                        <th>Pais</th>
                                        <th>Documento</th>
                                        <th>Fecha</th>
                                        <th>Cotizado</th>
                                        <th>Cerrado</th>
                                        <th>Total</th>
                                    </tr>
                                </thead >
                                <tbody id="body">
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <h2 class="title-formulario">Puntos Engage & Grow acumulados</h2>
                            <h4 id="puntosTrimestral"> </h4>
                        </div>
                    </div>
                    TERMINOS Y CONDICIONES
                    <div class="col-sm-12 col-xs-12" id="condiciones">
                        <div class="col-sm-12 col-xs-12">
                            <h2 class="title-formulario">T&eacute;rminos y condiciones generales</h2>
                            <label> Premios: </label>
                            <p> - <strong> Licencias Standard:</strong> </p>
                            <p> · 50 puntos ENGAGE & GROW por cada cotizaci&oacute;n +200 puntos adicionales por cierre de la oportunidad al mayorista.</p>
                            <p> · El reseller gana otros 250 puntos por venta cerrada.</p>
                            <br>
                            <p> - <strong> Licencias de DataCenter:</strong> </p>
                            <p> · 100 puntos ENGAGE & GROW por cada cotizaci&oacute;n +300 puntos adicionales por cierre de la oportunidad al mayorista.</p>
                            <p> · El reseller gana otros 400 puntos por venta cerrada.</p>
                            <br>
                            <label> T&eacute;rminos y condiciones: </label>
                            <p>-Solo se puede hacer 4 cotizaciones por reseller por trimestre.</p>
                            <p>-Las ventas valen a&uacute;n cuando no hayan sido cotizadas.</p>
                            <p>-Las cotizaciones valen a&uacute;n cuando no se cierre la venta.</p>
                            <p>-Cantidad l&iacute;mite de puntos disponibles para esta campaña: 40 000 puntos.</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section> -->
    <!--MODAL-->
    <div class="modal fade" id="ModalQuestion" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm text-center">
            <div class="modal-content">
                <div class="mdl-card">
                    <div class="mdl-card__supporting-text">
                        <h2>PERFECTO&#33;</h2>
                        <h2>Tu registro ha sido enviado satisfactoriamente.</h2>
                        <p>Nos pondremos en contacto contigo a la brevedad</p>
                        <small>Equipo HPE Latinoamerica</small>
                    </div> 
                    <div class="mdl-card__actions">                         
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script src="<?php echo RUTA_JS?>jquery-3.2.1.min.js?v=<?php echo time();?>"></script>
	<script src="<?php echo RUTA_JS?>jquery-1.11.2.min.js?v=<?php echo time();?>"></script>
	<script src="<?php echo RUTA_PLUGINS?>bootstrap/bootstrap.min.js?v=<?php echo time();?>"></script>
	<script src="<?php echo RUTA_PLUGINS?>bootstrap-select/js/bootstrap-select.min.js?v=<?php echo time();?>"></script>
	<script src="<?php echo RUTA_PLUGINS?>bootstrap-select/js/i18n/defaults-es_ES.min.js?v=<?php echo time();?>"></script>
	<script src="<?php echo RUTA_PLUGINS?>mdl/material.min.js?v=<?php echo time();?>"></script>
    <script src="<?php echo RUTA_PLUGINS?>moment/moment.min.js?v=<?php echo time();?>"></script>
    <script src="<?php echo RUTA_PLUGINS?>datetimepicker/js/bootstrap-material-datetimepicker.js?v=<?php echo time();?>"></script>
    <script src="<?php echo RUTA_PLUGINS?>jquery-mask/jquery.mask.min.js?v=<?php echo time();?>"></script>
    <script src="<?php echo RUTA_PLUGINS?>toaster/toastr.js?v=<?php echo time();?>"></script>
    <script src="<?php echo RUTA_JS?>Utils.js?v=<?php echo time();?>"></script>
    <script src="<?php echo RUTA_JS?>jsmenu.js?v=<?php echo time();?>"></script>
    <script src="<?php echo RUTA_JS?>solicitud.js?v=<?php echo time();?>"></script>
    <script type="text/javascript">
    	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
        	$('select').selectpicker('mobile');
        } else {
            $('select').selectpicker();
        }
        initButtonCalendarDaysRange('fecha','01/11/2017','31/10/2018');
        initMaskInputs('fecha');
    </script>
</body>