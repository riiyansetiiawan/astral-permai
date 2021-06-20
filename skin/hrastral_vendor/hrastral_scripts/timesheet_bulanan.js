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
	});	
	jQuery("#aj_perusahaan_mn").change(function(){
		jQuery.get(base_url+"/get_timesheet_karyawans/"+jQuery(this).val(), function(data, status){
			jQuery('#ajax_mn_karyawan').html(data);
		});
	});
});
/*$(function() {

  $('#calendar').fullCalendar({
    defaultView: 'timelineMonth',
    header: {
      left: 'prev,next',
      center: 'title',
      right: 'timelineMonth'
    },
    resourceColumns: [
        {
          labelText: 'karyawan',
          field: 'title'
        },
        {
          labelText: 'Worked Days',
          field: 'occupancy'
        }
      ],
    resources: site_url+'timesheet/timesheet_bulanan_karyawans/',
    events: site_url+'timesheet/timesheet_bulanan_resources/'
  });

});	*/