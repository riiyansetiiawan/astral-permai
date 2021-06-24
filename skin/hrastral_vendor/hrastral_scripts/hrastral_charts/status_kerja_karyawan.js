$(window).on("load", function() {

    Chart.defaults.global.legend.display = false;
    var donutChartCanvas = $('#status_kehadiran').get(0).getContext('2d');
    $.ajax({
        url: site_url + 'dashboard/status_kerja_karyawan/',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(response) {
            var donutData = {
                labels: [
                    response.bekerja_label, response.absent_label
                ],
                datasets: [{
                    data: [response.bekerja, response.absent],
                    backgroundColor: ['#009688', '#d9534f'],
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            var donutChart = new Chart(donutChartCanvas, {
                type: 'pie',
                data: donutData,
                options: donutOptions
            })
        }
    });
});