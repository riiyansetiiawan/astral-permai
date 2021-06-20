$(document).ready(function() {
	var karyawan_id = jQuery('#karyawan_id').val();
	var month_year = jQuery('#month_year').val();
	var perusahaan_id = jQuery('#aj_perusahaan').val();
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"payroll/list_slipgaji/?karyawan_id="+karyawan_id+"&perusahaan_id="+perusahaan_id+"&month_year="+month_year,
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
		}
	});

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	jQuery("#aj_perusahaan").change(function(){
		jQuery.get(base_url+"/get_karyawans/"+jQuery(this).val(), function(data, status){
			jQuery('#ajax_karyawan').html(data);
		});
	});
	jQuery("#aj_perusahaanx").change(function(){
		jQuery.get(escapeHtmlSecure(base_url+"/get_perusahaan_p_locations/"+jQuery(this).val()), function(data, status){
			jQuery('#ajax_location').html(data);
		});
	});
// Month & Year
$('.month_year').datepicker({
	changeMonth: true,
	changeYear: true,
	showButtonPanel: true,
	dateFormat:'yy-mm',
	yearRange: '1970:' + new Date().getFullYear(),
	beforeShow: function(input) {
		$(input).datepicker("widget").addClass('hide-calendar');
	},
	onClose: function(dateText, inst) {
		var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
		var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
		$(this).datepicker('setDate', new Date(year, month, 1));
		$(this).datepicker('widget').removeClass('hide-calendar');
		$(this).datepicker('widget').hide();
	}

});

// delete

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

// detail modal data payroll
$('.modal_payroll_template').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var karyawan_id = button.data('karyawan_id');
	var modal = $(this);
	$.ajax({
		url: site_url+'payroll/read_payroll_template/',
		type: "GET",
		data: 'jd=1&is_ajax=11&mode=not_bayar&data=payroll_template&type=payroll_template&karyawan_id='+karyawan_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_payroll").html(response);
			}
		}
	});
});

/*$('.view-modal-data').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget);
var pay_id = button.data('pay_id');
var modal = $(this);
$.ajax({
	url: site_url+'payroll/payroll_template_approve/',
	type: "GET",
	data: 'jd=1&is_ajax=11&mode=not_bayar&data=payroll_approve&type=payroll_approve&pay_id='+pay_id,
	success: function (response) {
		if(response) {
			$("#ajax_modal").html(response);
		}
	}
});
});*/

// detail modal data  hourlywages
$('.modal_template_upahhperjam').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var karyawan_id = button.data('karyawan_id');
	var payment_date = $('#month_year').val();
	var perusahaan_id = button.data('perusahaan_id');
	var modal = $(this);
	$.ajax({
		url: site_url+'payroll/read_upahperjam_template/',
		type: "GET",
		data: 'jd=1&is_ajax=11&mode=not_bayar&data=slipgaji_perjam&type=read_hourly_payment&karyawan_id='+karyawan_id+'&pay_date='+payment_date+'&perusahaan_id='+perusahaan_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_upahhperjam").html(response);
			}
		}
	});
});

// detail modal data
$('.detail_modal_data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var karyawan_id = button.data('karyawan_id');
	var pay_id = button.data('pay_id');
	var perusahaan_id = button.data('perusahaan_id');
	var modal = $(this);
	$.ajax({
		url: site_url+'payroll/view_melakukan_pembayaran/',
		type: "GET",
		data: 'jd=1&is_ajax=11&mode=modal&data=pay_payment&type=pay_payment&krywn_id='+karyawan_id+'&pay_id='+pay_id+'&perusahaan_id='+perusahaan_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_details").html(response);
			}
		}
	});
});


// detail modal data
$('.emo_monthly_pay').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var karyawan_id = button.data('karyawan_id');
	var payment_date = $('#month_year').val();
	var perusahaan_id = button.data('perusahaan_id');
	var modal = $(this);
	$.ajax({
		url: site_url+'payroll/pay_gaji/',
		type: "GET",
		data: 'jd=1&is_ajax=11&data=payment&type=monthly_payment&karyawan_id='+karyawan_id+'&pay_date='+payment_date+'&perusahaan_id='+perusahaan_id,
		success: function (response) {
			if(response) {
				$("#emo_monthly_pay_aj").html(response);
			}
		}
	});
});

$('.emo_hourly_pay').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var karyawan_id = button.data('karyawan_id');
	var payment_date = $('#month_year').val();
	var perusahaan_id = button.data('perusahaan_id');
	var modal = $(this);
	$.ajax({
		url: site_url+'payroll/pay_hourly/',
		type: "GET",
		data: 'jd=1&is_ajax=11&data=hourly_payment&type=fhourly_payment&karyawan_id='+karyawan_id+'&pay_date='+payment_date+'&perusahaan_id='+perusahaan_id,
		success: function (response) {
			if(response) {
				$("#emo_hourly_pay_aj").html(response);
			}
		}
	});
});
// bulk payments
$("#bulk_payment").submit(function(e){
	e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$('.icon-spinner3').show();
	var karyawan_id = jQuery('#karyawan_id').val();
	var bmonth_year = jQuery('#bmonth_year').val();
	var perusahaan_id = jQuery('#aj_perusahaan').val()
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&add_type=payroll&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('.save').prop('disabled', false);
				$('.icon-spinner3').hide();
			} else {
				var umb_table3 = $('#umb_table').dataTable({
					"bDestroy": true,
					"ajax": {
						url : site_url+"payroll/list_slipgaji/?karyawan_id="+karyawan_id+"&perusahaan_id="+perusahaan_id+"&month_year="+bmonth_year,
						type : 'GET'
					},
					"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
					}
				});
				umb_table3.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
			}
		}
	});
});

$("#user_gaji_template").submit(function(e){
	e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$('.icon-spinner3').show();
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&edit_type=payroll&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('.save').prop('disabled', false);
				$('.icon-spinner3').hide();
			} else {
				umb_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
			}
		}
	});
});

/* Set gaji Details*/
$("#set_gaji_details").submit(function(e){

	e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	var karyawan_id = jQuery('#karyawan_id').val();
	var month_year = jQuery('#month_year').val();
	var perusahaan_id = jQuery('#aj_perusahaan').val();
// On page load: datatable
$('#p_month').html(month_year);
var umb_table2 = $('#umb_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"payroll/list_slipgaji/?karyawan_id="+karyawan_id+"&perusahaan_id="+perusahaan_id+"&month_year="+month_year,
		type : 'GET'
	},
	"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
	}
});
umb_table2.api().ajax.reload(function(){ 
}, true);
});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete_slipgaji/'+$(this).data('record-id'))+'/';
});
