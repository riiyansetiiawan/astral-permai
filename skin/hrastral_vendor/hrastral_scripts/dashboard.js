$(document).ready(function() {	
	// view
	$('.view-modal-pengumuman').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var pengumuman_id = button.data('pengumuman_id');
		var modal = $(this);
		$.ajax({
			url : site_url+'/pengumuman/read/',
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=view_pengumuman&pengumuman_id='+pengumuman_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal_pengumuman").html(response);
				}
			}
		});
	});
});