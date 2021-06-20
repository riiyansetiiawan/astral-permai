$(document).ready(function() {
var umb_table = $('#umb_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"timesheet/list_tugas/",
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	}
});

$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
$('#description').trumbowyg();
jQuery("#aj_perusahaan").change(function(){
	jQuery.get(base_url+"/get_project_perusahaan/"+jQuery(this).val(), function(data, status){
		jQuery('#ajax_project').html(data);
	});
	jQuery.get(base_url+"/get_perusahaan_karyawans/"+jQuery(this).val(), function(data, status){
		jQuery('#ajax_karyawan').html(data);
	});
});
// Date
$('.date').datepicker({
  changeMonth: true,
  changeYear: true,
  dateFormat:'yy-mm-dd',
  yearRange: new Date().getFullYear() + ':' + (new Date().getFullYear() + 10)
});

$("#delete_record").submit(function(e){

e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=2&type=delete&form="+action,
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
$('.edit-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var tugas_id = button.data('tugas_id');
	var mname = button.data('mname');
	var modal = $(this);
$.ajax({
	url : base_url+"/read_record_tugas/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=tugas&tugas_id='+tugas_id+"&mname="+mname,
	success: function (response) {
		if(response) {
			$("#ajax_modal").html(response);
		}
	}
	});
});

 
$("#umb-form").submit(function(e){
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&add_type=tugas&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
			} else {
				umb_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
				$('.add-form').removeClass('in');
				$('.select2-selection__rendered').html('--Select--');
				$('#umb-form')[0].reset(); 
				$('.save').prop('disabled', false);
			}
		}
	});
});
});
$( document ).on( "click", ".delete", function() {
$('input[name=_token]').val($(this).data('record-id'));
$('#delete_record').attr('action',site_url+'timesheet/delete_tugas/'+$(this).data('record-id'));
});
