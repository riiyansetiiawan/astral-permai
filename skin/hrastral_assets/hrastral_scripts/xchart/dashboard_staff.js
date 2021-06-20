$(window).on("load", function(){	
	var ctx = $("#karyawan_perusahaan");
	Chart.defaults.global.legend.display = false;
	$.ajax({
		url: site_url+'dashboard/karyawan_perusahaan/',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
			var bgcolor = [];
			var final = [];
			var final2 = [];
			for(i=0; i < response.c_name.length; i++) {
				final.push(response.chart_data[i].value);
				final2.push(response.chart_data[i].label);
				bgcolor.push(response.chart_data[i].bgcolor);
			} 

		// Chart Options
		var chartOptions = {
			responsive: true,
			maintainAspectRatio: false,
			responsiveAnimationDuration:500,
		};

		// Chart Data
		var chartData = {
			labels: final2,
			datasets: [{
				label: "karyawan perusahaan",
				data: final,
				backgroundColor: bgcolor,
			}]
		};

		var config = {
			type: 'doughnut',
			options : chartOptions,
			data : chartData
		};

		var doughnutSimpleChart = new Chart(ctx, config);
	},
	error: function(data) {
		console.log(data);
	}
});
});
$(window).on("load", function(){	
	var ctx = $("#location_karyawan");
	Chart.defaults.global.legend.display = false;
	$.ajax({
		url: site_url+'dashboard/location_karyawan/',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
			var bgcolor = [];
			var final = [];
			var final2 = [];
			for(i=0; i < response.c_name.length; i++) {
				final.push(response.chart_data[i].value);
				final2.push(response.chart_data[i].label);
				bgcolor.push(response.chart_data[i].bgcolor);
			} 

		// Chart Options
		var chartOptions = {
			responsive: true,
			maintainAspectRatio: false,
			responsiveAnimationDuration:500,
		};

		// Chart Data
		var chartData = {
			labels: final2,
			datasets: [{
				label: "locations karyawan",
				data: final,
				backgroundColor: bgcolor,
			}]
		};

		var config = {
			type: 'pie',
			options : chartOptions,
			data : chartData
		};

		var doughnutSimpleChart = new Chart(ctx, config);
	},
	error: function(data) {
		console.log(data);
	}
});
});
$(window).on("load", function(){	
	var ctx = $("#karyawan_department");
	Chart.defaults.global.legend.display = false;
	$.ajax({
		url: site_url+'dashboard/karyawan_department/',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
			var bgcolor = [];
			var final = [];
			var final2 = [];
			for(i=0; i < response.c_name.length; i++) {
				final.push(response.chart_data[i].value);
				final2.push(response.chart_data[i].label);
				bgcolor.push(response.chart_data[i].bgcolor);
			} 

		// Chart Options
		var chartOptions = {
			responsive: true,
			maintainAspectRatio: false,
			responsiveAnimationDuration:500,
		};

		// Chart Data
		var chartData = {
			labels: final2,
			datasets: [{
				label: "karyawan departments",
				data: final,
				backgroundColor: bgcolor,
			}]
		};

		var config = {
			type: 'doughnut',
			options : chartOptions,
			data : chartData
		};

		var doughnutSimpleChart = new Chart(ctx, config);
	},
	error: function(data) {
		console.log(data);
	}
});
});
$(window).on("load", function(){
	var ctx = $("#karyawan_penunjukan");
	$.ajax({
		url: site_url+'dashboard/karyawan_penunjukan/',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
			var bgcolor = [];
			var final = [];
			var final2 = [];
			for(i=0; i < response.c_name.length; i++) {
				final.push(response.chart_data[i].value);
				final2.push(response.chart_data[i].label);
				bgcolor.push(response.chart_data[i].bgcolor);
			} 
			var chartOptions = {
				responsive: true,
				maintainAspectRatio: false,
				responsiveAnimationDuration:500,
			};
			var chartData = {
				labels: final2,
				datasets: [{
					label: "",
					data: final,
					backgroundColor: bgcolor,
				}]
			};

			var config = {
				type: 'pie',
				options : chartOptions,
				data : chartData
			};
			var doughnutSimpleChart = new Chart(ctx, config);
		},
		error: function(data) {
			console.log(data);
		}
	});

});