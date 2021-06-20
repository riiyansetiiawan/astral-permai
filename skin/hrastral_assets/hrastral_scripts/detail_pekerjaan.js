$(document).ready(function(){	
	
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var pekerjaan_id = button.data('pekerjaan_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/apply",
		type: "GET",
		data: 'jd=1&is_ajax=app_pekerjaan&mode=modal&data=apply_pekerjaan&type=apply_pekerjaan&pekerjaan_id='+pekerjaan_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
	});
	});
});