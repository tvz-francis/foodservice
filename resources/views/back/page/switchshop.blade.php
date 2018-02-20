@extends('back.backtemp.main')
@section('title', 'Switch Shop')
@section('title_name', '店舗切替')

@section('style')
	{{ Html::style('theme/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}
    <style>
        .dataTables_length{
            float: left;
        }
        #example1 > tbody > tr > td:nth-child(3) {
            padding: 2px;
        }
        #example1 > tbody > tr > td:nth-child(4) {
            padding: 0;
        }
        #example1 > tbody > tr > td:nth-child(4) > button {
            width: 100%;
        }
        #example1 > tbody > tr > td:nth-child(4){
            padding: 2px !important;
        }
        .hit-top{
            background-color: white;
            padding: 15px 20px 15px 20px;
            border-bottom: 1px solid gainsboro;
            /* border: 1px solid gainsboro; */
            box-shadow: 0px -1px 10px -1px black;
            /* border: 1px solid gainsboro; */
        }
        
    </style>
@stop

@section('content')

<div class="box">
    <div class="box-header" style="border-bottom: 1px solid #d2d6de;">
        <h3 class="box-title" style="font-weight: bold;font-size: 14px;">登録店舗一覧</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped example1">
        <thead>
        <tr>
            <th>FC番号</th>
            <th>店舗名</th>
            <th>ステータス</th>
            <th>切替実行</th>
        </tr>
        </thead>
        
        </table>
    </div>
    <!-- /.box-body -->
    </div>	
    <!-- /.box -->

@stop

@section('script')

{{ Html::script('theme/bower_components/datatables.net/js/jquery.dataTables.min.js') }}
{{ Html::script('theme/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}
<script>
    $(document).ready(function() {
        $('.switchshop').addClass('active');
        var dt = $('#example1').DataTable({
            language:{
                paginate:{
                    next:'<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                    previous:'<i class="fa fa-chevron-left" aria-hidden="true"></i>'
                },
                search:'検索',
                lengthMenu:"表示件数 _MENU_ 件"
            },
            ajax:{
                'url':"fs/back/get/switchshoplist",
                'type':'post',
                'dataType':'json',
            },
            columns:[
                {'data':'SHOP_FC_NO',"width":"80px"},
                {'data':'SHOP_NM'},
                {'data':'lock_element',"width":"70px"},
                {'data':'buttons',"width":"90px"},
            ],
            dom: '<"top"f>t<"bottom"lp><"clear">',
        });

        /* Switcher */
        $('table.example1').on('click', '.switch-btn', function () {
            var id = $(this).data('id'),
            name = $(this).data('name');

            var next = confirm('This shop will be loaded, continue?');
            if(next) {
                $.ajax({
                    url:'fs/back/action/switchshop',
                    type:'post',
                    data:{
                        "shop_fc_no":id,
                        "shop_name":name
                    },
                    dataType:'json',
                    success:function(res) {
                        if(res.error == 0) {
                            window.location = 'dashboard';
                        }
                    }
                });
            }
            
        });

        $('.content-wrapper').scroll(function() {
            if($(this).scrollTop() > '130') {
                $('#example1_wrapper div.top').css({
                    'position':'sticky',
                    'top':'0px',
                    'z-index': '1'
                });
                $('.top').addClass('hit-top');
            } else {
                $('.top').removeClass('hit-top');
            }
        });

    });
</script>
@stop