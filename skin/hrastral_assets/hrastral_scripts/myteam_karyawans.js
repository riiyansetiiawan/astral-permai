$(document).ready(function() {
	var umb_my_team_table = $('#umb_my_team_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/list_myteam_karyawans/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 

// Date
$('.tanggal_lahir').datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat:'yy-mm-dd',
	yearRange: '1940:' + new Date().getFullYear()
});
// Date
$('.tanggal_bergabung').datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat:'yy-mm-dd',
	yearRange: '1940:' + ':' + new Date().getFullYear()
});


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
	var peringatan_id = button.data('peringatan_id');
	var modal = $(this);
	$.ajax({
		url : base_url+"/read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=peringatan&peringatan_id='+peringatan_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
	});
});
$("#ihr_report").submit(function(e){
	
	e.preventDefault();
		//$('#hrload-img').show();
		//toastr.info(processing_request);
		var umb_table2 = $('#umb_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"karyawans/list_karyawans/?ihr=true&perusahaan_id="+$('#filter_perusahaan').val()+"&location_id="+$('#filter_location').val()+"&department_id="+$('#filter_department').val()+"&penunjukan_id="+$('#filter_penunjukan').val(),
				type : 'GET'
			},
			"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		umb_table2.api().ajax.reload(function(){
			//toastr.clear();
//$('#hrload-img').hide();
toastr.success(request_submitted);
}, true);
	});
jQuery("#aj_perusahaan").change(function(){
	jQuery.get(escapeHtmlSecure(base_url+"/get_perusahaan_elocations/"+jQuery(this).val()), function(data, status){
		jQuery('#ajax_location').html(data);
	});
	jQuery.get(escapeHtmlSecure(base_url+"/get_perusahaan_shifts_kantor/"+jQuery(this).val()), function(data, status){
		jQuery('#ajax_shift_kantor').html(data);
	});
});
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

$("#umb-form").submit(function(e){
	var fd = new FormData(this);
	var obj = $(this), action = obj.attr('name');
	fd.append("is_ajax", 1);
	fd.append("add_type", 'karyawan');
	fd.append("form", action);
	e.preventDefault();
	$('.icon-spinner3').show();
	$('.save').prop('disabled', true);
	//$('#hrload-img').show();
	//toastr.info(processing_request);
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
				//toastr.clear();
//$('#hrload-img').hide();
toastr.error(JSON.error);
$('.icon-spinner3').hide();
$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
$('.save').prop('disabled', false);
} else {
				//toastr.success(JSON.result);
				$('.icon-spinner3').hide();
				umb_my_team_table.api().ajax.reload(function(){ 
					//toastr.clear();
//$('#hrload-img').hide();
toastr.success(JSON.result);
$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
}, true);
				$('.add-form').removeClass('in');
				$('.select2-selection__rendered').html('--Select--');
				$('#umb-form')[0].reset(); 
				$('.save').prop('disabled', false);
			}
		},
		error: function() 
		{
			//toastr.clear();
//$('#hrload-img').hide();
toastr.error(JSON.error);
$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
$('.icon-spinner3').hide();
$('.save').prop('disabled', false);
} 	        
});
});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});