$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"laporans/list_laporan_karyawans/0/0/0/",
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
	// get departments
	jQuery("#aj_perusahaan").change(function(){
		var c_id = jQuery(this).val();
		jQuery.get(base_url+"/get_departments/"+c_id, function(data, status){
			jQuery('#department_ajax').html(data);			
		});
		if(c_id == 0){
			jQuery.get(base_url+"/penunjukan/"+jQuery(this).val(), function(data, status){
				jQuery('#penunjukan_ajax').html(data);
			});
		}
	});
	
	/* projects report */
	$("#laporans_karyawan").submit(function(e){
		
		e.preventDefault();
		var perusahaan_id = $('#aj_perusahaan').val();
		var department_id = $('#aj_department').val();
		var penunjukan_id = $('#penunjukan_id').val();
		var umb_table2 = $('#umb_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"laporans/list_laporan_karyawans/"+perusahaan_id+"/"+department_id+"/"+penunjukan_id+"/",
				type : 'GET'
			},
			dom: 'lBfrtip',
			"buttons": ['csv', 'excel', 'pdf', 'print'], 
			"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		toastr.success('Request Submit.');
		umb_table2.api().ajax.reload(function(){ }, true);
	});
});