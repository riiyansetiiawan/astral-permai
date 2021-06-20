$(document).ready(function() {
   var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/list_promotion/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var promotion_id = button.data('promotion_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/read_promotion/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_promotion&promotion_id='+promotion_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});
});