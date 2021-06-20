$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"laporans/list_project/0/all",
			type : 'GET'
		},
		dom: 'lBfrtip',
		"buttons": ['csv', 'excel', 'pdf', 'print'], 
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	
	/* projects report */
	$("#laporans_projects").submit(function(e){
		
		e.preventDefault();
		var project_id = $('#project_id').val();
		var status = $('#status').val();
		var umb_table2 = $('#umb_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"laporans/list_project/"+project_id+"/"+status,
				type : 'GET'
			},
			dom: 'lBfrtip',
			"buttons": ['csv', 'excel', 'pdf', 'print'], 
			"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		toastr.success('Request Submit.');
		umb_table2.api().ajax.reload(function(){
			Ladda.stopAll();
		}, true);
	});
});