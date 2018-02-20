var iid,gender_flg,_gender,item_nm;
var base_url = 'http://food.across-web.net/v2/';

// setInterval(function() {
//     console.log(document.readyState);
// },1000);
// setInterval(function() {
//     console.log(document.readyState);
//     console.log(window.onload);
// },1000);

$(document).ready(function(e) {

    // $('.history-btn').click(function() {
    //     $('.historyDetail').modal();
    // });

    // $('.submit-btn').click(function() {
        // $('.submitDetail').modal();
    // });
    if(typeof(EventSource) !== "undefined") {
        var source = new EventSource("/v2/get/gender/status");
        source.onmessage = function(event) {
            // document.getElementById("result").innerHTML += event.data + "<br>";
            
            var result = $.parseJSON(event.data);
            _gender = result.gender;
            
            if(_gender == 0) {
                
                $('.menu-price-1').addClass('price-disabled');
                $('.menu-price-0').removeClass('price-disabled');
            } else if(_gender == 1) {
                
                $('.menu-price-0').addClass('price-disabled');
                $('.menu-price-1').removeClass('price-disabled');
            } else {
                
                $('.menu-price-1').removeClass('price-disabled');
                $('.menu-price-0').removeClass('price-disabled');
            }
            
        };
    } else {
        // document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
        console.log('else sorry cant load data');
    } 
    
    $.ajax({
        url:'/v2/check-session',
        type:'GET',
        dataType:'json',
        success: function(res) {
            var host_name = res.data.host_name;
            if(typeof(EventSource) !== "undefined") {
                var source = new EventSource("/v2/get/status");
                source.onmessage = function(event) {
                    // document.getElementById("result").innerHTML += event.data + "<br>";
                    if(event.data == 0){
                        // console.log("log-out");
                        window.location = '/v2?seat_no='+ host_name +'';
                    }
                    // console.log(source);
                };
            } else {
                // document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
                console.log('else sorry cant load data');
            } 
        }
    });
    
    $('.category-btn').click(function() {
        var _self = $(this);
        var cat_id = _self.data('id');
        
        // $.ajax({
            // url:base_url+'get/gender',
            // type:'post',
            // dataType:'json',
            // success: function(res) {
                // _gender = res.gender;
            // }
        // });  
        
        if($(this).hasClass('x-toggle')) {
            if($(this).hasClass('toggled')) {
                $(this).removeClass('toggled');
                $('.fa-chevron-left').css({
                    'transform':'rotate(0deg)',
                    'overflow': 'hidden',
                    'transition-duration': '0.4s',
                    'transition-property': 'transform'
                });
                // $('#sub-menu').slideUp('fast');
                // $('#sub-menu').hide();
                $('#sub-menu').css({'display':'none'});
            } else {
                $('.fa-chevron-left').css({
                    'transform':'rotate(-90deg)',
                    'overflow': 'hidden',
                    'transition-duration': '0.4s',
                    'transition-property': 'transform'
                });
                $(this).addClass('toggled');
                // $('#sub-menu').slideDown('fast');
                // $('#sub-menu').show();
                $('#sub-menu').css({'display':'block'});
            }
        } else {
            if($(this).hasClass('toggled')) {
                $('.category-btn').removeClass('toggled');
                $(this).addClass('toggled');
            } else {
                $('.category-btn').removeClass('toggled');
                $('.fa-chevron-left').css({
                    'transform':'rotate(0deg)',
                    'overflow': 'hidden',
                    'transition-duration': '0.4s',
                    'transition-property': 'transform'
                });
                // $(this).addClass('toggled');
                $(this).removeClass('toggled');
                // $('#sub-menu').slideUp('fast');
                // $('#sub-menu').hide();
                $('#sub-menu').css({'display':'none'});
            }
        }
        

        if($(this).hasClass('toggled')) {
            // console.log("toggled");

            // display subcategory
            $.ajax({
                url:base_url+'get/subcategory',
                type:'post',
                data:{a:cat_id},
                dataType:'json',
                beforeSend: function(){
                    // $('.loader').show();
                },
                success: function(res) {
                    if(res.error == 0) {
                        
                        // $('.loader').fadeOut("slow");
                        var n = '';
                        for(i in res.data) {
                            var obj = res.data[i];
                            var myvar = '<button class="check-star btn-menu sub-cat-btn" data-id="'+obj.CATEGORY_ID+'" style="height: 45px;border: 1px solid #A88C35;background-color: #f4d164;color: #002323;padding: 4px 0px 2px 13px;font-size: 17px;"><span><i class="fa fa-star-o" aria-hidden="true"></i></span> '+obj.CATEGORY_NM+'</button>';
                            
                            n+=myvar;
                        }
                        
                        $('#sub-menu').html(n);

                        // animate scroll sub-cat
                        $('.sub-cat-btn').click(function() {
                            var subcat_id = $(this).data('id');
                            // $('.group').slideUp('slow');
                            // $('.group_'+subcat_id).slideDown('slow');
                            
                            // $('.group').fadeOut('slow');
                            // $('.group_'+subcat_id).fadeIn('slow');
                            
                            // $('.group').fadeOut('fast');
                            // $('.group_'+subcat_id).fadeIn('fast');
                            
                            $('.group').hide();
                            $('.group_'+subcat_id).show();

                            // var star = '<i class="fa fa-star" aria-hidden="true"></i>',star_o = '<i class="fa fa-star-o" aria-hidden="true"></i>';

                            // $('.check-star span').html(star);


                            // $('.check-star').addClass('fa-star');

                            // $('.group').slideUp('fast');
                            // $('.group_'+subcat_id).slideDown('fast');

                            // if($('.group_'+subcat_id).length > 0) {
                            //     $('.content-body').animate({
                            //         scrollTop: $('.group_'+subcat_id).offset().top
                            //     }, 800);
                            //     console.log($('.group_'+subcat_id).offset());
                            // }
                            
                        });

                    }
                }
            });

        }
        
        // draw group category
        $.ajax({
            url:base_url+'get/groupcategory',
            type:'post',
            data:{a:cat_id},
            dataType:'json',
           beforeSend: function(){
               // console.log("layout Group category");
                $('.content-body').empty();
                $('.loader').show();
                // $('.loader').fadeIn("slow");
           },
            success: function(res) {
                if(res.error == 0) {
                    var n = '';
                    var cat_first = 0;
                    for(i in res.data) {
                        var obj = res.data[i];

                        if(obj.CATEGORY_SUB_ID == null) {
                            var myvar = '<div class="group group_'+obj.CATEGORY_SUB_ID+'" data-parent="'+obj.CATEGORY_PARENT_ID+'" data-group-id="'+obj.CATEGORY_SUB_ID+'" style="/* height: 45px; */color: #f4d164;font-weight: bold;font-size: 17px;padding: 7px 0px 0px 0px;">'+
                            '<p class="cat-name" style="font-weight: bold;font-size: 17px;color: #f4d164;width: 15em;"></p>'+
                            '<div></div>'+
                            '</div>';
                        } else {
                            var note_content = '';
                            cat_first = cat_first + 1;
                            console.log(cat_first);
                            if(cat_first == 1) {
                                note_content = '<span style="float: right;">※画像タップでメニュー写真を大きく表示して頂けます。</span>';
                            } else {
                                note_content = '';
                            }
                            var myvar = '<div class="group group_'+obj.CATEGORY_SUB_ID+'" data-parent="'+obj.CATEGORY_PARENT_ID+'" data-group-id="'+obj.CATEGORY_SUB_ID+'" style="/* height: 45px; */color: #f4d164;font-weight: bold;font-size: 17px;padding: 7px 0px 0px 0px;">'+
                            '<p class="cat-name" style="font-weight: bold;font-size: 17px;color: #f4d164;    float: left;width: 100%;">'+obj.CATEGORY_NM+note_content+'</p>'+
                            '<div></div>'+
                            '</div>';
                        }
                        /* '<div class="content-header group group_'+obj.CATEGORY_SUB_ID+'" data-parent="'+obj.CATEGORY_PARENT_ID+'" data-group-id="'+obj.CATEGORY_SUB_ID+'" style="height: 45px;color: #f4d164;font-weight: bold;font-size: 17px;padding: 7px 0px 0px 0px;">'+obj.CATEGORY_NM+'</div>'; */
                        
                        /*  */
                        
                        n+=myvar;
                    }
                var cleanN = n + 
                    '<div class="end_category">' +
                        '<div class="menu_list_item" style="background-color:  black;border: 1px solid black; height: 400px;">'+
                            '<div class="menu-header" data-img="no_img.png">'+
                                '<div class="menu-image">'+
                            '</div>'+
                        '<div class="menu-details">'+
                            '<p class="detail-header"></p>'+
                            '<p class="detail-body" style="overflow: hidden;"></p>'+
                        '</div>'+
                        '</div>'+
                            '<div class="menu-footer">'+
                            '</div>'+
                        '</div>'+
                    '</div>';
                    $('.content-body').html(cleanN);

                    // display menu
                    $.ajax({
                        url:base_url+'get/menu',
                        type:'post',
                        data:{a:cat_id},
                        dataType:'json',
                     beforeSend: function(){
                        // $('.loader').show();
                        // $('.loader').fadeIn("slow");
                        // console.log("before the layout of items");
                        // $('.loader').fadeOut("slow");
                     }, 
                        success: function(res1) {
                        
                            if(res1.error == 0) {
                            console.log(res1.data);
                            $('.loader').hide();
                            // $('.loader').fadeOut("fast");
                                var batch_menu = [];
                                for(i in res1.data) {
                                    var obj = res1.data[i];
                                    batch_menu[obj.CATEGORY_SUB_ID] = [];
                                    batch_menu[obj.CATEGORY_SUB_ID]['cnt'] = 0;
                                    batch_menu[obj.CATEGORY_SUB_ID]['els'] = '';
                                }
                                
                                var parent_div = '<div class="batch-menu" data-category>';
                                var close_div = '</div>';
                                var n_parent = '';
                                var n_child = '';

                                var remaining = 0;
                                
                                var max_item = 2;

                                // if(res1.data.length < 4) {
                                //     max_item = res1.data.length;
                                // }

                                for(i in res1.data) {
                                    var obj = res1.data[i];

                                    if(obj.CATEGORY_PARENT_ID == '001') {
                                        var child_div = ''+
                                        '<div class="menu_list_item" data-group="'+obj.GROUP_ID+'" >'+
                                            '<div class="menu-header" data-img="'+obj.ITEM_IMG+'">'+
                                                // '<div class="menu-image" style="background: url(http://food.across-web.net/image/food/pizza-sliced.png);"></div>'+
                                                '<div class="menu-image" style="background: url(http://food.across-web.net/image/'+obj.ITEM_IMG+');"></div>'+
                                                '<div class="menu-details">'+
                                                    '<p class="detail-header">'+obj.ITEM_NM+'</p>'+
                                                    '<p class="detail-body" style="overflow: hidden;">'+obj.ITEM_DESC+'</p>'+
                                                '</div>'+
                                            '</div>'+
            
                                            '<div class="menu-footer" id="menu-footer">'+
                                                '<div class="gender-price menu-price-0">'+
                                                    '<div class="price male-price" style="background: #293EAA;">&#165;000</div>'+
                                                '</div>'+
                                                '<div class="gender-price menu-price-1">'+
                                                    '<div class="price female-price" style="background: #DA0895;">&#165;000</div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>';
        
                                    } else {
                                        var child_div = ''+
                                        '<div class="menu_list_item" data-group="'+obj.GROUP_ID+'">'+
                                            '<div class="menu-header" data-img="no_img.png">'+
                                                // '<div class="menu-image" style="background: url(http://busterfood.acrossweb.net/image/food/pizza-sliced.png);"></div>'+
                                                '<div class="menu-details">'+
                                                    '<p class="detail-header">'+obj.ITEM_NM+'</p>'+
                                                    '<p class="detail-body" style="overflow: hidden;">'+obj.ITEM_DESC+'</p>'+
                                                '</div>'+
                                            '</div>'+
            
                                            '<div class="menu-footer" id="menu-footer">'+
                                                '<div class="gender-price menu-price-0">'+
                                                    '<div class="price male-price" style="background: #293EAA;">&#165;000</div>'+
                                                '</div>'+
                                                '<div class="gender-price menu-price-1">'+
                                                    '<div class="price female-price" style="background: #DA0895;">&#165;000</div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>';
        
                                    }
                                    
                                    batch_menu[obj.CATEGORY_SUB_ID]['els'] += child_div;
                                    
                                }

                                for(i in batch_menu) {
                                    var obj = batch_menu[i];
                                    $('.group_'+i+' div').html(obj.els);
                                }

                                $.ajax({
                                    url:base_url+'get/pricegender',
                                    type:'post',
                                    //data:{a:cat_id},
                                    dataType:'json',
                                    success: function(res2) {
                                        if(res2.error == 0) {
                                            $('div.menu_list_item').each(function() {
                                                var res2_parent = $(this);
                                                var gid = $(this).data('group');
                                                for(i in res2.data) {
                                                    var obj2 = res2.data[i];
                                                    // var _price = obj2.ITEM_PRICE.toString();

                                                    // if(_price.length == 3) {
                                                    //     _price = _price.splice(2,0,',');
                                                    // }
                                                    obj2.ITEM_PRICE = obj2.ITEM_PRICE.toLocaleString();

                                                    if(_gender == 0) {
                                                        res2_parent.find('.menu-price-1').addClass('price-disabled');
                                                    } else if(_gender == 1) {
                                                        res2_parent.find('.menu-price-0').addClass('price-disabled');
                                                    }
                                                    if(gid == obj2.GROUP_ID && obj2.GENDER_FLG == 0) {
                                                        res2_parent.find('.menu-price-0').attr('data-item-id', obj2.ITEM_ID);
                                                        res2_parent.find('.menu-price-0').attr('data-gender-flg', obj2.GENDER_FLG);
                                                        res2_parent.find('.menu-price-0').attr('data-item-nm', obj2.ITEM_NM);
                                                        if(obj2.ITEM_PRICE == 0) {
                                                            res2_parent.find('.menu-price-0 div').html('無料');
                                                        } else {
                                                            res2_parent.find('.menu-price-0 div').html('&#165;'+obj2.ITEM_PRICE);
                                                        }

                                                    } else if(gid == obj2.GROUP_ID && obj2.GENDER_FLG == 1) {
                                                        res2_parent.find('.menu-price-1').attr('data-item-id', obj2.ITEM_ID);
                                                        res2_parent.find('.menu-price-1').attr('data-gender-flg', obj2.GENDER_FLG);
                                                        res2_parent.find('.menu-price-1').attr('data-item-nm', obj2.ITEM_NM);
                                                        if(obj2.ITEM_PRICE == 0) {
                                                            res2_parent.find('.menu-price-1 div').html('無料');
                                                        } else {
                                                            res2_parent.find('.menu-price-1 div').html('&#165;'+obj2.ITEM_PRICE);
                                                        }
                                                        
                                                    }

                                                }
                                                
                                                
                                            });
                                            
                                        }
                                    }
                                });

                                $('.menu-header').click(function () {
                                    var data_img = $(this).data('img');
                                    
                                    var file_name = $(this).data('img');

                                    if(data_img == 'no_img.png') {
                                        return false;
                                    }
                                    
                                    $('.view_image_modal').find('img').attr('src', 'http://food.across-web.net/image/'+file_name);
                                    $('.view_image_modal').modal();

                                });

                                $('.close_img').click(function() {
                                    $('.view_image_modal').modal('hide');
                                });

                                // click 
                                $('.gender-price').click(function() {
								    $('.note').val('');
    								$('.quantity_item').attr('data-status', '0');
    								$('.submit-to-cart').attr('data-flg', '0');
                                    var _self = $(this);
                                        
                                    iid = _self.data('item-id'),
                                    gender_flg = _self.data('gender-flg'),
                                    item_nm = _self.data('item-nm');
                                        
                                    // console.log(item_nm);
                                    $('.item-nm').html(item_nm);

                                    if(gender_flg == 0) {
                                        $('.itemDetail').find('div.qbox').removeClass('female').addClass('male');
                                    } else if(gender_flg == 1) {
                                        $('.itemDetail').find('div.qbox').removeClass('male').addClass('female');
                                    }

                                    if(!$(this).hasClass('price-disabled')) {
                                        $.ajax({
                                            url:base_url+'cart/menu/'+iid+'/read',
                                            type:'post',
                                            dataType:'json',
                                            beforeSend: function(){
                                                // updateQuantity($, zeroPad(0, 2));
                                            },
                                            success: function(res) {
                                                console.log(res);
                                                if(res.error == 0) {
                                                    // quantity = res.data[0];
                                                    // updateQuantity($, itm_quantity);
                                                    itm_quantity = res.data;
                                                    
                                                    console.log(res.data)
                                                    // updateQuantity($, zeroPad(res.data, 2));
                                                }
                                            }
                                        });
                                        $('.itemDetail').modal();

                                    }   
                                    
                                });
                                
                            }
            
                        }
                    });
                    
                }
            }
        });

        
        
    });
    $('.submit-to-cart').on('click',function() {
        // console.log(iid,gender_flg,$('.quantity_item').text(),quantity);
        var data_flg = $(this).attr('data-flg');
        // var item_quantity = $('.item_quantity').val();
        var item_quantity = $('.quantity_item').html();
	   var note = $('textarea.note').val();
        if(item_quantity == 0){
            item_quantity = 1;
        }
		// console.log(item_quantity);
        $('.countdown-modal').attr('data-bill', '1');
        $('.btn-checkOut').addClass('btn-glow');
        $.ajax({
            url:base_url+'cart/menu/'+iid+'/read',
            type:'post',
            dataType:'json',
            beforeSend: function(){
                // updateQuantity($, zeroPad(0, 2));
            },
            success: function(res) {
                console.log(res);
                if(res.error == 0) {
                    // quantity = res.data[0];
                    // updateQuantity($, itm_quantity);
                    var quantity = 0;
                    if(res.data == 99){
                        quantity = 99;
                    }else{
                        if(data_flg == 0){
                            quantity = parseInt(res.data) + parseInt(item_quantity);
                            if(quantity >= 99){
                                quantity = 99;
                            }
                        }else{ 
                            quantity = parseInt(item_quantity);
                        }
                    }
                    

                    // updateQuantity($, zeroPad(res.data, 2));
                                
				$.ajax({
					// url:base_url+'cart/add/'+iid+'/'+quantity,
					url:base_url+'cart/add',
					type:'post',
					data:{
						'item_id': iid,
						'quantity': quantity,
						'note': note
					},
					// dataType:'json',
					success: function(res1) {
						console.log(res1);
						$.ajax({
							url:base_url+'cart/view',
							type:'post',
							dataType:'json',
							success: function(res2) {
								console.log(res2);
								drawOrder($,res2);
							}
						});
						// console.log(res);
						//drawOrder($,res);
						$('.itemDetail').modal('hide');
					}
				});
                }
            }
        });
    });
    $('.category-btn').eq(0).trigger('click');

    /* billout */
    $('.billout-male').click(function() {
        var dVal = $(this).data('value');
        var data = {'gender_flg':dVal};
        $('.modal').modal('hide');
        // billOut(data);
        drawBillOut(data);
    });
    $('.billout-female').click(function() {
        var dVal = $(this).data('value');
        var data = {'gender_flg':dVal};
        $('.modal').modal('hide');
        // billOut(data);
        drawBillOut(data);
    });
    $('.billout-all').click(function() {
        var dVal = $(this).data('value');
        var data = {'gender_flg':dVal};
        drawBillOut(data, 1);
    });

    $('.btn-cancel').click(function() {
        $('.modal').modal('hide');
    });

    function drawBillOut(data,ty = 0) {
        billOut(data);
        $('.modal').modal('hide');
        if(ty == 1) {
            $('.billout-modal-ty').modal();
        }
        $('.btn-checkOut').removeClass('btn-glow');
        clearInterval();
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

    $('#note').on('focus', function() {
        $('.itemDetail').find('.modal-dialog').css({'top': '-28vw'});
    });

    $('#note').on('blur', function() {
        $('.itemDetail').find('.modal-dialog').css({'top': '0'});
    });
});

function drawMenu($, res) {

}

function drawOrder($, res) {
    var parent = $('.right-side-bar');
    var n = '';
    parent.find('.male-order .order-body').empty();
    parent.find('.female-order .order-body').empty();
    
         var lastItem = '<div class="delete-menu" style="float: left;height: 34px;width: 34px;padding: 4px 0px 0px 7px;"><i class="fa fa-times xitem" aria-hidden="true"></i></div>'+
            '<div class="edit-menu flg_1" style="float: left;height: 34px;width: 176px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;font-weight: bold;font-size: 16px;padding-top: 4px;padding-left: 5px;"> name </div>'+
            '<div style="float: left;height: 34px;width: 34px;font-size: 18px;font-weight: bold;padding: 4px 0px 0px 4px;"> 99 </div>';

    for(i in res.data) {
        var obj = res.data[i];
        if(obj.GENDER_FLG == 0) {
            var myvar = '<div class="delete-menu" data-item-id="'+obj.ITEM_ID+'" style="float: left;height: 34px;width: 34px;padding: 4px 0px 0px 7px;"><i class="fa fa-times xitem" aria-hidden="true"></i></div>'+
            '<div class="edit-menu flg_0" data-item-id="'+obj.ITEM_ID+'" style="float: left;height: 34px;width: 176px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;font-weight: bold;font-size: 16px;padding-top: 4px;padding-left: 5px;">'+obj.ITEM_NM+'</div>'+
            '<div style="float: left;height: 34px;width: 34px;font-size: 18px;font-weight: bold;padding: 4px 0px 0px 4px;">'+obj.PCS+'</div>';
            parent.find('.male-order .order-body').prepend(myvar);
        } else if(obj.GENDER_FLG == 1) {
            var myvar = '<div class="delete-menu" data-item-id="'+obj.ITEM_ID+'" style="float: left;height: 34px;width: 34px;padding: 4px 0px 0px 7px;"><i class="fa fa-times xitem" aria-hidden="true"></i></div>'+
            '<div class="edit-menu flg_1" data-item-id="'+obj.ITEM_ID+'" style="float: left;height: 34px;width: 176px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;font-weight: bold;font-size: 16px;padding-top: 4px;padding-left: 5px;">'+obj.ITEM_NM+'</div>'+
            '<div style="float: left;height: 34px;width: 34px;font-size: 18px;font-weight: bold;padding: 4px 0px 0px 4px;">'+obj.PCS+'</div>';
            parent.find('.female-order .order-body').prepend(myvar);
        }

    }
    $('.right-side-bar').find('.delete-menu').click(function(e) {
        e.preventDefault();
        var _self = $(this);
        iid = _self.data('item-id');
        
       $('.countdown-modal').attr('data-bill', '0');
       $('.btn-checkOut').removeClass('btn-glow');
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
        console.log(iid);
        
       // $('.submit-to-cart').val('min');
        $('.submit-to-cart').attr('data-flg', '1');
		$('.quantity_item').attr('data-status', '0');
        $.ajax({
            url:base_url+'cart/menu/'+iid+'/read',
            type:'post',
            dataType:'json',
            success: function(res) {
                console.log(res);
                if(res.error == 0) {
                    // quantity = res.data[0];
                // updateQuantity($, itm_quantity);
                itm_quantity = res.data;
                // updateQuantity($, zeroPad(itm_quantity, 2));
                updateQuantity($, itm_quantity, 2);
                }
            }
        });

        $('.itemDetail').modal();
    });

}

function updateQuantity($,num) {
    // $('.itemDetail').find('.item_quantity').val(num);
    $('.itemDetail').find('.quantity_item').html(num);
    
    /* if(num > 9) {
        // $('.itemDetail').find('.quantity_item').html(num);
        $('.itemDetail').find('.item_quatity').val(num);
    } else {
        // $('.itemDetail').find('.quantity_item').html('0'+num);
        $('.itemDetail').find('.item_quatity').val('0'+num);
    }  */
    
}

function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}

function requestLostFocus(){
    if(typeof app != 'undefined'){      
        app.lostFocus();
    }
}

function maxLengthCheck(object) {
    if (object.value.length > object.maxLength)
    object.value = object.value.slice(0, object.maxLength)
}
    
function isNumeric (evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode (key);
    // var regex = /[0-9.]|\./;
    var regex = /^(?:\d{1,3}(?:,\d{3})*|\d+)(?:\.\d+)?$/;
    
        if ( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
}

function placeOrderFood( jsonData ){
    
    /* $.ajax({
        url: '/v1/cart/order_food',
        type: 'POST',
        data: {
            data: jsonData
        },
        dataType:'json',
        beforeSend: function(){
            
        }, 
        success: function(resOrder){
            console.log(resOrder);
        }
    }); */
    $.ajax({
        url: '/v1/cart/order_food',
        type: 'POST',
        data:{
            data: jsonData, 
        },
        // dataType:'json',
        beforeSend: function(){}, 
        success: function(resOrder){

            console.log(resOrder);
            var result = $.parseJSON(resOrder);
            if(result.error == 0){
                window.location = '/v1/home';
                /* if(typeof app != 'undefined'){}else{} */
            }
        }
    });
}


function v2placeOrderFood( jsonData ){
    $.ajax({
        url: '/v2/cart/order_food',
        type: 'POST',
        data:{
            data: jsonData, 
        },
        // dataType:'json',
        beforeSend: function(){}, 
        success: function(resOrder){

            console.log(resOrder);
            var result = $.parseJSON(resOrder);
            if(result.error == 0){
                // window.location = '/v2/home';
                $('.btn-checkOut').removeClass('btn-glow');
                $('.submitDetail').modal('hide');
                $('#countdown-modal').modal('hide');
                $('.order-body').html('');
                 // if(typeof app != 'undefined'){}else{} 
            }
        }
    });
}