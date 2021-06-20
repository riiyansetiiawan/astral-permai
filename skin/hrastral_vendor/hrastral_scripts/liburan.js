$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"timesheet/list_liburan/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
//filter
$("#ihr_report").submit(function(e){
	
	e.preventDefault();
	var umb_table2 = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"timesheet/list_liburan/?ihr=true&perusahaan_id="+$('#aj_perusahaanf').val()+"&status="+$('#status').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	umb_table2.api().ajax.reload(function(){
		Ladda.stopAll(); }, true);
});

$("#delete_record").submit(function(e){

	e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=2&type=delete&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				toastr.error(JSON.error);
				Ladda.stopAll();
			} else {
				$('.delete-modal').modal('toggle');
				umb_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);	
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				Ladda.stopAll();						
			}
		}
	});
});

// edit
$('.edit-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var libur_id = button.data('libur_id');
	var modal = $(this);
	$.ajax({
		url : site_url+"timesheet/read_record_libur/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=libur&libur_id='+libur_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
	});
});
$('#modals-slide').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var libur_id = button.data('libur_id');
	var modal = $(this);
	$.ajax({
		url : site_url+"timesheet/read_record_libur/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_libur&libur_id='+libur_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
	});
});

 
$("#umb-form").submit(function(e){
	e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&add_type=libur&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			} else {
				umb_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				$('.add-form').fadeOut('slow');
				$('#umb-form')[0].reset(); 
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			}
		}
	});
});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',site_url+'timesheet/delete_libur/'+$(this).data('record-id'));
});