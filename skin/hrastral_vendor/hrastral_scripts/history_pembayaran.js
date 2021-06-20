$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"payroll/list_history_pembayaran/",
			type : 'GET'
		},
		dom: 'lBfrtip',
		"buttons": [{
			extend: 'csv',
			exportOptions: {
				columns: [ 1, 2, 3, 4, 5,6]
			}
		}, {
			extend: 'excel',
			exportOptions: {
				columns: [ 1, 2, 3, 4, 5,6]
			}
		}, {
			extend: 'pdfHtml5',
			exportOptions: {
				columns: [ 1, 2, 3, 4, 5,6]
			}
		},], 
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 	
	jQuery("#aj_perusahaan").change(function(){
		jQuery.get(base_url+"/get_perusahaan_p_locations/"+jQuery(this).val(), function(data, status){
			jQuery('#ajax_location').html(data);
		});
	});
	$("#ihr_report").submit(function(e){
		
		e.preventDefault();
	//var tanggal_kehadiran = $('#tanggal_kehadiran').val();
	//var date_format = $('#date_format').val();
		//$('#hadir_tanggal').html(date_format);
		var umb_table2 = $('#umb_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"payroll/list_history_pembayaran/?ihr=true&perusahaan_id="+$('#aj_perusahaan').val()+"&location_id="+$('#aj_location_id').val()+"&department_id="+$('#aj_subdepartments').val()+"&gaji_bulan="+$('#gaji_bulan').val(),
				type : 'GET'
			},
			"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		umb_table2.api().ajax.reload(function(){ 
			Ladda.stopAll();
		}, true);
		
	});
// detail modal data
$('.detail_modal_data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var karyawan_id = button.data('karyawan_id');
	var pay_id = button.data('pay_id');
	var modal = $(this);
	$.ajax({
		url: site_url+'payroll/view_melakukan_pembayaran/',
		type: "GET",
		data: 'jd=1&is_ajax=11&mode=modal&data=pay_payment&type=pay_payment&emp_id='+karyawan_id+'&pay_id='+pay_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_details").html(response);
			}
		}
	});
});
});