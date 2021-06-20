$(document).ready(function() {
	
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+"/list_pengunduran_diri/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
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
			data: obj.serialize()+"&is_ajax=2&form="+action,
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
		var pengunduran_diri_id = button.data('pengunduran_diri_id');
		var modal = $(this);
		$.ajax({
			url : base_url+"/read/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=pengunduran_diri&pengunduran_diri_id='+pengunduran_diri_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
	});
	$('#modals-slide').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var pengunduran_diri_id = button.data('pengunduran_diri_id');
		var modal = $(this);
		$.ajax({
			url : base_url+"/read/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=view_pengunduran_diri&pengunduran_diri_id='+pengunduran_diri_id,
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
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=pengunduran_diri&form="+action,
			cache: false,
			success: function (JSON) {
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
					$('.add-form').removeClass('show');
					$('.select2-selection__rendered').html('--Select--');
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
	$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});