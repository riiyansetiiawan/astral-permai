$(document).ready(function() {
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var type_id = $('#type_id').val();
    var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url: site_url + "accounting/list_laporan_pendapatan/?from_date=" + from_date + "&to_date=" + to_date + "&type_id=" + type_id,
            type: 'GET'
        },
        dom: 'lBfrtip',
        "buttons": ['copy', 'csv', 'excel', 'pdf', 'print'],
        "fnDrawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width: '100%' });
    $('.date').datepicker({
        changeMonth: true,
        changeYear: true,
        maxDate: '0',
        dateFormat: 'yy-mm-dd',
        altField: "#date_format",
        altFormat: js_date_format,
        yearRange: '1900:' + new Date().getFullYear(),
        beforeShow: function(input) {
            $(input).datepicker("widget").show();
        }
    });
    $("#hrm-form").submit(function(e) {
        e.preventDefault();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var type_id = $('#type_id').val();
        jQuery.get(base_url + "/get_footer_pendapatan/?from_date=" + from_date + "&to_date=" + to_date + "&type_id=" + type_id, function(data, status) {
            jQuery('#get_footer').html(data);
        });
        var umb_table2 = $('#umb_table').dataTable({
            "bDestroy": true,
            "ajax": {
                url: site_url + "accounting/list_laporan_pendapatan/?from_date=" + from_date + "&to_date=" + to_date + "&type_id=" + type_id,
                type: 'GET'
            },
            dom: 'lBfrtip',
            "buttons": ['copy', 'csv', 'excel', 'pdf', 'print'],
            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    });
});