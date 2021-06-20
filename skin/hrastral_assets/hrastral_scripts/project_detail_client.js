$(document).ready(function() {

var umb_attachment_table = $('#umb_attachment_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"projects/list_attachment/"+$('#client_project_id').val(),
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});
$('#description').trumbowyg();

$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	
$(".nav-tabs-link").click(function(){
		var profile_id = $(this).data('config');
		var profile_block = $(this).data('config-block');
		$('.nav-link').removeClass('active');
		$('.current-tab').hide();
		$('#pj_data_'+profile_id).addClass('active');
		$('#'+profile_block).show();
	});

// edit
$('.view-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var bug_id = button.data('bug_id');
	var modal = $(this);
$.ajax({
	url :  base_url+"/read_bug/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=bug&bug_id='+bug_id,
	success: function (response) {
		if(response) {
			$("#ajax_modal_view").html(response);
		}
	}
	});
});

$('.edit-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var tugas_id = button.data('tugas_id');
	var mname = button.data('mname');
	var modal = $(this);
$.ajax({
	url : site_url+"timesheet/read_record_tugas/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=project_tugas&tugas_id='+tugas_id+"&mname="+mname,
	success: function (response) {
		if(response) {
			$("#ajax_modal").html(response);
		}
	}
	});
});

var umb_table = $('#umb_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"projects/list_project_tugas/"+$('#client_project_id').val(),
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});


});