$(document).ready(function(){			
	
	
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var field_id = button.data('field_id');
		var field_tpe = button.data('field_type');
		if(field_tpe == 'document'){
			var field_add = '&data=krywn_document&type=krywn_document&';
		} else if(field_tpe == 'imgdocument'){
			var field_add = '&data=e_imgdocument&type=e_imgdocument&';
		} else if(field_tpe == 'license_perusahaans_kadaluarsaa'){
			var field_add = '&data=edocument_id&type=edocument_id&';
		} else if(field_tpe == 'garansi_assets_kadaluarsa'){
			var field_add = '&data=eassets_warranty&type=eassets_warranty&';
		}
		var modal = $(this);
		$.ajax({
			url: site_url+'karyawans/dialog_exp_'+field_tpe+'/',
			type: "GET",
			data: 'jd=1'+field_add+'field_id='+field_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal").html(response);
				}
			}
		});
   });
	
	// On page load: table_kontaks
	 var umb_table_kontak = $('#umb_table_perusahaan_license').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"karyawans/list_licence_perusahaan_exp/"+$('#user_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	// On page load > documents
	var umb_table_immigration = $('#umb_table_imgdocument').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"karyawans/list_immigration_kadaluarsa/"+$('#user_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	// On page load > documents
	var umb_table_document = $('#umb_table_document').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"karyawans/list_documents_kadaluarsa/"+$('#user_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });	
	// On page load > documents
	var umb_table_assets_warranty = $('#umb_table_assets_warranty').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"karyawans/list_garansi_assets/"+$('#user_id').val(),
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });	  
	$(".nav-tabs-link").click(function(){
		var profile_id = $(this).data('constant');
		var profile_block = $(this).data('constant-block');
		$('.list-group-item').removeClass('active');
		$('.current-tab').hide();
		$('#constant_'+profile_id).addClass('active');
		$('#'+profile_block).show();
	});
});	