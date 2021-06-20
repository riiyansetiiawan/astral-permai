$(document).ready(function() {
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	var type_id = $('#type_id').val();
	var perusahaan_id = $('#aj_perusahaan').val();
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"accounting/list_laporan_biaya/?from_date="+from_date+"&to_date="+to_date+"&type_id="+type_id+"&perusahaan_id="+perusahaan_id,
			type : 'GET'
		},
		dom: 'lBfrtip',
		"buttons": [{
			extend: 'csv',
			exportOptions: {
				columns: [ 1, 2, 3, 4]
			}
		}, {
			extend: 'excel',
			exportOptions: {
				columns: [ 1, 2, 3, 4]
			}
		}, {
			extend: 'pdfHtml5',
			exportOptions: {
				columns: [ 1, 2, 3, 4]
			}
		},], 
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	jQuery("#aj_perusahaan").change(function(){
		jQuery.get(base_url+"/get_laporans_type_biaya/"+jQuery(this).val(), function(data, status){
			jQuery('#type_biaya_ajax').html(data);
		});
	});	
	/* report */
	$("#hrm-form").submit(function(e){
		
		e.preventDefault();
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var type_id = $('#type_id').val();
		var perusahaan_id = $('#aj_perusahaan').val();
		jQuery.get(base_url+"/get_footer_biaya/?from_date="+from_date+"&to_date="+to_date+"&type_id="+type_id+"&perusahaan_id="+perusahaan_id, function(data, status){
			jQuery('#get_footer').html(data);
		});
		var umb_table2 = $('#umb_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"accounting/list_laporan_biaya/?from_date="+from_date+"&to_date="+to_date+"&type_id="+type_id+"&perusahaan_id="+perusahaan_id,
				type : 'GET'
			},
			dom: 'lBfrtip',
			"buttons": [{
				extend: 'csv',
				exportOptions: {
					columns: [ 1, 2, 3, 4]
				}
			}, {
				extend: 'excel',
				exportOptions: {
					columns: [ 1, 2, 3, 4]
				}
			}, {
				extend: 'pdfHtml5',
				exportOptions: {
					columns: [ 1, 2, 3, 4]
				}
			},], 
			"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		Ladda.stopAll();
	});
});