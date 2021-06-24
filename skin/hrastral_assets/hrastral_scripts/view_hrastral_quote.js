$(document).ready(function() {

    $('.view-modal-data').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var quote_id = button.data('quote_id');
        var modal = $(this);
        $.ajax({
            url: site_url + "quotes/read_po_quote/",
            type: "GET",
            data: 'jd=1&is_ajax=1&mode=modal&data=po_quote&quote_id=' + quote_id,
            success: function(response) {
                if (response) {
                    $("#ajax_modal_view").html(response);
                }
            }
        });
    });
});