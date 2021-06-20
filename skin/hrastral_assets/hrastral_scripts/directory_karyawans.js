$(document).ready(function() {
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	jQuery("#filter_perusahaan").change(function(){
		jQuery.get(escapeHtmlSecure(site_url+"karyawans/filter_perusahaan_f_locations/"+jQuery(this).val()), function(data, status){
			jQuery('#ajax_flt_location').html(data);
		});
	});
});