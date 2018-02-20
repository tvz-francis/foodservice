
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
	
	$('.num-btn').click(function(){
		var number = $(this).attr('data-num');
		 // $('.quantity_item').append(number);
		// if(quantity_item.html() == "00"){
			// quantity_item.html("01");
		// }else{
			// console.log(parseInt(quantity_item.html()) + parseInt(number));
		// }
		console.log(quantity_item.html().length);
		if(quantity_item.html().length != 2) {
			// quantity_item.append(zeroPad(number, 2));
			quantity_item.append(number);
		} else {
			quantity_item.html('');
			quantity_item.append(number);
		}
	});
	
	
	$('.btn-clear').click(function(){
		// quantity_item.html('01');
		quantity_item.html('1');
	});
	
	

    // display menus
    $('.category-btn').click(function() {
        // var _self = $(this);

    });
    // $('.category-btn').eq(0).trigger('click');

});