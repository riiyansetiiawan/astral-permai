$(document).ready(function() {
    var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url: site_url + "permintaan_lembur/list_permintaan_lembur/?karyawan_id=" + $('#karyawan_id').val() + "&tanggal_kehadiran=" + $('#tanggal_kehadiran').val(),
            type: 'GET'
        },

    });
    $('.tanggal_kehadiran').datepicker({
        changeMonth: true,
        changeYear: true,
        maxDate: '0',
        dateFormat: 'yy-mm-dd',
        altField: "#date_format",
        altFormat: js_date_format,
        yearRange: '1970:' + new Date().getFullYear(),
        beforeShow: function(input) {
            $(input).datepicker("widget").show();
        }
    });

    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width: '100%' });

    $("#update_laporan_kehadiran").submit(function(e) {

        e.preventDefault();
        var karyawan_id = $('#karyawan_id').val();
        var tanggal_kehadiran = $('#tanggal_kehadiran').val();
        var umb_table2 = $('#umb_table').dataTable({
            "bDestroy": true,
            "ajax": {
                url: site_url + "permintaan_lembur/list_permintaan_lembur/?karyawan_id=" + karyawan_id + "&tanggal_kehadiran=" + tanggal_kehadiran,
                type: 'GET'
            },
            //dom: 'lBfrtip',
            //"buttons": ['csv', 'excel', 'pdf', 'print'], 
            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#add_kehadiran_btn').show();
        toastr.success('Request Submit.');
        umb_table2.api().ajax.reload(function() {}, true);
    });

    $("#delete_record").submit(function(e) {

        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=true&type=delete&form=" + action,
            cache: false,
            success: function(JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                } else {
                    $('.delete-modal').modal('toggle');
                    umb_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                }
            }
        });
    });

    $('.add-modal-data').on('show.bs.modal', function(event) {
        var karyawan_id = $('#karyawan_id').val();
        var button = $(event.relatedTarget);
        var modal = $(this);
        $.ajax({
            url: site_url + 'permintaan_lembur/update_add_kehadiran/',
            type: "GET",
            data: 'jd=1&is_ajax=9&mode=modal&data=add_kehadiran&type=add_kehadiran&karyawan_id=' + karyawan_id,
            success: function(response) {
                if (response) {
                    $("#add_ajax_modal").html(response);
                }
            }
        });
    });

    $('.edit-modal-data').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var permintaan_waktu_id = button.data('permintaan_waktu_id');
        var modal = $(this);
        $.ajax({
            url: site_url + "permintaan_lembur/read/",
            type: "GET",
            data: 'jd=1&is_ajax=1&mode=modal&data=kehadiran&type=kehadiran&permintaan_waktu_id=' + permintaan_waktu_id,
            success: function(response) {
                if (response) {
                    $("#ajax_modal").html(response);
                }
            }
        });
    });
});
$(document).on("click", ".delete", function() {
    $('input[name=_token]').val($(this).data('record-id'));
    $('#delete_record').attr('action', site_url + 'permintaan_lembur/delete_kehadiran/' + $(this).data('record-id')) + '/';
});