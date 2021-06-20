$(document).ready(function(){
	
	/*$(window).scroll(function(){
		if ($(this).scrollTop() >= 75) 
		{
			jQuery('.navbar-static-top').addClass('fixed-header');
		} 
		else 
		{
			jQuery('.navbar-static-top').removeClass('fixed-header');
		}
	});*/
	
});	

$(document).ready(function(){	
	
	
	$('.kebijakan').on('show.bs.modal', function (event) {
		$.ajax({
			url: site_url+'settings/read_kebijakan/',
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=kebijakan&type=kebijakan&p=1',
			success: function (response) {
				if(response) {
					$("#modal_kebijakan").html(response);
				}
			}
		});
	});
	
	
	
	jQuery(".hrastral_layout").change(function(){
		if($('#fixed_layout_hrastral').is(':checked')){
			var fixed_layout_hrastral = $("#fixed_layout_hrastral").val();
			
		} else {
			var fixed_layout_hrastral = '';
		}
		if($('#boxed_layout_hrastral').is(':checked')){
			var boxed_layout_hrastral = $("#boxed_layout_hrastral").val();
		} else {
			var boxed_layout_hrastral = '';
		}
		if($('#sidebar_layout_hrastral').is(':checked')){
			var sidebar_layout_hrastral = $("#sidebar_layout_hrastral").val();
		} else {
			var sidebar_layout_hrastral = '';
		}
		
		$.ajax({
			type: "GET",  url: site_url+"settings/info_layout_skin/?is_ajax=2&type=hrastral_info_layout&form=2&fixed_layout_hrastral="+fixed_layout_hrastral+"&boxed_layout_hrastral="+boxed_layout_hrastral+"&sidebar_layout_hrastral="+sidebar_layout_hrastral+"&user_session_id="+user_session_id,
			//data: order,
			success: function(response) {
				if (response.error != '') {
					toastr.error(response.error);
				} else {
					toastr.success(response.result);	
				}
			}
		});
	});
	//
	jQuery("#fixed_layout_hrastral").click(function(){
		if($('#fixed_layout_hrastral').is(':checked')){
			//$('#boxed_layout_hrastral').prop('checked', false);
		}
	});
	jQuery("#boxed_layout_hrastral").click(function(){
		if($('#boxed_layout_hrastral').is(':checked')){
			$('.hrastral-layout').removeClass('fixed');
			$('#fixed_layout_hrastral').prop('checked', false);
		}
	});
});