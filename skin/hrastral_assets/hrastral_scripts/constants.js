$(document).ready(function() {		
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	// listing
	// On page load:
	var umb_table_type_pngtrn_perjalanan = $('#umb_table_type_pngtrn_perjalanan').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_type_pngtrn_perjalanan/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_type_exit = $('#umb_table_type_exit').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_type_exit/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_type_pekerjaan = $('#umb_table_type_pekerjaan').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_type_pekerjaan/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	var umb_table_kategori_pekerjaan = $('#umb_table_kategori_pekerjaan').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 15,
		"aLengthMenu": [[15, 30, 50, 75, 100, -1], [15, 30, 50,75, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_kategori_pekerjaan/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_type_biaya = $('#umb_table_type_biaya').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_type_biaya/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_type_penghentian = $('#umb_table_type_penghentian').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_type_penghentian/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_type_peringatan = $('#umb_table_type_peringatan').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_type_peringatan/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_type_cuti = $('#umb_table_type_cuti').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_type_cuti/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_type_award = $('#umb_table_type_award').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_type_award/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_type_document = $('#umb_table_type_document').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_type_document/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});

	
	var umb_table_type_kontrak = $('#umb_table_type_kontrak').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_type_kontrak/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_payment_method = $('#umb_table_payment_method').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_payment_method/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_tingkat_pendidikan = $('#umb_table_tingkat_pendidikan').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_tingkat_pendidikan/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_qualification_language = $('#umb_table_qualification_language').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_qualification_language/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_qualification_skill = $('#umb_table_qualification_skill').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_qualification_skill/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_type_currency = $('#umb_table_type_currency').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_type_currency/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_type_perusahaan = $('#umb_table_type_perusahaan').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_type_perusahaan/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	
	var umb_table_type_sukubangsa = $('#umb_table_type_sukubangsa').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_type_sukubangsa/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	var umb_table_type_pendapatan = $('#umb_table_type_pendapatan').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_type_pendapatan/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});
	var umb_table_security_level = $('#umb_table_security_level').dataTable({
		"bDestroy": true,
		"bFilter": false,
		"bLengthChange": false,
		"iDisplayLength": 5,
		"aLengthMenu": [[5, 10, 30, 50, 100, -1], [5, 10, 30, 50, 100, "All"]],
		"ajax": {
			url : site_url+"settings/list_security_level/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}			
	});	
	jQuery("#info_type_document").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=15&data=info_type_document&type=info_type_document&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_type_document.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_type_document')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_type_kontrak").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=16&data=info_type_kontrak&type=info_type_kontrak&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_type_kontrak.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_type_kontrak')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_payment_method").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=17&data=info_payment_method&type=info_payment_method&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					umb_table_payment_method.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_payment_method')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_tingkat_pddkn").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=18&data=info_tingkat_pddkn&type=info_tingkat_pddkn&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					umb_table_tingkat_pendidikan.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_tingkat_pddkn')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_edu_language").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=19&data=info_edu_language&type=info_edu_language&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					umb_table_qualification_language.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_edu_language')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_edu_skill").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=20&data=info_edu_skill&type=info_edu_skill&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					umb_table_qualification_skill.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_edu_skill')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_type_cuti").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=23&data=info_type_cuti&type=info_type_cuti&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					umb_table_type_cuti.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_type_cuti')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	
	jQuery("#info_type_pngtrn_perjalanan").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=45&data=info_type_pngtrn_perjalanan&type=info_type_pngtrn_perjalanan&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					umb_table_type_pngtrn_perjalanan.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_type_pngtrn_perjalanan')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_type_award").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=22&data=info_type_award&type=info_type_award&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_type_award.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_type_award')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_type_peringatan").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=24&data=info_type_peringatan&type=info_type_peringatan&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_type_peringatan.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_type_peringatan')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	jQuery("#info_type_sukubangsa").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=24&data=info_type_sukubangsa&type=info_type_sukubangsa&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_type_sukubangsa.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_type_sukubangsa')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_type_pendapatan").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=24&data=info_type_pendapatan&type=info_type_pendapatan&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_type_pendapatan.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_type_pendapatan')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_type_penghentian").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=25&data=info_type_penghentian&type=info_type_penghentian&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_type_penghentian.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_type_penghentian')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_type_biaya").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=26&data=info_type_biaya&type=info_type_biaya&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_type_biaya.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_type_biaya')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_type_pekerjaan").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=27&data=info_type_pekerjaan&type=info_type_pekerjaan&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_type_pekerjaan.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_type_pekerjaan')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	jQuery("#info_kategori_pekerjaan").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=27&data=info_kategori_pekerjaan&type=info_kategori_pekerjaan&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_kategori_pekerjaan.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_kategori_pekerjaan')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_type_exit").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=28&data=info_type_exit&type=info_type_exit&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_type_exit.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_type_exit')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_type_currency").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=28&data=info_type_currency&type=info_type_currency&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_type_currency.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_type_currency')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	jQuery("#info_type_perusahaan").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=28&data=info_type_perusahaan&type=info_type_perusahaan&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_type_perusahaan.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_type_perusahaan')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	jQuery("#info_security_level").submit(function(e){
		
		e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=28&data=info_security_level&type=info_security_level&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table_security_level.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#info_security_level')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	
	
	$("#delete_record").submit(function(e){
		var tk_type = $('#token_type').val();
		$('.icon-spinner3').show();
		if(tk_type == 'type_document'){
			var field_add = '&is_ajax=9&data=delete_type_document&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'type_kontrak'){
			var field_add = '&is_ajax=10&data=delete_type_kontrak&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'payment_method'){
			var field_add = '&is_ajax=11&data=delete_payment_method&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'tingkat_pendidikan'){
			var field_add = '&is_ajax=12&data=delete_tingkat_pendidikan&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'qualification_language'){
			var field_add = '&is_ajax=13&data=delete_qualification_language&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'qualification_skill'){
			var field_add = '&is_ajax=14&data=delete_qualification_skill&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'type_award'){
			var field_add = '&is_ajax=31&data=delete_type_award&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'type_cuti'){
			var field_add = '&is_ajax=32&data=delete_type_cuti&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'type_peringatan'){
			var field_add = '&is_ajax=33&data=delete_type_peringatan&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'type_penghentian'){
			var field_add = '&is_ajax=34&data=delete_type_penghentian&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'type_biaya'){
			var field_add = '&is_ajax=35&data=delete_type_biaya&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'type_pekerjaan'){
			var field_add = '&is_ajax=36&data=delete_type_pekerjaan&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'type_exit'){
			var field_add = '&is_ajax=37&data=delete_type_exit&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'type_pngtrn_perjalanan'){
			var field_add = '&is_ajax=47&data=delete_type_pngtrn_perjalanan&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'type_currency'){
			var field_add = '&is_ajax=47&data=delete_type_currency&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'type_perusahaan'){
			var field_add = '&is_ajax=47&data=delete_type_perusahaan&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'kategori_pekerjaan'){
			var field_add = '&is_ajax=47&data=delete_kategori_pekerjaan&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'type_sukubangsa'){
			var field_add = '&is_ajax=47&data=delete_type_sukubangsa&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'type_pendapatan'){
			var field_add = '&is_ajax=47&data=delete_type_pendapatan&type=delete_record&';
			var tb_name = 'umb_table_'+tk_type;
		} else if(tk_type == 'security_level'){
			var field_add = '&is_ajax=47&data=delete_security_level&type=delete_record&';
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
					$('.icon-spinner3').hide();
				} else {
					$('.delete-modal').modal('toggle');
					$('.icon-spinner3').hide();
					$('#'+tb_name).dataTable().api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				}
			}
		});
	});   
	
	$('#edit_setting_datail').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var field_id = button.data('field_id');
		var field_type = button.data('field_type');
		$('.icon-spinner3').show();
		if(field_type == 'type_document'){
			var field_add = '&data=ed_type_document&type=ed_type_document&';
		} else if(field_type == 'type_kontrak'){
			var field_add = '&data=ed_type_kontrak&type=ed_type_kontrak&';
		} else if(field_type == 'payment_method'){
			var field_add = '&data=ed_payment_method&type=ed_payment_method&';
		} else if(field_type == 'tingkat_pendidikan'){
			var field_add = '&data=ed_tingkat_pendidikan&type=ed_tingkat_pendidikan&';
		} else if(field_type == 'qualification_language'){
			var field_add = '&data=ed_qualification_language&type=ed_qualification_language&';
		} else if(field_type == 'qualification_skill'){
			var field_add = '&data=ed_qualification_skill&type=ed_qualification_skill&';
		} else if(field_type == 'type_award'){
			var field_add = '&data=ed_type_award&type=ed_type_award&';
		} else if(field_type == 'type_cuti'){
			var field_add = '&data=ed_type_cuti&type=ed_type_cuti&';
		} else if(field_type == 'type_peringatan'){
			var field_add = '&data=ed_type_peringatan&type=ed_type_peringatan&';
		} else if(field_type == 'type_penghentian'){
			var field_add = '&data=ed_type_penghentian&type=ed_type_penghentian&';
		} else if(field_type == 'type_biaya'){
			var field_add = '&data=ed_type_biaya&type=ed_type_biaya&';
		} else if(field_type == 'type_pekerjaan'){
			var field_add = '&data=ed_type_pekerjaan&type=ed_type_pekerjaan&';
		} else if(field_type == 'type_exit'){
			var field_add = '&data=ed_type_exit&type=ed_type_exit&';
		} else if(field_type == 'type_pngtrn_perjalanan'){
			var field_add = '&data=ed_type_pngtrn_perjalanan&type=ed_type_pngtrn_perjalanan&';
		} else if(field_type == 'type_currency'){
			var field_add = '&data=ed_type_currency&type=ed_type_currency&';
		} else if(field_type == 'type_perusahaan'){
			var field_add = '&data=ed_type_perusahaan&type=ed_type_perusahaan&';
		} else if(field_type == 'kategori_pekerjaan'){
			var field_add = '&data=ed_kategori_pekerjaan&type=ed_kategori_pekerjaan&';
		} else if(field_type == 'type_sukubangsa'){
			var field_add = '&data=ed_type_sukubangsa&type=ed_type_sukubangsa&';
		} else if(field_type == 'type_pendapatan'){
			var field_add = '&data=ed_type_pendapatan&type=ed_type_pendapatan&';
		} else if(field_type == 'security_level'){
			var field_add = '&data=ed_security_level&type=ed_security_level&';
		}
		
		
		var modal = $(this);
		$.ajax({
			url: site_url+'settings/read_constants/',
			type: "GET",
			data: 'jd=1'+field_add+'field_id='+field_id,
			success: function (response) {
				if(response) {
					$('.icon-spinner3').hide();
					$("#ajax_setting_info").html(response);
				}
			}
		});
	});
	
	$(".nav-tabs-link").click(function(){
		var profile_id = $(this).data('constant');
		var profile_block = $(this).data('constant-block');
		$('.list-group-item').removeClass('active');
		$('.current-tab').hide();
		$('#constant_'+profile_id).addClass('active');
		$('#'+profile_block).show();
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('input[name=token_type]').val($(this).data('token_type'));
	$('#delete_record').attr('action',site_url+'settings/delete_'+$(this).data('token_type')+'/'+$(this).data('record-id'))+'/';
});