$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"meetings/list_meetings/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	$('#event_note').trumbowyg({
		btns: [
		['formatting'],
		'btnGrp-semantic',
		['superscript', 'subscript'],
		['removeformat'],
		],
		autogrowOnEnter: true
	});
	var isRtl = $('body').attr('dir') === 'rtl' || $('html').attr('dir') === 'rtl';
	$('#minicolors-brightness').minicolors({
		control:  'brightness',
		position: 'top ' + (isRtl ? 'right' : 'left'),
	});
	jQuery("#aj_perusahaan").change(function(){
		jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
			jQuery('#ajax_karyawan').html(data);
		});
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
	var meeting_id = button.data('meeting_id');
	var modal = $(this);
	$.ajax({
		url : site_url+"meetings/read_record_meeting/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=meeting&meeting_id='+meeting_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
	});
});
$('#modals-slide').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var meeting_id = button.data('meeting_id');
	var modal = $(this);
	$.ajax({
		url : site_url+"meetings/read_record_meeting/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_meeting&meeting_id='+meeting_id,
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
		data: obj.serialize()+"&is_ajax=1&add_type=meeting&form="+action,
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
				$('.select2-selection__rendered').html('--Select--');
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			}
		}
	});
});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',site_url+'meetings/delete_meeting/'+$(this).data('record-id'));
});