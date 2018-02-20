$(document).ready(function() {
	
	$('.tablinks').click(function() {

        $('.tablinks').removeClass('active');
        var data_id = $(this).data('id');
        $(this).addClass('active');

        $.ajax({
            url:base_url+'get/menu',
            type:'POST',
            data:{a:data_id},
            dataType:'json',
            success: function(res) {
                if(res.error == 0) {
                    $('.menu-content-body div.menu_list_item').empty();
                    // console.log(res);
                    // return false;
                    drawMenus($,res);
                    $('.menu_item').click(function(){
                        var name = $(this).data('menu-name');
                        
						
                        $.ajax({
                            url:base_url+'get/name',
                            type:'post',
                            data:{a:name},
                            dataType:'json',
                            success: function (res) {
                                if(res.error == 0) {
                                    var gender_stat = '';
                                    $.ajax({
                                        url:base_url+'get/gender',
                                        type:'post',
                                        dataType:'json',
                                        success: function (response) {
                                            // gender_stat = response.gender;
                                            showDetails($,res,response.gender);
                                        }
                                    });
                                    
                                }
                            }
                        });
                    });
                } else { $('.menu-content-body div.menu_list_item').empty(); }
            }
        });

    });
    $('button').eq(0).trigger('click');
    // add to cart
	
    $('.add_to_cart').click(function () {
         var parent = $('.itemDetail');

         // $('.gender').each(function() {
             
            // if(!$(this).hasClass('select_disable')) {
                // console.log($(this).find('quantity'));
                // $(this).find('quantity').text();
            // }
         // });
         
		
		// console.log( parent.attr('data-order') );

        /* TO BE CONTINUE */
        // if(parent.attr('data-order') > 0) {
            var order_count = parent.attr('data-order');

            var male_id = parent.find('div.male_quantity').attr('data-id');
            var female_id = parent.find('div.female_quantity').attr('data-id');

            var order = [];

            order.push({
                order_id:male_id,
                order_qty:parent.find('div.male_quantity strong').text()
            });
            order.push({
                order_id:female_id,
                order_qty:parent.find('div.female_quantity strong').text()
            });
		
		// console.log( male_id );
		// console.log( female_id );
            for(var i = 0; i < order.length; i++) {
				// console.log( order[i].order_id );
				if( order[i].order_id != null ){
					// console.log("if true condition");
					$.ajax({
						url:base_url+'cart/add/'+order[i].order_id+'/'+order[i].order_qty,
						//data:{a:parent.data('item-name')},
						// url: base_url+'cart/add/',
						// data: {
							// 'item_id': order[i].order_id,
							// 'item_qty': order[i].order_qty
						// },
						type: 'POST',
						dataType: 'json',
						success: function(res) {
							console.log(res);
						}
					});
				}
             
            }

         return false;
            

            // var gender_obj = {
            //     ''+male_id+'':parent.find('div.male_quantity').text(),
            //     female_id:parent.find('div.female_quantity').text()
            // };
            // console.log(gender_obj);
            // return false;

            // var male_order = parent.find('div.male_quantity').attr('data-id');
            // var female_order = parent.find('div.female_quantity').attr('data-id');
            
            // $.ajax({
            //     url:base_url+'cart/add/0342/55',
            //     type:'post',
            //     //data:{a:parent.data('item-name')},
            //     dataType:'json',
            //     success: function(res) {

            //     }
            // });

        // }

        // addToCart($,parent);
    });
});

function drawMenus($,res) {

    // console.log(res);
    // return false;

    var parent_div = '<div class="parent_div" style="width: 326px;height: 599px;margin-right: 8px;">';
    var close_div = '</div>';
    var n_parent = '';
    var n_child = '';

    var remaining = 0;
    
    var max_item = 3;

    if(res.data.length < 4) {
        max_item = res.data.length;
    }
    
    for(var k = 0; k < res.data.length;) {

        for(var ix = 0; ix < max_item; ix++) {

            var child_div = '<div class="menu_item" data-toggle="modal" data-target="#itemDetail" data-menu-name="'+res.data[k].ITEM_NM+'">'+
            '<div class="" style="background-color: #333333;border-radius: 5px;padding: 10px;padding: 10px;width: 326px;">'+
            '<div class="row">'+
            '<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xs-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-offset-4" style="padding: 0;">'+
            '<div style="width: 120px;height: 120px;border: 1px solid white;background: url(https://www.thesun.co.uk/wp-content/uploads/2016/09/nintchdbpict000264481984.jpg?w=960);background-size: 150% auto;background-repeat: no-repeat;border-radius: 50%;"></div>'+
            '</div>'+
            '</div>'+
            '<div class="row" style="height: 54px; margin-left: -10px; width: 242px; margin: 0;width: 306px;">'+
            '<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="height: 54px; padding: 0px 0px 0px 0px; width: 100%;">'+
            '<p style="color:white;margin: 0px 10px 0px 0px;word-wrap: break-word;font-size: 20px;width: 242px;float: left;height:100%;padding-top: 4px;"> <strong style="vertical-align: -webkit-baseline-middle;">'+res.data[k].ITEM_NM+'</strong> </p>'+
            '<div class="img-rounded img-circle" style="background-color:#917F1A;width: 54px;height: 54px;float: left;text-align: center;">'+
            '<p style="font-size: 14px;color: white;margin: 18px 0px 0px 2px;'+
            '">&#165;'+res.data[k].ITEM_PRICE+'</p>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>';
            n_child+=child_div;
            k++;
        }
        remaining = res.data.length - k;
        if(remaining < 4) {
            max_item = remaining;
        }
        $('.menu-content-body div.menu_list_item').append(parent_div+n_child+close_div);
        n_child = '';
    }

    
    
}



function showDetails($,res, gender_flg) {
    var parent = $('.itemDetail');
    $('div.male_section').removeClass('select_disable');
    $('div.female_section').removeClass('select_disable');

    console.log(gender_flg);

    switch (gender_flg) {
        case '0':
            // male
            $('div.female_section').addClass('select_disable');
            parent.find('div.male_quantity').attr('data-id',res.data[0].ITEM_ID);
            break;
        case '1':
            // female
            $('div.male_section').addClass('select_disable');
            parent.find('div.female_quantity').attr('data-id',res.data[0].ITEM_ID);
            break;
        case '3':
            break;
    }

    // if(res.data.length > 1) {
    //     parent.attr('data-order',res.data.length);
    //     for(i in res.data) {
    //         var obj = res.data[i];
    //         switch (obj.GENDER_FLG) {
    //             case '0':
    //                 // male
    //                 parent.find('div.male_quantity').attr('data-id',obj.ITEM_ID);
    //                 break;
    //             case '1':
    //                 // female
    //                 parent.find('div.female_quantity').attr('data-id',obj.ITEM_ID);
    //                 break;
    //             case '3':
    //                 break;
    //         }
    //     }
    // } else {
    //     parent.attr('data-order',res.data.length);
    //     switch (res.data[0].GENDER_FLG) {
    //         case '0':
    //             // male
    //             $('div.female_section').addClass('select_disable');
    //             parent.find('div.male_quantity').attr('data-id',res.data[0].ITEM_ID);
    //             break;
    //         case '1':
    //             // female
    //             $('div.male_section').addClass('select_disable');
    //             parent.find('div.female_quantity').attr('data-id',res.data[0].ITEM_ID);
    //             break;
    //         case '3':
    //             break;
    //     }
    // }
    parent.find('strong.item_detail_price').text('￥'+res.data[0].ITEM_PRICE);
    parent.find('span.item_detail_name').html(res.data[0].ITEM_NM);
    parent.attr('data-item-id',res.data[0].ITEM_ID);
    parent.attr('data-item-name',res.data[0].ITEM_NM);
}


function addToCart($,el) {
    var name = el.data('item-name');
    
}