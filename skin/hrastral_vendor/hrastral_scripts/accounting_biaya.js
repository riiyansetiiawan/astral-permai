$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+'/list_biaya/',
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
		jQuery('#option_penerima_pembayaran').prop('disabled', false);
		jQuery.get(base_url+"/get_perusahaan_types_biaya/"+jQuery(this).val(), function(data, status){
			jQuery('#ajax_kategori').html(data);
		});
		jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
			jQuery('#data_penerima_pembayaran').html(data);
		});
	});
	jQuery("#option_penerima_pembayaran").change(function(){
		if(jQuery(this).val() == 2) {
			jQuery.get(base_url+"/get_all_penerima_pembayaran/"+jQuery(this).val(), function(data, status){
				jQuery('#data_penerima_pembayaran').html(data);
			});
		} else {
			jQuery.get(base_url+"/get_karyawans/"+jQuery('#aj_perusahaan').val(), function(data, status){
				jQuery('#data_penerima_pembayaran').html(data);
			});
		}
	});
	$(".from-account").change(function(){
		var ac_balance = $(this).find('option:selected').attr('saldo-account');
		$('#acc_saldo').html(' Available Balance: '+ac_balance);
		$('#saldo_account').val(ac_balance);
		$('#acc_saldo').show();
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
		var biaya_id = button.data('biaya_id');
		var modal = $(this);
		$.ajax({
			url :  base_url+"/read_biaya/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=biaya&biaya_id='+biaya_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
	});
	
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var deposit_id = button.data('deposit_id');
		var modal = $(this);
		$.ajax({
			url :  base_url+"/read_deposit/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=view_award&deposit_id='+deposit_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal_view").html(response);
				}
			}
		});
	});
	
	/* Update logo */
	$("#umb-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("add_type", 'biaya');
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
					Ladda.stopAll();
				} else {
					umb_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.add-form').removeClass('show');
					$('.select2-selection__rendered').html('--Select--');
					$('#umb-form')[0].reset(); 
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				Ladda.stopAll();
				$('.save').prop('disabled', false);
			} 	        
		});
	});

	
//	$("#umb-form").submit(function(e){});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete_biaya/'+$(this).data('record-id'));
});