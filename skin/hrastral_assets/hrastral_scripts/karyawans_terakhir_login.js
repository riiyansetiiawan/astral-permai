$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/list_terakhir_login/",
			type : 'GET'
		},
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	jQuery("#filter_perusahaan").change(function(){
		if(jQuery(this).val() == 0){
			jQuery('#filter_location').prop('selectedIndex', 0);	
			jQuery('#filter_department').prop('selectedIndex', 0);
			jQuery('#filter_penunjukan').prop('selectedIndex', 0);
		}
		jQuery.get(escapeHtmlSecure(site_url+"karyawans/filter_perusahaan_f_locations/"+jQuery(this).val()), function(data, status){
			jQuery('#ajax_flt_location').html(data);
			
		});
	});
	$("#ihr_report").submit(function(e){
		
		e.preventDefault();
		//$('#hrload-img').show();
		//toastr.info(processing_request);
		var umb_table2 = $('#umb_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"karyawans_terakhir_login/list_terakhir_login/?ihr=true&perusahaan_id="+$('#filter_perusahaan').val()+"&location_id="+$('#filter_location').val()+"&department_id="+$('#filter_department').val()+"&penunjukan_id="+$('#filter_penunjukan').val(),
				type : 'GET'
			},
			"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		umb_table2.api().ajax.reload(function(){ toastr.success(request_submitted);}, true);
	});
});