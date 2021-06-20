$(document).ready(function() {
   var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"user/list_award/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var award_id = button.data('award_id');
		var modal = $(this);
	$.ajax({
		url :  site_url+"user/read_awards/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_award&award_id='+award_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});
});