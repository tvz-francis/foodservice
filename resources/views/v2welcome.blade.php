<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome - BusterFood</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        {{ Html::style('css/bootstrap/bootstrap.css') }}
        {{ Html::style('css/fonts/fontawesome/css/font-awesome.min.css') }}

        <!-- Styles -->
        <style>
            html, body{
                height: 100%;
                font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
            }
            .message_info {
            	width: 100%;
			    text-align: left;
			    margin-top: 4vw;
            }
            .message_info p {
            	font-size: 2vw;
    			/*padding-left: 34vw;*/
    			text-align: justify;
            }
        </style>

    </head>
    <body style="background-color: black;color: #ffffff;text-align: center; position: fixed; overflow-y: scroll;width: 100%;">
    <!-- <body style="background-color: black;color: #ffffff;text-align: center;padding:5em;"> -->

        <!-- <div class="progress_loading" style="position: fixed;width: 100%;margin: 0;padding: 0;border: 1px solid white;top: 0;left: 0;height: 10px;">
            <div class="loading_bar" style="background: white;width: 50%;height: 100%;"></div>
        </div> -->

        <div style="">
            <h1 style="font-size: 5vw;margin-top: 4vw;margin-bottom: 0px"><strong>VIVANT FOOD</strong></h1>
        </div>
            
        <div style="margin-top: 4vw;">
        	{{-- width: 292px;height: 292px; --}}
            <div class="buster-food-logo" style="border: 1px solid white;background: url(http://food.across-web.net/image/food/nintchdbpict000264481984.jpg);background-size: 150% auto;background-repeat: no-repeat;border-radius: 50%;margin: auto;"></div>
		<!-- &quot;https://www.thesun.co.uk/wp-content/uploads/2016/09/nintchdbpict000264481984.jpg?w=960&quot; -->
	   </div>
            
        <div class="message_info" style="text-align: center;">
			<p></p>
        </div>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        

        {{ Html::script('js/jquery-3.2.1.min.js') }}
        {{ Html::script('js/bootstrap/bootstrap.min.js') }}
        <script>
			(function (global) {

			if(typeof (global) === "undefined")
			{
				throw new Error("window is undefined");
			}

			var _hash = "!";
			var noBackPlease = function () {
				global.location.href += "#";
				// making sure we have the fruit available for juice....
				// 50 milliseconds for just once do not cost much (^__^)
				global.setTimeout(function () {
					global.location.href += "!";
				}, 50);
			};

			// Earlier we had setInerval here....
			global.onhashchange = function () {
				if (global.location.hash !== _hash) {
					global.location.hash = _hash;
				}
			};

			global.onload = function () {
				noBackPlease();
				// disables backspace on page except on input fields and textarea..
				document.body.onkeydown = function (e) {
					var elm = e.target.nodeName.toLowerCase();
					if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
						e.preventDefault();
					}
					// stopping event bubbling up the DOM tree..
					e.stopPropagation();
				};
				
			};

			})(window);
		</script>
        <script>
            $(document).ready(function() {
			window.history.forward(1);
            	var main_base_width = $(this).width();
            	var main_width = main_base_width/4;

            	$('.buster-food-logo').width(main_width);
				$('.buster-food-logo').height(main_width);
			
				function callMe(){ 
					$.ajax({
						url:'http://food.across-web.net/v2/get/seat',
						type:'post',
						dataType:'json',
						data: {
						 "_token": "{{ csrf_token() }}"	
						},
						success: function(res2) {
						// console.log(res2);
							if(res2.error == 0) {
								// $('.message_info p').html('Please touch to get started');
								// $('.message_info p').html('画面をタッチして下さい。');
								$('.message_info').html(
									'<p style="font-size: 2vw; text-align: center;">'+
										'画面をタッチして下さい。'+
									'</p>'
								);
							$(document).click(function() {
								window.location = "{{ url('v2/home') }}";
							});
							} else {
							$('.message_info').html(
								'<p style="font-size: 2vw; text-align: center;">'+
									res2.msg +
								'</p>'
							);
							$(document).click(function() {
								location.reload(true);
							});
							}
						}
					});
				}

				callMe();

				setInterval(callMe, 1000); //every 1 secs

				$(window).resize(function() {

					var base_width = $(this).width();
					var _width = base_width/4;

					$('.buster-food-logo').width(_width);
					$('.buster-food-logo').height(_width);

					// console.log('base width: '+base_width+' percent width: '+_width);

				});
				
			/* if(typeof(EventSource) !== "undefined") {
				var source = new EventSource("/v1/testServer");
				source.onmessage = function(event) {
					// document.getElementById("result").innerHTML += event.data + "<br>";
					if(event.data == 1){
						console.log("log-in");
						  // $('.itemDetail').modal('hide');
					}else{
						console.log("log-out");
						window.location = '/v1?seat_no='+ host_name +'';
						// reload
					}
					// console.log(source);
				};
			} else {
				// document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
				console.log('else sorry cant load data');
			} */

                // $(this).click(function() {

                //     $.ajax({
                //         url:'{{ url("/get/shop") }}',
                //         type:'POST',
                //         dataType:'json',
                //         success: function(res) {
                //             if(res.error == 0) {
                //                 document.cookie = "SID = "+res.data.shop_id;
                //                 //document.cookie = "gender_flg = "+res.data.shop_id;
                //                 window.location = "{{ url('/home') }}";
                //             }
                //         }
                //     });

                // });

            });
        </script>
        
    </body>
</html>