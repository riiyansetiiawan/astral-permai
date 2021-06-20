function update_total() { 
	var sub_total = 0;
	var st_pajak = 0;
	var grand_total = 0;
	var gdTotal = 0;
	var rdiscount = 0;
	
	i = 1;	
	$('.sub-total-item').each(function(i) {
		var total = $(this).val();
		
		total = parseFloat(total);
		
		sub_total = total+sub_total;
	});
	$('.pajak-nilai-item').each(function(i) {
		var nilai_pajak = $(this).val();
		
		nilai_pajak = parseFloat(nilai_pajak);
		
		st_pajak = nilai_pajak+st_pajak;
	});
	$('.pajak_total').html(st_pajak.toFixed(2));
	$('.sub_total').html(sub_total.toFixed(2));
	
	var item_sub_total = sub_total;
	
	var angka_discount = $('.angka_discount').val();
	//var fsub_total = item_sub_total - angka_discount;
	$('.items-pajak-total').val(st_pajak.toFixed(2));
	$('.items-sub-total').val(item_sub_total.toFixed(2));
	
	//var type_discount = $('.type_discount').val(); 
	//var sub_total = $('.items-sub-total').val();

	if($('.type_discount').val() == '1'){
		var fsub_total = item_sub_total - angka_discount;
		  //var discount_amval = angka_discount;//.toFixed(2);
		  $('.jumlah_discount').val(angka_discount);
		  //$('.grand_total').html(grand_total.toFixed(2));	 
		} else {
			var discount_percent = item_sub_total / 100 * angka_discount;
			var fsub_total = item_sub_total - discount_percent;
		// var discount_amval = discount_percent.toFixed(2);
		$('.jumlah_discount').val(discount_percent.toFixed(2));
		 //$('.grand_total').html(grand_total.toFixed(2));	 
		}
		
		$('.fgrand_total').val(fsub_total.toFixed(2));
		$('.grand_total').html(fsub_total.toFixed(2));
		
	}//Update total function ends here.
	jQuery(document).on('click','.remove-invoice-item', function () {
		$(this).closest('.item-row').fadeOut(300, function() {
			$(this).remove();
			update_total();
		});
	});	
	
	jQuery(document).on('click','.eremove-item', function () {
		var record_id = $(this).data('record-id');
		var invoice_id = $(this).data('invoice-id');
		$(this).closest('.item-row').fadeOut(300, function() {
			$(this).remove();
			update_total();
		});
	});
  // for qty
  jQuery(document).on('click keyup change','.qty_hrs,.unit_price',function() {
  	var qty = 0;
  	var unit_price = 0;
  	var nilai_pajak = 0;
  	var qty = $(this).closest('.item-row').find('.qty_hrs').val();
  	var unit_price = $(this).closest('.item-row').find('.unit_price').val();
  	var nilai_pajak = $(this).closest('.item-row').find('.type_pajak').val();
  	var element = $(this).closest('.item-row').find('.type_pajak').find('option:selected'); 
  	var type_pajak = element.attr("pajak-type"); 
  	var nilai_pajak = element.attr("pajak-rate");
  	if(qty == ''){
  		var qty = 0;
  	} if(unit_price == ''){
  		var unit_price = 0;
  	} if(nilai_pajak == ''){
  		var nilai_pajak = 0;
  	}
	 // calculation
	 var sbT = (qty * unit_price);
	 if(type_pajak==='fixed'){
	 	var pajakPP = 1 / 1 * nilai_pajak;
	 	var singlePajaks = pajakPP;
	 	var subTotal = sbT + pajakPP;
	 	var sub_total = subTotal.toFixed(2);
	 	jQuery(this).closest('.item-row').find('.pajak-nilai-item').val(singlePajaks.toFixed(2));		
	 } else {
	 	var pajakPP = sbT / 100 * nilai_pajak;
	 	var singlePajaks = pajakPP;
	 	var subTotal = sbT + pajakPP;
	 	var sub_total = subTotal.toFixed(2);
	 	jQuery(this).closest('.item-row').find('.pajak-nilai-item').val(singlePajaks.toFixed(2));
	 }	 
	 jQuery(this).closest('.item-row').find('.sub-total-item').val(sub_total); 
	 jQuery(this).closest('.item-row').find('.sub-total-item').val(sub_total);
	 update_total();
	});
  jQuery(document).on('change click','.type_pajak', function () {
  	var qty = 0;
  	var unit_price = 0;
  	var nilai_pajak = 0;
  	var qty = $(this).closest('.item-row').find('.qty_hrs').val();
  	var unit_price = $(this).closest('.item-row').find('.unit_price').val();
  	var nilai_pajak = $(this).closest('.item-row').find('.type_pajak').val();
  	var element = $(this).closest('.item-row').find('.type_pajak').find('option:selected'); 
  	var type_pajak = element.attr("pajak-type"); 
  	var nilai_pajak = element.attr("pajak-rate");
  	if(qty == ''){
  		var qty = 0;
  	} if(unit_price == ''){
  		var unit_price = 0;
  	} if(nilai_pajak == ''){
  		var nilai_pajak = 0;
  	}
	 // calculation
	 var sbT = (qty * unit_price);
	 if(type_pajak==='fixed'){
	 	var pajakPP = 1 / 1 * nilai_pajak;
	 	var singlePajaks = pajakPP;
	 	var subTotal = sbT + pajakPP;
	 	var sub_total = subTotal.toFixed(2);
	 	jQuery(this).closest('.item-row').find('.pajak-nilai-item').val(singlePajaks.toFixed(2));
	 	jQuery(this).closest('.item-row').find('.sub-total-item').val(sub_total);
	 	update_total();
	 } else {
	 	var pajakPP = sbT / 100 * nilai_pajak;
	 	var singlePajaks = pajakPP;
	 	var subTotal = sbT + pajakPP;
	 	var sub_total = subTotal.toFixed(2);
	 	jQuery(this).closest('.item-row').find('.pajak-nilai-item').val(singlePajaks.toFixed(2));
	 	jQuery(this).closest('.item-row').find('.sub-total-item').val(sub_total);
	 	update_total();
	 }
	 jQuery(this).closest('.item-row').find('.sub-total-item').val(sub_total); 
	 update_total();
	});
  jQuery(document).on('click keyup change','.angka_discount',function() {
  	var qty = 0;
  	var unit_price = 0;
  	var nilai_pajak = 0;
  	var angka_discount = $('.angka_discount').val();
  	var type_discount = $('.type_discount').val(); 
  	var sub_total = $('.items-sub-total').val();

  	if(parseFloat(angka_discount) <= parseFloat(sub_total)) {
  		if($('.type_discount').val() == '1'){
  			var grand_total = sub_total - angka_discount;
		  var discount_amval = angka_discount;//.toFixed(2);
		  $('.jumlah_discount').val(discount_amval);
		  $('.grand_total').html(grand_total.toFixed(2));	 
		} else {
			var discount_percent = sub_total / 100 * angka_discount;
			var grand_total = sub_total - discount_percent;
			var discount_amval = discount_percent.toFixed(2);
			$('.jumlah_discount').val(discount_amval);
			$('.grand_total').html(grand_total.toFixed(2));	 
		}
	} else {
		//
		$('.jumlah_discount').val(0);
		$('.angka_discount').val(0)
	//	var grand_total = sub_total;
	$('.grand_total').html(sub_total);
	alert('Discount price should be less than Sub Total.');
}
update_total();
});
  jQuery(document).on('change click','.type_discount',function() {
  	var qty = 0;
  	var unit_price = 0;
  	var nilai_pajak = 0;
  	var angka_discount = $('.angka_discount').val();
  	var type_discount = $('.type_discount').val(); 
  	var sub_total = $('.items-sub-total').val();

  	if($('.type_discount').val() == '1'){
  		var grand_total = sub_total - angka_discount;
		  var discount_amval = angka_discount;//.toFixed(2);
		  $('.jumlah_discount').val(discount_amval);
		  $('.grand_total').html(grand_total.toFixed(2));	 
		} else {
			var discount_percent = sub_total / 100 * angka_discount;
			var grand_total = sub_total - discount_percent;
			var discount_amval = discount_percent.toFixed(2);
			$('.jumlah_discount').val(discount_amval);
			$('.grand_total').html(grand_total.toFixed(2));	 
		}
		
		
		
	//jQuery(this).closest('.item-row').find('.sub-total-item').val(sub_total); 
	//jQuery(this).closest('.item-row').find('.jumlah-html').html(sub_total);
	update_total();
});
  $(document).ready(function(){	
  	
  	
  	$("#umb-form").submit(function(e){
  		
  		
  		e.preventDefault();
  		var obj = $(this), action = obj.attr('name');
  		$('.save').prop('disabled', true);
  		
  		$.ajax({
  			type: "POST",
  			url: e.target.action,
  			data: obj.serialize()+"&is_ajax=1&add_type=create_invoice&form="+action,
  			cache: false,
  			success: function (JSON) {
  				if (JSON.error != '') {
  					toastr.error(JSON.error);
  					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
  					$('.save').prop('disabled', false);
  				} else {
  					toastr.success(JSON.result);
  					$('.save').prop('disabled', false);
  					$('input[name="csrf_hrastral"]').val(JSON.csrf_hash);
  					window.location = site_url+'invoices/';
  				}
  			}
  		});
  	});
	// Date
	$('.date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd',
		yearRange: '1980:' + (new Date().getFullYear() + 10),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
	});
	
	}); // jquery load
  