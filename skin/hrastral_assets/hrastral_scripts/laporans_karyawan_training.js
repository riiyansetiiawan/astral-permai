$(document).ready(function() {
    var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url: site_url + "laporans/list_training/",
            type: 'GET'
        },
        dom: 'lBfrtip',
        "buttons": ['csv', 'excel', 'pdf', 'print'],
        "fnDrawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width: '100%' });
    jQuery("#aj_perusahaan").change(function() {
        jQuery.get(base_url + "/get_khdrn_karyawan/" + jQuery(this).val(), function(data, status) {
            jQuery('#ajax_karyawan').html(data);
        });
    });
    // Month & Year
    $('.tanggal_training').datepicker({
        changeMonth: true,
        changeYear: true,
        //maxDate: '0',
        dateFormat: 'yy-mm-dd',
        altField: "#date_format",
        altFormat: js_date_format,
        yearRange: '1970:' + new Date().getFullYear(),
        beforeShow: function(input) {
            $(input).datepicker("widget").show();
        }
    });

    /* kehadiran tanggalbijaksana report */
    $("#laporan_training").submit(function(e) {

        e.preventDefault();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var user_id = $('#karyawan_id').val();
        var perusahaan_id = $('#aj_perusahaan').val();
        var umb_table2 = $('#umb_table').dataTable({
            "bDestroy": true,
            "ajax": {
                url: site_url + "laporans/list_training/" + start_date + "/" + end_date + "/" + user_id + "/" + perusahaan_id,
                type: 'GET'
            },
            dom: 'lBfrtip',
            "buttons": ['csv', 'excel', 'pdf', 'print'],
            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        toastr.success('Request Submit.');
        umb_table2.api().ajax.reload(function() {}, true);
    });
});