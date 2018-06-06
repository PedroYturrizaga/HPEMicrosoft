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
    <link rel="stylesheet"    href="<?php echo RUTA_FONTS?>roboto.css?v=<?php echo time();?>">
    <link rel="stylesheet"    href="<?php echo RUTA_CSS?>m-p.min.css?v=<?php echo time();?>">
    <link rel="stylesheet"    href="<?php echo RUTA_CSS?>index.css?v=<?php echo time();?>">
</head>
<body>
    <section id="principal">
        <div class="container">
            <div class="row">
                <div class="header">
                    <div class="header-imagen inline">
                        <img src="<?php echo RUTA_IMG?>logo.png">
                    </div>
                    <div class="header-contenido inline">
                        <p>Registro de Oportunidades Centroam&eacute;rica</p>
                    </div>
                </div>
                
                <div class="formulario col-sm-12 col-xs-12 m-t-20">
					<!-- GRAFICOS -->
					<div class="col-sm-4 col-xs-12"> 
                        <div id="donutchart" style="width: 250px; height: 100px;"></div>
                        <div id="donut_single" style="width: 250px; height: 100px;"></div>
					</div>
                    <!-- TOP CANALES CON MAS IMPORTE -->
                    <div class="col-sm-8 col-xs-12">
                        <div class="col-sm-12 col-xs-12"> 
                            <h3>Top 3 canales en importes facturados</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nombre canal</th>
                                        <th>Nombre vendedor</th>
                                        <th>Pais</th>
                                        <th>Importe</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyCanales">
                                    <?php echo $bodyCanales?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col-sm-8 col-xs-12">
                        	<h3>&Uacute;ltimas 10 cotizaciones </h3>
                            <table id="tbProductos" >
                                <thead>
                                    <tr>
                                        <th>Nombre canal</th>
                                        <th>Nombre vendedor</th>
                                        <th>Pais</th>
                                        <th>Fecha</th>
                                        <th>Ver m&aacute;s</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyUltimaCotizacion">
                                    <?php echo $bodyCotizaciones?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--MODAL-->
    <div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg text-center">
            <div class="modal-content">
                <div class="mdl-card">
                    <div class="mdl-card__supporting-text">
                        <div class="col-sm-6 col-xs-12"> 
                            <h2 class="title-formulario">Detalles del ingreso</h2>
                            <div class="form-group col-xs-12 p-0">
                                <input type="text" class="form-control" id="Nombre" placeholder="Nombre del vendedor" onchange="validarCampos()" disabled>
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <input type="email" class="form-control" id="email" placeholder="Email" onchange="validarCampos()" disabled>
                            </div>

                            <!-- Simple Select -->
                            <div class="form-group col-xs-12 p-0">
                                <select name="noMayorista" id="noMayorista" disabled> 
                                    <?php echo $option ?>
                                </select>
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <input type="text" class="form-control" id="canal" placeholder="Canal al que cotiza" onchange="validarCampos()" disabled>
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <input type="text" class="form-control" id="pais" placeholder="Pais" onchange="validarCampos()" disabled>
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <label> Tipo Documento:</label>
                                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="radioCotizacion">
                                    <input type="radio" id="radioCotizacion" class="mdl-radio__button" name="option1" value="1" onchange="validarCampos()" disabled>
                                    <span class="mdl-radio__label">Cotizaci&oacute;n</span>
                                </label>
                                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="radioFacturacion">
                                    <input type="radio" id="radioFacturacion" class="mdl-radio__button" name="option1" value="0" onchange="validarCampos()" disabled>
                                    <span class="mdl-radio__label">Factura</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group col-xs-12 p-0">
                            <input type="text" class="form-control" id="numFactura" placeholder="# Factura" onchange="validarCampos()" disabled>
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <div class="form-group">
                                    <div class="mdl-input">
                                        <div class="mdl-icon">
                                            <button type="button" class="mdl-button mdl-js-button mdl-button--icon" disabled>
                                                <i class="mdi mdi-date_range"></i>
                                            </button>
                                        </div>
                                        <input class="form-control" type="text" id="fecha" name="fecha" maxlength="10" placeholder="dd/mm/aaaa" value="" style="pointer-events: none" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-xs-12 p-0">
                                <!-- <label for="rol">Rol</label> -->
                                <input type="text" class="form-control" id="monto" placeholder="Monto" onchange="validarCampos()" disabled>
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
                                        <td><input type="text" id="cantidadWSEE" name="cantidadWSEE" onchange="calcularWSEE()" disabled/></td>
                                        <td> <span id="puntosWSEE"> </span> </td>
                                    </tr>
                                    <tr>
                                        <td id="product2">Windows Server Standard Edition</td>
                                        <td><input type="text" id="cantidadWSSE" name="cantidadWSSE" onchange="calcularWSSE()" disabled/></td>
                                        <td> <span id="puntosWSSE"> </span> </td>
                                    </tr>
                                    <tr>
                                        <td id="product3">Windows Server Datacenter Edition</td>
                                        <td><input type="text" id="cantidadWSDE" name="cantidadWSDE" onchange="calcularWSDE()" disabled/></td>
                                        <td> <span id="puntosWSDE"> </span> </td>
                                    </tr>
                                    <tr>
                                        <td id="product4">CALs</td>
                                        <td><input type="text" id="cantidadCAL" name="cantidadCAL" onchange="calcularCAL()" disabled/></td>
                                        <td> <span id="puntosCAL"> </span> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
    <script src="<?php echo RUTA_JS?>champion.js?v=<?php echo time();?>"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
        	$('select').selectpicker('mobile');
        } else {
            $('select').selectpicker();
        }
        initButtonCalendarDaysRange('fecha','01/11/2017','31/10/2018');
        initMaskInputs('fecha');
        $(document).ready(function(){
            // $('#modalDetalles').modal('show');
        })
    </script>

    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChartDonut);
    </script>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
    </script>

</body>