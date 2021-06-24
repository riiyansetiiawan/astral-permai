$(window).on("load", function() {

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
                    backgroundColor: ['#00a65a', '#f56954'],
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

$(window).on("load", function() {

    var donutChartCanvas = $('#status_cuti').get(0).getContext('2d');
    Chart.defaults.global.legend.display = false;
    $.ajax({
        url: site_url + 'dashboard/status_karyawan_cuti/',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(response) {
            var donutData = {
                labels: [
                    response.accepted, response.pending, response.rejected
                ],
                datasets: [{
                    data: [response.accepted_count, response.pending_count, response.rejected_count],
                    backgroundColor: ['#00a65a', '#f39c12', '#f56954'],
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