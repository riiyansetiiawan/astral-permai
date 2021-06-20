$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"user/list_slipgaji_karyawan/",
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 	
	
	// detail modal data
	$('.detail_modal_data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var karyawan_id = button.data('karyawan_id');
		var pay_id = button.data('pay_id');
		var modal = $(this);
		$.ajax({
			url: site_url+'payroll/view_melakukan_pembayaran/',
			type: "GET",
			data: 'jd=1&is_ajax=11&mode=modal&data=pay_payment&type=pay_payment&krywn_id='+karyawan_id+'&pay_id='+pay_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal_details").html(response);
				}
			}
		});
	});
});