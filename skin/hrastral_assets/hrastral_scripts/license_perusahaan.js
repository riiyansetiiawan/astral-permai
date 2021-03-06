$(document).ready(function() {
    var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url: base_url + "/list_document/",
            type: 'GET'
        },
        dom: 'lBfrtip',
        "buttons": ['csv', 'excel', 'pdf', 'print'],
        "fnDrawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $('[data-plugin="umb_select"]').select2($(this).attr('data-options'));
    $('[data-plugin="umb_select"]').select2({ width: '100%' });

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
        var document_id = button.data('document_id');
        var modal = $(this);
        $.ajax({
            url: base_url + "/read_document/",
            type: "GET",
            data: 'jd=1&is_ajax=1&mode=modal&data=document&document_id=' + document_id,
            success: function(response) {
                if (response) {
                    $("#ajax_modal").html(response);
                }
            }
        });
    });

    $('.view-modal-data').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var document_id = button.data('document_id');
        var modal = $(this);
        $.ajax({
            url: base_url + "/read_document/",
            type: "GET",
            data: 'jd=1&is_ajax=1&mode=modal&data=view_document&document_id=' + document_id,
            success: function(response) {
                if (response) {
                    $("#ajax_modal_view").html(response);
                }
            }
        });
    });

    $("#umb-form").submit(function(e) {
        var fd = new FormData(this);
        var obj = $(this),
            action = obj.attr('name');
        fd.append("is_ajax", 1);
        fd.append("add_type", 'document_resmi');
        fd.append("form", action);
        e.preventDefault();
        $('.save').prop('disabled', true);

        $.ajax({
            url: base_url + '/add_document_resmi/',
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
                } else {
                    umb_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('#umb-form')[0].reset();
                    $('.add-form').removeClass('in');
                    $('.select2-selection__rendered').html('--Select--');
                    $('.save').prop('disabled', false);
                }
            },
            error: function() {
                toastr.error(JSON.error);
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                $('.save').prop('disabled', false);
            }
        });
    });
});
$(document).on("click", ".delete", function() {
    $('input[name=_token]').val($(this).data('record-id'));
    $('#delete_record').attr('action', base_url + '/delete_document/' + $(this).data('record-id'));
});