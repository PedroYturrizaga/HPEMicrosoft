function getDetails(cotizacion) {
	var idCotizacion = cotizacion;

	$.ajax({
		data  : { id_cotizacion 	  : idCotizacion },
		url   : 'champion/getDetalle',
		post : 'POST'
	}).done(function(data){
		try{
        	data = JSON.parse(data);
        	if(data.error == 0){
        		console.log(data.detalles);
        		$('#Nombre').val(data.detalles[0]['no_vendedor']);
        		$('#email').val(data.detalles[0]['email']);
        		$('#noMayorista').val(data.detalles[0]['noMayorista']);
        		$('#canal').val(data.detalles[0]['canal']);
        		$('#pais').val(data.detalles[0]['pais']);
        		$('#numFactura').val(data.detalles[0]['nu_cotizacion']);
        		$('#fecha').val(data.detalles[0]['fecha']);
        		$('#monto').val(data.detalles[0]['monto']);
        		for (var i = 0; i <= data.detalles.length; i++) {
        			switch(i <= data.detalles.length){
        				case data.detalles[i]['no_producto'] == "Windows Server Essentials Edition" :
        					$('#cantidadWSEE').val(data.detalles[i]['cantidad']);
        					break;
        				case data.detalles[i]['no_producto'] == "Windows Server Standard Edition" :
        					$('#cantidadWSSE').val(data.detalles[i]['cantidad']);
        					break;
        				case data.detalles[i]['no_producto'] == "Windows Server Datacenter Edition" :
        					$('#cantidadWSDE').val(data.detalles[i]['cantidad']);
        					break;
        				case data.detalles[i]['no_producto'] == "CALs" :
        					$('#cantidadCAL').val(data.detalles[i]['cantidad']);
        					break;
        			}
        			console.log(data.detalles[i]['no_producto']);
        			console.log(data.detalles[i]['cantidad']);
        		}
        		modal('modalDetalles');
        		// $('#').val();
        		// $('#').val();
        	} else { return; }
      } catch (err){
        msj('error',err.message);
      }
	});
}

function drawChartDonut() {
	$.ajax({
		data : {},
		url  : 'champion/getDatosGraficosCanales',
		post : 'POST'
	}).done(function(data) {
		data = JSON.parse(data);
		console.log(data.datos);
		var data = new google.visualization.DataTable();
			data.addColumn('string', 'paises');
			data.addColumn('number', 'importe');
			data.addRow(data.datos);

	    var options = {
			title: 'Venta por paises',
			pieHole: 0.6,
	    };

	    var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
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
		console.log(data.datos);
		var data = new google.visualization.DataTable(data.datos);
			data.addColumn('string', 'paises');
			data.addColumn('number', 'puntaje');
			data.addRow(data.datos);

        var options = {
        	title: 'Puntaje entregado',
			pieHole: 0.6,
			pieSliceTextStyle: {
				color: 'black',
			},
        };

        var chart = new google.visualization.PieChart(document.getElementById('donut_single'));
        chart.draw(data, options);
	});

}