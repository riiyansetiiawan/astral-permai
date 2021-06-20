$(document).ready(function() {
   var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/list_peringatan/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	$('.view-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var peringatan_id = button.data('peringatan_id');
	var modal = $(this);
$.ajax({
	url : base_url+"/read_peringatan/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=view_peringatan&peringatan_id='+peringatan_id,
	success: function (response) {
		if(response) {
			$("#ajax_modal_view").html(response);
		}
	}
	});
});
});