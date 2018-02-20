// var idleTime = 0;
// var counter = 5;

// function resetCoundown(){
// 	clearInterval(counter);
// }
// function timerIncrement() {
//     idleTime = idleTime + 1;
//     if (idleTime > 1) { // 20 minutes
//         // window.location.reload();
// 		$('.clearCart').modal();
// 		$('#clearCart').find('.countdown').html(10);
		
// 		/* var counter = 5;
// 		setInterval(function() {
// 			counter--;
// 			if (counter >= 0) {
// 				// span = document.getElementById("count");
// 				// span.innerHTML = counter;
// 				console.log(counter);
// 			}
// 		// Display 'counter' wherever you want to display it.
// 			if (counter === 0) {
// 				console.log('hello world this clear');
// 				clearInterval(counter);
// 			}
// 		}, 1000); */
// 		count=11;
// 		counter=setInterval(timer, 1000);
// 		function timer(){
// 			count=count-1;
// 			if (count <= 0){
// 				clearInterval(counter);
// 				// return;  
// 			}
// 			if(count == 0){
// 				console.log("please be clear me let me go");
// 				$.ajax({
// 					url: '/v1/cart/forget_test',
// 					type: 'GET',
// 					success: function(res) {
// 						console.log(res);
// 						window.location.href = "/home/";
// 					}
// 				});
// 			}
			
// 			console.log(count);
// 			$('#clearCart').find('.countdown').html(count);
// 		}
// 			// document.getElementById("secs").innerHTML=count + " secs.";}
		
		  
//     }
// }
$(document).ready(function() {

	var timer = 30, _idle = 0; 
	// var idle_timer = 60;

	// check cart
	var check_cart_CD = setInterval(function() {
		$.ajax({
			url: '/v1/cart/view',
			type: 'post',
			dataType:'json',
			success: function(res) {
				if(res.error == 1) {
					setTimer();
					_idle = 0;
				} else {
					// _idle = 1;
					if($('.countdown-modal').attr('data-bill') == 1){
						_idle = 1;
					}else{
						setTimer();
						_idle = 0;
					}
				}
			}
		});
	},5000);

	/* COUNTDOWN TIMER */
	var CD = setInterval(function() {
		timer = timer - 1;
		// console.log('Countdown: '+timer+' Idle: '+_idle);
		// console.log(timer);
		if(timer <= 0) {
			
			// clearInterval(CD);
		} else if(timer < 11 && _idle == 1) {
			// if($('.checkItem-modal').is(':visible')) {
				// $('.checkItem-modal').modal('hide');
			// }
			$('.modal').modal('hide');
			$('.countdown-modal').modal();
			$('.countdown-modal').find('p.modal-num').text(timer);
			$(this).click(function() { setTimer(); });
		}
		
			if(timer === 0){
				console.log("add to cart");
				$.ajax({
					url: '/v1/cart/order',
					type: 'post',
					// dataType:'json',
					success: function(res) {
						var result = $.parseJSON(res);
						if(result.error == 0){
							if(typeof app != 'undefined'){						
								// app.testPrintDialog();
								app.makeReceipt(res);
							}else{
								$('.countdown-modal').modal('hide');
								// window.location = '/v1/home';
								placeOrderFood( result );
							}
						}
					}
				});
			}
	}, 1000);

    // var _idle_timer = setInterval(function () {

    //     idle_timer = idle_timer - 1;
    //     if(idle_timer == 1) {
    //         window.location = 'http://food.across-web.net/v1';
    //     }

    // }, 1000);

	$(this).on('touchmove', function() {
		$('.countdown-modal').modal('hide');
		// idle_timer = 60;
		setTimer();
	});
	$(this).click(function() {
		$('.countdown-modal').modal('hide');
		// idle_timer = 60;
		setTimer();
	});

	$('.cd-btn').click(function() {
		$('.countdown-modal').modal('hide');
	});

	function setTimer() {
		timer = 30;
		_idle = 0;
	}
	
	
	
	//Increment the idle time counter every minute.
	// var idleInterval = setInterval(timerIncrement, 60000); // 1 minute
	//var idleInterval = setInterval(timerIncrement, 5000); // 1 minute

	//Zero the idle timer on mouse movement.
	$(this).mousemove(function (e) {
		idleTime = 0;
	});
	$(this).keypress(function (e) {
		idleTime = 0;
	});
	
	// resetCoundown();
	// $('.clearCart').on('hidden.bs.modal', function () {
	// 	console.log("hide me");
	// 	resetCoundown();
	// })

	
	$('.submit-btn').click(function() {
		// $('.submitDetail').modal();
		
		// var jsonData = [{
			// "error": 0,
			// "seat_no": "001",
			// "host_name": "sakaihigashi003",
			// "order_date": "2017-12-11",
			// "data":[
			// {
				// "item_id": "0001",
				// "item_nm": "item_nm test",
				// "price": 100,
				// "quantity": 1,
				// "total": 100,
				// "seq": 0,
				// "gender_flg": 1
			// },
			// {
				// "item_id": "0002",
				// "item_nm": "item_nm_1 test",
				// "price": 200,
				// "quantity": 2,
				// "total": 400,
				// "seq": 1,
				// "gender_flg": 1
			// }],
			// "msg": "Successfully placed the order",
			// "print_flg": "0"
		// }];
		
		$.ajax({
			url: '/v1/cart/check',
			type: 'GET',
			dataType:'json',
			beforeSend: function(){
				
			}, 
			success: function(res){
				if(res.error == 0){
					$('.submitDetail').modal();
					$('#submitDetail').find('.submit-btn').click( function(){
					 // $('.submitDetail').modal();
						$.ajax({
							url: '/v1/cart/order',
							type: 'POST',
							// dataType:'json',
							success: function(res) {
								var result = $.parseJSON(res);
								if(result.error == 0){
									if(typeof app != 'undefined'){
										if(result.data.length != 0){
											app.makeReceipt(res);	
											// app.testPrintDialog();											
										}else{
											window.location = '/v1/home';
										}
									}else{
										// $('.submitDetail').modal('hide');
										// window.location = '/v1/home';
										// placeOrderFood( jsonData );
										console.log(res);
										placeOrderFood( result );
									}
									
								}
								
								// app.reloadWebView();
							}
						});
					});
				}else{
					$('.msgModal').modal();
				}
			}
		});
	});
	
	
	$('.right-side-bar').find('.history-btn').click(function(){
		// console.log("history");
		//$('#historyDetail').modal();
		var parent_div = $('#historyDetail');
		$.ajax({
			url: '/v1/cart/history',
			type: 'GET',
			dataType:'json',
			beforeSend: function(){
				$('.historyDetail').modal();
				parent_div.find('.male-history #male-history-table tbody').empty();
				parent_div.find('.female-history #female-history-table tbody').empty();
			},
			success: function(res) {
				console.log(res);
				
				if(res.error == 0) {
					var divData = '';
					
					var	max_item = res.data.length;
					for(var x = 0; x < res.data.length;) {
						for(var i = 0; i < max_item; i++) {

							res.data[x].ITEM_PRICE = (res.data[x].ITEM_PRICE == 0)?'無料':'¥'+res.data[x].ITEM_PRICE;
							
								if(res.data[x].GENDER_FLG == 0){
									var historyVar = ''+
										'<tr style="height: 50px;" data-id="'+res.data[x].ITEM_ID+'">'+
											'<td style="width: 448px;padding: 0px 0px 0px 16px;">'+res.data[x].ITEM_NM+'</td>'+
											'<td style="width: 62px;text-align: center;">'+res.data[x].ITEM_QTY+'</td>'+
											'<td style="width: 96px;text-align: center;">'+res.data[x].ITEM_PRICE+'</td>'+
										'</td>';
									parent_div.find('.male-history #male-history-table tbody').append(historyVar);
								}else{
									var historyVar = ''+
										'<tr style="height: 50px;" data-id="'+res.data[x].ITEM_ID+'">'+
											'<td style="width: 448px;padding: 0px 0px 0px 16px;">'+res.data[x].ITEM_NM+'</td>'+
											'<td style="width: 62px;text-align: center;">'+res.data[x].ITEM_QTY+'</td>'+
											'<td style="width: 96px;text-align: center;">'+res.data[x].ITEM_PRICE+'</td>'+
										'</td>';
									parent_div.find('.female-history #female-history-table tbody').append(historyVar);
								}
							x++
						}
						
						remaining = res.data.length - x;
						if(remaining < 3) {
							max_item = remaining;
						}
					}
					
				}
				
			}
		});
	});
	
	
	$('.btn-billout').click(function(){
		// $('.billout-modal').modal();
		$.ajax({
			url: '/v1/cart/check',
			type: 'GET',
			dataType:'json',
			beforeSend: function(){
				
			}, 
			success: function(res){
				if(res.error != 0){
					$('.billout-modal').modal();
				}else{				
					$('.checkItem-modal').modal();
					$('.countdown-modal').attr('data-bill', '0');
					//0
				}
				
			}
		});
	});
	
	$('.checkItem-modal').click(function(){
		$.ajax({
			url: '/v1/cart/check',
			type: 'GET',
			dataType:'json',
			beforeSend: function(){
				
			}, 
			success: function(res){
				if(res.error != 0){
					$('.billout-modal').modal();
				}else{					
					console.log(res.error);
					$('.countdown-modal').attr('data-bill', '1');
					//0
				}
				
			}
		});
	});
	
	$('.bill-clearCart').click(function(){
		$.ajax({
			url: '/v1/cart/forget_test',
			type: 'GET',
			beforeSend:function(){
				$('.order-body div').html("");
				$('.checkItem-modal').modal('hide');
			},
			success: function(res) {
				// $('.billout-modal').modal();
				$('.billout-overlay').modal();
				billOut();
			}
		});
	});
	
			

	$('.billout-yes').click(function() {
		$('.billout-overlay').modal();
		billOut();
	});
	
	$('.billout-cancel').click(function(){
		$.ajax({
			url: '/v1/bill-out-cancel',
			type: 'POST',
			dataType:'json',
			beforeSend: function(){
				$('.billout-overlay').modal();
			},
			success: function(res) {
				console.log(res);
				if(res.error == 0){
					// $('.billout-overlay').modal('hide');
					window.location = '/v1/home';
				}
			}
		});
	});
	
	$('.billout-no').click(function() {
		$('.billout-modal').modal('hide');
	});

	$('.btn-billout-no').click(function() {
		$('.checkItem-modal').modal('hide');
	});


});

function billOut(){
	$.ajax({
		url: '/v1/bill-out',
		type: 'POST',
		dataType:'json',
		beforeSend: function(){
			// $('.billout-overlay').modal();
		},
		success: function(res) {
			if(res.error == 0) {
				$('.billout-modal').modal('hide');
				var host_name = res.data.host_name;
				if(typeof(EventSource) !== "undefined") {
					var source = new EventSource("/v1/get/status");
					source.onmessage = function(event) {
						// document.getElementById("result").innerHTML += event.data + "<br>";
						if(event.data == 1){
							console.log("one");
							  // $('.itemDetail').modal('hide');
						}else{
							console.log("zero");
							window.location = '/v1?seat_no='+ host_name +'';
							// reload
						}
						// console.log(source);
					};
				} else {
					// document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
					console.log('else sorry cant load data');
				}
				// window.location = '/v1/home';
			}
		}
	});
}