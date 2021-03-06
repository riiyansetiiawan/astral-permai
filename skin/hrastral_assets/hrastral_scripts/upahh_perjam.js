$(document).ready(function() {
    var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url: site_url + "payroll/list_perjam/",
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
        var nilai_perjam_id = button.data('nilai_perjam_id');
        var modal = $(this);
        $.ajax({
            url: site_url + "payroll/read_upah_perjam/",
            type: "GET",
            data: 'jd=1&is_ajax=1&mode=modal&data=payroll&nilai_perjam_id=' + nilai_perjam_id,
            success: function(response) {
                if (response) {
                    $("#ajax_modal").html(response);
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
            data: obj.serialize() + "&is_ajax=1&add_type=payroll&form=" + action,
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
                    $('.add-form').fadeOut('slow');
                    $('#umb-form')[0].reset();
                    $('.save').prop('disabled', false);
                }
            }
        });
    });
});
$(document).on("click", ".delete", function() {
    $('input[name=_token]').val($(this).data('record-id'));
    $('#delete_record').attr('action', site_url + 'payroll/delete_hourly_wage/' + $(this).data('record-id')) + '/';
});