$(document).ready(function() {
    var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url: base_url + "/list_kategori/",
            type: 'GET'
        },
        "fnDrawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width: '100%' });

    $(".add-new-form").click(function() {
        $(".add-form").slideToggle('slow');
    });

    $("#delete_record").submit(function(e) {

        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=2&type=delete_record&form=" + action,
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

    $('.modal_payroll_template').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var kategori_assets_id = button.data('field_id');
        var modal = $(this);
        $.ajax({
            url: base_url + "/read_kategori_assets/",
            type: "GET",
            data: 'jd=1&is_ajax=1&mode=modal&data=kategori_assets&kategori_assets_id=' + kategori_assets_id,
            success: function(response) {
                if (response) {
                    $("#ajax_modal_payroll").html(response);
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
            data: obj.serialize() + "&is_ajax=1&add_type=add_kategori&form=" + action,
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
                    $('#umb-form')[0].reset();
                    $('.select2-selection__rendered').html('--Select--');
                    $('.save').prop('disabled', false);
                }
            }
        });
    });
});
$(document).on("click", ".delete", function() {
    $('input[name=_token]').val($(this).data('record-id'));
    $('#delete_record').attr('action', base_url + '/delete_kategori_assets/' + $(this).data('record-id'));
});