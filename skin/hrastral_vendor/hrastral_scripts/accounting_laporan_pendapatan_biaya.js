$(document).ready(function() {
   var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	var umb_table = $('#umb_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : site_url+"accounting/list_laporan_pendapatan_biaya/?from_date="+from_date+"&to_date="+to_date,
			type : 'GET'
		},
		dom: 'lBfrtip',
		"buttons": ['copy', 'csv', 'excel', 'pdf', 'print'], 
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	
	/* report */
	$("#hrm-form").submit(function(e){
		
		e.preventDefault();
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var account_id = $('#account_id').val();
		var type_id = $('#type_id').val();
		var umb_table2 = $('#umb_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"accounting/list_laporan_pendapatan_biaya/?from_date="+from_date+"&to_date="+to_date,
				type : 'GET'
			},
			dom: 'lBfrtip',
        	"buttons": ['copy', 'csv', 'excel', 'pdf', 'print'], 
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		Ladda.stopAll();
	});
});

$(document).on('click','.pdf-btn',function(){
var pdf = new jsPDF('l', 'pt', 'a4');
    pdf.setFont("times");
    pdf.text(40,60,$(".report-heading h4").html());
    pdf.setFontSize(12);
    pdf.text(40,75,$(".report-heading p").html());
    source = $('#Table-div')[0]; //table Id
    specialElementHandlers = { 
        '#bypassme': function (element, renderer) {
            return true
        }
    };
    margins = { //table margins and width
        top: 80,
        bottom: 60,
        left: 40,
        width: 522
    };
    pdf.fromHTML(
    source, 
    margins.left,
    margins.top, { 
        'width': margins.width, 
        'elementHandlers': specialElementHandlers
    },

    function (dispose) {
        pdf.save('Report.pdf'); //Filename
    }, margins);

});