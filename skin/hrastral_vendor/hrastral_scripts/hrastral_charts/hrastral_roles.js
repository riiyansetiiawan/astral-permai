$(window).on("load", function() {
    var ctx = $("#hrastral_roles");
    Chart.defaults.global.legend.display = false;
    $.ajax({
        url: site_url + 'dashboard/hrastral_roles/',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(response) {
            var bgcolor = [];
            var final = [];
            var final2 = [];
            for (i = 0; i < response.c_name.length; i++) {
                final.push(response.chart_data[i].value);
                final2.push(response.chart_data[i].label);
                bgcolor.push(response.chart_data[i].bgcolor);
            }

            var chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                responsiveAnimationDuration: 500,
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
                type: 'doughnut',
                options: chartOptions,
                data: chartData
            };
            var doughnutSimpleChart = new Chart(ctx, config);
        },
        error: function(data) {
            console.log(data);
        }
    });
});