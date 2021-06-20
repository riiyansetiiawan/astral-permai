$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"timesheet/list_kehadiran/?tanggal_kehadiran="+$('#tanggal_kehadiran').val(),
			type : 'GET'
		},
		dom: 'lBfrtip',
		"buttons": ['csv', 'excel', 'pdf', 'print'], 
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var ipaddress = button.data('ipaddress');
		var uid = button.data('uid');
		var start_date = button.data('start_date');
		var att_type = button.data('att_type');
		var modal = $(this);
		$.ajax({
			url :  site_url+"timesheet/read_map_info/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=view_map&type=view_map&ipaddress='+ipaddress+'&uid='+uid+'&start_date='+start_date+'&att_type='+att_type,
			success: function (response) {
				if(response) {
					$("#ajax_modal_view").html(response);
				}
			}
		});
	});

	$('.tanggal_kehadiran').datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate: '0',
		dateFormat:'yy-mm-dd',
		altField: "#date_format",
		altFormat: js_date_format,
		yearRange: '1970:' + new Date().getFullYear(),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
	});
	$("#kehadiran_daily_report").submit(function(e){

		e.preventDefault();
		var tanggal_kehadiran = $('#tanggal_kehadiran').val();
		var date_format = $('#date_format').val();
		if(tanggal_kehadiran == ''){
			toastr.error('Please select date.');
		} else {
			$('#hadir_tanggal').html(date_format);
			var umb_table2 = $('#umb_table').dataTable({
				"bDestroy": true,
				"ajax": {
					url : site_url+"timesheet/list_kehadiran/?tanggal_kehadiran="+$('#tanggal_kehadiran').val()+"&location_id="+$('#location_id').val(),
					type : 'GET'
				},
			/*dom: 'lBfrtip',
			"buttons": ['csv', 'excel', 'pdf', 'print'], 
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}*/
	});
			umb_table2.api().ajax.reload(function(){ }, true);
		}
	});

});