function getDetails(cotizacion) {
	var cotizacion = cotizacion;
	$.ajax({
		data  : { cotizacion : cotizacion },
		url   : 'champion/getDetalles',
		post : 'POST'
	}).done(function(data){
		try{
        	data = JSON.parse(data);
        	if(data.error == 0){
        		$('#Nombre').val(data.detalles[0]['no_vendedor']);
        		$('#email').val(data.detalles[0]['email']);
        		//FALTA METODO PARA SETEAR COMBOS
        		$('#noMayorista').html(data.option);

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
        		modal('modalDetalles');
        	} else { return; }
      } catch (err){
        msj('error',err.message);
      }
	});
}

function drawChartDonut() {
	var pais = null;
	var importe = null;
	$.ajax({
		data : {},
		url  : 'champion/getDatosGraficosCanales',
		post : 'POST'
	}).done(function(data) {
		data = JSON.parse(data);
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
			colors: ['#2AD2C9', '#FF8D6D', '#614767', '#5F7A76'], //, '#425563'. '#80746E', '#C6C9CA']
			legend : 'bottom'
	    };

	    var chart = new google.visualization.PieChart(document.getElementById('venta'));
	    chart.draw(data, options);
	});
}

function drawChart() {
	$.ajax({
		data : {},
		url  : 'champion/getDatosGraficoCotiza',
		post : 'POST'
	}).done(function(data) {
		data = JSON.parse(data);
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
			colors: ['#2AD2C9', '#FF8D6D', '#614767', '#5F7A76'], //, '#425563'. '#80746E', '#C6C9CA']
			legend : 'bottom'
        };

        var chart = new google.visualization.PieChart(document.getElementById('puntaje'));
        chart.draw(data, options);
	});
}
