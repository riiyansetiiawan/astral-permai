$(function() {

  // tugas Kanban Board
	dragula([
		document.getElementById('first-notstarted'),
		document.getElementById('first-inprogress'),
		document.getElementById('first-completed'),
		document.getElementById('first-cancelled'),
		document.getElementById('first-hold'),
	])
	.on('drag', function(event) {
		var infieldid =  event.dataset.id;
		var infieldst = event.dataset.status;
		
	}).on('dragend', function(el,target) {
		var xfieldid =  el.dataset.id;
		var xfieldst = $('.'+el.id+'_'+xfieldid).parent( ".kanban-box" ).data('status');
			$.get(site_url+"project/update_status_scrum_board_tugas/"+xfieldid+"/"+xfieldst, function(data, status){
				toastr.success(data.result);
		});
	});
  // RTL
  if ($('html').attr('dir') === 'rtl') {
    $('.kanban-board-actions .dropdown-menu').removeClass('dropdown-menu-right');
  }

});
$(document).ready(function() {
	// add
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var status_tugas = button.data('status_tugas');
		var modal = $(this);
	$.ajax({
		url : site_url+"project/get_scrumboard_tugas/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=scrum_board&status_tugas='+status_tugas,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
});