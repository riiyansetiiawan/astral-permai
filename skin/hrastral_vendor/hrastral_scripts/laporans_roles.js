$(document).ready(function() {
   var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"laporans/list_role_karyawans/0/",
            type : 'GET'
        },
		dom: 'Bfrtip',
		"buttons": ['csv', 'excel', 'pdf', 'print'], 
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		
	/* roles report */
	$("#roles_report").submit(function(e){
		
		e.preventDefault();
		var role_id = $('#role_id').val();
		var umb_table2 = $('#umb_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"laporans/list_role_karyawans/"+role_id+"/",
				type : 'GET'
			},
			dom: 'Bfrtip',
			"buttons": ['csv', 'excel', 'pdf', 'print'], 
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		toastr.success('Request Submit.');
		umb_table2.api().ajax.reload(function(){ Ladda.stopAll(); }, true);
	});
});