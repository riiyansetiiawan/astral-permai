$(document).ready(function() {
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"laporans/list_laporan_slipgaji/"+$('#aj_perusahaan').val()+"/"+$('#karyawan_id').val()+"/"+$('#month_year').val(),
			type : 'GET'
		},
		dom: 'lBfrtip',
		"buttons": [{
			extend: 'csv',
			exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5]
			}
		}, {
			extend: 'excel',
			exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5]
			}
		}, {
			extend: 'pdfHtml5',
			exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5]
			}
		}, {
			extend: 'print',
			exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5]
			}
            },], 
            "fnDrawCallback": function(settings){
            	$('[data-toggle="tooltip"]').tooltip();          
            },
        });

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	jQuery("#aj_perusahaan").change(function(){
		jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
			jQuery('#ajax_karyawan').html(data);
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
			data: obj.serialize()+"&is_ajax=1&type=laporan_slipgaji&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
					Ladda.stopAll();
				} else {
					var aj_perusahaan = $('#aj_perusahaan').val();
					var karyawan_id = $('#karyawan_id').val();
					var month_year = $('#month_year').val();
					var umb_table2 = $('#umb_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : site_url+"laporans/list_laporan_slipgaji/"+aj_perusahaan+"/"+karyawan_id+"/"+month_year,
							type : 'GET'
						},
						dom: 'lBfrtip',
						"buttons": [{
							extend: 'csv',
							exportOptions: {
								columns: [ 0, 1, 2, 3, 4, 5]
							}
						}, {
							extend: 'excel',
							exportOptions: {
								columns: [ 0, 1, 2, 3, 4, 5]
							}
						}, {
							extend: 'pdfHtml5',
							exportOptions: {
								columns: [ 0, 1, 2, 3, 4, 5]
							}
						}, {
							extend: 'print',
							exportOptions: {
								columns: [ 0, 1, 2, 3, 4, 5]
							}
					},], 
					"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
					},
				});
					toastr.success(JSON.result);
					umb_table2.api().ajax.reload(function(){ 
						Ladda.stopAll();
					}, true);
					$('.icon-spinner3').hide();
					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});
