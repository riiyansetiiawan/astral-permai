$(document).ready(function(){			
	
	
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var field_id = button.data('field_id');
		var field_tpe = button.data('field_type');
		if(field_tpe == 'gaji_tunjanagan'){
			var field_add = '&data=e_gaji_tunjanagan&type=e_gaji_tunjanagan&';
		} else if(field_tpe == 'gaji_pinjaman'){
			var field_add = '&data=e_gaji_pinjaman&type=e_gaji_pinjaman&';
		} else if(field_tpe == 'krywn_lembur'){
			var field_add = '&data=krywn_info_lembur&type=krywn_info_lembur&';
		} else if(field_tpe == 'gaji_komissi'){
			var field_add = '&data=gaji_info_komissi&type=gaji_info_komissi&';
		} else if(field_tpe == 'gaji_statutory_potongans'){
			var field_add = '&data=gaji_info_statutory_potongans&type=gaji_info_statutory_potongans&';
		} else if(field_tpe == 'gaji_pembayarans_lainnya'){
			var field_add = '&data=gaji_info_pembayarans_lainnya&type=gaji_info_pembayarans_lainnya&';
		} else if(field_tpe == 'security_level'){
			var field_add = '&data=einfo_security_level&type=einfo_security_level&';
		}
		var modal = $(this);
		$.ajax({
			url: site_url+'karyawans/dialog_'+field_tpe+'/',
			type: "GET",
			data: 'jd=1'+field_add+'field_id='+field_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
	});
	
   // Month & Year
   $('.ln_month_year').datepicker({
   	changeMonth: true,
   	changeYear: true,
   	showButtonPanel: true,
   	dateFormat:'yy-mm',
   	yearRange: '1900:' + (new Date().getFullYear() + 15),
   	beforeShow: function(input) {
   		$(input).datepicker("widget").addClass('hide-calendar');
   	},
   	onClose: function(dateText, inst) {
   		var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
   		var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
   		$(this).datepicker('setDate', new Date(year, month, 1));
   		$(this).datepicker('widget').removeClass('hide-calendar');
   		$(this).datepicker('widget').hide();
   	}
   	
   }); 
	// get current val
	$(".gaji_pokok").keyup(function(e){
		var to_currency_rate = $('#to_currency_rate').val();
		var curr_val = $(this).val();
		var final_val = to_currency_rate * curr_val;
		var float_val = final_val.toFixed(2);
		$('#current_cur_val').html(float_val);
	});	
	$(".upahh_harian").keyup(function(e){
		var to_currency_rate = $('#to_currency_rate').val();
		var curr_val = $(this).val();
		var final_val = to_currency_rate * curr_val;
		var float_val = final_val.toFixed(2);
		$('#current_cur_val2').html(float_val);
	});		
	// On page load 
	var umb_table_krywn_lembur = $('#umb_table_krywn_lembur').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"karyawans/gaji_lembur/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	// On page load 
	var umb_table_tunjanagans_ad = $('#umb_table_all_tunjanagans').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"karyawans/gaji_all_tunjanagans/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	var umb_table_komissi_ad = $('#umb_table_all_komissi').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"karyawans/gaji_all_komissi/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	var umb_table_statutory_potongans_ad = $('#umb_table_all_statutory_potongans').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"karyawans/gaji_all_statutory_potongans/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	var umb_table_pembayarans_lainnya_ad = $('#umb_table_all_pembayarans_lainnya').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"karyawans/gaji_all_pembayarans_lainnya/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	// On page load 
	var umb_table_all_potongans = $('#umb_table_all_potongans').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"karyawans/gaji_all_potongans/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});		
	/* */
	$("#karyawan_update_gaji").submit(function(e){
		
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=karyawan_update_gaji&type=karyawan_update_gaji&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					Ladda.stopAll();
					toastr.success(JSON.result);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				}
			}
		});
	});
	// add loan
	$("#add_pinjaman_info").submit(function(e){
		
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=pinjaman_info&type=pinjaman_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					umb_table_all_potongans.api().ajax.reload(function(){ 
						Ladda.stopAll();
						toastr.success(JSON.result);
						$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#add_pinjaman_info')[0].reset(); 
					$('.save').prop('disabled', false);
				}
			}
		});
	});
	
	/* Add info */
	jQuery("#karyawan_update_tunjanagan").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=karyawan_update_tunjanagan&type=karyawan_update_tunjanagan&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_tunjanagans_ad.api().ajax.reload(function(){ 
						Ladda.stopAll();
						toastr.success(JSON.result);
						$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#karyawan_update_tunjanagan')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	/* */
	jQuery("#karyawan_update_komissi").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=karyawan_update_komissi&type=karyawan_update_komissi&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_komissi_ad.api().ajax.reload(function(){ 
						Ladda.stopAll();
						toastr.success(JSON.result);
						$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#karyawan_update_komissi')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	jQuery("#statutory_potongans_info").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=statutory_potongans_info&type=statutory_potongans_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_statutory_potongans_ad.api().ajax.reload(function(){ 
						Ladda.stopAll();
						toastr.success(JSON.result);
						$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#statutory_potongans_info')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	jQuery("#pembayarans_lainnya_info").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=pembayarans_lainnya_info&type=pembayarans_lainnya_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_pembayarans_lainnya_ad.api().ajax.reload(function(){ 
						Ladda.stopAll();
						toastr.success(JSON.result);
						$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#pembayarans_lainnya_info')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	/* */
	$("#lembur_info").submit(function(e){
		
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=krywn_lembur&type=krywn_lembur&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					umb_table_krywn_lembur.api().ajax.reload(function(){ 
						Ladda.stopAll();
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#lembur_info')[0].reset(); 
					$('.save').prop('disabled', false);
				}
			}
		});
	});
	
	$("#delete_record").submit(function(e){
		var tk_type = $('#token_type').val();
		if(tk_type == 'all_tunjanagans'){
			var field_add = '&is_ajax=30&data=delete_record&type=delete_gaji_tunjanagan&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'all_potongans'){
			var field_add = '&is_ajax=30&data=delete_record&type=delete_gaji_pinjaman&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'krywn_lembur'){
			var field_add = '&is_ajax=30&data=delete_record&type=delete_gaji_lembur&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'all_komissi'){
			var field_add = '&is_ajax=30&data=delete_record&type=delete_all_komissi&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'all_statutory_potongans'){
			var field_add = '&is_ajax=30&data=delete_record&type=delete_all_statutory_potongans&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'all_pembayarans_lainnya'){
			var field_add = '&is_ajax=30&data=delete_record&type=pembayaran_lainnya&';
			var tb_name = 'umb_table_'+tk_type;
		}
		
		
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			url: e.target.action,
			type: "post",
			data: '?'+obj.serialize()+field_add+"form="+action,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					Ladda.stopAll();
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				} else {
					$('.delete-modal').modal('toggle');
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('#'+tb_name).dataTable().api().ajax.reload(function(){ 
						toastr.success(JSON.result);
						Ladda.stopAll();
					}, true);
					
				}
			}
		});
	});   
   /// delete a record
   $( document ).on( "click", ".delete", function() {
   	$('input[name=_token]').val($(this).data('record-id'));
   	$('input[name=token_type]').val($(this).data('token_type'));
   	$('#delete_record').attr('action',site_url+'karyawans/delete_'+$(this).data('token_type')+'/'+$(this).data('record-id'));
   });
});	
$(document).ready(function(){
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	
	$('.cont_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd',
		yearRange: '1990:' + (new Date().getFullYear() + 10),
	});	
	
});