function projectTotalHours() {
    var startDate = $('#start_date').val();
    var endDate = $('#end_date').val();
    var startTime = $("#start_time").val();
    var endTime = $("#end_time").val();

    var timeStart = new Date(startDate + " " + startTime);
    var timeEnd = new Date(endDate + " " + endTime);

    var diff = (timeEnd - timeStart) / 60000;

    var minutes = diff % 60;
    var hours = (diff - minutes) / 60;

    if (hours < 0 || minutes < 0) {
        var numberOfDaysToAdd = 1;
        timeEnd.setDate(timeEnd.getDate() + numberOfDaysToAdd);
        var dd = timeEnd.getDate();

        if (dd < 10) {
            dd = "0" + dd;
        }

        var mm = timeEnd.getMonth() + 1;

        if (mm < 10) {
            mm = "0" + mm;
        }
        projectTotalHours();
    } else {
        $('#total_time').html(hours + "Hrs " + minutes + "Mins");
        $('#total_hours').val(hours + ':' + minutes);
    }
}
$(document).ready(function() {
    var umb_diskusi_table = $('#umb_diskusi_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url: site_url + "quoted_projects/list_diskusi/" + $('#tproject_id').val(),
            type: 'GET'
        },
        "iDisplayLength": 25,
        "aLengthMenu": [
            [10, 25, 50, 100, 200, -1],
            [10, 25, 50, 100, 200, "All"]
        ],

        "fnDrawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    var umb_attachment_table = $('#umb_attachment_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url: site_url + "quoted_projects/list_attachment/" + $('#f_project_id').val(),
            type: 'GET'
        },
        "fnDrawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    $('#description').trumbowyg();
    $('#vdescription').trumbowyg();
    /* Edit tugas data */
    $("#update_status").submit(function(e) {

        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=3&type=update_status&update=1&view=tugas&form=" + action,
            cache: false,
            success: function(JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('.save').prop('disabled', false);
                } else {
                    toastr.success(JSON.result);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('.save').prop('disabled', false);
                }
            }
        });
    });

    $("#assign_project").submit(function(e) {
        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=4&type=project_user&view=user&form=" + action,
            cache: false,
            success: function(JSON) {
                jQuery.get(site_url + "quoted_projects/project_users/" + jQuery('#project_id').val(), function(data, status) {
                    jQuery('#all_list_karyawans').html(data);
                });
                $('.save').prop('disabled', false);
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('.save').prop('disabled', false);
                } else {
                    toastr.success(JSON.result);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('.save').prop('disabled', false);
                }
            }
        });
    });

    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width: '100%' });
    $(".nav-tabs-link").click(function() {
        var profile_id = $(this).data('config');
        var profile_block = $(this).data('config-block');
        $('.nav-tabs-link').removeClass('active');
        $('.current-tab').hide();
        $('#pj_data_' + profile_id).addClass('active');
        $('#' + profile_block).show();
    });

    $("#set_diskusi").submit(function(e) {
        var fd = new FormData(this);
        var obj = $(this),
            action = obj.attr('name');
        fd.append("is_ajax", 1);
        fd.append("add_type", 'set_diskusi');
        fd.append("form", action);

        e.preventDefault();
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
                } else {
                    umb_diskusi_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('#umb_message').val('');
                    $('#set_diskusi')[0].reset();
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

    $("#add_attachment").submit(function(e) {
        var fd = new FormData(this);
        var obj = $(this),
            action = obj.attr('name');
        fd.append("is_ajax", 7);
        fd.append("add_type", 'dfile_attachment');
        fd.append("form", action);

        e.preventDefault();
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
                } else {
                    umb_attachment_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('#add_attachment')[0].reset();
                    $('.save').prop('disabled', false);
                }
            },
            error: function() {
                toastr.error('Bug. Ada yang tidak beres, coba lagi.');
                $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                $('.save').prop('disabled', false);
            }
        });
    });

    $("#delete_record").submit(function(e) {
        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=6&data=bug&form=" + action,
            cache: false,
            success: function(JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                } else {
                    $('.delete-modal').modal('toggle');
                    umb_bug_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                }
            }
        });
    });

    $('.edit-modal-data-timelog').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var timelogs_id = button.data('timelogs_id');
        var modal = $(this);
        $.ajax({
            url: site_url + "quoted_projects/read_record_timelog/",
            type: "GET",
            data: 'jd=1&is_ajax=1&mode=modal&data=project_timelog&timelogs_id=' + timelogs_id,
            success: function(response) {
                if (response) {
                    $("#timelog").html(response);
                }
            }
        });
    });
    var umb_timelogs_table = $('#umb_timelogs_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url: site_url + "quoted_projects/list_project_timelogs/" + $('#f_project_id').val(),
            type: 'GET'
        },
        "fnDrawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $("#umb-form").submit(function(e) {
        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=1&add_type=tugas&form=" + action,
            cache: false,
            success: function(JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('.save').prop('disabled', false);
                } else {
                    umb_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('.icon-spinner3').hide();
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('#umb-form')[0].reset();
                    $('.add-form').removeClass('in');
                    $('.select2-selection__rendered').html('');
                    $('.save').prop('disabled', false);
                }
            }
        });
    });

    $("#add_timelog").submit(function(e) {
        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=1&add_type=timelog&form=" + action,
            cache: false,
            success: function(JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('.save').prop('disabled', false);
                } else {
                    umb_timelogs_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('.icon-spinner3').hide();
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('#add_timelog')[0].reset();
                    $('.add-form').removeClass('in');
                    $('.save').prop('disabled', false);
                }
            }
        });
    });
    $("#delete_record_f").submit(function(e) {
        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=8&data=attachment&type=delete&form=" + action,
            cache: false,
            success: function(JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                } else {
                    $('.delete-modal-file').modal('toggle');
                    umb_attachment_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                }
            }
        });
    });

    $("#delete_record_t").submit(function(e) {
        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=8&data=tugas&type=delete&form=" + action,
            cache: false,
            success: function(JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                } else {
                    $('.delete-modal-tugas').modal('toggle');
                    umb_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                }
            }
        });
    });
    $("#delete_record_v").submit(function(e) {
        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=8&data=tugas&type=delete&form=" + action,
            cache: false,
            success: function(JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                } else {
                    $('.delete-modal-variasi').modal('toggle');
                    umb_table_variasi.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                }
            }
        });
    });
    $("#redelete_timelog").submit(function(e) {
        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=8&data=timelog&type=delete&form=" + action,
            cache: false,
            success: function(JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                } else {
                    $('.delete-modal-timelogs').modal('toggle');
                    umb_timelogs_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                }
            }
        });
    });

    $("#add_note").submit(function(e) {

        e.preventDefault();
        var obj = $(this),
            action = obj.attr('name');
        $('.save').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=9&type=add_note&update=2&view=note&form=" + action,
            cache: false,
            success: function(JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('.save').prop('disabled', false);
                } else {
                    toastr.success(JSON.result);
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('.save').prop('disabled', false);

                }
            }
        });
    });

    var input = $('.timepicker').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now',
        afterDone: function() {
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var startTime = $("#start_time").val();
            var endTime = $("#end_time").val();
            if (startDate != '' && endDate != '' && startTime != '' && endTime != '') {
                projectTotalHours();
            }
        }
    });
    $('.user_timelog_date').datepicker({
        minDate: -1,
        maxDate: "+0D",
        dateFormat: 'yy-mm-dd',
    });
    $('.timelog_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '1900:' + (new Date().getFullYear() + 15),
        beforeShow: function(input) {
            $(input).datepicker("widget").show();
        }
    });
});
jQuery(document).on('click keyup change', '.timepicker,.date', function() {
    var startDate = $('#start_date').val();
    var endDate = $('#end_date').val();
    var startTime = $("#start_time").val();
    var endTime = $("#end_time").val();
    if (startDate != '' && endDate != '' && startTime != '' && endTime != '') {
        projectTotalHours();
    }
});
$(document).on("click", ".fidelete", function() {
    $('input[name=_token]').val($(this).data('record-id'));
    $('#delete_record_f').attr('action', site_url + 'quoted_projects/delete_attachment/' + $(this).data('record-id'));
});
$(document).on("click", ".delete-timelog", function() {
    $('input[name=_token_timelog]').val($(this).data('record-id'));
    $('#redelete_timelog').attr('action', site_url + 'quoted_projects/delete_timelog/' + $(this).data('record-id'));
});