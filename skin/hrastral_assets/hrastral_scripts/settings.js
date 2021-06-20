$(document).ready(function(){			

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	
	
	jQuery("#info_perusahaan").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&data=info_perusahaan&type=info_perusahaan&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});


	$("#file_setting_info").submit(function(e){

		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		if($('#view_all_files').is(':checked')){
			var view_all_files = $("#view_all_files").val();
		} else {
			var view_all_files = '';
		}
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=setting_info&form="+action+"&view_all_files="+view_all_files,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);	
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);						
				}
			}
		});
	});
	jQuery("#is_half_monthly").change(function(){
		var opt = $(this).val();
		if(opt == 1){
			$('#deduct_options').show();
		} else {
			$('#deduct_options').hide();
		}
	});
	jQuery("#email_type").change(function(){
		var opt = $(this).val();
		if(opt == 'smtp'){
			$('#smtp_options').show();
		} else {
			$('#smtp_options').hide();
		}
	});
	jQuery("#system_info").submit(function(e){

		e.preventDefault();
		if($('#enable_page_rendered').is(':checked')){
			var enable_page_rendered = $("#enable_page_rendered").val();
		} else {
			var enable_page_rendered = '';
		}
		if($('#enable_current_year').is(':checked')){
			var enable_current_year = $("#enable_current_year").val();
		} else {
			var enable_current_year = '';
		}
		if($('#enable_auth_background').is(':checked')){
			var enable_auth_background = $("#enable_auth_background").val();
		} else {
			var enable_auth_background = '';
		}
		
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=system_info&type=system_info&form="+action+'&enable_page_rendered='+enable_page_rendered+'&enable_current_year='+enable_current_year+'&enable_auth_background='+enable_auth_background,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				}
			}
		});
	});

	jQuery("#role_info").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		if($('#kontak_role').is(':checked')){
			var kontak_role = $("#kontak_role").val();
		} else {
			var kontak_role = '';
		}
		if($('#edu_role').is(':checked')){
			var edu_role = $("#edu_role").val();
		} else {
			var edu_role = '';
		}
		if($('#work_role').is(':checked')){
			var work_role = $("#work_role").val();
		} else {
			var work_role = '';
		}
		if($('#doc_role').is(':checked')){
			var doc_role = $("#doc_role").val();
		} else {
			var doc_role = '';
		}
		if($('#social_role').is(':checked')){
			var social_role = $("#social_role").val();
		} else {
			var social_role = '';
		}
		if($('#pic_role').is(':checked')){
			var pic_role = $("#pic_role").val();
		} else {
			var pic_role = '';
		}
		if($('#profile_role').is(':checked')){
			var profile_role = $("#profile_role").val();
		} else {
			var profile_role = '';
		}
		if($('#bank_account_role').is(':checked')){
			var bank_account_role = $("#bank_account_role").val();
		} else {
			var bank_account_role = '';
		}
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=role_info&type=role_info&form="+action+'&karyawan_manage_own_kontak='+kontak_role+'&karyawan_manage_own_qualification='+edu_role+'&karyawan_manage_own_pengalaman_kerja='+work_role+'&karyawan_manage_own_document='+doc_role+'&karyawan_manage_own_social='+social_role+'&karyawan_manage_own_picture='+pic_role+'&karyawan_manage_own_profile='+profile_role+'&karyawan_manage_own_bank_account='+bank_account_role,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				}
			}
		});
	});

	jQuery("#info_kehadiran").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		if($('#enable_kehairans').is(':checked')){
			var enable_kehadiran = $("#enable_kehairans").val();
		} else {
			var enable_kehadiran = '';
		}
		if($('#enable_clock_in_btn').is(':checked')){
			var enable_clock_in_btn = $("#enable_clock_in_btn").val();
		} else {
			var enable_clock_in_btn = '';
		}
		
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=5&data=info_kehadiran&type=info_kehadiran&form="+action+"&enable_kehadiran="+enable_kehadiran+"&enable_clock_in_btn="+enable_clock_in_btn,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});

	jQuery("#email_info").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		if($('#srole_email_notification').is(':checked')){
			var role_email_notification = $("#srole_email_notification").val();
		} else {
			var role_email_notification = '';
		}
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=5&data=email_info&type=email_info&form="+action+'&enable_email_notification='+role_email_notification,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});

	jQuery("#payroll_config").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		if($('#generate_password_slipgaji').is(':checked')){
			var p_generate_pass = $("#generate_password_slipgaji").val();
		} else {
			var p_generate_pass = '';
		}
		jQuery.ajax({
			type: "POST",
			url: site_url+'settings/payroll_config/',
			data: obj.serialize()+"&is_ajax=6&data=payroll_config&type=payroll_config&form="+action+"&generate_password_slipgaji="+p_generate_pass,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});


	jQuery("#info_pekerjaan").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		if($('#enable_pekerjaan2').is(':checked')){
			var epekerjaan = $("#enable_pekerjaan2").val();
		} else {
			var epekerjaan = '';
		}
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=7&data=info_pekerjaan&type=info_pekerjaan&form="+action+'&enable_pekerjaan='+epekerjaan,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	jQuery("#info_performance").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=7&data=info_performance&type=info_performance&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});

	jQuery("#email_notification_info").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=8&data=email_notification_info&type=email_notification_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});


	
	$(".nav-tabs-link").click(function(){
		var profile_id = $(this).data('setting');
		var profile_block = $(this).data('profile-block');
		$('.list-group-item').removeClass('active');
		$('.current-tab').hide();
		$('#setting_'+profile_id).addClass('active');
		$('#'+profile_block).show();
	});	
});
