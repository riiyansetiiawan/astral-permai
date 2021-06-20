$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/list_transaksii_bijaksanabank/"+$('#current_segment').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
});