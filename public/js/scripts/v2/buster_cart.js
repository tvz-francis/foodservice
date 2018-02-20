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
// 					url: '/v2/cart/forget_test',
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

	var timer = 30, _idle = 0, campaign = 15;
	// var idle_timer = 60;

	// check cart
	var check_cart_CD = setInterval(function() {
		$.ajax({
			url: '/v2/cart/view',
			type: 'post',
			dataType:'json',
			success: function(res) {
				if(res.error == 1) {
					setTimer();
					_idle = 0;
				} else {
					// _idle = 1;
					campaign = 15;
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
		campaign = campaign - 1;
		console.log(campaign);
		if(campaign == 0) {
			$('.modal').modal('hide');
			$('.campaign_overlay').removeClass('co_hide');
			$('.campaign_overlay').addClass('co_show');
		}

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
			// $('.submit-btn').addClass('btn-glow');
		}
		
			if(timer === 0){
				console.log("add to cart");
				$.ajax({
					url: '/v2/cart/order',
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
								// window.location = '/v2/home';
								v2placeOrderFood( result );
							}
						}
					}
				});
			}
	}, 1000);

    // var _idle_timer = setInterval(function () {

    //     idle_timer = idle_timer - 1;
    //     if(idle_timer == 1) {
    //         window.location = 'http://food.across-web.net/v2';
    //     }

    // }, 1000);

	$(this).on('touchmove', function() {
		$('.countdown-modal').modal('hide');
		// idle_timer = 60;
		campaign = 15;
		setTimer();
	});
	$(this).click(function() {
		$('.countdown-modal').modal('hide');
		// idle_timer = 60;
		campaign = 15;
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
	
	// $('.submit-to-cart').click(function(){
		// if($('.order-body').hasClass('edit-menu')){
			// console.log("has Item");
			// $('.submit-btn').addClass('btn-glow');
		// }else{
			// console.log("has no item");
		// }
		// console.log($('.order-body').hasClass('edit-menu'));
	// });
	
	$('.submit-btn').click(function() {
		// $('.submitDetail').modal();
		
		$.ajax({
			url: '/v2/cart/check',
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
							url: '/v2/cart/order',
							type: 'POST',
							// dataType:'json',
							success: function(res) {
								var result = $.parseJSON(res);
								console.log(result);
								if(result.error == 0){
									if(typeof app != 'undefined'){
										if(result.data.length != 0){
											app.makeReceipt(res);	
											// app.testPrintDialog();											
										}else{
											// window.location = '/v2/home';
										}
									}else{
										// $('.submitDetail').modal('hide');
										// window.location = '/v2/home';
										console.log(result);
										// v2placeOrderFood( result );
									}
									
									$('.btn-checkOut').removeClass('btn-glow');
									$('.submitDetail').modal('hide');
									$('.order-body').html('');
									
									
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
	
	
	var parent_div = $('#historyDetail');
	$('.right-side-bar').find('.history-btn').click(function(){
		// console.log("history");
		$('.historyDetail').modal();
		/* $.ajax({
			url: '/v2/cart/history',
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
							var status;
							if(res.data[x].ITEM_STATUS == 0){
								status = 'pending';
							}else if(res.data[x].ITEM_STATUS == 1){
								status = 'process';
							}else{
								status = 'complete';
							}
							
								if(res.data[x].GENDER_FLG == 0){
									var historyVar = ''+
										'<tr style="height: 50px;" data-id="'+res.data[x].ITEM_ID+'">'+
											'<td style="width: 448px;padding: 0px 0px 0px 16px;">'+res.data[x].ITEM_NM+'</td>'+
											'<td style="width: 62px;text-align: center;">'+res.data[x].ITEM_QTY+'</td>'+
											'<td style="width: 96px;text-align: center;">'+res.data[x].ITEM_PRICE+'</td>'+
											'<td style="width: 120px;text-align: center;">'+status+'</td>'+
										'</td>';
									parent_div.find('.male-history #male-history-table tbody').append(historyVar);
								}else{
									var historyVar = ''+
										'<tr style="height: 50px;" data-id="'+res.data[x].ITEM_ID+'">'+
											'<td style="width: 448px;padding: 0px 0px 0px 16px;">'+res.data[x].ITEM_NM+'</td>'+
											'<td style="width: 62px;text-align: center;">'+res.data[x].ITEM_QTY+'</td>'+
											'<td style="width: 96px;text-align: center;">'+res.data[x].ITEM_PRICE+'</td>'+
											'<td style="width: 120px;text-align: center;">'+status+'</td>'+
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
		}); */
	});
	
	if(typeof(EventSource) !== "undefined") {
		var source = new EventSource("/v2/get/item/status");
		
		source.onmessage = function(event) {
			// document.getElementById("result").innerHTML += event.data + "<br>";
			parent_div.find('.male-history #male-history-table tbody').empty();
			parent_div.find('.female-history #female-history-table tbody').empty();
			
			var result = $.parseJSON(event.data);
			var max_item = result.data.length;
			for(var x = 0; x < result.data.length;) {
				for(var i = 0; i < max_item; i++) {
					var obj = result.data[x];
					obj.ITEM_PRICE = (obj.ITEM_PRICE == 0)?'無料':'¥'+obj.ITEM_PRICE;
					var status;
					if(obj.ITEM_STATUS == 0){
						status = '準備中';
					}else if(obj.ITEM_STATUS == 1){
						status = '済';
					}else{
						status = '取消';
					}
					
						if(obj.GENDER_FLG == 0){
							var historyVar = ''+
								'<tr style="height: 50px;" data-id="'+obj.ITEM_ID+'">'+
									'<td style="width: 448px;padding: 0px 0px 0px 16px;">'+obj.ITEM_NM+'</td>'+
									'<td style="width: 62px;text-align: center;">'+obj.ITEM_QTY+'</td>'+
									'<td style="width: 96px;text-align: center;">'+obj.ITEM_PRICE+'</td>'+
									'<td style="width: 120px;text-align: center;">'+status+'</td>'+
								'</td>';
							parent_div.find('.male-history #male-history-table tbody').append(historyVar);
						}else{
							var historyVar = ''+
								'<tr style="height: 50px;" data-id="'+obj.ITEM_ID+'">'+
									'<td style="width: 448px;padding: 0px 0px 0px 16px;">'+obj.ITEM_NM+'</td>'+
									'<td style="width: 62px;text-align: center;">'+obj.ITEM_QTY+'</td>'+
									'<td style="width: 96px;text-align: center;">'+obj.ITEM_PRICE+'</td>'+
									'<td style="width: 120px;text-align: center;">'+status+'</td>'+
								'</td>';
							parent_div.find('.female-history #female-history-table tbody').append(historyVar);
						}
					x++
				}
				
				// remaining = result.data.length - x;
				// if(remaining < 3) {
					// max_item = remaining;
				// }
			}
			
		};
	} else {
		// document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
		console.log('else sorry cant load data');
	} 
	
	
	$('.btn-billout').click(function(){
		// $('.billout-modal').modal();
		$.ajax({
			url: '/v2/cart/check',
			type: 'GET',
			dataType:'json',
			beforeSend: function(){
				
			}, 
			success: function(res){
				var with_cart = '注文が確定していない商品は すべてキャンセルとなります。 お会計でよろしいですか？',without_cart = 'お会計でよろしいですか？';
				console.log(res);
				if(!res.error) {

					if(_gender == 3) {
						$('.modal-check-desc').text(with_cart);
						drawBillOutModal('.billout-modal-check-gender');
					} else {
						$('.billout-modal').find('.billout-modal-desc').html(with_cart);
						drawBillOutModal('.billout-modal');
					}
					
				} else {

					if(_gender == 3) {
						$('.modal-check-desc').text(without_cart);
						drawBillOutModal('.billout-modal-check-gender');
					} else {
						$('.billout-modal').find('.billout-modal-desc').html(without_cart);
						drawBillOutModal('.billout-modal');
					}
					
				}


				// if(res.error != 0){
				// 	$('.billout-modal').modal();
				// }else{				
				// 	$('.checkItem-modal').modal();
				// 	$('.countdown-modal').attr('data-bill', '0');
				// 	//0
				// }
				
			}
		});


		// if(_gender == 3) {
			
		// } else {
		// 	$('.billout-modal').find('.billout-modal-desc').text();
		// 	drawBillOutModal('.billout-modal');
		// }

		
	});
	function drawBillOutModal(el) {
		$(el).modal();
	}
	
	$('.checkItem-modal').click(function(){
		$.ajax({
			url: '/v2/cart/check',
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
			url: '/v2/cart/forget_test',
			type: 'GET',
			beforeSend:function(){
				$('.order-body div').html("");
				$('.checkItem-modal').modal('hide');
			},
			success: function(res) {
				// $('.billout-modal').modal();
				$('.modal').modal('hide');
				$('.billout-modal-ty').modal();
				billOut({gender_flg:_gender});
			}
		});
	});
	
			

	$('.billout-yes').click(function() {
		// $('.modal').modal('hide');
		// $('.billout-modal-ty').modal();
		// billOut({gender_flg:_gender});
		drawBillOut({gender_flg:_gender});
	});

	function drawBillOut(data) {
        billOut(data);
        $('.modal').modal('hide');
        $('.billout-modal-ty').modal();
        $('.btn-checkOut').removeClass('btn-glow');
        clearInterval(CD);
        setTimeout(function() {
            // prepareFrame();
            $('.modal').modal('hide');
            $('.campaign_overlay').removeClass('co_hide');
			$('.campaign_overlay').addClass('co_show');
            var checkBO = setInterval(function() {
                checkPendingBillOut();
            },3000);
        },15000);
    }

    function prepareFrame() {
        var ifrm = document.createElement("iframe");
        ifrm.setAttribute("src", "http://www.xn--pckhtyr3f0e1k.jp/");
        ifrm.style.width = "100%";
        ifrm.style.height = "100%";
        ifrm.style.position = "absolute";
        ifrm.style.top = "0";
        ifrm.style.left = "0";
        document.body.appendChild(ifrm);

        $('iframe').on('click',function() {
			// window.location = 'http://food.across-web.net/v2/home';
			console.log('HELLO');
		});
    }

    function checkPendingBillOut() {
        $.ajax({
            url:'/v2/get/checkbillout',
            type:'post',
            dataType:'json',
            success:function(res) {
                if(res.error == 0) {
                    window.location = 'home';
                }
            }
        });
    }

    // function prepareCampaign(action) {
    // 	if(campaign == 0) {
    		
    // 	}

    // 	if(action == 'show') {
    // 		$('.campaign_overlay').removeClass('co_hide');
    // 		$('.campaign_overlay').addClass('co_show');
    // 	} else if(action == 'hide') {
    // 		$('.campaign_overlay').removeClass('co_show');
    // 		$('.campaign_overlay').addClass('co_hide');
    // 	}
    // }
	
	$('.billout-cancel').click(function(){
		$.ajax({
			url: '/v2/bill-out-cancel',
			type: 'POST',
			dataType:'json',
			beforeSend: function(){
				// $('.billout-overlay').modal();
				$('.modal').modal('hide');
				drawBillOutModal('.billout-modal-ty');
			},
			success: function(res) {
				console.log(res);
				if(res.error == 0){
					// $('.billout-overlay').modal('hide');
					window.location = '/v2/home';
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

	$('.campaign_overlay').click(function () {
		window.location = 'http://food.across-web.net/v2/home';
	});
});

function billOut(data=null){
	$.ajax({
		url: '/v2/bill-out',
		type: 'POST',
		data:data,
		dataType:'json',
		beforeSend: function(){
			// $('.billout-overlay').modal();
		},
		success: function(res) {
			if(res.error == 0) {
				$('.billout-modal').modal('hide');
				var host_name = res.data.host_name;
				if(typeof(EventSource) !== "undefined") {
					var source = new EventSource("/v2/get/status");
					source.onmessage = function(event) {
						// document.getElementById("result").innerHTML += event.data + "<br>";
						if(event.data == 1){
							console.log("one");
							  // $('.itemDetail').modal('hide');
						}else{
							console.log("zero");
							window.location = '/v2?seat_no='+ host_name +'';
							// reload
						}
						// console.log(source);
					};
				} else {
					// document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
					console.log('else sorry cant load data');
				}
				// window.location = '/v2/home';
			}
		}
	});
}