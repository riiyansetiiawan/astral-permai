$(document).ready(function() {
	
	var umb_table_report = $('#umb_table_report').dataTable({
		"bDestroy": true,
		"ajax": {
			url : base_url+'/list_laporan_advance_gaji/',
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var karyawan_id = button.data('karyawan_id');
		var modal = $(this);
		$.ajax({
			url :  base_url+"/read_laporan_advance_gaji/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=view_laporan_advance_gaji&karyawan_id='+karyawan_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal_view").html(response);
				}
			}
		});
	});
});