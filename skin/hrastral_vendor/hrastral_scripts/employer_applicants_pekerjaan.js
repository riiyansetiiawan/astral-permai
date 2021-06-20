$(document).ready(function() {
var umb_table = $('#umb_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : base_url+"/list_applicants_employer/"+$('#employer_id').val(),
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});
$('.view-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var application_id = button.data('application_id');
	var modal = $(this);
$.ajax({
	url :  base_url+"/read_application/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=view_application&application_id='+application_id,
	success: function (response) {
		if(response) {
			$("#ajax_modal_view").html(response);
		}
	}
	});
});
$('.add-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var application_id = button.data('application_id');
	var modal = $(this);
$.ajax({
	url :  base_url+"/read_application/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&type=employer_applicant&data=view_application_status&edit=status&application_id='+application_id,
	success: function (response) {
		if(response) {
			$("#add_ajax_modal").html(response);
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
			} else {
				$('.delete-modal').modal('toggle');
				umb_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);							
			}
		}
	});
});	
});
$( document ).on( "click", ".delete", function() {
$('input[name=_token]').val($(this).data('record-id'));
$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'))+'/';
});
