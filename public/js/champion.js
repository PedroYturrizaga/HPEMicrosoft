function getDetails(cotizacion) {
	var idCotizacion = cotizacion;
	$.ajax({
		data : { idCotizacion : idCotizacion },
		url  : 'champion/getDetalle',
		post : 'POST' 
	}).done(function(data){
		try{
        	data = JSON.parse(data);
        	if(data.error == 0){
        		modal('modalDetalles');
				limpiarCampos();
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
			data.addRows([["Panama",6230],["Mexico",2904],["Argentina",1995],["Peru",850],["Chile",126]]);

		// var data = new google.visualization.DataTable();
		// 	data.addColumn('string', 'Marca');
		// 	data.addColumn('string', 'Alerta');
		// 	data.addColumn('number', 'Costo');
		// 	data.addColumn('boolean', 'Solucionadas');
		// 	data.addRows([
		// 	['Mercedes Bens','Motor', {v: 10000, f: '$10,000'}, true],
		// 	['Volvo','Gasolina', {v: 8000, f: '$8,000'}, true],
		// 	['Kia','Bujia', {v: 12500, f: '$12,500'}, true],
		// 	['Susuki','Carburador', {v: 7000, f: '$7,000'}, true],
		// ]);


		// var data = google.visualization.arrayToDataTable([
		// 	["Panama" , 6230],
		// 	// data.datos
	 //    ]);

	    var options = {
			title: 'My Daily Activities',
			pieHole: 0.4,
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
		var data = google.visualization.arrayToDataTable([
			['Effort', 'Amount given'],
			// ['Work',     'Work'],
			// ['Eat',      'Eat'],
			// ['Commute',  'Commute'],
			// ['Watch TV', 'Watch TV'],
			// ['Sleep',   'Sleep'],
			['My all',     2550],
        ]);

        var options = {
			pieHole: 0.6,
			pieSliceTextStyle: {
			color: 'black',
			},
			legend: 'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('donut_single'));
        chart.draw(data, options);
	});

}