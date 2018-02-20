@extends('layouts.main')

@section('title', 'HOME')

@section('style')
<style>
	.ml27{
		margin-left: 27px; 
	}
	.mr27{
		margin-right: 27px; 
	}
	.mb10{
		margin-bottom: 10px; 
	}

	.number-style{
		height: 70px;   
		width: 70px;
		background-color: #002323;
		color: #f4d164;
		padding: 0px 0px 4px 0px;
		font-size: 23px;
		font-weight: bold;
		text-align: center;
		border-radius: 35px;
		align-items: center;
		line-height: 73px;
	}
    .batch-menu div.menu_list_item{
        height: 176px;
        width: 400px;
        border: 1px solid #E5CE4C;
        border-radius: 6px;
        padding: 10px;
        float: left;
        margin: 0px 12px 12px 0px;
        color: #ffffff;
    }
    .batch-menu div.menu_list_item:last-child{
        margin: 0px 0px 12px 0px;
    }
    .group div.menu_list_item:nth-child(odd) {
        margin: 0px 12px 12px 0px;
    }
    .group div.menu_list_item:nth-child(even) {
        margin: 0px 0px 12px 0px;
    }


    .menu_list_item {
        background-color:#141526;
        /* edited */
        height: 176px;
        width: 400px;
        border: 1px solid #E5CE4C;
        border-radius: 6px;
        padding: 10px;
        float: left;
        /* margin: 0px 12px 12px 0px; */
        color: #ffffff;
    }
    .menu_list_item div.menu-header{
        height: 104px;
        margin-bottom: 6px;
    }

    .menu_list_item div.no-img {
        width: 374px;
    }

    .menu_list_item div.menu-footer{
        height: 42px;
    }
    .menu-header div.menu-image{
        width: 120px;
        height: 104px;
        /* background-size: 180% auto !important; */
        background-size: 100% 100% !important;
        background-repeat: no-repeat !important;
        float: left;
        margin-right: 5px;
    }
    .menu-header div.menu-details{
        float: left;
        width: 251px;
        height: 104px;
    }
    .menu-footer div{
        float: left;
        width: 167px;
        height: 43px;
        margin-right: 42px;
    }
    .menu-footer div:last-child{
        margin-right: 0px;
    }
    .menu-footer div.price {
        text-align: center;
        font-size: 17px;
        font-weight: bold;
        padding-top: 9px;
        border-radius: 10px;
    }
    .menu-details p.detail-header{
        margin: 0;
        max-height: 53px;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .menu-details p.detail-body{
        margin: 0;
        height: 50px;
        font-size: 12px;
    }
    /* male */
    .itemDetail div.qbox.male button {
        background-color: #293EAA !important;
    }
    /* female */
    .itemDetail div.qbox.female button {
        background-color: #DA0895 !important;
    }

    .itemDetail div.qbox {
        float: left;
        width: 72px;
        height: 72px;
        margin-right: 24px;
    }
    .itemDetail div.qbox:last-child {
        margin-right: 0px;
    }
	input[type=number].no-spinner::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
		-webkit-appearance: none; 
		 margin: 0; 
	}
	.btn-clear{
		height: 70px;
		background-color: #002323;
		color: #f4d164;
		padding: 0px 0px 4px 0px;
		font-size: 26px;
		font-weight: bold;
		text-align: center;
		border-radius: 35px;
	}
	.btn-placeOrder{
		height: 70px;
		width: 264px;
		background-color: #002323;
		color: #f4d164;
		padding: 0px 0px 4px 0px;
		font-size: 26px;
		font-weight: bold;
		text-align: center;
		border-radius: 35px;
	}
	.btn-num.active.focus,
	.btn-num.active:focus,
	.btn-num.focus,
	.btn-num.focus:active,
	.btn-num:active:focus,
	.btn-num:focus {
		outline: 0 !important;
		outline-offset: 0  !important;
		background-image: none  !important;
		-webkit-box-shadow: none !important;
		box-shadow: none  !important;
	}
	.btn-num:active{
		color: #002323;
		background-color: #f4d164;
	}
</style>
@endsection

@section('content')
		
        <div class="menu-content-body" style="overflow-x: scroll;overflow-y: hidden;width: 100%;height: 100%;">

            <!-- <div class="content-header" style="height: 45px;color: #f4d164;font-weight: bold;font-size: 17px;padding: 7px 0px 0px 0px;">
                ハンバーグ
            </div> -->

            <div class="content-body" style="overflow-y:scroll;height: 800px;">

                <!-- <div class="group" data-group-id="" style="color: #f4d164;">
                    <p style="font-weight: bold;font-size: 17px;color: #f4d164;">ハンバーグ</p>
                    <div></div>
                </div> -->

                @for($i = 0;$i <= 1; $i++)

                

				<!-- <div class="category-menu"> -->
                <!-- <div class="batch-menu">
                    
                    <div class="menu_list_item">
                        <div class="menu-header">
                            <div class="menu-image" style="background: url(http://busterfood.acrossweb.net/image/food/pizza-sliced.png);"></div>
                            <div class="menu-details">
                                <p class="detail-header">システムメンテナンス中のため、現在使用できません。 test</p>
                                <p class="detail-body" style="overflow: hidden;">システムメンテナンス中のため、現在使用できません。システムメンテナンス中のため、現在使用できません。システムメンテナンス中のため、現在使用できません。</p>
                            </div>
                        </div>
                        <div class="menu-footer">

                            <div class="menu-price-1">
                                <div class="price male-price" style="background: #293EAA;">
                                    ¥10,000
                                </div>
                            </div>

                            <div class="menu-price-2">
                                <div class="price female-price" style="background: #DA0895;">
                                    ¥15,000
                                </div>
                            </div>

                        </div>
                    </div>
                    
                    <div class="menu_list_item">
                        <div class="menu-header">
                            <div class="menu-image" style="background: url(http://busterfood.acrossweb.net/image/food/pizza-sliced.png);"></div>
                            <div class="menu-details">
                                <p class="detail-header">システムメンテナンス中のため、現在使用できません。</p>
                                <p class="detail-body" style="overflow: hidden;">システムメンテナンス中のため、現在使用できません。システムメンテナンス中のため、現在使用できません。システムメンテナンス中のため、現在使用できません。システムメンテナンス中のため、現在使用できません。</p>
                            </div>
                        </div>
                        <div class="menu-footer">

                            <div class="menu-price-1">
                                <div class="price male-price" style="background: #293EAA;">
                                    ¥10,000
                                </div>
                            </div>

                            <div class="menu-price-2">
                                <div class="price female-price" style="background: #DA0895;">
                                    ¥15,000
                                </div>
                            </div>

                        </div>
                    </div>

                </div> -->
				<!-- </div> -->
               
                @endfor

                @for($i = 0;$i <= 5; $i++)

                <!-- <div class="batch-menu">
                    
                    <div class="menu_list_item">
                        <div class="menu-header">
                            <div class="menu-details no-img" style="width:374px;">
                                <p class="detail-header">システムメンテナンス中のため、現在使用できません。</p>
                                <p class="detail-body" style="overflow: hidden;">システムメンテナンス中のため、現在使用できません。システムメンテナンス中のため、現在使用できません。システムメンテナンス中のため、現在使用できません。</p>
                            </div>
                        </div>
                        <div class="menu-footer">

                            <div class="menu-price-1">
                                <div class="price male-price" style="background: #293EAA;">
                                    ¥10,000
                                </div>
                            </div>

                            <div class="menu-price-2">
                                <div class="price female-price" style="background: #DA0895;">
                                    ¥15,000
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="menu_list_item">
                        <div class="menu-header">
                            <div class="menu-details no-img" style="width:374px;">
                                <p class="detail-header">システムメンテナンス中のため、現在使用できません。</p>
                                <p class="detail-body" style="overflow: hidden;">システムメンテナンス中のため、現在使用できません。システムメンテナンス中のため、現在使用できません。システムメンテナンス中のため、現在使用できません。システムメンテナンス中のため、現在使用できません。</p>
                            </div>
                        </div>
                        <div class="menu-footer">

                            <div class="menu-price-1">
                                <div class="price male-price" style="background: #293EAA;">
                                    ¥10,000
                                </div>
                            </div>

                            <div class="menu-price-2">
                                <div class="price female-price" style="background: #DA0895;">
                                    ¥15,000
                                </div>
                            </div>

                        </div>
                    </div>

                </div> -->

                @endfor

                   
            </div>

            


                <!-- overflow x -->

            <!-- Modal -->
            <div id="itemDetail" class="modal itemDetail" role="dialog"> <!-- data-keyboard="false" data-backdrop="static" -->
                <div class="modal-dialog modal-sm" style="top: 10em;width:594px;">
				
                    <div class="modal-content" style="height: 342px;padding: 16px;background-color: #333333;border: 1px solid #f4d164;border-radius: 10px;color: white;">
					<div class="row">
						<div class="col-md-6" style="padding-right: 0px;">
							<div style="text-align: center;font-size: 26px;height: 35px;font-weight: bold;margin-bottom: 5px;">数量を決めて下さい</div>
							<div class="item-nm" style="text-align: center;font-size: 16px;height: 21px;"> </div> <!-- 現在使用できません。システムメンテ -->

							<div style="margin-top: 48px;height: 72px;margin-bottom: 60px;">
								<div class="qbox">
									<button id="minusQuantity" class="minusQuantity btn" style="width: 100%;height: 100%;background-color: #293EAA;border: 0px;border-radius: 5px;"><i class="fa fa-minus" aria-hidden="true" style="font-size: 30px;"></i></button>
								</div>

								<div class="qbox" style="background-color: #ffffff;color: black;text-align: center;font-size: 40px; padding-top: 0px;">
									<!-- <input onblur="requestLostFocus();" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" id="item_quantity" type="number" class="item_quantity qbox quantity_item no-spinner" value="01" min="01" max="99" maxlength="2" style="width: 72px;height: 100%;text-align: center;">-->
									<div class="qbox quantity_item" style="background-color: #ffffff;color: black;text-align: center;font-size: 40px;padding-top: 5px;">1</div>
								</div>
							 
								<div class="qbox">
									<button id="addQuantity" class="addQuantity btn" style="width: 100%;height: 100%;background-color: #293EAA;border: 0px;border-radius: 5px;"><i class="fa fa-plus" aria-hidden="true" style="font-size: 30px;"></i></button>
								</div>
							</div>
							
							<div style="height: 72px; /*padding: 0px 40px 0px 40px;*/">
								<button class="submit-to-cart btn-menu btn-num btn-placeOrder">確　定</button>
							</div>
							
						</div>
						<div class="col-md-6" style="padding-left: 17px;">
							<table>
								<tr>
									<td> 
										<button data-num="1" class="btn-num num-btn number-one number-style btn-menu mr27 mb10">1</button>
									</td>
									<td>
										<button data-num="2" class="btn-num num-btn number-two number-style btn-menu mb10">2</button>
									</td>
									<td>
										<button data-num="3" class="btn-num num-btn number-three number-style btn-menu ml27 mb10">3</button>
									</td>
								</tr>
								<tr>
									<td> 
										<button data-num="4" class="btn-num num-btn number-four number-style btn-menu mr27 mb10">4</button>
									</td>
									<td>
										<button data-num="5" class="btn-num num-btn number-five number-style btn-menu mb10">5</button>
									</td>
									<td>
										<button data-num="6" class="btn-num num-btn number-six number-style btn-menu ml27 mb10">6</button>
									</td>
								</tr>
								<tr>
									<td> 
										<button data-num="7" class="btn-num num-btn number-seven number-style btn-menu mr27 mb10">7</button>
									</td>
									<td>
										<button data-num="8" class="btn-num num-btn number-eight number-style btn-menu mb10">8</button>
									</td>
									<td>
										<button data-num="9" class="btn-num num-btn number-nine number-style btn-menu ml27 mb10">9</button>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<button class="btn-num btn-clear btn-menu">クリア</button>
									</td>
									<td>
										<button data-num="0" class="btn-num num-btn number-zero number-style btn-menu ml27 mb10">0</button>
										<input type="hidden" class="calc">
									</td>
								</tr>
							</table>
						</div>
					</div>
                       
                        
                    </div>

                </div>
            </div>
            
        
        </div> <!-- e menu-content-body -->

    <!-- </div> -->

    <!-- <div id="Paris" class="tabcontent">
        <h3>Paris</h3>
        <p>Paris is the capital of France.</p> 
    </div>

    <div id="Tokyo" class="tabcontent">
        <h3>Tokyo</h3>
        <p>Tokyo is the capital of Japan.</p>
    </div> -->


@endsection

@section('script')
    {{ Html::script('js/scripts/plugin/add_minus/add_minus_plugin.js') }}
    {{ Html::script('js/scripts/buster_menu.js') }}
    {{ Html::script('js/scripts/content-menu.js') }}
    {{ Html::script('js/scripts/buster_cart.js') }}
@endsection