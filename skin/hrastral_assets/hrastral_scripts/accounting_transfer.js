$(document).ready(function() {	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	
	//$('#description').trumbowyg();
	
	$(".from-account").change(function(){
		var ac_balance = $(this).find('option:selected').attr('saldo-account');
		$('#acc_saldo').html(' Available Balance: '+ac_balance);
		$('#saldo_account').val(ac_balance);
		$('#acc_saldo').show();
	});
	
	$("#umb-form").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=transfer&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					window.location = base_url + '/transaksii';
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});