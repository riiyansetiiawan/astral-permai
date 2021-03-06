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
    var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url: site_url + "quoted_projects/list_timelogs/",
            type: 'GET'
        },
        "fnDrawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width: '100%' });
    jQuery("#project_id").change(function() {
        jQuery.get(base_url + "/get_project_karyawans/" + jQuery(this).val(), function(data, status) {
            jQuery('#ajax_karyawan').html(data);
        });
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

    $('.edit-modal-data-timelog').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var timelogs_id = button.data('timelogs_id');
        var modal = $(this);
        $.ajax({
            url: base_url + "/read_record_project_timelog/",
            type: "GET",
            data: 'jd=1&is_ajax=1&mode=modal&data=project_timelog&timelogs_id=' + timelogs_id,
            success: function(response) {
                if (response) {
                    $("#timelog").html(response);
                }
            }
        });
    });

    $("#umb-form").submit(function(e) {
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
                    Ladda.stopAll();
                } else {
                    umb_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('.icon-spinner3').hide();
                    $('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
                    $('#umb-form')[0].reset();
                    $('.add-form').removeClass('show');
                    $('.save').prop('disabled', false);
                    Ladda.stopAll();
                }
            }
        });
    });
});

$(document).on("click", ".delete", function() {
    $('input[name=_token_timelog]').val($(this).data('record-id'));
    $('#delete_record').attr('action', base_url + '/delete_timelog/' + $(this).data('record-id'));
});
jQuery(document).on('click keyup change', '.timepicker,.date,.user_timelog_date,.timelog_date', function() {
    var startDate = $('#start_date').val();
    var endDate = $('#end_date').val();
    var startTime = $("#start_time").val();
    var endTime = $("#end_time").val();
    if (startDate != '' && endDate != '' && startTime != '' && endTime != '') {
        projectTotalHours();
    }
});