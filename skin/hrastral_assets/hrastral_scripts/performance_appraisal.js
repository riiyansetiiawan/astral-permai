$(document).ready(function() {
    var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url: base_url + "/list_appraisal/",
            type: 'GET'
        },
        "fnDrawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width: '100%' });

    jQuery("#aj_perusahaan").change(function() {
        jQuery.get(base_url + "/get_karyawans/" + jQuery(this).val(), function(data, status) {
            jQuery('#ajax_karyawan').html(data);
        });
    });
    $('#remarks').trumbowyg();

    $('.month_year').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm',
        yearRange: '1970:' + new Date().getFullYear(),
        beforeShow: function(input) {
            $(input).datepicker("widget").addClass('hide-calendar');
        },
        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
            $(this).datepicker('widget').removeClass('hide-calendar');
            $(this).datepicker('widget').hide();
        }

    });

    $("#delete_record").submit(function(e) {

        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=2&form=" + action,
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

    $('.edit-modal-data').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var performance_appraisal_id = button.data('performance_appraisal_id');
        var modal = $(this);
        $.ajax({
            url: base_url + "/read/",
            type: "GET",
            data: 'jd=1&is_ajax=1&mode=modal&data=appraisal&performance_appraisal_id=' + performance_appraisal_id,
            success: function(response) {
                if (response) {
                    $("#ajax_modal").html(response);
                }
            }
        });
    });

    $('.view-modal-data-bg').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var p_appraisal_id = button.data('p_appraisal_id');
        var modal = $(this);
        $.ajax({
            url: base_url + '/read/',
            type: "GET",
            data: 'jd=1&is_ajax=4&mode=modal&data=view_appraisal&type=view_appraisal&performance_appraisal_id=' + p_appraisal_id,
            success: function(response) {
                if (response) {
                    $("#pajax_modal_view").html(response);
                }
            }
        });
    });

    $("#umb-form").submit(function(e) {
        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $('.save').prop('disabled', true);
        $('.icon-spinner3').show();
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=1&add_type=appraisal&form=" + action,
            cache: false,
            success: function(JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('.save').prop('disabled', false);
                    $('.icon-spinner3').hide();
                } else {
                    umb_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('.icon-spinner3').hide();
                    $('.add-form').removeClass('in');
                    $('.select2-selection__rendered').html('--Select--');
                    $('#umb-form')[0].reset();
                    $('.save').prop('disabled', false);
                }
            }
        });
    });
});
$(document).on("click", ".delete", function() {
    $('input[name=_token]').val($(this).data('record-id'));
    $('#delete_record').attr('action', base_url + '/delete/' + $(this).data('record-id'));
});