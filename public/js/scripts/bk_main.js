var iid,gender_flg;
$(document).ready(function() {

    $('.x-toggle').click(function(e) {
        e.preventDefault();

        if($(this).hasClass('toggled')) {
            $('.fa-chevron-left').css({
                'transform':'rotate(0deg)',
                'overflow': 'hidden',
                'transition-duration': '0.4s',
                'transition-property': 'transform'
            });
            $(this).removeClass('toggled');
            $('#sub-menu').slideUp('fast');
        } else {
            $('.fa-chevron-left').css({
                'transform':'rotate(-90deg)',
                'overflow': 'hidden',
                'transition-duration': '0.4s',
                'transition-property': 'transform'
            });
            $(this).addClass('toggled');
            $('#sub-menu').slideDown('fast');
        }

        //$(this).addClass('toggled');

    });

    $('.history-btn').click(function() {
        $('.historyDetail').modal();
    });

    $('.submit-btn').click(function() {
        $('.submitDetail').modal();
    });

    

    $('.category-btn').click(function() {
        var _self = $(this);
        var cat_id = _self.data('id');
        if($(this).hasClass('toggled')) {

            // display subcategory
            $.ajax({
                url:base_url+'get/subcategory',
                type:'post',
                data:{a:cat_id},
                dataType:'json',
                success: function(res) {
                    if(res.error == 0) {
                        var n = '';
                        for(i in res.data) {
                            var obj = res.data[i];
                            var myvar = '<button class="btn-menu" data-id="'+obj.CATEGORY_ID+'" style="height: 45px;border: 1px solid #A88C35;background-color: #f4d164;color: #002323;padding: 0px 0px 2px 13px;font-size: 17px;"><i class="fa fa-star" aria-hidden="true"></i> '+obj.CATEGORY_NM+'</button>';
                            
                            n+=myvar;
                        }
                        $('#sub-menu').html(n);
                    }
                }
            });

        }
        
        $.ajax({
            url:base_url+'get/menu',
            type:'post',
            data:{a:cat_id},
            dataType:'json',
            success: function(res1) {

                // var iid,gender_flg;

                $('.content-body').empty();
                if(res1.error == 0) {

                    var parent_div = '<div class="batch-menu" data-category>';
                    var close_div = '</div>';
                    var n_parent = '';
                    var n_child = '';
                
                    var remaining = 0;
                    
                    var max_item = 2;

                    if(res1.data.length < 4) {
                        max_item = res1.data.length;
                    }
                    
                    for(var k = 0; k < res1.data.length;) {
                
                        for(var ix = 0; ix < max_item; ix++) {
                
                            var child_div = ''+
                            '<div class="menu_list_item" data-group="'+res1.data[k].GROUP_ID+'">'+
                                '<div class="menu-header">'+
                                    '<div class="menu-image" style="background: url(http://busterfood.acrossweb.net/image/food/pizza-sliced.png);"></div>'+
                                    '<div class="menu-details">'+
                                        '<p class="detail-header">'+res1.data[k].ITEM_NM+'</p>'+
                                        '<p class="detail-body" style="overflow: hidden;">'+res1.data[k].ITEM_DESC+'</p>'+
                                    '</div>'+
                                '</div>'+

                                '<div class="menu-footer">'+
                                    '<div class="gender-price menu-price-1">'+
                                        '<div class="price male-price" style="background: #293EAA;"></div>'+
                                    '</div>'+
                                    '<div class="gender-price menu-price-2">'+
                                        '<div class="price female-price" style="background: #DA0895;"></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';

                            n_child+=child_div;
                            k++;
                        }
                        remaining = res1.data.length - k;
                        if(remaining < 3) {
                            max_item = remaining;
                        }
                        $('.content-body').append(parent_div+n_child+close_div);
                        n_child = '';
                    }

                    $.ajax({
                        url:base_url+'get/pricegender',
                        type:'post',
                        //data:{a:cat_id},
                        dataType:'json',
                        success: function(res2) {
                            if(res2.error == 0) {
                                $('.batch-menu div.menu_list_item').each(function() {
                                    var res2_parent = $(this);
                                    var gid = $(this).data('group');
                                    for(i in res2.data) {
                                        var obj2 = res2.data[i];
                                        if(gid == obj2.GROUP_ID && obj2.GENDER_FLG == 0) {
                                            res2_parent.find('.menu-price-1').attr('data-item-id', obj2.ITEM_ID);
                                            res2_parent.find('.menu-price-1').attr('data-gender-flg', obj2.GENDER_FLG);
                                            if(obj2.ITEM_PRICE == 0) {
                                                res2_parent.find('.menu-price-1 div').html('無料');
                                            } else {
                                                res2_parent.find('.menu-price-1 div').html(obj2.ITEM_PRICE);
                                            }
                                            
                                        } else if(gid == obj2.GROUP_ID && obj2.GENDER_FLG == 1) {
                                            res2_parent.find('.menu-price-2').attr('data-item-id', obj2.ITEM_ID);
                                            res2_parent.find('.menu-price-2').attr('data-gender-flg', obj2.GENDER_FLG);
                                            if(obj2.ITEM_PRICE == 0) {
                                                res2_parent.find('.menu-price-2 div').html('無料');
                                            } else {
                                                res2_parent.find('.menu-price-2 div').html(obj2.ITEM_PRICE);
                                            }
                                            
                                        }
                                    }
                                    
                                    
                                });
                                
                            }
                        }
                    });
                    // click 
                    $('.gender-price').on('click',function() {
                        var _self = $(this);
                        iid = _self.data('item-id'),gender_flg = _self.data('gender-flg');

                        $.ajax({
                            url:base_url+'cart/menu/'+iid+'/read',
                            type:'post',
                            dataType:'json',
                            success: function(res) {
                                console.log(res);
                                if(res.error == 0) {
                                    quantity = res.data[0];
                                    updateQuantity($, quantity);
                                }
                            }
                        });

                        $('.itemDetail').modal();
                    });
                    
                    
                }

            }
        });
        
    });
    $('.submit-to-cart').on('click',function() {
        // console.log(iid,gender_flg,$('.quantity_item').text(),quantity);
        $.ajax({
            url:base_url+'cart/add/'+iid+'/'+quantity,
            type:'post',
            // data:{},
            dataType:'json',
            success: function(res1) {
                $.ajax({
                    url:base_url+'cart/view',
                    type:'post',
                    dataType:'json',
                    success: function(res2) {
                        drawOrder($,res2);
                        
                    }
                });
                //console.log(res);
                //drawOrder($,res);
                $('.itemDetail').modal('hide');
            }
        });
    });
    $('.category-btn').eq(0).trigger('click');
	
	
	// $("#img002").click(function(){
	/* $(".sub-menu .btn-menu").click(function(){
		var data_category = $(this).attr('data-id');
		console.log(data_category);
		if(!wait){
			wait=true;
			console.log("HELLO 002");
				$("#panel002").show(500, function(){
					wait=false;
				});
			// $("#panel002").slideToggle(500, function(){
				// wait=false;
			// });
		
		}
	});  */

});

function drawMenu($, res) {

}

function drawOrder($, res) {
    var parent = $('.right-side-bar');
    var n = '';
    parent.find('.male-order .order-body').empty();
    parent.find('.female-order .order-body').empty();
    //parent.find('.male-order .order-body').empty();
    for(i in res.data) {
        var obj = res.data[i];

        if(obj.GENDER_FLG == 0) {
            var myvar = '<div class="delete-menu" data-item-id="'+obj.ITEM_ID+'" style="float: left;height: 34px;width: 34px;padding: 4px 0px 0px 7px;"><i class="fa fa-times-circle" aria-hidden="true" style="color: #f4d164;font-size: 26px;"></i></div>'+
            '<div class="edit-menu" data-item-id="'+obj.ITEM_ID+'" style="float: left;height: 34px;width: 176px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;font-weight: bold;font-size: 16px;padding-top: 4px;padding-left: 5px;">'+obj.ITEM_NM+'</div>'+
            '<div style="float: left;height: 34px;width: 34px;font-size: 18px;font-weight: bold;padding: 4px 0px 0px 4px;">'+obj.PCS+'</div>';
            parent.find('.male-order .order-body').append(myvar);
        } else if(obj.GENDER_FLG == 1) {
            var myvar = '<div class="delete-menu" data-item-id="'+obj.ITEM_ID+'" style="float: left;height: 34px;width: 34px;padding: 4px 0px 0px 7px;"><i class="fa fa-times-circle" aria-hidden="true" style="color: #f4d164;font-size: 26px;"></i></div>'+
            '<div class="edit-menu" data-item-id="'+obj.ITEM_ID+'" style="float: left;height: 34px;width: 176px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;font-weight: bold;font-size: 16px;padding-top: 4px;padding-left: 5px;">'+obj.ITEM_NM+'</div>'+
            '<div style="float: left;height: 34px;width: 34px;font-size: 18px;font-weight: bold;padding: 4px 0px 0px 4px;">'+obj.PCS+'</div>';
            parent.find('.female-order .order-body').append(myvar);
        }

    }
    $('.right-side-bar').find('.delete-menu').click(function(e) {
        e.preventDefault();
        var _self = $(this);
        iid = _self.data('item-id');
        $.ajax({
            url:base_url+'cart/delete/'+iid,
            type:'post',
            dataType:'json',
            success: function(res) {
                if(res.error == 0) {
                    // quantity = res.data[0];
                    // updateQuantity($, quantity);
                    $.ajax({
                        url:base_url+'cart/view',
                        type:'post',
                        dataType:'json',
                        success: function(res2) {
                            drawOrder($,res2);
                        }
                    });
                }
            }
        });
    });
    $('.right-side-bar').find('.edit-menu').click(function(e) {
        e.preventDefault();
        var _self = $(this);
        iid = _self.data('item-id');
        $.ajax({
            url:base_url+'cart/menu/'+iid+'/read',
            type:'post',
            dataType:'json',
            success: function(res) {
                if(res.error == 0) {
                    quantity = res.data[0];
                    updateQuantity($, quantity);
                }
            }
        });

        $('.itemDetail').modal();
    });

}

function updateQuantity($,num) {
    if(num > 9) {
        $('.itemDetail').find('.quantity_item').html(num);
    } else {
        $('.itemDetail').find('.quantity_item').html('0'+num);
    }
    
}