$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"employer/list_employer_pekerjaan/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
		//$('[data-toggle="tooltip"]').tooltip();          
	}
});
	
	$("#delete_record").submit(function(e){
		
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=delete_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
				} else {
					$('.delete-modal').modal('toggle');
					toastr.success(JSON.result);	
					window.location = '';						
				}
			}
		});
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',site_url+'employer/delete_pekerjaan/'+$(this).data('record-id'));
});
$( document ).on( "click", ".edit-pekerjaan", function() {
	var id = $(this).data('record-id');
	window.location = site_url + 'employer/edit_pekerjaan/'+ id;
});
$( document ).on( "click", ".view-pekerjaan", function() {
	var id = $(this).data('record-id');
	window.location = site_url + 'pekerjaans/detail/'+ id;
});