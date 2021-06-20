$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/list_training/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
//$('#description').trumbowyg();
jQuery("#aj_perusahaan").change(function(){
	jQuery('#trainer_option').prop('disabled', false);
	jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
		jQuery('#ajax_karyawan').html(data);
	});
});
jQuery("#trainer_option").change(function(){
	if(jQuery(this).val() == 2) {
		jQuery.get(base_url+"/get_all_trainers/"+jQuery(this).val(), function(data, status){
			jQuery('#trainers_data').html(data);
		});
	} else {
		jQuery.get(base_url+"/get_internal_karyawan/"+jQuery('#aj_perusahaan').val(), function(data, status){
			jQuery('#trainers_data').html(data);
		});
	}
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
	var training_id = button.data('training_id');
	var modal = $(this);
	$.ajax({
		url : base_url+"/read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=training&training_id='+training_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
	});
});

 
$("#umb-form").submit(function(e){
	var fd = new FormData(this);
	var obj = $(this), action = obj.attr('name');
	fd.append("is_ajax", 1);
	fd.append("add_type", 'training');
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
				Ladda.stopAll();
			} else {
				umb_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('.icon-spinner3').hide();
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				$('#umb-form')[0].reset(); 
				$('.add-form').removeClass('show');
				$('.select2-selection__rendered').html('--Select--');
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			}
		},
		error: function() 
		{
			toastr.error(JSON.error);
			$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
			$('.icon-spinner3').hide();
			$('.save').prop('disabled', false);
			Ladda.stopAll();
		} 	        
	});
});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'))+'/';
});