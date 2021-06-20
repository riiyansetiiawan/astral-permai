$(window).on("load", function(){	
	Chart.defaults.global.legend.display = false;
	 var donutChartCanvas = $('#hrastral_biaya_deposit').get(0).getContext('2d');
	$.ajax({
		url: site_url+'dashboard/hrastral_biaya_deposit/',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response) {
			var donutData        = {
			  labels: [
				  response.deposit_label, response.biaya_label
			  ],
			  datasets: [
				{
				  data: [response.deposit, response.biaya],
				  backgroundColor : ['#647c8a', '#2196f3'],
				}
			  ]
			}
			var donutOptions     = {
			  maintainAspectRatio : false,
			  responsive : true,
			}
			//Create pie or douhnut chart
			// You can switch between pie and douhnut using the method below.
			var donutChart = new Chart(donutChartCanvas, {
			  type: 'pie',
			  data: donutData,
			  options: donutOptions      
			})
		},
		error: function(data) {
			console.log(data);
		}
	});
});
   