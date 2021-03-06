$(document).ready(function() {
    var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url: site_url + "laporans/list_karyawan_cuti/",
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

    $("#laporan_training").submit(function(e) {

        e.preventDefault();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var user_id = $('#karyawan_id').val();
        var perusahaan_id = $('#aj_perusahaan').val();
        var umb_table2 = $('#umb_table').dataTable({
            "bDestroy": true,
            "ajax": {
                url: site_url + "laporans/list_karyawan_cuti/" + start_date + "/" + end_date + "/" + user_id + "/" + perusahaan_id,
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
    $('.edit-modal-data').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var karyawan_id = button.data('karyawan_id');
        var opt_cuti = button.data('opt_cuti');
        var modal = $(this);
        $.ajax({
            url: base_url + "/read_details_cuti/",
            type: "GET",
            data: 'jd=1&is_ajax=1&mode=modal&type=status_cuti&karyawan_id=' + karyawan_id + '&opt_cuti=' + opt_cuti,
            success: function(response) {
                if (response) {
                    $("#ajax_modal").html(response);
                }
            }
        });
    });
});