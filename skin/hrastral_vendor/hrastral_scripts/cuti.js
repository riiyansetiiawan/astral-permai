$(document).ready(function() {
    var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url: site_url + "timesheet/list_cuti/",
            type: 'GET'
        },
        "fnDrawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    var umb_my_team_table = $('#umb_my_team_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url: site_url + "timesheet/list_team_saya_cuti/",
            type: 'GET'
        },
        "fnDrawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width: '100%' });
    jQuery("#aj_perusahaan").change(function() {
        jQuery.get(base_url + "/get_cuti_karyawans/" + jQuery(this).val(), function(data, status) {
            jQuery('#ajax_karyawan').html(data);
        });
    });

    jQuery("#aj_perusahaanf").change(function() {
        jQuery.get(site_url + "payroll/get_karyawans/" + jQuery(this).val(), function(data, status) {
            jQuery('#ajax_f_karyawan').html(data);
        });
    });
    $('#remarks').trumbowyg();
    $("#ihr_report").submit(function(e) {

        e.preventDefault();
        var umb_table2 = $('#umb_table').dataTable({
            "bDestroy": true,
            "ajax": {
                url: site_url + "timesheet/list_cuti/?ihr=true&perusahaan_id=" + $('#aj_perusahaanf').val() + "&karyawan_id=" + $('#karyawan_id').val() + "&status=" + $('#status').val(),
                type: 'GET'
            },
            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        umb_table2.api().ajax.reload(function() {
            Ladda.stopAll();
        }, true);
    });

    $("#delete_record").submit(function(e) {

        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=2&type=delete&form=" + action,
            cache: false,
            success: function(JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    Ladda.stopAll();
                } else {
                    $('.delete-modal').modal('toggle');
                    umb_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    Ladda.stopAll();
                }
            }
        });
    });

    $('.edit-modal-data').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var cuti_id = button.data('cuti_id');
        var modal = $(this);
        $.ajax({
            url: site_url + "timesheet/read_record_cuti/",
            type: "GET",
            data: 'jd=1&is_ajax=1&mode=modal&data=leave&cuti_id=' + cuti_id,
            success: function(response) {
                if (response) {
                    $("#ajax_modal").html(response);
                }
            }
        });
    });

    $("#umb-form").submit(function(e) {
        var fd = new FormData(this);
        var obj = $(this),
            action = obj.attr('name');
        fd.append("is_ajax", 1);
        fd.append("add_type", 'cuti');
        fd.append("form", action);
        e.preventDefault();
        $('.icon-spinner3').show();
        $('.save').prop('disabled', true);
        $.ajax({
            url: e.target.action,
            type: "POST",
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            success: function(JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('.save').prop('disabled', false);
                    $('.icon-spinner3').hide();
                    Ladda.stopAll();
                } else {
                    umb_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('.icon-spinner3').hide();
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('#umb-form')[0].reset();
                    $('.add-form').removeClass('show');
                    $('.select2-selection__rendered').html('--Select--');
                    $('.save').prop('disabled', false);
                    Ladda.stopAll();
                }
            },
            error: function() {
                toastr.error(JSON.error);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                $('.icon-spinner3').hide();
                $('.save').prop('disabled', false);
                Ladda.stopAll();
            }
        });
    });
});

$(document).on("click", ".delete", function() {
    $('input[name=_token]').val($(this).data('record-id'));
    $('#delete_record').attr('action', site_url + 'timesheet/delete_cuti/' + $(this).data('record-id'));
});