$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"payroll/list_gaji/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	
	
	$("#delete_record").submit(function(e){
		
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				} else {
					$('.delete-modal').modal('toggle');
					umb_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);	
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);						
				}
			}
		});
	});
	
	// detail modal data payroll
	$('.modal_payroll_template').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var karyawan_id = button.data('karyawan_id');
		var modal = $(this);
		$.ajax({
			url: site_url+'payroll/read_payroll_template/',
			type: "GET",
			data: 'jd=1&is_ajax=11&mode=not_bayar&data=payroll_template&type=payroll_template&karyawan_id='+karyawan_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal_payroll").html(response);
				}
			}
		});
	});
	
	// detail modal data  hourlywages
	$('.modal_template_upahhperjam').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var karyawan_id = button.data('karyawan_id');
		var modal = $(this);
		$.ajax({
			url: site_url+'payroll/read_upahperjam_template/',
			type: "GET",
			data: 'jd=1&is_ajax=11&mode=not_bayar&data=hourlywages&type=hourlywages&karyawan_id='+karyawan_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal_upahhperjam").html(response);
				}
			}
		});
	});
	
	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var nilai_perjam_id = button.data('nilai_perjam_id');
		var modal = $(this);
		$.ajax({
			url : site_url+"payroll/hourly_wage_read/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=payroll&nilai_perjam_id='+nilai_perjam_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
	});
	
	 
	$("#user_gaji_template").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=payroll&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					umb_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				}
			}
		});
	});
	jQuery("#aj_perusahaan").change(function(){
		jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
			jQuery('#ajax_karyawan').html(data);
		});
	});
	/* Set gaji Details*/
	$("#set_gaji_details").submit(function(e){
		
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		var karyawan_id = jQuery('#karyawan_id').val();
		var perusahaan_id = jQuery('#aj_perusahaan').val();
		$('.icon-spinner33').show();
		// On page load: datatable
		var umb_table2 = $('#umb_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"payroll/list_gaji/?karyawan_id="+karyawan_id+"&perusahaan_id="+perusahaan_id,
				type : 'GET'
			},
			"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		umb_table2.api().ajax.reload(function(){ 
		}, true);
		$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
		$('.icon-spinner33').hide();
	});
});