@extends('back.backtemp.main')
@section('title', 'Shops List')
@section('title_name', '店舗管理')
@section('style')
{{ Html::style('theme/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}
<style>
    .dataTables_length{
        float: left;
    }
    .dt-buttons {
        float: left;
        background-color: #6ba6d0;
        color: #ffffff;
        width: 120px;
        height: 30px;
        text-align: center;
        padding-top: 5px;
        border-radius: 5px;
        cursor: pointer;
    }
    .dt-buttons a {
        color: #ffffff;
    }
    /* th.sorting_asc::after, th.sorting_desc::after, th.sorting::after { 
        content:"" !important; 
    } */
    table > tbody > tr > td:nth-child(2) {
        padding: 5px;
    }
    .form-control {
        border-radius:4px;
    }
    #example1 > tbody > tr > td:nth-child(4){
        padding: 2px !important;
    }
    /* popover */
    .popover {
        /* left: 514.5px !important; */
        color: red;
    }
    .popover div.arrow {
        left: 20% !important;
    }
    /* table */
    table.tbl-form td.has-error {
        border: 1px solid red;
    }
    .box-body div.bottom {
        margin-top: 14px;
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
@endsection

@section('content')

<div class="box">
    <div class="box-header" style="border-bottom: 1px solid #d2d6de;">
        <h3 class="box-title" style="font-weight: bold;font-size: 14px;">店舗一覧</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped example1" style="width:100%;">
        <thead>
        <tr>
            <th>FC番号</th>
            <th>店舗名</th>
            <th>IPアドレス</th>
            <th style="width: 99px;">修正/ロック/削除</th>
        </tr>
        </thead>
        </table>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

<!-- Modal -->
<div id="myModal" class="modal parent-modal" role="dialog">
    <div class="modal-dialog" style="width: 328px;top: 23%;">

        <!-- Modal content-->
        <div class="modal-content" style="min-height: 414px;">
            <div class="modal-header" style="background-color: #3e92ce;color: #ffffff;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">x</button>
                <h4 class="modal-title" style="font-size: 14px;">New Entry</h4>
            </div>

            <div class="modal-body">
                
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="form-group has-feedback">         
                            <label for="shop_fc_no">FC番号</label>
                            <input type="text" id="shop_fc_no" class="form-control ishop" placeholder="00242"  >
                            <span class="form-control-feedback shop_fc_no_err_mes"></span>
                        </div>
                    </div>
                        
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="shop_item_name">店舗名</label>
                            <input type="text" id="shop_item_name" class="form-control shop_item_name nulled" placeholder="Hankyu Ibaraki">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div style="margin-bottom: 25px;">

                        <table class="tbl-form" border="1" style="margin: auto;width: 299px;">
                            <thead >
                                <tr style="height: 34px;">
                                    <th style="padding: 0px 0px 0px 15px;">IPアドレス</th>
                                    <th style="padding: 0px 0px 0px 15px;">削除/追加</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="height: 34px;" class="ip-first">
                                    <td style="padding: 0px 0px 0px 15px;">
                                        <input class="form-ip" type="text" placeholder="192.xxx.xxx.xxx" style="width: 100%;margin: 0;padding: 0;border: 0;outline: none;" ></td>
                                    <td>
                                        <button class="btn btn-danger delete-ip" style="width:100%;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                                <tr class="tbl-form-submit" style="height: 34px;">
                                    <td style="padding: 0px 0px 0px 15px;">
                                        <input type="text" class="new-ip" placeholder="" style="width: 100%;margin: 0;padding: 0;border: 0;outline: none;">
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-add-ip" style="width:100%;"><i class="fa fa-plus" aria-hidden="true"></i></button> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="row">
                    
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                        <div class="form-group">                        
                            <button class="btn btn-primary form-control submit_shop" data-action="">Create</button>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 pull-right">
                        <div class="form-group">                        
                            <button class="btn btn-danger form-control btn-close">キャンセル</button>
                        </div>
                    </div>
                        
                </div>

            </div>

            <div class="modal-footer">

            </div>

        </div>

    </div>
</div>

<!-- delete modal -->
<div id="deleteModal" class="modal deleteModal" role="dialog">
    <div class="modal-dialog" style="width: 328px;top: 23%;">

        <!-- Modal content-->
        <div class="modal-content" style="min-height: 105px;">
            <div class="modal-header" style="background-color: #3e92ce;color: #ffffff;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">x</button>
                <h4 class="modal-title" style="font-size: 14px;">Delete</h4>
            </div>

            <div class="modal-body">
                
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p style="text-align: center;margin-bottom: 30px;font-size: 24px;"><span class="ip-address"></span>の情報をすべて削除します。よろしいですか？</p>
                    </div>
                </div>

                <div class="row">
                    
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                        <div class="form-group">                        
                            <button class="btn btn-primary form-control delete-yes">Yes</button>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 pull-right">
                        <div class="form-group">                        
                            <button class="btn btn-danger form-control delete-cancel">Cancel</button>
                        </div>
                    </div>
                        
                </div>

            </div>

            <div class="modal-footer">

            </div>

        </div>

    </div>
</div>

@endsection

@section('script')

{{ Html::script('theme/bower_components/datatables.net/js/jquery.dataTables.min.js') }}
{{ Html::script('theme/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}
{{ Html::script('theme/bower_components/datatables.net-bs/js/dataTables.buttons.js') }}
<script>
    var error = 0;
    var data = {};
    $(document).ready(function() {
        $('.shops').addClass('active');
        var dt = $('#example1').DataTable({
            language:{
                paginate:{
                    next:'<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                    previous:'<i class="fa fa-chevron-left" aria-hidden="true"></i>'
                },
                search:'検索',
                lengthMenu:"表示件数 _MENU_ 件"
            },
            'scrollX':true,
            processing:true,
            ajax:{
                'url':"fs/back/get/shoplist",
                'type':'post',
                'dataType':'json',
                'cache':true
            },
            columns: [
                {"data":"SHOP_FC_NO", "width":"80px"},
                {"data":"SHOP_NM"},
                {"data":"GLOBAL_IP"},
                {"data":"buttons", "width":"112px"}
            ],
            dom: '<"top"Bf>t<"bottom"lp><"clear">',
            buttons: [
                {
                    text: '新規作成',
                    // action: function ( e, dt, node, config ) {
                    //     alert( 'Button activated' );
                    // }
                }
            ],
            createdRow:function(row,data,index) {
                //console.log(this,row,data,index);
            }
        });

        var create_items = {};

        $('.ishop').keyup(function () {
            var key = $('.ishop');
            err_0 = '<i class="fa fa-check-circle-o" aria-hidden="true" style="font-size: 20px;color: #00a65a;"></i>'; 
            err_1 = '<i class="fa fa-times-circle" aria-hidden="true" style="font-size: 20px;color: #dd4b39;"></i>';
            delay(function () {
                console.log(error);
                $.ajax({
                    url:'fs/back/action/get/shopno/'+key.val(),
                    type:'post',
                    dataType:'json',
                    success: function(res) {
                        //$('.shop_fc_no_err_mes').html();
                        if(res.error == 0) {
                            $('.shop_fc_no_err_mes').html(err_1);
                        } else {
                            $('.shop_fc_no_err_mes').html(err_0);
                        }
                    }
                });
            },600);
        });

        var pad = 0;

        $('.btn-add-ip').click(function (ev) {
            console.log(pad);
            ev.preventDefault();
            var myvar = '<tr class="new-row-form" data-row="'+pad+'" style="height: 34px;">'+
                '<td style="padding: 0px 0px 0px 15px;">'+
                    '<input class="form-ip nulled" type="text" value="'+$('.new-ip').val()+'" placeholder="192.xxx.xxx.xxx" style="width: 100%;margin: 0;padding: 0;border: 0;outline: none;">'+
                '</td>'+
                '<td>'+
                    '<button class="btn btn-danger delete-ip s" data-row="'+pad+'" style="width:100%;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'+
                '</td>'+
            '</tr>';
            $(myvar).insertBefore('.tbl-form-submit');
            pad++;

            $('button.delete-ip').unbind().click('click',function () {
                num = $(this).data('row');
                $('.new-row-form').each(function() {
                    if($(this).data('row') == num) {
                        $(this).remove();
                    }
                });
            });
        });

        $('.submit_shop').click(function () {
            var action = $(this).data('action');
            create_items['shop_fc_no'] = $('#shop_fc_no').val();
            create_items['shop_name'] = $('#shop_item_name').val();
            create_items['shop_ip'] = [];
            
            $('.form-ip').each(function () {
                create_items['shop_ip'].push($(this).val());
            });
            
            if(action == 'create') {
                if(validationPop($)) {
                    $.ajax({
                        url:'fs/back/create/shop',
                        type:'post',
                        data:create_items,
                        dataType:'json',
                        success: function(res) {
                            if(res.error == 0) {
                                delay(function(){
                                    $.ajax({
                                        url:'fs/schema/c',
                                        type:'post',
                                        dataType:'json',
                                        success: function(res) {
                                            console.log(res);
                                        }
                                    });
                                    $('#myModal').modal('hide');
                                    dt.ajax.reload();
                                },1000);
                            } else {
                                drawPopOver($,res,action);
                            }
                        }
                    });
                }
            } else if(action == 'update') {
                if(validationPop($)) {
                    $.ajax({
                        url:'fs/back/update/shop',
                        type:'post',
                        data:create_items,
                        dataType:'json',
                        success: function(res) {
                            if(res.error == 0) {
                                $('#myModal').modal('hide');
                                dt.ajax.reload();
                            } else {
                                drawPopOver($,res,action);
                            }
                        }
                    });
                }
            }
        });

        /* Create shop */
        $('.dt-buttons').click(function() {
            createMod($);
            $('#myModal').modal();
        });

        $('table.example1').sortable({
            items: 'tr',
            stop : function(event, ui){
                // console.log($(this).sortable('toArray'));
                // console.log($(this));
                console.log('Stop: '+event, ui);
            },
            start: function(event, ui){
                console.log('Start: '+event, ui);
            },
            update: function(event, ui){
                console.log('Update: '+event, ui);
            }
        });
        $("table tbody").disableSelection();

        $('table.example1').on('click', '.edit-shop-btn', function () {
            /* Edit shop */
            $('#myModal').modal();
            editMod($);
            id = $(this).data('id');

            $.ajax({
                url:'fs/back/action/get/shopinfo/'+id,
                type:'post',
                dataType:'json',
                success:function(res) {
                    console.log(res);
                    if(res.error == 0) {

                        obj = res.data[0];

                        $('#shop_fc_no').val(obj.SHOP_FC_NO);
                        $('#shop_item_name').val(obj.SHOP_NM);
                        n = '';
                        for(i in obj.GLOBAL_IP) {
                            iObj = obj.GLOBAL_IP[i];
                            var myvar = '<tr class="new-row-form" data-row="'+pad+'" style="height: 34px;">'+
                                '<td style="padding: 0px 0px 0px 15px;">'+
                                    '<input class="form-ip nulled" type="text" value="'+iObj+'" placeholder="192.xxx.xxx.xxx" style="width: 100%;margin: 0;padding: 0;border: 0;outline: none;">'+
                                '</td>'+
                                '<td>'+
                                    '<button class="btn btn-danger delete-ip s" data-row="'+pad+'" style="width:100%;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'+
                                '</td>'+
                            '</tr>';
                            $(myvar).insertBefore('.tbl-form-submit');
                            pad++;
                        }
                        pad--;
                        $('button.delete-ip').unbind().click('click',function () {
                            num = $(this).data('row');
                            $('.new-row-form').each(function() {
                                if($(this).data('row') == num) {
                                    $(this).remove();
                                }
                            });
                        });
                    }

                }
            });
        });

        var shop_num = 0;
        $('table.example1').on('click', '.delete-shop-btn', function() {
            // data['shop_fc_no'] = $(this).data('id');
            // data['shop_ip'] = $(this).data('ip');
            var shop_id = $(this).data('id');
            drawIP($,shop_id);
            shop_num = shop_id;
            $('#deleteModal').modal();
        });

        $('table.example1').on('click', '.lock-shop-btn', function() {
            var shop_id = $(this).data('id');
            shop_num = shop_id;

            $.ajax({
                url:'fs/back/update/shop/lockunlock',
                type:'post',
                data:{shop_fc_no:shop_num},
                dataType:'json',
                success:function (res) {
                    if(res.error == 0) {
                        $('#deleteModal').modal('hide');
                        dt.ajax.reload();
                    }
                }
            });
        });
        
        
        $('.delete-yes').click(function() {
            $.ajax({
                url:'fs/back/update/shop/delete',
                type:'post',
                data:{shop_fc_no:shop_num},
                dataType:'json',
                success:function (res) {
                    if(res.error == 0) {
                        $('#deleteModal').modal('hide');
                        dt.ajax.reload();
                    }
                }
            });
        });
        
        $('.delete-cancel').click(function() {
            $('#deleteModal').modal('hide');
        });

        $('.btn-close').click(function() {
            $('#myModal').modal('hide');
        });

        $('#myModal').on('hidden.bs.modal', function () {
            resetForm();
            if($('.nulled').parent().hasClass('has-error')) {
                $('.nulled').parent().removeClass('has-error')
            }
            $('.nulled').popover('hide');
        });

        $('#deleteModal').on('hidden.bs.modal', function () {
            data = {};
        });

        $('.nulled').blur(function() {
            $('.nulled').popover('hide');
            $('.popover').remove();
        });

        function resetForm() {
            $('.new-row-form').remove();
            $('#shop_fc_no').val('');
            $('#shop_item_name').val('');
            $('.form-ip').val('');
            $('.shop_fc_no_err_mes i').remove();
        }

        $('.content-wrapper').scroll(function() {
            if($(this).scrollTop() > '130') {
                $('#example1_wrapper div.top').css({
                    'position':'sticky',
                    'top':'15px',
                    'z-index': '1'
                });
            }
        });

    });

    function createMod($) {
        $('.parent-modal').find('.modal-title').text('新規登録'); // title
        $('.parent-modal').find('.submit_shop').text('新規作成'); // btn name
        $('.parent-modal').find('.submit_shop').data('action', 'create'); // action
        $('.parent-modal').find('.ip-first').show();
        $('.ip-first').find('input').addClass('nulled');
        $('.ishop').addClass('nulled');
        $('.ishop').removeAttr('disabled');
    }

    function editMod($) {
        $('.parent-modal').find('.modal-title').text('店舗情報作成/修正'); // title
        $('.parent-modal').find('.submit_shop').text('作成/更新'); // btn name
        $('.parent-modal').find('.submit_shop').data('action', 'update'); // action
        $('.parent-modal').find('.ip-first').hide();
        $('.ip-first').find('input').removeClass('nulled');
        $('.ishop').removeClass('nulled');
        $('.ishop').attr('disabled', 'disabled');
    }

    function setData() {
        data = {};
    }

    function drawIP($,d) {
        $('.deleteModal').find('span.ip-address').text(d);
    }

    function validationPop($) {
        var next = 0;
        $('.nulled').each(function() {
            var this_value = $(this).val().trim();
            if(this_value == '') {
                $(this).parent().addClass('has-error');
                next++;
            } else {
                $(this).parent().removeClass('has-error');
            }
        });
        if(!next) {
            return true;
        }
        return false;
    }

    function drawPopOver($,d,a,index = null) {
        var options = {};
        switch(d.ref) {
            case 'shop_fc_no':
                options.content = d.msg;
                options.container = 'body';
                options.placement = 'bottom';
                $('.ishop').popover(options);
                $('.ishop').popover('show');
                $('.shop_item_name').popover('hide');
                $('.form-ip.nulled').popover('hide');
                $('.ishop').focus();
                break;
            case 'shop_name':
                options.content = d.msg;
                options.container = 'body';
                options.placement = 'bottom';
                $('.shop_item_name').popover(options);
                $('.shop_item_name').popover('show');
                $('.ishop').popover('hide');
                $('.form-ip.nulled').popover('hide');
                $('.shop_item_name').focus();
                break;
            case 'shop_ip':
                options.content = d.msg;
                options.container = 'body';
                options.placement = 'bottom';
                $('.form-ip.nulled:eq('+d.index+')').popover(options);
                $('.form-ip.nulled:eq('+d.index+')').popover('show');
                $('.ishop').popover('hide');
                $('.shop_item_name').popover('hide');
                $('.form-ip.nulled:eq('+d.index+')').focus();
                break;
        }
    }



</script>
@endsection