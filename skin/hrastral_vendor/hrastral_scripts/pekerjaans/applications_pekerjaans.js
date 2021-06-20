$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"employer/list_applications_pekerjaans/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
		//$('[data-toggle="tooltip"]').tooltip();          
		}
	});
});