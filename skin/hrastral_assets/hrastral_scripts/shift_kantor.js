$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"timesheet/list_shift_kantor/",
			type : 'GET'
		},
		
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('.clockpicker').clockpicker();

	var input = $('.timepicker').clockpicker({
		placement: 'bottom',
		align: 'left',
		autoclose: true,
		'default': 'now'
	});

	$(".clear-time").click(function(){
		var clear_id  = $(this).data('clear-id');
		$(".clear-"+clear_id).val('');
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

// edit
$('.edit-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var shift_kantor_id = button.data('shift_kantor_id');
	var modal = $(this);
	$.ajax({
		url : site_url+"timesheet/read_record_shift/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=shift&shift_kantor_id='+shift_kantor_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
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
		data: obj.serialize()+"&is_ajax=1&add_type=shift_kantor&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
			} else {
				umb_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				$('.add-form').removeClass('in');
				$('.select2-selection__rendered').html('--Select--');
				$('#umb-form')[0].reset(); 
				$('.save').prop('disabled', false);
			}
		}
	});
});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',site_url+'timesheet/delete_shift/'+$(this).data('record-id'));
});

$( document ).on( "click", ".default-shift", function() {
	var shiftkantor_id = $(this).data('shift_kantor_id');
	$.ajax({
		type: "GET",
		url: site_url+"timesheet/default_shift/?shift_kantor_id="+shiftkantor_id,
		success: function (JSON) {
			var umb_table2 = $('#umb_table').dataTable({
				"bDestroy": true,
				"ajax": {
					url : site_url+"timesheet/list_shift_kantor/",
					type : 'GET'
				},
				"fnDrawCallback": function(settings){
					$('[data-toggle="tooltip"]').tooltip();          
				}
			});
			umb_table2.api().ajax.reload(function(){ 
				toastr.success(JSON.result);
			}, true);
		}
	});
});
