$(document).ready(function() {
	
	$.ajax({
		url: 'fs/back/get/catlist/1',
		type:'GET',
		dataType:'json',
		success: function(res) {
			if(res.error == 0){
				var n = '';
				for(x in res.data){
					var obj = res.data[x];
					var catContent = '<div class="panel panel-default category-id" data-seq="'+ obj.SEQ +'" data-id="'+ zeroPad(obj.CATEGORY_ID, 3) +'" style="border-radius: 0px;">'+
							'<div class="panel-heading" data-toggle="collapse" data-target="#cat-'+ zeroPad(obj.CATEGORY_ID, 3) +'">'+
								obj.CATEGORY_NM +
								'<span class="pull-right"><i class="fa fa-fw fa-th-list"></i></span>'+
							'</div> '+   
									  
							'<div class="panel-body cat-'+ zeroPad(obj.CATEGORY_ID, 3) +' collapse in" id="cat-'+ zeroPad(obj.CATEGORY_ID, 3) +'" style="padding: 0;"> '+
								'<div class="box-body item-body category-'+ zeroPad(obj.CATEGORY_ID, 3) +'">'+
									// '<div class="row item-container"style="margin-right: 0px;margin-left: 0px;width: 100%;margin: 0 auto;padding: 0;">'+
										
									// '</div>'+
								'</div>'+
							'</div>'+
						'</div>';
						
					n+=catContent;
				}
				$('#items-content').html(n);

				$.ajax({
					url: 'fs/back/get/catlist/0',
					type:'GET',
					dataType:'json',
					success: function(res) {
						if(res.error == 0){
							// console.log(res.data);
							// if(res.data)
							var i = '';
							for(x in res.data){
								var obj1 = res.data[x];
								// if(obj1.CATEGORY_ID == '1'){
									
								// }
								var subcatContent = '<div class="panel panel-default sub-category-id" data-id="'+ zeroPad(obj1.CATEGORY_ID, 3) +'" data-seq="'+ obj1.SEQ +'" style="border-radius: 0px;">'+
									'<div class="panel-heading" data-toggle="collapse" data-target="#sub-cat-'+ zeroPad(obj1.CATEGORY_ID, 3) +'">'+
										obj1.CATEGORY_NM +
										'<span class="pull-right"><i class="fa fa-fw fa-th-list"></i></span>'+
									'</div> '+   
												
									'<div class="panel-body sub-cat-'+ zeroPad(obj1.CATEGORY_ID, 3) +' collapse in" style="padding: 0;" id="sub-cat-'+zeroPad(obj1.CATEGORY_ID, 3)+'"> '+
										'<div class="box-body item-body items-'+ zeroPad(obj1.CATEGORY_ID, 3) +' sub-category-'+ zeroPad(obj1.CATEGORY_ID, 3) +'" >'+
											// '<div class="row item-container"style="margin-right: 0px;margin-left: 0px;width: 100%;margin: 0 auto;padding: 0;">'+
												
											// '</div>'+
										'</div>'+
									'</div>'+
								'</div>';
								
								i+=subcatContent;
							}
							$('.category-001').html(i);
							
							var parent_category_id = $('.category-id').attr('data-id');
							$('.category-id').find( ".sub-category-id" ).each(function() {
								var sub_category_id = $(this).attr('data-id');
								$.ajax({
									url: 'fs/back/get/fooditemlist/'+parent_category_id+'/'+sub_category_id,
									type:'GET',
									dataType:'json',
									success: function(res) {
										// console.log(res);
										if(res.error == 0){
											
											var n = '';
											var itemStart = '<ul id="item_seq'+'" class="item_seq ui-sortable" style="list-style-type: none;padding: 3px 0px 3px 0px;list-style: none;margin: 0;">', 
												itemEnd = '</ul>';
												
											for(x in res.data){
												var obj = res.data[x];
												if(obj.ITEM_PRICE_0 == 0) {
													obj.ITEM_PRICE_0 = '無料';
												}
												if(obj.ITEM_PRICE_1 == 0) {
													obj.ITEM_PRICE_1 = '無料';
												}
												var item_icon = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
												if(obj.VIEW_FLG == 1) {
													item_icon = '<i class="fa fa-eye" aria-hidden="true"></i>';
												}
												var itemContent = ''+
													'<li id="item_'+obj.ITEM_ID+'" data-seq="'+obj.SEQ+'" class="item_list" data-id="'+obj.ITEM_ID+'">'+
														'<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 thumb item-dtl" style="cursor: move;">'+
														
															'<div class="panel panel-primary" style="border-radius: 0px; margin-right: 0px; width: 146px; ">'+
																'<div class="panel-heading" style="text-align: right; border-radius: 0px;">'+
																	'<span class="item_name">	<i class="fa fa-fw fa-th-list"></i> </span>'+
																'</div>'+
																'<div class="panel-body itm-body">'+
																	'<div class="item-img">'+
																		'<img class="img" src="image/'+obj.ITEM_IMG+'" alt="" style="width: 126px;height: 100px;">'+
																	'</div>'+
																		'<div class="item-nm" style="height: 50px;width: 130px;">'+
																			'<p> '+obj.ITEM_NM+' </p>'+
																		'</div>'+
																	'<div class="row" style="margin: 0px;">'+
																		'<div class="col-md-6" style="padding-left: 0px;padding-right: 0px;">'+
																			'<button class="btn btn-xs btn-primary" data-id="'+obj.ITEM_ID_0+'" style="width: 55px;height: 34px;background-color: #276ba7"> '+obj.ITEM_PRICE_0+' </button>'+
																		'</div>'+
																		'<div class="col-md-6" style="padding-left: 7px;padding-right: 0px;">'+
																			'<button class="btn btn-xs btn-primary" data-id="'+obj.ITEM_ID_1+'" style="width: 55px;height: 34px;background-color: #ed43b1"> '+obj.ITEM_PRICE_1+' </button>'+
																		'</div>'+
																	'</div>'+
																	'<div class="row" style="padding-top: 16px;">'+
																		'<div class="col-md-4" style="padding-left: 15px;padding-right: 0px;">'+
																			'<button class="btn btn-sm btn-primary btn-size view-item" data-id="'+obj.ITEM_ID+'"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button>'+
																		'</div>'+
																		'<div class="col-md-4" style="padding-left: 11px;padding-right: 0px;">'+
																			'<button class="btn btn-sm btn-size btn-warning view-btn" data-id="'+obj.ITEM_ID+'" style="margin-right: 15px;">'+item_icon+'</button>'+
																		'</div>'+
																		'<div class="col-md-4" style="padding-left: 5px;padding-right: 0px;">'+
																			'<button class="btn btn-sm btn-danger btn-size delete-item" data-id="'+obj.ITEM_ID+'"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'+
																		'</div>'+
																	'</div>'+
																'</div>'+
															'</div>'+
														'</div>'+
													'</li>';
												
												n+=itemContent;
											}
											$('.view-btn').unbind().click(function() {
												var id = $(this).data('id');
												var _this = $(this);
												$.ajax({
													url:'fs/back/update/item/view',
													type:'post',
													data:{item_id:id},
													dataType:'json',
													success: function(res) {
														if(res.error == 0) {
															var item_icon;
															if(res.data == 1) {
																item_icon = '<i class="fa fa-eye" aria-hidden="true"></i>';
															} else {
																item_icon = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
															}
															_this.html(item_icon);
														}
													}
												});
											});
											
											// console.log(itemStart + n + itemEnd);
											// $('.category-'+category_id).html("hello world category - "+category_id);
											$('.sub-category-'+sub_category_id).html(itemStart + n + itemEnd);
											if(res.data.length == 0){
												$('.sub-cat-'+sub_category_id).addClass('collapse');
											}
											
											$(".item_seq").sortable({
												refreshPositions: true,
												opacity: 0.3,
												scroll: true,
												tolerance: 'pointer',  
												placeholder: "ui-sortable-placeholder",
												change: function (event, ui) {
													// console.log(ui.item.attr('data-id'));
													// console.log(ui.item.attr('data-seq'));
													
												},
												start: function (event, ui) {
														ui.item.toggleClass("highlight");
												},
												stop: function (event, ui) {
														ui.item.toggleClass("highlight");
												},
												update: function (event, ui){
													var data = $(this).sortable('serialize');
													
													console.log(data);
													$.ajax({
														url: '/fs/back/create/item-seq',
														type: "POST", 
														data: {
															'data': data
														},
														beforeSend: function(){
															// $('.loader').show();
														},
														success: function(data){
															// $('.loader').hide();
															console.log(data);
													
														},
														error: function (err) {
															console.log(err);
																
														}
													});
												}
											});
											
											
										}
									}
								});
							});
							
							
						}
						
					}
				});
					
					// console.log( $('.category-container').attr('data-id') );
						// console.log($('.category-id').attr('data-id'));
						
					$( ".category-id" ).each(function() {
						var category_id = $(this).attr('data-id');
						
						// console.log( $(this).find('.sub-category-id').attr('data-id') );
						if(category_id != 1){
							$.ajax({
								url: 'fs/back/get/itemslist/'+category_id,
								// url: 'fs/back/get/itemslist/015',
								type:'GET',
								dataType:'json',
								success: function(res) {
									if(res.error == 0){
										
										var n = '';
										var itemStart = '<ul id="seq_item'+'" class="seq_item ui-sortable" style="list-style-type: none;padding: 3px 0px 3px 0px;list-style: none;margin: 0;">', 
											itemEnd = '</ul>';

											
											
										for(x in res.data){
											var obj = res.data[x];
											var itemContent = ''+
												'<li id="item_'+obj.ITEM_ID+'" data-seq="'+obj.SEQ+'" class="item_list" data-id="'+obj.ITEM_ID+'">'+
													'<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 thumb item-dtl" style="cursor: move;">'+
													
														'<div class="panel panel-primary" style="border-radius: 0px; margin-right: 0px; width: 146px; ">'+
															'<div class="panel-heading" style="text-align: right; border-radius: 0px;">'+
																'<span class="item_name">	<i class="fa fa-fw fa-th-list"></i> </span>'+
															'</div>'+
															'<div class="panel-body itm-body">'+
																'<div class="item-img">'+
																	'<img class="img" src="image/'+obj.ITEM_IMG+'" alt="" style="width: 126px;height: 100px;">'+
																'</div>'+
																	'<div class="item-nm" style="height: 50px;width: 130px;">'+
																		'<p> '+obj.ITEM_NM+' </p>'+
																	'</div>'+
																'<div class="row" style="margin: 0px;">'+
																	'<div class="col-md-6" style="padding-left: 0px;padding-right: 0px;">'+
																		'<button class="btn btn-xs btn-primary" data-id="'+obj.ITEM_ID_0+'" style="width: 55px;height: 34px;background-color: #276ba7"> '+obj.ITEM_PRICE_0+' </button>'+
																	'</div>'+
																	'<div class="col-md-6" style="padding-left: 7px;padding-right: 0px;">'+
																		'<button class="btn btn-xs btn-primary" data-id="'+obj.ITEM_ID_1+'" style="width: 55px;height: 34px;background-color: #ed43b1"> '+obj.ITEM_PRICE_1+' </button>'+
																	'</div>'+
																'</div>'+
																'<div class="row" style="padding-top: 16px;">'+
																	'<div class="col-md-4" style="padding-left: 15px;padding-right: 0px;">'+
																		'<button class="btn btn-sm btn-primary btn-size view-item" data-id="'+obj.ITEM_ID+'"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button>'+
																	'</div>'+
																	'<div class="col-md-4" style="padding-left: 11px;padding-right: 0px;">'+
																		'<button class="btn btn-sm  btn-warning btn-size" data-id="'+obj.ITEM_ID+'" style="margin-right: 15px;"><i class="fa fa-eye" aria-hidden="true"></i></button>'+
																	'</div>'+
																	'<div class="col-md-4" style="padding-left: 5px;padding-right: 0px;">'+
																		'<button class="btn btn-sm btn-danger btn-size delete-item" data-id="'+obj.ITEM_ID+'"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'+
																	'</div>'+
																'</div>'+
															'</div>'+
														'</div>'+
													'</div>'+
												'</li>';
											
											n+=itemContent;
										}
										// console.log(itemStart + n + itemEnd);
										// $('.category-'+category_id).html("hello world category - "+category_id);
										$('.category-'+category_id).html(itemStart + n + itemEnd);
										if(res.data.length == 0){
											$('.cat-'+category_id).addClass('collapse');
										}
										
										$(".seq_item").sortable({
											refreshPositions: true,
											opacity: 0.3,
											scroll: true,
											tolerance: 'pointer',  
											placeholder: "ui-sortable-placeholder",
											change: function (event, ui) {
												// console.log(ui.item.attr('data-id'));
												// console.log(ui.item.attr('data-seq'));
											},
											start: function (event, ui) {
												ui.item.toggleClass("highlight");
											},
											stop: function (event, ui) {
												ui.item.toggleClass("highlight");
											},
											update: function (event, ui){
												var data = $(this).sortable('serialize');
												
												console.log(data);
												$.ajax({
													url: '/fs/back/create/item-seq',
													type: "POST", 
													data: {
														'data': data
													},
													beforeSend: function(){
														// $('.loader').show();
													},
													success: function(data){
														// $('.loader').hide();
														console.log(data);
												
													},
													error: function (err) {
														console.log(err);
															
													}
												});
											}
										});
										
										
									}
										
								}
							});
						
						}
					});
					
							
					
			}
		}
	});

	$('.create-item').click(function(){
		$('#myModal').modal();
		$('.flg').val('0');
		$('.modal-title').html('New Entry');
		$('.upload-image').attr('data-status', 0);
		$('.upload-image').val("");
		if($(this).val() == 1){
			$('.sub-cat-container').show();
		}else{
			$('.sub-cat-container').hide();
		}
		$('.myModal button#submit_item').text('Create');
		removeError();
		clearData();
	});
	
	$.ajax({
		url: 'fs/back/get/catlist/1',
		type:'GET',
		dataType:'json',
		beforeSend: function(){
			// $('.loader').show();
		},
		success: function(res) {
			if(res.error == 0){
				for(x in res.data){
					var obj = res.data[x];
					$('#category').append($('<option>', {
						value: obj.CATEGORY_ID,
						text: obj.CATEGORY_NM
					}));
				}
				
				$.ajax({
					url: 'fs/back/get/catlist/0',
					type:'GET',
					dataType:'json',
					beforeSend: function(){
						// $('.loader').show();
					},
					success: function(res) {
						if(res.error == 0){
							for(x in res.data){
								var obj = res.data[x];
								$('#sub-category').append($('<option>', {
									value: obj.CATEGORY_ID,
									text: obj.CATEGORY_NM
								}));
							}
							
						}
					}
				});
				
			}
		}
	});
	

	
	$('#category').on('change', function(){
		if($(this).val() == 1){
			$('.sub-cat-container').show();
		}else{
			$('.sub-cat-container').hide();
		}
	}); 
	
	$('.upload-image').click(function() { 
		$(this).val(""); 
		// if($(this).attr('data-status') == 0){}
	});
	
	$('.submit_item').click(function(){

		var formData = new FormData($("#createItem")[0]);
		console.log(formData);
		$.ajax({
			url: '/fs/back/create/item',
			type: "POST",
			data: formData,
			// headers: {
				// 'X-CSRF-TOKEN' : $('meta[name="_token"]').attr('content')
			// },
			async: true,
			cache: false,
			processData: false,
			contentType: false,
			beforeSend: function(){
				$('.form-group').popover('destroy');
				// $('.form-group').removeClass('enable-tooltip').tooltip('destroy');
				// $('input').removeAttr('title');
				// $('textarea').removeAttr('title');
				removeError();
			},
			success: function(result){
				// if(response == 1){
					// window.location = window.location.href.split("?")[0];
				// }
				
				console.log(result);
				var json = $.parseJSON(result);
				var options = {
					container: 'body',
					trigger: 'hover'
				};
				console.log(json);
				if(json.error == 0){
					location.reload();
					console.log("success");
				}else if(json.error == 2){
					options.content = json.msg;
					$('[data-req="male_id"]').addClass('has-error').popover(options);
					$('[data-req="female_id"]').addClass('has-error').popover(options);
				}else{
	
					$.each(json.msg, function(k, v) {
						$.each(v, function(key, val){
							$('[data-req="'+key+'"]').addClass('has-error');
							// $('.'+key).attr('title', val);
							options.content = val;
							$('[data-req="'+key+'"]').popover(options);
							// $('[data-req="'+key+'"]').popover('show');
						});
					});
				}
			},
			error: function (err) {
				console.log(err);
					
			}
		});
	});
	
	$('.generate_id').click(function(){
		var gender_type = $(this).attr('data-type');
		/* $.ajax({
			url: 'fs/back/get/item-dtl',
			type:'GET',
			dataType:'json',
			beforeSend: function(){ 
			},
			success: function(res) {
				if(res.error == 0){
					var obj_itemID = parseInt(res.item_id);
					
					var errCount = 2;
					$('input[type="text"].item_dtl_id').each(function () {
						if($(this).val() == ""){
							errCount --;
						}
					});
					if(errCount == 0){
						errCount = 1;
					}else{
						errCount += 1;
					}
					if(gender_type != 0){
						$('#female_id').val( zeroPad(obj_itemID + parseInt(errCount), 12) );
					}else{
						$('#male_id').val( zeroPad(obj_itemID + parseInt(errCount), 12) );
					}
				}
			}
		}); */
		
	});
	
	
	$(document).on('click', '.view-item', function(){ 
		var item_id = $(this).attr('data-id');
		$('.flg').val('1');
		$.ajax({
			url: 'fs/back/get/item/'+item_id,
			type:'GET',
			dataType:'json',
			beforeSend: function(){
				// $('.loader').show();
				$('#myModal').modal();
				$('.modal-title').html('商品作成/修正');
				clearData();
			},
			success: function(res) {
				console.log(res);
				var obj = res.data;
				for(x in res.data){
					var obj = res.data[x];
					$('.group_id').val(zeroPad(obj.ITEM_ID, 12));
					$('.seq').val(obj.SEQ);
					$('.item_nm').val(obj.ITEM_NM);
					$('.item_description').val(obj.ITEM_DESC);
					$('.category').val( parseInt(obj.CATEGORY_PARENT_ID) );
					if(parseInt(obj.CATEGORY_PARENT_ID) == 1){
						$('.sub-cat-container').show();
						$('.sub-category').val( parseInt(obj.CATEGORY_SUB_ID) );
					}else{
						$('.sub-cat-container').hide();
						console.log("hide me");
					}
					$('.male_id').val(obj.ITEM_ID_0);
					$('.male_price ').val(obj.ITEM_PRICE_0);
					$('.female_id ').val(obj.ITEM_ID_1);
					$('.female_price ').val(obj.ITEM_PRICE_1);
					$('.item-img').attr('src', '/image/'+obj.ITEM_IMG);
					$('.upload-image').attr('data-status', 1);
					// $('.item-img').attr({
						// 'data-status': "1",
						// 'src': '/image/'+obj.ITEM_IMG
					// });
				}
				$('.myModal button#submit_item').text('Update');
			}
		});
	});
	
	
	
	// $('.delete-item').click(function(){
	$(document).on('click', '.delete-item', function(){ 
		var item_id = $(this).attr('data-id');
		 $('.deleteModal').modal();
		 $('.delete-yes').click(function(){
			$.ajax({
				url: 'fs/back/delete/item',
				type:'POST',
				data: {
					'item_id' : item_id,
				},
				dataType:'json',
				beforeSend: function(){
					// $('.loader').show();
				},
				success: function(res) {
					console.log(res.error);
					if(res.error == 0){
						location.reload();
					}
					
				}
			});
		 });
	});
}); 

function removeError(){
	$('.form-group').removeClass('has-error');
	$('input').removeAttr('title');
	$('textarea').removeAttr('title');
	$('.popover').remove();
}

function clearData(){
	$('.group_id').val('');
	$('.seq').val('');
	$('.item_nm').val('');
	$('.item_description').val('');
	$('.category').val('');
	$('.sub-category').val('');
	$('.male_id ').val('');
	$('.male_price ').val('');
	$('.female_id ').val('');
	$('.female_price ').val('');
	$('.item-img').attr('src', '/image/no_image_startup.png');
}

function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}

$(function () {
    $(":file").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });
});

function imageIsLoaded(e) {
    $('.item-img').attr('src', e.target.result);
};

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