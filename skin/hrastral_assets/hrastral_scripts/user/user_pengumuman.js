$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"user/list_pengumuman/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	
	// view
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var pengumuman_id = button.data('pengumuman_id');
		var modal = $(this);
		$.ajax({
			url : site_url+'user/read_pengumuman/',
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=view_pengumuman&pengumuman_id='+pengumuman_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal_view").html(response);
				}
			}
		});
	});
});