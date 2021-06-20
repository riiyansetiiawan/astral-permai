$(document).ready(function() {	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
});
$(document).ready(function() { 
  var table = $('#umb_table').DataTable( {       
		scrollX:        true,
		scrollCollapse: false,
		autoWidth:         true,  
		paging:         true,    
		"bSort" : false,
		columnDefs: [
			{ "width": "240px", "targets": [0] },
		  ],
		  dom: 'lBfrtip',
		  "buttons": ['csv', 'excel', 'print']		
	});	
	jQuery("#aj_perusahaan").change(function(){
		jQuery.get(base_url+"/get_timesheet_karyawans/"+jQuery(this).val(), function(data, status){
			jQuery('#ajax_karyawan').html(data);
		});
	});
	$('.d_month_year').datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat:'yy-mm',
		yearRange: '2019:' + new Date().getFullYear(),
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
});