$(document).ready(function(){			
	var umb_table = $('#umb_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"leads/list_leads_followup/"+$('#xlead_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	/* Edit training data */
	jQuery("#followup_info").submit(function(e){
	
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=16&data=followup_info&type=followup_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
				} else {
					umb_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
						$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					}, true);
					$('.icon-spinner3').hide();
					jQuery('#followup_info')[0].reset(); 
					jQuery('.save').prop('disabled', false);
				}
			}
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
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var leads_followup_id = button.data('leads_followup_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/read_leads_followup/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=leads_followup&leads_followup_id='+leads_followup_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});
});
$( document ).on( "click", ".delete", function() {
$('input[name=_token]').val($(this).data('record-id'));
$('#delete_record').attr('action',base_url+'/delete_lead_followup/'+$(this).data('record-id'))+'/';
});