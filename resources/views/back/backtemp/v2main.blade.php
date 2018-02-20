<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        

        <title>@yield('title') - BusterFood</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> -->

        {{ Html::style('theme/bower_components/bootstrap/dist/css/bootstrap.css') }}
        {{ Html::style('css/fonts/fontawesome/css/font-awesome.min.css') }}

        <!-- Admin LTE -->

        {{ Html::style('theme/dist/css/AdminLTE.css') }}
        {{ Html::style('theme/dist/css/skins/_all-skins.min.css') }}

        <!-- Styles -->
        <style>
            html, body{
                height: 100%;
                font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
            }
            .main-header a.header-name {
                background-color: #222d32 !important;
            }
            .main-header nav {
                background-color: #222d32 !important;
            }
            .box {
                margin-bottom: 0px !important;
            }
            .modal-content{
                border-radius:4px;
            }
            .modal-header{
                border-top-left-radius: 4px;
                border-top-right-radius: 4px;
            }
            button.btn {
                border-radius: 0px;
            }
        </style>
		
	   
        {{ Html::style('css/items.css') }}
        @yield('style')

    </head>
    <body class="hold-transition skin-blue sidebar-mini">

        <!-- header -->
        <div class="wrapper">
        
            <header class="main-header">

                <!-- Logo -->
                <a class="logo header-name" href="#" class="logo">
                    <span class="logo-lg"><b>管理画面</b></span>
                </a>

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top"></nav>

            </header>
            <!-- Left side column. contains the logo and sidebar -->

            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                
                
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    
                    <!-- <li class="active treeview menu-open">
                        <a href="#" style="padding: 16px 10px 10px 10px;height: 50px;font-size: 14px;">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                            <li class="active"><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                        </ul>
                    </li> -->
                    <li class="dashboard">
                        <a href="/dashboard" style="padding: 16px 10px 10px 10px;height: 50px;font-size: 14px;">
                            <i class="fa fa-dashboard"></i> <span>ダッシュボード</span>
                        </a>
                    </li> 

                    @if(session()->get('users')['user_level'] == 0)
                    <li class="users">
                        <a href="/users" style="padding: 16px 10px 10px 10px;height: 50px;font-size: 14px;">
                            <i class="fa fa-users" aria-hidden="true"></i> <span>ユーザー管理</span>
                        </a>
                    </li>
                    <li class="shops">
                        <a href="/shops" style="padding: 16px 10px 10px 10px;height: 50px;font-size: 14px;">
                            <i class="fa fa-home" aria-hidden="true"></i> <span>店舗管理</span>
                        </a>
                    </li>
                    @endif

                    @if(session()->exists('current_shop'))
                    <li class="categories">
                        <a href="/categories" style="padding: 16px 10px 10px 10px;height: 50px;font-size: 14px;">
                            <i class="fa fa-list-ul" aria-hidden="true"></i> <span>カテゴリー管理</span>
                        </a>
                    </li>
                    <li class="items">
                        <a href="/items" style="padding: 16px 10px 10px 10px;height: 50px;font-size: 14px;">
                            <i class="fa fa-cutlery" aria-hidden="true"></i> <span>商品管理</span>
                        </a>
                    </li>
                    <li class="services">
                        <a href="/services" style="padding: 16px 10px 10px 10px;height: 50px;font-size: 14px;">
                            <i class="fa fa-phone-square" aria-hidden="true"></i> <span>サービス管理</span>
                        </a>
                    </li>
                    @endif
                    <li class="switchshop">
                        <a href="/switchshop" style="padding: 16px 10px 10px 10px;height: 50px;font-size: 14px;">
                            <i class="fa fa-repeat" aria-hidden="true"></i> <span>店舗切替</span>
                        </a>
                    </li>
                    
					
				<li style="position: absolute; bottom: 10px; width: 100%; border-top: 1px solid rgba(107, 108, 109, 0.19);">
					<a href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
						<i class="fa fa-fw fa-sign-out"></i> ログアウト</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
                    </li>
                </ul>

                </section>
                <!-- /.sidebar -->
            </aside>

            <div class="content-wrapper" style="min-height: 885px;overflow-y: scroll;max-height: 885px;">
                <section class="content-header" style="height: 86px;padding: 25px 0 25px 0;margin-bottom: 10px;">
                <h1 style="border-bottom: 2px solid #d2d6de;padding-bottom: 6px;">
                    <span style="font-size: 36px;">@yield('title_name') 
                    @if(session()->exists('current_shop'))
                        @if($header_name)
                        <small>- {{ session()->get('current_shop')[1] }}</small>
                        @endif
                    @endif
                    </span>
                </h1>
                </section>

                <!-- Main content -->
                <section class="content" style="padding: 0;">

                @yield('content')
                
                </section>
            </div>


        </div>

        

        <script>
            var base_url = 'http://busterfood.acrossweb.net/';
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
        {{ Html::script('js/scripts/plugin/jQueryUI/jquery-ui.js') }}
        {{ Html::script('js/bootstrap/bootstrap.min.js') }}
        <!-- Admin LTE APP -->
        {{ Html::script('theme/dist/js/adminlte.min.js') }}
        <script>
        var delay = (function() {
            var timer = 0;
            return function(callback, ms) {
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();
        // $(document).ready(function() {
            
            
            <?php //if(session()->get('users')['user_level'] != 0): ?>
            /*verify = setInterval(function(){
                $.ajax({
                    url:'fs/verify/{{ md5(uniqid(true)) }}?logger=true&in_case={{ md5(uniqid(true)) }}',
                    type:'post',
                    dataType:'json',
                    success:function(res) {
                        console.log(res);
                    }
                });
            },12000);*/
            <?php //endif; ?>

        // });
        </script>
        @yield('script')
    </body>
</html>
