$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/list_department/",
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
						$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					}, true);							
				}
			}
		});
	});
	
	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var department_id = button.data('department_id');
		var modal = $(this);
		$.ajax({
			url : base_url+"/read/",
			type: "GET",
			data: escapeHtmlSecure('jd=1&is_ajax=1&mode=modal&data=department&department_id='+department_id),
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
	});
	
	jQuery("#aj_perusahaan").change(function(){
		jQuery.get(escapeHtmlSecure(base_url+"/get_karyawans/"+jQuery(this).val()), function(data, status){
			jQuery('#ajax_karyawan').html(data);
		});
	});
	jQuery("#aj_perusahaan").change(function(){
		jQuery.get(escapeHtmlSecure(base_url+"/get_locations_perusahaan/"+jQuery(this).val()), function(data, status){
			jQuery('#ajax_location').html(data);
		});
	});
	
	
	$("#umb-form").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: base_url+'/add_department/',
			data: obj.serialize()+"&is_ajax=1&add_type=department&form="+action,
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
						$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					}, true);
					$('.icon-spinner3').hide();
					$('#umb-form')[0].reset(); 
					$('.select2-selection__rendered').html('--Select--');
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	var delUrl = base_url+'/delete/'+$(this).data('record-id');
	$('#delete_record').attr('action',escapeHtmlSecure(delUrl));
});
