function getDetails(cotizacion) {
	var cotizacion = cotizacion;
	limpiarCampos();
	$.ajax({
		data  : { cotizacion : cotizacion },
		url   : 'champion/getDetalles',
		type : 'POST'
	}).done(function(data){
		try{
        	data = JSON.parse(data);
        	if(data.error == 0){
        		$('#Nombre').val(data.detalles[0]['no_vendedor']);
        		$('#email').val(data.detalles[0]['email']);
				$('#noMayorista').html(data.option);
				$('#noMayorista').selectpicker('render');
        		$('#canal').val(data.detalles[0]['canal']);
        		$('#pais').val(data.detalles[0]['pais']);
        		$('#numFactura').val(data.detalles[0]['nu_cotizacion']);
        		$('#fecha').val(data.detalles[0]['fecha']);
        		$('#monto').val(data.detalles[0]['monto']);
        		(data.detalles[0]['tipo_documento'] == 0) ? $('#facturacion').addClass('is-checked') : $('#cotizacion').addClass('is-checked');
        		for (var i = 0; i < data.detalles.length; i++) {
        			if(data.detalles[i]['no_producto'] == "Windows Server Essentials Edition") {
						$('#cantidadWSEE').val(data.detalles[i]['cantidad']);
        			} else if(data.detalles[i]['no_producto'] == "Windows Server Standard Edition") {
						$('#cantidadWSSE').val(data.detalles[i]['cantidad']);
        			} else if(data.detalles[i]['no_producto'] == "Windows Server Datacenter Edition") {
						$('#cantidadWSDE').val(data.detalles[i]['cantidad']);
        			} else if (data.detalles[i]['no_producto'] == "CALs") {
        				$('#cantidadCAL').val(data.detalles[i]['cantidad']);
        			}
        		}
        		$('#Nombre').prop('disabled', true);
				$('#email').prop('disabled', true);
				$('#noMayorista').prop('disabled', true);
				$('#canal').prop('disabled', true);
				$('#pais').prop('disabled', true);
				$('#facturacion').prop('disabled', true);
				$('#cotizacion').prop('disabled', true);
				$('#numFactura').prop('disabled', true);
				$('#fecha').prop('disabled', true);
				$('#monto').prop('disabled', true);
				$('#cantidadWSEE').prop('disabled', true);
				$('#cantidadWSSE').prop('disabled', true);
				$('#cantidadWSDE').prop('disabled', true);
				$('#cantidadCAL').prop('disabled', true);
				$('#aceptar').css('display', 'block');
				$('#registrar').css('display', 'none');
				$('#cancelar').css('display', 'none');
				$('#puntosWSEE').css('display','none');
				$('#puntosWSSE').css('display','none');
				$('#puntosWSDE').css('display','none');
				$('#puntosCAL').css('display','none');

        		modal('modalDetalles');
        	} else { return; }
      } catch (err){
        msj('error',err.message);
      }
	});
}

function openModal(){
	limpiarCampos();
	$.ajax({
		data : { },
		url  : 'champion/comboMayoristas',
		type : 'POST'
	}).done(function(data){
		data = JSON.parse(data);
		if(data.error == 0 ){
    		$('#Nombre').prop('disabled', false);
			$('#email').prop('disabled', false);
			$('#noMayorista').prop('disabled', false);
			$('#canal').prop('disabled', false);
			$('#pais').prop('disabled', false);
			$('#facturacion').prop('disabled', false);
			$('#cotizacion').prop('disabled', false);
			$('#numFactura').prop('disabled', false);
			$('#fecha').prop('disabled', false);
			$('#monto').prop('disabled', false);
			$('#cantidadWSEE').prop('disabled', false);
			$('#cantidadWSSE').prop('disabled', false);
			$('#cantidadWSDE').prop('disabled', false);
			$('#cantidadCAL').prop('disabled', false);
			$('#aceptar').css('display', 'none');
			$('#registrar').css('display', 'block');
			$('#cancelar').css('display', 'block');
			$('#puntosWSEE').css('display','block');
			$('#puntosWSSE').css('display','block');
			$('#puntosWSDE').css('display','block');
			$('#puntosCAL').css('display','block');
			$('#noMayorista').html(data.option);
			$('#noMayorista').selectpicker('refresh');
			$('#pais').val(data.pais);
			console.log(data.pais);
			componentHandler.upgradeAllRegistered();
			modal('modalDetalles');		
		} else { return; }
	});
}

function limpiarCampos() {
	$('#facturacion').removeClass('is-checked');
	$('#cotizacion').removeClass('is-checked');
	$('#Nombre').val('');
	$('#email').val('');
	$('#noMayorista').prop('disabled', false);
	$('#canal').val('');
	$('#pais').val('');
	$('#facturacion').val('');
	$('#cotizacion').val('');
	$('#numFactura').val('');
	$('#fecha').val('');
	$('#monto').val('');
	$('#cantidadWSEE').val('');
	$('#cantidadWSSE').val('');
	$('#cantidadWSDE').val('');
	$('#cantidadCAL').val('');
	$('#puntosWSEE').val('');
	$('#puntosWSSE').val('');
	$('#puntosWSDE').val('');
	$('#puntosCAL').val('');
}

function drawChartDonut() {
	var pais = null;
	var importe = null;
	$.ajax({
		data : {},
		url  : 'champion/getDatosGraficosCanales',
		type : 'POST'
	}).done(function(data) {
		data = JSON.parse(data);
		if((data.datos).length > 2 ) {
			var arr = $.parseJSON(data.datos);
			arr.splice(0, 0, ["pais", "ventas"]);
			var data = google.visualization.arrayToDataTable( arr );

		    var options = {
				title: 'Venta por paises',
				pieHole: 0.6,
				pieSliceTextStyle: {
					color: 'black',
				},
				titleTextStyle : { 
					color: 'black',
					// fontName: <string>,
					fontSize: 18,
					bold: true,
				},
				colors: ['#2AD2C9', '#FF8D6D', '#614767', '#5F7A76','#56C5D0'], //, '#425563'. '#80746E', '#C6C9CA']
				legend : 'bottom'
		    };

		    var chart = new google.visualization.PieChart(document.getElementById('venta'));
		    chart.draw(data, options);
		}
	});
}

function drawChart() {
	$.ajax({
		data : { },
		url  : 'champion/getDatosGraficoCotiza',
		type : 'POST'
	}).done(function(data) {
		data = JSON.parse(data);
		if((data.datos).length > 2 ) {
			var arr = $.parseJSON(data.datos);
			arr.splice(0, 0, ["pais", "puntaje"]);
			var data = google.visualization.arrayToDataTable( arr );

	        var options = {
	        	title: 'Puntaje entregado',
				pieHole: 0.6,
				pieSliceTextStyle: {
					color: 'black',
				},
				titleTextStyle : { 
					color: 'black',
					// fontName: <string>,
					fontSize: 18,
					bold: true,
				},
				colors: ['#2AD2C9', '#FF8D6D', '#614767', '#5F7A76','#56C5D0'], //, '#425563'. '#80746E', '#C6C9CA']
				legend : 'bottom'
	        };

	        var chart = new google.visualization.PieChart(document.getElementById('puntaje'));
	        chart.draw(data, options);
		}
	});
}

