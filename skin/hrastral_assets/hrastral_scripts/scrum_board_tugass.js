//Init
init();

//Button Functions------------------------------------------
function init() {
  $(".button-notstarted").on("click", function() {
    if (!($(this).closest(".notstarted").length > 0)) {
      $(this).parents(".input-group").appendTo(".notstarted").css({
        "background-color": "",
        "border": ""
      });
	    $('#hrload-img').show();
		var tugas_id = $(this).data('tugas-id');
		var status_tugas = $(this).data('tugas-status');
		jQuery.get(site_url+"project/update_status_scrum_board_tugas/"+tugas_id+"/"+status_tugas, function(data, status){
			$('#hrload-img').hide();
		});
    }
  });
  $(".button-progress").on("click", function() {
    if (!($(this).closest(".in-progress").length > 0)) {
      $(this).parents(".input-group").appendTo(".in-progress").css({
        "background-color": "#bbe9ff",
        "border": "none"
      });
		$('#hrload-img').show();
		var tugas_id = $(this).data('tugas-id');
		var status_tugas = $(this).data('tugas-status');
		jQuery.get(site_url+"project/update_status_scrum_board_tugas/"+tugas_id+"/"+status_tugas, function(data, status){
			$('#hrload-img').hide();
		});
    }
  });
  $(".button-complete").on("click", function() {
    if (!($(this).closest(".complete").length > 0)) {
      $(this).parents(".input-group").appendTo(".complete").css({
        "background-color": "#cfffd0",
        "border": "none"
      });
	  	$('#hrload-img').show();
		var tugas_id = $(this).data('tugas-id');
		var status_tugas = $(this).data('tugas-status');
		jQuery.get(site_url+"project/update_status_scrum_board_tugas/"+tugas_id+"/"+status_tugas, function(data, status){
			$('#hrload-img').hide();
		});
    }
  });
  $(".button-cancelled").on("click", function() {
    if (!($(this).closest(".cancelled").length > 0)) {
      $(this).parents(".input-group").appendTo(".cancelled").css({
        "background-color": "#ffd8d8",
        "border": "none"
      });
	  	$('#hrload-img').show();
		var tugas_id = $(this).data('tugas-id');
		var status_tugas = $(this).data('tugas-status');
		jQuery.get(site_url+"project/update_status_scrum_board_tugas/"+tugas_id+"/"+status_tugas, function(data, status){
			$('#hrload-img').hide();
		});
    }
  });
  $(".button-hold").on("click", function() {
    if (!($(this).closest(".hold").length > 0)) {
      $(this).parents(".input-group").appendTo(".hold").css({
        "background-color": "#fbffa2",
        "border": "none"
      });
	  	$('#hrload-img').show();
		var tugas_id = $(this).data('tugas-id');
		var status_tugas = $(this).data('tugas-status');
		jQuery.get(site_url+"project/update_status_scrum_board_tugas/"+tugas_id+"/"+status_tugas, function(data, status){
			$('#hrload-img').hide();
		});
    }
  });
  
  $(".button-delete").on("click", function() {
    $(this).parents(".input-group").remove();
  });

  var placeholderDiv = document.createElement("div");
  var placeholderAtt = document.createAttribute("class");
  var tugasDivAttVal = placeholderAtt.value = "placeholder";
  placeholderDiv.setAttributeNode(placeholderAtt);

}
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