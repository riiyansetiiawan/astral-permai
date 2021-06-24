$(window).on("load", function() {

    Chart.defaults.global.legend.display = false;
    var donutChartCanvas = $('#hrastral_permintaan_lembur').get(0).getContext('2d');
    $.ajax({
        url: site_url + 'dashboard/hrastral_permintaan_lembur/',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(response) {
            var donutData = {
                labels: [
                    response.lembur_approved, response.lembur_pending, response.lembur_rejected
                ],
                datasets: [{
                    data: [response.approved, response.pending, response.rejected],
                    backgroundColor: ['#009688', '#FFD950', '#d9534f'],
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            var donutChart = new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })
        }
    });
});