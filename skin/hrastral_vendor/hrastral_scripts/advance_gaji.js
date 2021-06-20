$(document).ready(function() {
   var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+'/list_advance_gaji/',
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
		
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	
	jQuery("#aj_perusahaan").change(function(){
		jQuery.get(base_url+"/get_advance_karyawans/"+jQuery(this).val(), function(data, status){
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
					toastr.error(JSON.error);
					Ladda.stopAll();
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				} else {
					$('.delete-modal').modal('toggle');
					umb_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
						Ladda.stopAll();
					}, true);		
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);					
				}
			}
		});
	});
	
	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var advance_gaji_id = button.data('advance_gaji_id');
		var modal = $(this);
	$.ajax({
		url :  base_url+"/read_advance_gaji/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=advance_gaji&advance_gaji_id='+advance_gaji_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
	
	$('#modals-slide').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var advance_gaji_id = button.data('advance_gaji_id');
		var modal = $(this);
	$.ajax({
		url :  base_url+"/read_advance_gaji/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_advance_gaji&advance_gaji_id='+advance_gaji_id,
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
				data: obj.serialize()+"&is_ajax=1&add_type=advance_gaji&form="+action,
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
						$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
						$('.icon-spinner3').hide();
						$('.add-form').removeClass('show');
						$('#umb-form')[0].reset(); 
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					}
				}
			});
		});
		$(".pengurangan_satu_kali").change(function(){
			if($(this).val()==1){
				$('#angsuran_bulanan').attr('disabled',true);
				$('#angsuran_bulanan').val(0);
			} else {
				$('#angsuran_bulanan').attr('disabled',false);
			}
		});	
 
//	$("#umb-form").submit(function(e){});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete_advance_gaji/'+$(this).data('record-id'));
});