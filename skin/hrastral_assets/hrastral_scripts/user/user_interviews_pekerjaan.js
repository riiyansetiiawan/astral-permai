$(document).ready(function() {
   var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/list_interview_pekerjaans/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
});