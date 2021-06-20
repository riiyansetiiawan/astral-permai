$(document).ready(function(){			
	/* Edit training data */
	$("#update_status").submit(function(e){
	
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$(".icon-spinner3").show();
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&edit_type=update_status&update=1&view=training&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$(".icon-spinner3").hide();
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$(".icon-spinner3").hide();
					$('.save').prop('disabled', false);				
				}
			}
		});
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
});