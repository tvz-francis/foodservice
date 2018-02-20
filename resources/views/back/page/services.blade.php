@extends('back.backtemp.main')
@section('title', 'Services')
@section('title_name', 'サービス管理')

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
    #example1 > tbody > tr > td:nth-child(4) {
        text-align:right;
        color:#293eaa;
    }
    #example1 > tbody > tr > td:nth-child(5) {
        text-align:right;
        color:#da0895;
    }
    #example1 > tbody > tr > td:nth-child(6){
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
@endsection

@section('content')

<div class="box">
    <div class="box-header" style="border-bottom: 1px solid #d2d6de;">
        <h3 class="box-title" style="font-weight: bold;font-size: 14px;">サービス一覧</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped example1" style="width:100%;">
        <thead>
        <tr>
            <th>サービスID</th>
            <th>表示順</th>
            <th>サービス名</th>
            <th style="color: #293eaa;">男性価格</th>
            <th style="color: #da0895;">女性価格</th>
            <th>修正/表示選択/削除</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

<!-- Modal -->
<div id="myModal" class="modal parent-modal" role="dialog">
    <div class="modal-dialog" style="width: 328px;top: 16%;">

        <!-- Modal content-->
        <div class="modal-content" style="height: 630px;">
            <div class="modal-header" style="background-color: #3e92ce;color: #ffffff;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">X</button>
                <h4 class="modal-title" style="font-size: 14px;">New Entry</h4>
            </div>

            <div class="modal-body">
                
                <div class="row">
                    
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                        <label for="serv_group_id">グループID</label>
                        <div class="input-group">                        
                            <input type="text" id="serv_group_id" class="form-control serv_group_id" placeholder="000000000000" style="border-top-left-radius: 4px;border-bottom-left-radius: 4px;" disabled>
                            <span class="input-group-addon" style="border-bottom-right-radius: 4px;border-top-right-radius: 4px;"><i class="fa fa-pencil"></i></span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding-left: 0;">
                        <div class="form-group">
                            <label for="serv_seq_no">表示順</label>
                            <input type="text" id="serv_seq_no" class="form-control serv_seq_no" placeholder="00" style="border-radius:4px;" disabled>
                        </div>
                    </div>
                        
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="serv_item_name">商品名</label>
                            <input type="text" id="serv_item_name" class="form-control serv_item_name nulled" placeholder="Full Body Massage" style="border-radius:4px;">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="serv_item_desc">商品説明</label>
                            <textarea id="serv_item_desc" class="form-control serv_item_desc nulled" placeholder="Swedish massage is a relaxing full-body massage" style="resize:none;border-radius:4px;"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="serv_cate">カテゴリー</label>
                            <select id="serv_cate" class="form-control serv_cate nulled" style="border-radius:4px;">
                                <option value="" selected disabled>-- Select Category --</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                        <label for="serv_male_id">男性用ID</label>
                        <div class="input-group">                        
                            <input type="text" id="serv_male_id" class="form-control serv_male_id nulled" placeholder="000000000000" style="border-top-left-radius: 4px;border-bottom-left-radius: 4px;">
                            <span class="input-group-addon" style="border-bottom-right-radius: 4px;border-top-right-radius: 4px;"><i class="fa fa-pencil"></i></span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" style="padding-left: 0;">
                        <div class="form-group">
                            <label for="serv_male_price">男性価格</label>
                            <input type="text" id="serv_male_price" class="form-control serv_male_price nulled" placeholder="10.000" style="border-radius:4px;">
                        </div>
                    </div>
                        
                </div>

                <div class="row">
                    
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                        <label for="serv_female_id">女性用ID</label>
                        <div class="input-group">                        
                            <input type="text" id="serv_female_id" class="form-control serv_female_id nulled" placeholder="000000000000" style="border-top-left-radius: 4px;border-bottom-left-radius: 4px;">
                            <span class="input-group-addon" style="border-bottom-right-radius: 4px;border-top-right-radius: 4px;"><i class="fa fa-pencil"></i></span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" style="padding-left: 0;">
                        <div class="form-group">
                            <label for="serv_female_price">男性価格</label>
                            <input type="text" id="serv_female_price" class="form-control serv_female_price nulled" placeholder="10.000" style="border-radius:4px;">
                        </div>
                    </div>
                        
                </div>

                <div class="row">
                    
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">                        
                            <button id="submit_shop" class="btn btn-primary form-control submit_shop" data-action="">Create</button>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-right">
                        <div class="form-group">                        
                            <button class="btn btn-danger form-control close_modal">キャンセル</button>
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
                        <p style="text-align: center;margin-bottom: 30px;font-size: 24px;"><span class="serv-item-message">このサービスを削除してもよろしいですか？</span></p>
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
    var data = {};
    $(document).ready(function() {
        $('.services').addClass('active');
        var current_page = 0;
        /* load category list */
        $.ajax({
            url:'fs/back/action/get/servicecategory',
            type:'post',
            dataType:'json',
            success:function(res) {
                drawCategory(res);
            }
        });

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
                'url':'fs/back/get/serviceslist',
                'type':'post',
                'dataType':'json',
            },
            dom: '<"top"Bf>t<"bottom"lp><"clear">',
            buttons: [
                {
                    text: '新規作成'
                }
            ],
            columns:[
                {'data':'ITEM_ID'},
                {'data':'SEQ'},
                {'data':'ITEM_NM'},
                {'data':'MALE_PRICE'},
                {'data':'FEMALE_PRICE'},
                {'data':'buttons'},
            ],
            columnDefs:[
                {"width":"80px","targets":0},
                {"width":"43px","targets":1},
                {"width":"56px","targets":3},
                {"width":"56px","targets":4},
                {"width":"133px","targets":5},
            ],
            initComplete: initData = function(s,j) {
                dt.page(current_page).draw('page');
            }
            // createdRow:function (r,d,i) {
            //     console.log($('td',r));
            // },
            // initComplete: function() {
            //     var category_select = '<label>Category: <select class="form-control input-sm" placeholder="" aria-controls="example1">'+
            //     '<option>Food</option>'+
            //     '<option>Beer</option>'+
            //     '<option>Appetizers</option>'+
            //     '</select></label> ';
            //     $('.dataTables_filter').prepend(category_select);
            // }
        });

        $('.dt-buttons').click(function () {
            createMod($);
            $('#myModal').modal();
        });

        /* Edit */
        $('table.example1').on('click', '.edit-serv-btn', function () {
            editMod($);
            $('#myModal').modal();
            id = $(this).data('id');
            current_page = dt.page();

            $.ajax({
                url:'fs/back/action/get/infoservice/'+id,
                type:'post',
                dataType:'json',
                success: function(res) {
                    drawData(res);
                    // $('.cat_id').val(res.CATEGORY_ID);
                    // $('.cat_name').val(res.CATEGORY_NM);
                    // $('.cat_seq').val(res.SEQ);
                    // $('.cat_type').val(res.TYPE_FLG);
                }
            });
        });

        var del_id = 0,del_name;
        /* Delete */
        $('table.example1').on('click', '.delete-serv-btn', function () {
            del_id = $(this).data('id');
            del_name = $(this).data('name');
            current_page = dt.page();

            $('.deleteModal').modal();
        });

        $('.delete-yes').click(function () {
            var data = {
                'serv_id':del_id,
                'serv_name':del_name
            };
            $.ajax({
                url:'fs/back/delete/service',
                type:'post',
                data:data,
                dataType:'json',
                success: function(res) {
                    if(res.error == 0) {
                        $('#deleteModal').modal('hide');
                        dt.ajax.reload(initData);
                    }
                }
            });
        });

        $('.delete-cancel').click(function () {
            $('#deleteModal').modal('hide');
        });

        /* View */
        $('table.example1').on('click', '.view-serv-btn', function () {
            var id = $(this).data('id');
            current_page = dt.page();
            $.ajax({
                url:'fs/back/update/service/view',
                type:'post',
                data:{service_id:id},
                dataType:'json',
                success: function(res) {
                    if(res.error == 0) {
                        $('#deleteModal').modal('hide');
                        dt.ajax.reload(initData);
                    }
                }
            });
            // $('.deleteModal').modal();
        });

        $('.submit_shop').click(function() {
            var action = $(this).data('action');
            
            if(!assignValidate($)) {
                return false;
            }

            if(action == 'create') {
                if(setData(action)) {
                    $.ajax({
                        url:'fs/back/create/servicesitem',
                        type:'post',
                        data:data,
                        dataType:'json',
                        success: function(res) {
                            if(res.error == 0) {
                                $('#myModal').modal('hide');
                                dt.ajax.reload(initData);
                            }
                        }
                    });
                }
            } else if(action == 'update') {
                if(setData(action)) {
                    $.ajax({
                        url:'fs/back/update/service',
                        type:'post',
                        data:data,
                        dataType:'json',
                        success: function(res) {
                            if(res.error == 0) {
                                $('#myModal').modal('hide');
                                dt.ajax.reload(initData);
                            }
                        }
                    });
                }
            }
        });

        $('.close_modal').click(function () {
            $('#myModal').modal('hide');
        });

        $('#myModal').on('hidden.bs.modal', function () {
            resetForm($);
            $('.serv_cate').val('');
        });

        $('.content-wrapper').scroll(function() {
            if($(this).scrollTop() > '130') {
                $('#example1_wrapper div.top').css({
                    'position':'sticky',
                    'top':'15px',
                    'z-index': '1'
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

    function createMod($) {
        $('.parent-modal').find('.modal-title').text('サービス商品作成/修正'); // title
        $('.parent-modal').find('.submit_shop').text('作成/更新'); // btn name
        $('.parent-modal').find('.submit_shop').data('action', 'create'); // action
        // $('.parent-modal').find('.ip-first').show();
    }

    function editMod($) {
        $('.parent-modal').find('.modal-title').text('サービス更新'); // title
        $('.parent-modal').find('.submit_shop').text('作成/更新'); // btn name
        $('.parent-modal').find('.submit_shop').data('action', 'update'); // action
        // $('.parent-modal').find('.ip-first').hide();
    }

    function drawCategory(d) {
        var sel = document.getElementById('serv_cate');
        for(i in d) {
            o = d[i];
            var opt = document.createElement('option');
            opt.value = o.CATEGORY_ID;
            opt.text = o.CATEGORY_ID+' - '+o.CATEGORY_NM;
            sel.add(opt);
        }
    }

    function setData(action) {
        data = {};
        if(action == undefined) {
            return false;
        }
        if(action == 'create') {
            data['serv_item_name'] = document.getElementById('serv_item_name').value;
            data['serv_item_desc'] = document.getElementById('serv_item_desc').value;
            data['serv_cat_id'] = document.getElementById('serv_cate').value;

            data['serv_male_item_id'] = document.getElementById('serv_male_id').value;
            data['serv_male_price'] = document.getElementById('serv_male_price').value;
            data['serv_female_item_id'] = document.getElementById('serv_female_id').value;
            data['serv_female_price'] = document.getElementById('serv_female_price').value;
            return true;
        } else if(action == 'update') {
            data['serv_group_id'] = document.getElementById('serv_group_id').value;
            data['serv_item_name'] = document.getElementById('serv_item_name').value;
            data['serv_item_desc'] = document.getElementById('serv_item_desc').value;
            data['serv_cat_id'] = document.getElementById('serv_cate').value;

            data['serv_male_item_id'] = document.getElementById('serv_male_id').value;
            data['serv_male_price'] = document.getElementById('serv_male_price').value;
            data['serv_female_item_id'] = document.getElementById('serv_female_id').value;
            data['serv_female_price'] = document.getElementById('serv_female_price').value;
            return true;
        }
        return false;
    }

    function resetForm($) {
        $('.nulled').val('');
    }

    function drawData(d) {
        document.getElementById('serv_group_id').value = d.GROUP_ID;
        document.getElementById('serv_seq_no').value = d.SEQ;
        document.getElementById('serv_item_name').value = d.ITEM_NM;
        document.getElementById('serv_item_desc').value = d.ITEM_DESC;
        document.getElementById('serv_cate').value = d.CATEGORY_PARENT_ID;

        document.getElementById('serv_male_id').value = d.MALE_ID;
        document.getElementById('serv_male_price').value = d.MALE_PRICE;
        document.getElementById('serv_female_id').value = d.FEMALE_ID;
        document.getElementById('serv_female_price').value = d.FEMALE_PRICE;
    }

    var assignValidate = function($) {
        var error = 0;
        $('.nulled').each(function() {
            var current = $(this);
            if(current.parent().hasClass('has-error')) {
                current.parent().removeClass('has-error');
            }
            if(current.val() == '') {
                current.parent().addClass('has-error');
                error++;
            }
        });
        if(!error) { return true; }
        return false;
    };

</script>
@endsection