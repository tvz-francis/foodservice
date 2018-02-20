<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

        <title>@yield('title') - BusterFood</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        {{ Html::style('css/bootstrap/bootstrap.css') }}
        {{ Html::style('css/fonts/fontawesome/css/font-awesome.min.css') }}
        {{Html::style('css/v2/main.css')}}
        <!-- Styles -->

        @yield('style')
        {{Html::style('/css/1920x1080.css')}}

    </head>
    <body style="position: fixed; overflow-y: scroll; width: 100%;">
	
        <div id="buster-section" style="height: 100%;overflow: hidden;">

            <div class="tab" style="background-color: black;border-left: 1px solid black !important;">
                <div>
                @if($data)

                    @foreach($data as $key)
                        
                        @if($key->CATEGORY_ID == '001')

                        <button class="x-toggle btn-menu category-btn" data-id="{{ $key->CATEGORY_ID }}" style="height: 65px;font-size: 17px;padding: 4px 15px 0px 18px;">{{$key->CATEGORY_NM}}<i class="fa fa-chevron-left fa-1" aria-hidden="true" style="float: right;margin-top: 3px;"></i></button>

                        @endif
                        
                    @endforeach

                    <div class="top-cat" style="/* height: 663px;*/ height: 640px; overflow-y: scroll;">
                        <div id="sub-menu" class="collapse">

                            <button class="btn-menu" style="height: 45px;border: 1px solid #A88C35;background-color: #f4d164;color: #002323;padding: 0px 0px 2px 13px;font-size: 17px;"><i class="fa fa-star" aria-hidden="true"></i> ビールビル</button>
                            <button class="btn-menu" style="height: 45px;border: 1px solid #A88C35;background-color: #f4d164;color: #002323;padding: 0px 0px 2px 13px;font-size: 17px;"><i class="fa fa-star-o" aria-hidden="true"></i> ービル</button>
                            <button class="btn-menu" style="height: 45px;border: 1px solid #A88C35;background-color: #f4d164;color: #002323;padding: 0px 0px 2px 13px;font-size: 17px;"><i class="fa fa-star-o" aria-hidden="true"></i> ービル</button>
                            <button class="btn-menu" style="height: 45px;border: 1px solid #A88C35;background-color: #f4d164;color: #002323;padding: 0px 0px 2px 13px;font-size: 17px;"><i class="fa fa-star-o" aria-hidden="true"></i> ービル</button>

                        </div>

                        @foreach($data as $key)

                            @if($key->CATEGORY_ID != '001')
                            <button class="btn-menu category-btn" data-id="{{ $key->CATEGORY_ID }}" style="height: 45px;background-color: #141526;color: #f4d164;padding: 4px 0px 4px 18px;font-size: 17px;">{{$key->CATEGORY_NM}}</button>
                            @endif
                        
                        @endforeach
					<button class="btn-menu category-btn" style="height: 100px;background-color: #000000;color: #000000;padding: 0px 0px 4px 18px;font-size: 17px;border: solid #000000 1px;">invi</button>
                            

                    </div>

                @endif
                </div>

                <!-- left footer -->

                <div class="bill-out-container" style="background-color:black">
                    <button class="btn-menu btn-billout" style="height: 65px;font-size: 17px;padding: 0px 15px 0px 18px;color: black;background-color: #cacaca;border: 2px solid #929292;"> お会計 </button>
                </div>


            </div>
			<div class="item-container" style="position: relative;">
			<div class="loader" style="position: fixed;top: 0px;left: 16%;width: 100%;height: 100%;text-align: center;background-color: rgb(0, 0, 0);/* opacity: 0.8; *//* display: none; */"></div>
				<div id="London" class="tabcontent" style="padding-left: 12px; padding-right: 12px;width: 836px;">
					@yield('content')

				</div>
			</div>
            <div class="right-side-bar" style="position: relative;float: left;width: 244px;height: 800px;background-color: #141526;">

                <div class="male-order">

                    <div class="order-header" style="background-color: #293eaa;">男性</div>

                    <div class="order-body male-body">

                        @for($i = 0;$i <= 15; $i++)

                        <!-- <div style="height: 34px;">
                            <div style="float: left;height: 34px;width: 34px;    padding: 4px 0px 0px 7px;"><i class="fa fa-times-circle" aria-hidden="true" style="color: #f4d164;font-size: 26px;"></i></div>
                            <div style="float: left;height: 34px;width: 176px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;font-weight: bold;font-size: 16px;padding-top: 4px;padding-left: 5px;">システムメンテナンス中のため、現在使用できません。
申し訳ございませんが、フードをご注文の際は
スタッフまでお申し付け下さい。</div>
                            <div style="float: left;height: 34px;width: 34px;font-size: 18px;font-weight: bold;padding: 4px 0px 0px 4px;">99</div>
                        </div> -->

                        @endfor

                    </div>
					

                </div>

                <div class="female-order">

                    <div class="order-header" style="background-color: #da0895;">女性</div>
                    <div class="order-body female-body">

                        @for($i = 0;$i <= 8; $i++)
					
                        <!--<div style="height: 34px;">
                            <div style="float: left;height: 34px;width: 34px;    padding: 4px 0px 0px 7px;"><i class="fa fa-times-circle" aria-hidden="true" style="color: #f4d164;font-size: 26px;"></i></div>
                            <div style="float: left;height: 34px;width: 176px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;font-weight: bold;font-size: 16px;padding-top: 4px;padding-left: 5px;">システムメンテナンス中のため、現在使用できません。
					申し訳ございませんが、フードをご注文の際は
					スタッフまでお申し付け下さい。</div>
                            <div style="float: left;height: 34px;width: 34px;font-size: 18px;font-weight: bold;padding: 4px 0px 0px 4px;">99</div>
                        </div> -->

                        @endfor
                    </div>
                    

                </div>

                <div class="set-order" style="height: 100px; background: #141526;">
                        
                    <button class="submit-btn btn-menu btn-num btn-checkOut">注文確定</button>

                    <button class="history-btn btn-menu btn-num btn-history">注文状況</button>

                </div>

            </div>

        </div>

        <!-- History modal -->
        <div id="historyDetail" class="modal historyDetail" role="dialog">
            <div class="modal-dialog modal-sm" style="top: 0em;width:610px;">

                <!-- Modal content-->
                <div class="modal-content" style="height: 656px;background-color: #333333;/*border: 2px solid #f4d164;padding: 14px;*/border-radius: 10px;color: white;">
                    <div class="male-history">
                        <div class="history-header" style="background-color: #293EAA;border-radius: 7px 7px 0px 0px;">男性</div>
                        <div class="history-body">
                            <table id="male-history-table" style="font-size: 16px;font-weight: bold;">
                                <tbody>
                                    @for($i = 0; $i <= 10; $i++)
                                    <!-- <tr style="height: 50px;">
                                         <td style="width: 448px;padding: 0px 0px 0px 16px;">システムメンテナンス中のため、</td>
                                         <td style="width: 62px;text-align: center;">99</td>
                                         <td style="width: 96px;text-align: center;">¥10,000</td>
                                    </tr> -->
                                    @endfor
                                </tbody>
                            </table>
                        
                        </div>
                    </div>

                    <div class="female-history">
                        <div class="history-header" style="background-color: #DA0895;">女性</div>
                        <div class="history-body">
                            <table id="female-history-table" style="font-size: 16px;font-weight: bold;">
                                <tbody>
                                    @for($i = 0; $i <= 10; $i++)
                                    <!-- <tr style="height: 50px;">
                                        <td style="width: 448px;padding: 0px 0px 0px 16px;">システムメンテナンス中のため、</td>
                                        <td style="width: 62px;text-align: center;">99</td>
                                        <td style="width: 96px;text-align: center;">¥10,000</td>
                                    </tr> -->
                                    @endfor
                                </tbody>
                            </table>
                        
                        </div>
                    </div>

                    <div style="height: 80px;padding: 20px 190px 15px 190px;">
                        <button class="btn-menu btn-historyOk" data-dismiss="modal">閉じる</button>
                    </div>
                    
                </div>

            </div>
        </div>

        <!-- Submit modal -->
        <div id="submitDetail" class="modal submitDetail" role="dialog">
            <div class="modal-dialog modal-sm" style="top: 15em;width:390px;">

                <!-- Modal content-->
                <div class="modal-content" style="height: 300px;background-color: #333333;border: 1px solid #f4d164;padding: 0px 26px 0px 26px;border-radius: 10px;color: white;">

                    <div style="font-size: 30px;font-weight: bold;color: #f4d164;text-align: center;margin: 10px 0px 20px 0px;">お会計</div>

                    <div style="font-size: 18px;">

                        <p style="margin-bottom: 25px;">ご注文を受付いたしました
料理が出来上がるまでしばらくお待ち下さい</p>
                        <p style="margin-bottom: 30px;">※混雑時には、料理のご提供まで時間がかかる
場合がございます、ご了承下さい</p>

                    </div>

                    <div style="height: 55px;text-align: center;">
                        <button class="submit-btn btn-menu btn-num btn-style">OK</button>
                    </div>

                </div>

            </div>
        </div>
		
	<!-- msg modal -->
        <div id="msgModal" class="modal msgModal in" role="dialog">
            <div class="modal-dialog modal-sm" style="top: 15em;width:390px;">

                <!-- Modal content-->
                <div class="modal-content" style="height: 200px;background-color: #333333;border: 1px solid #f4d164;padding: 0px 26px 0px 26px;border-radius: 10px;color: white;">
                    <div style="font-size: 28px;text-align: center;">
                        <p style="margin: 35px 0px 50px 0px"> 商品が選択されていません</p>
                    </div>

                    <div style="height: 55px;text-align: center;">
                        <button class="close-btn btn-menu failed-btn btn-style" data-dismiss="modal">OK</button>
                    </div>

                </div>

            </div>
        </div>

        <!-- CountDown modal -->
        <div id="countdown-modal" class="modal countdown-modal" role="dialog" data-bill="0">
            <div class="modal-dialog modal-sm" style="top: 10em;width:416px;">

                <!-- Modal content-->
                <!-- <div class="modal-content" style="height: 264px;width: 415px;border: 1px solid #f4d164;padding: 0px 20px 0px 20px;border-radius: 10px;color: white;"> -->
                <div class="modal-content" style="height: 264px;width: 416px;border: 1px solid #f4d164;padding: 30px 17px 30px 17px;border-radius: 10px;color: white;">

                    <div style="font-size: 18px;">

					<p class="modal-num" style="margin: 0px 0px 0px 0px;text-align: center;font-size: 60px;">0</p>
					
					<div style="margin-top: 27px; text-align: center;"> 
						<p style="margin: 0 0 0px;">注文確定していない商品があります。</p>
						<p>カウントダウン後に自動で注文します。</p>
						<p style="margin-bottom: 30px;">注文確定を止めたい場合は、<br> 画面をタッチして下さい。</p>
					</div>
					

                    </div>

                </div>

            </div>
        </div>
		
		<!-- CountDown modal -->
		<div id="checkItem-modal" class="modal checkItem-modal" role="dialog"> 
			<div class="modal-dialog modal-sm" style="top: 15em;width:540px;">
				<!-- Modal content-->
				<div class="modal-content" style="height: 264px;width: 530px;border: 1px solid #f4d164;padding: 0px 20px 0px 20px;border-radius: 10px;color: white;">
					<div style="font-size: 30px;font-weight: bold;color: #f4d164;text-align: center;margin: 10px 0px 20px 0px;">お会計</div>
					<div style="font-size: 18px;text-align: left;margin: 10px 0px 20px 0px;padding-top: 10px;">
						注文が確定していない商品はすべてキャンセルとなります。 <br>
						お会計でよろしいですか？
					</div>
					<div style="font-size: 18px;text-align: left;margin: 50px 0px 20px 0px;padding-top: 10px;">
						<button class="btn-menu btn-billout-yes billOut bill-clearCart" >はい</button>
						<button class="btn-menu btn-billout-no billOut pull-right">閉じる</button>
					</div>
				</div>
			</div>
		</div>

		<!-- CountDown modal -->

        {{-- billout modal --}}
		<div id="billout-modal" class="modal billout-modal" role="dialog">
			<div class="modal-dialog modal-sm" style="top: 15em;width:390px;">
				<!-- Modal content-->
				<div class="modal-content" style="height: 264px;width: 415px;border: 1px solid #f4d164;padding: 0px 20px 0px 20px;border-radius: 10px;color: white;">
					<div style="font-size: 30px;font-weight: bold;color: #f4d164;text-align: center;margin: 10px 0px 20px 0px;">お会計</div>
					<div class="billout-modal-desc" style="font-size: 18px;text-align: left;margin: 10px 0px 20px 0px;padding-top: 10px;height: 60px; padding-right: 115px;">Loading...</div>
					<div style="font-size: 18px;text-align: left;margin: 43px 0px 20px 0px;padding-top: 10px;">
						<button class="billout-yes btn-menu billOut" >はい</button>
						<button class="billout-no btn-menu billOut pull-right">閉じる</button>
					</div>
				</div>
			</div>
		</div>
        <div id="billout-modal-check-gender" class="modal billout-modal-check-gender" role="dialog">
            <div class="modal-dialog modal-sm modal-check-body">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-check-header">お会計</div>
                    <div class="modal-check-desc">Loading...</div>
                    <div class="modal-check-btn-wrap">
                        <button class="btn btn-default billout-male" data-value="0">男性</button>
                        <button class="btn btn-default billout-female" data-value="1">女性</button>
                        <button class="btn btn-default billout-all" style="margin-right: 0;" data-value="3">全て</button>
                    </div>
                    <div class="modal-check-footer">
                        <button class="btn btn-default btn-cancel">閉じる</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="billout-modal-ty" class="modal billout-modal-ty" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm modal-ty-body">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-ty-header">ご来店ありがとうございました。</div>
                    <div class="modal-ty-desc">係りの者が参りますので、 しばらくお待ち下さい。</div>
                </div>
            </div>
        </div>
	
	    <!-- CountDown modal -->
        <div id="billout-overlay" class="modal billout-overlay" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-sm" style="top: 15em;width:390px;">

                <!-- Modal content-->
                <div class="modal-content" style="height: 254px;width: 390px;border: 1px solid #f4d164;padding: 10px;border-radius: 10px;color: white;">

					<div style="font-size: 24px;font-weight: bold;color: #f4d164;text-align: left;margin: 15px 0px 25px 0px;">ご来店ありがとうございました。</div>
					<div style="font-size: 15px;text-align: left;margin: 10px 0px 63px 0px;"><p>係りの者が参りますので、 しばらくお待ち下さい。</p></div>
						
					<div class="text-center center-block" style="float: none; margin-bottom: 41px;">
						<button class="btn-menu billout-cancel billOut center-block">閉じる</button>
					</div>

				</div>

			</div>
        </div>

        <div id="view_image_modal" class="modal view_image_modal" role="dialog">
            <div class="modal-dialog modal-md" style="top: 12vw;">
                <!-- Modal content-->
                <div class="modal-content">
                    <div>
                        <img src="" style="width: 100%;">
                        <div><i class="fa fa-times xitem close_img" aria-hidden="true" style="position: absolute;top: -28px;right: 0;color: #f4d164;"></i></div>
                    </div>
                </div>
            </div>
        </div>
		


        <script>
            var base_url = 'http://food.across-web.net/v1/';
            var quantity = 1;
            function readCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for(var i=0;i < ca.length;i++) {
                    var c = ca[i];
                    while (c.charAt(0)==' ') c = c.substring(1,c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
                }
                return null;
            }
        </script>
        {{ Html::script('js/jquery-3.2.1.min.js') }}
        {{ Html::script('js/bootstrap/bootstrap.min.js') }}
        {{ Html::script('js/scripts/v2/main.js') }}
        <script>
        var delay = (function() {
            var timer = 0;
            return function(callback, ms) {
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();
        </script>
        @yield('script')
        <div class="campaign_overlay co_hide" style="background-color: black;height: 100%;width: 100%;position: absolute;top: 0;">
            <div style="margin: auto;text-align: center;margin-top: 24vw;">
                <h1 style="color: #fff;font-weight: bold;font-size: 10vw;">キャンペーン</h1>
            </div>
        </div>
    </body>
</html>
