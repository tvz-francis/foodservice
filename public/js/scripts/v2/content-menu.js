
	/* var timeout;
	var count = 0;
	// $('.addQuantity').mousedown(function(){
	$('.addQuantity').bind('mousedown touch', function(){
		timeout = setInterval(function(){
			
			quantity = $(this).Quantity({
				operation:'add',
				targetDOM:$('.quantity_item'),
				item_quantity:quantity
			});
			// console.log(count++);
		}, 100);

		return false;
	});  */
	
	// $('.minusQuantity').mousedown(function(){
	/* $('.minusQuantity').bind('mousedown touchstart', function(){
		timeout = setInterval(function(){
			
			quantity = $(this).Quantity({
				operation:'minus',
				targetDOM:$('.quantity_item'),
				item_quantity:quantity
			});
			// console.log(count++);
		}, 100);

		return false;
	}); */
	



$(document).ready(function() {
    // new
	
	/* $(document).mouseup(function(){
	// $(document).bind('mouseup touchend', function(){
		clearInterval(timeout);
		return false;
	}); */

	// var item_quantity = $('.item_quantity');
/* 	$('.price').click(function() {
		console.log("hello im add");
		$('.submit-to-cart').val('add');
		$('#itemDetail').modal();
	}); */
	
	var quantity_item = $('.quantity_item');
    $('.addQuantity').click(function() {
		// console.log(item_quantity.val());
		
		quantity = $(this).Quantity({
			operation:'add',
			targetDOM:quantity_item,
			targetINPUT:$('.item_quantity'),
			// item_quantity:quantity
			item_quantity: quantity_item.html()
		});
        
    });

    $('.minusQuantity').click(function() {
        quantity = $(this).Quantity({
            operation:'minus',
            targetDOM:quantity_item,
            targetINPUT:$('.item_quantity'),
            // item_quantity:quantity
            item_quantity:quantity_item.html()
        });
    });

    $('#itemDetail').on('hidden.bs.modal', function() {
        // quantity_item.html('01');
        quantity_item.html('1');
	   // $('.item_quantity').val('01');
        quantity = 1;
    });
	
	var numberLimit = 2;
	$('.num-btn').click(function(){
		var number = $(this).attr('data-num');
		// if(number == "0"){ 
			// console.log(number); 
			// quantity_item.attr('data-status', 0);
		// }
		// $('.calc').val(numberLimit);
		if(quantity_item.html().length < numberLimit) {
			// quantity_item.append(number);
			if(quantity_item.attr('data-status') == 0){
				quantity_item.html(number).attr('data-status', 1);
			}else{
				quantity_item.append(number);
			}
		} else {
			quantity_item.html('');
			quantity_item.append(number).attr('data-status', 1);
			/* quantity_item.append(number); */
		}
	});
	
	
	$('.btn-clear').click(function(){
		// quantity_item.html('01');
		quantity_item.html('1').attr('data-status', 0);
	});
	
	

    // display menus
    $('.category-btn').click(function() {
        // var _self = $(this);

    });
    // $('.category-btn').eq(0).trigger('click');

});