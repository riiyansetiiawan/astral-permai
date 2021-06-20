$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/list_transaksii_bijaksanabank/"+$('#current_segment').val(),
            type : 'GET'
        },
		dom: 'Bfrtip',
		buttons: [
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true }
        ],
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
});