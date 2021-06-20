$(document).ready(function(){			
	
	
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var field_id = button.data('field_id');
		var field_tpe = button.data('field_type');
		if(field_tpe == 'kontak'){
			var field_add = '&data=krywn_kontak&type=krywn_kontak&';
		} else if(field_tpe == 'document'){
			var field_add = '&data=krywn_document&type=krywn_document&';
		} else if(field_tpe == 'qualification'){
			var field_add = '&data=krywn_qualification&type=krywn_qualification&';
		} else if(field_tpe == 'pengalaman_kerja'){
			var field_add = '&data=krywn_pengalaman_kerja&type=krywn_pengalaman_kerja&';
		} else if(field_tpe == 'bank_account'){
			var field_add = '&data=krywn_bank_account&type=krywn_bank_account&';
		} else if(field_tpe == 'kontrak'){
			var field_add = '&data=krywn_kontrak&type=krywn_kontrak&';
		} else if(field_tpe == 'cuti'){
			var field_add = '&data=krywn_cuti&type=krywn_cuti&';
		} else if(field_tpe == 'shift'){
			var field_add = '&data=krywn_shift&type=krywn_shift&';
		}  else if(field_tpe == 'location'){
			var field_add = '&data=krywn_location&type=krywn_location&';
		} else if(field_tpe == 'imgdocument'){
			var field_add = '&data=e_imgdocument&type=e_imgdocument&';
		}
		var modal = $(this);
		$.ajax({
			url: site_url+'karyawans/dialog_'+field_tpe,
			type: "GET",
			data: 'jd=1'+field_add+'field_id='+field_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
	});

	/* Update basic info */
	$("#basic_info").submit(function(e){

		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&data=basic_info&type=basic_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				}
			}
		});
	});
	
	/* Update profile picture */
	$("#f_profile_picture").submit(function(e){
		var fd = new FormData(this);
		$('.icon-spinner3').show();
		var user_id = $('#user_id').val();
		var session_id = $('#session_id').val();
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 2);
		fd.append("type", 'profile_picture');
		fd.append("data", 'profile_picture');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('#remove_file').show();
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$("#remove_profile_picture").attr('checked', false);
					$('#u_file').attr("src", JSON.img);
					if(user_id == session_id){
						$('.user_avatar').attr("src", JSON.img);
					}
					$('.save').prop('disabled', false);
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('.icon-spinner3').hide();
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
			} 	        
		});
	});
	
	/* Update profile picture */
	$("#profile_background").submit(function(e){
		var fd = new FormData(this);
		$('.icon-spinner3').show();
		var user_id = $('#user_id').val();
		var session_id = $('#session_id').val();
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 2);
		fd.append("type", 'profile_background');
		fd.append("data", 'profile_background');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('#remove_file').show();
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$("#remove_profile_picture").attr('checked', false);
					$('#u_file').attr("src", JSON.img);
					if(user_id == session_id){
						$('.user_avatar').attr("src", JSON.img);
					}
					$('.save').prop('disabled', false);
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
			} 	        
		});
	});

	/* Update social networking */
	$("#f_social_networking").submit(function(e){

		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&data=social_info&type=social_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.save').prop('disabled', false);
				}
			}
		});
	});
	
	$(".nav-tabs-link").click(function(){
		var profile_id = $(this).data('profile');
		var profile_block = $(this).data('profile-block');
		$('.nav-tabs-link').removeClass('active');
		$('.current-tab').hide();
		$('#user_profile_'+profile_id).addClass('active');
		$('#'+profile_block).show();
	});
	$(".gaji-tab").click(function(){
		var profile_id = $(this).data('profile');
		var profile_block = $(this).data('profile-block');
		$('.gaji-tab-list').removeClass('active');
		$('.gaji-current-tab').hide();
		$('#suser_profile_'+profile_id).addClass('active');
		$('#'+profile_block).show();
	});
	$(".umb-core-hr-opt").click(function(){
		var core_hr_info = $(this).data('core-hr-info');
		var core_profile_block = $(this).data('core-profile-block');
		$('.umb-core-hr-tab').removeClass('active');
		$('.core-current-tab').hide();
		$('#core_hr_'+core_hr_info).addClass('active');
		$('#'+core_profile_block).show();
	});
	$(".core-projects").click(function(){
		var core_project_info = $(this).data('core-project-info');
		var core_projects_block = $(this).data('core-projects-block');
		$('.core-projects-tab').removeClass('active');
		$('#core_projects_'+core_project_info).addClass('active');
		$('.project-current-tab').hide();
		$('#'+core_projects_block).show();
	});
	/*$(".nav-tabs-link").click(function(){
		var profile_id = $(this).data('profile');
		var profile_block = $(this).data('profile-block');
		$('.list-group-item').removeClass('active');
		$('.current-tab').hide();
		$('#user_profile_'+profile_id).addClass('active');
		$('#'+profile_block).show();
	});*/
	
	// On page load: table_kontaks
	var umb_table_kontak = $('#umb_table_kontak').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"profile/kontaks/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	// On page load > documents
	var umb_table_immigration = $('#umb_table_imgdocument').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"karyawans/immigration/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	// On page load > documents
	var umb_table_document = $('#umb_table_document').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"karyawans/documents/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	// On page load > qualification
	var umb_table_qualification = $('#umb_table_qualification').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"karyawans/qualification/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	// On page load 
	var umb_table_pengalaman_kerja = $('#umb_table_pengalaman_kerja').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"karyawans/pengalaman/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	// On page load 
	var umb_table_bank_account = $('#umb_table_bank_account').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"karyawans/bank_account/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	// On page load > contract
	var umb_table_kontrak = $('#umb_table_kontrak').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"profile/kontrak/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	// On page load > leave
	var umb_table_cuti = $('#umb_table_cuti').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"profile/cuti/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});

	// On page load 
	var umb_table_shift = $('#umb_table_shift').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"profile/shift/"+$('#user_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});

	/* Add document info */
	$("#document_info").submit(function(e){
		var fd = new FormData(this);
		$('.icon-spinner3').show();
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 7);
		fd.append("type", 'document_info');
		fd.append("data", 'document_info');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					umb_table_document.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#document_info')[0].reset(); 
					$('.save').prop('disabled', false);
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
			} 	        
		});
	});
	
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var xfield_id = button.data('xfield_id');
		var field_type = button.data('field_type');
		var field_key = '';
		if(field_type == 'awards'){
			var view_info  = 'view_award';
			var field_key  = 'award_id';
		} else if(field_type == 'perjalanan'){
			var view_info  = 'view_perjalanan';
			var field_key  = 'perjalanan_id';
		} else if(field_type == 'transfers'){
			var view_info  = 'view_transfer';
			var field_key  = 'transfer_id';
		} else if(field_type == 'promotion'){
			var view_info  = 'view_promotion';
			var field_key  = 'promotion_id';
		} else if(field_type == 'keluhans'){
			var view_info  = 'view_keluhan';
			var field_key  = 'keluhan_id';
		} else if(field_type == 'peringatan'){
			var view_info  = 'view_peringatan';
			var field_key  = 'peringatan_id';
		}
		var modal = $(this);
		$.ajax({
			url :  site_url+field_type+"/read/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=view_modal&data='+view_info+'&'+field_key+'='+xfield_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal_view").html(response);
				}
			}
		});
	});
	$('.umb_hrastral_table').DataTable();
	/* Add document info */
	$("#immigration_info").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 7);
		fd.append("type", 'immigration_info');
		fd.append("data", 'immigration_info');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		$('.save').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					umb_table_immigration.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#document_info')[0].reset(); 
					$('.save').prop('disabled', false);
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
			} 	        
		});
	});
	
	/* Add qualification info */
	jQuery("#info_qualification").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=10&data=info_qualification&type=info_qualification&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_qualification.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_qualification')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	/* Add work experience info */
	jQuery("#info_pengalaman_kerja").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=13&data=info_pengalaman_kerja&type=info_pengalaman_kerja&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_pengalaman_kerja.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_pengalaman_kerja')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	/* Add bank account info */
	jQuery("#info_bank_account").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=16&data=info_bank_account&type=info_bank_account&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_bank_account.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_bank_account')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	/* Add contract info */
	jQuery("#info_kontrak").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=19&data=info_kontrak&type=info_kontrak&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_kontrak.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_kontrak')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	/* Add leave info */
	jQuery("#info_cuti").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=22&data=info_cuti&type=info_cuti&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_cuti.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('#info_cuti')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	/* Add shift info */
	jQuery("#info_shift").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=25&data=info_shift&type=info_shift&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_shift.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('#info_shift')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	/* Add location info */
	jQuery("#info_location").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=28&data=info_location&type=info_location&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_location.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('#info_location')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	/* Add change password */
	jQuery("#e_change_password").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=31&data=e_change_password&type=change_password&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('#e_change_password')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_kontak").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=info_kontak&type=info_kontak&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_kontak.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_kontak2").submit(function(e){

		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save2').prop('disabled', true);
		$('.icon-spinner33').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=4&data=info_kontak&type=info_kontak&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner33').hide();
					jQuery('.save2').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner33').hide();
					jQuery('.save2').prop('disabled', false);
				}
			}
		});
	});

	


	$("#delete_record").submit(function(e){
		var tk_type = $('#token_type').val();
		if(tk_type == 'kontak'){
			var field_add = '&is_ajax=6&data=delete_record&type=delete_kontak&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'document'){
			var field_add = '&is_ajax=8&data=delete_record&type=delete_document&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'qualification'){
			var field_add = '&is_ajax=12&data=delete_record&type=delete_qualification&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'pengalaman_kerja'){
			var field_add = '&is_ajax=15&data=delete_record&type=delete_pengalaman_kerja&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'bank_account'){
			var field_add = '&is_ajax=18&data=delete_record&type=delete_bank_account&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'kontrak'){
			var field_add = '&is_ajax=21&data=delete_record&type=delete_kontrak&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'cuti'){
			var field_add = '&is_ajax=24&data=delete_record&type=delete_cuti&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'shift'){
			var field_add = '&is_ajax=27&data=delete_record&type=delete_shift&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'location'){
			var field_add = '&is_ajax=30&data=delete_record&type=delete_location&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'imgdocument'){
			var field_add = '&is_ajax=30&data=delete_record&type=delete_imgdocument&';
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
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				} else {
					$('.delete-modal').modal('toggle');
					$('#'+tb_name).dataTable().api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
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
	
	if($('#change_pass').val()=='true'){
		$('.current-tab').hide();
		$('.nav-tabs-link').removeClass('active');
		$('#change_password').show();
		$('#user_profile_14').addClass('active');
	}

	$('.cont_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd',
		yearRange: '1850:' + (new Date().getFullYear() + 10),
	});	
	
});