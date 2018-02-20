@extends('layouts.main')

@section('title', 'HOME')

@section('style')
<style>
	.category-items{
		height: 235px;
		width: 811px;
		border: 1px solid #E5CE4C;
		border-radius: 6px;
		padding: 10px;
		float: left;
		margin: 0px 12px 12px 0px;
		color: #ffffff;
	}
    .batch-menu div.menu_list_item{
        /* height: 176px; */
        height: 180px;
        /* width: 400px; */
        width: 388px;
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
    .menu_list_item {
        background-color:#141526;
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
        background-size: 180% auto !important;
        background-repeat: no-repeat !important;
        float: left;
        margin-right: 5px;
    }
    .menu-header div.menu-details{
        float: left;
        /* width: 251px;*/
		width: 240px;
        height: 104px; 
    }
    .menu-footer div{
        float: left;
        /* width: 167px; */
        width: 162px;
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
        height: 53px;
        font-size: 17px;
        font-weight: bold;
    }
    .menu-details p.detail-body{
        margin: 0;
        height: 50px;
        font-size: 12px;
    }

    .itemDetail div.qbox {
        float: left;
        width: 72px;
        height: 72px;
        margin-right: 14px;
    }
    .itemDetail div.qbox:last-child {
        margin-right: 0px;
    }

</style>
@endsection

@section('content')

        <div class="menu-content-body" style="overflow-x: scroll;overflow-y: hidden;width: 100%;height: 100%;">

            <div class="content-header" style="height: 45px;color: #f4d164;font-weight: bold;font-size: 17px;padding: 7px 0px 0px 0px;">
                ハンバーグ
            </div>

            <div class="content-body" style="overflow-y:scroll;height: 743px;">

                @for($i = 0;$i <= 1; $i++)
				<!-- <div class="category-items">
					<p class="detail-header">Category Item</p>
					<div class="batch-menu">
						
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

					</div>
				</div> -->
               
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
            <div id="itemDetail" class="modal fade itemDetail" role="dialog">
                <div class="modal-dialog modal-sm" style="top: 14em;width:360px;">

                    <!-- Modal content-->
                    <div class="modal-content" style="height: 300px;padding: 14px;background-color: #333333;border: 1px solid #f4d164;border-radius: 10px;color: white;">
                    
                        <div style="text-align: center;font-size: 26px;height: 35px;font-weight: bold;margin-bottom: 5px;">数量を決めて下さい</div>
                        <div style="text-align: center;font-size: 16px;height: 21px;">現在使用できません。システムメンテ</div>
                        <div style="padding: 42px 40px 25px 40px;height: 139px;">
                            <div class="qbox">
                                <button class="minusQuantity" style="width: 100%;height: 100%;background-color: #293EAA;border: 0px;border-radius: 5px;"><i class="fa fa-minus" aria-hidden="true" style="font-size: 30px;"></i></button>
                            </div>

                            <div class="qbox quantity_item" style="background-color: #ffffff;color: black;text-align: center;font-size: 40px;padding-top: 5px;">01</div>

                            <div class="qbox">
                                <button class="addQuantity" style="width: 100%;height: 100%;background-color: #293EAA;border: 0px;border-radius: 5px;"><i class="fa fa-plus" aria-hidden="true" style="font-size: 30px;"></i></button>
                            </div>
                        </div>
                        <div style="height: 72px;padding: 0px 40px 0px 40px;">
                            <button class="submit-to-cart btn-menu" style="height: 71px;background-color: #002323;color: #f4d164;padding: 0px 0px 4px 0px;font-size: 26px;font-weight: bold;text-align: center;border-radius: 35px;">確　定</button>
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