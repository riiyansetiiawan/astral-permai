$(document).ready(function() {
	$('#umb_table').DataTable( {
		"ajax": {
			url : base_url+"/list_saldo_accounts/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	} );
} );