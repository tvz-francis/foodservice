@extends('back.backtemp.main')
@section('title', 'Categories List')
@section('title_name', 'カテゴリー管理')
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
    #example1 > tbody > tr > td:nth-child(5){
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
        <h3 class="box-title" style="font-weight: bold;font-size: 14px;">カテゴリー一覧</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <div id="table-parent">

            <table id="example1" class="table table-bordered table-striped example1" style="width:100%;">
            <thead>
            <tr>
                <th>カテゴリーID</th>
                <th>表示順</th>
                <th>カテゴリー名</th>
                <th>サブカテゴリーID</th>
                <th>修正/表示選択/削除</th>
            </tr>
            </thead>
            </table>

        </div>


    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->


<!-- Modal -->
<div id="myModal" class="modal parent-modal" role="dialog">
    <div class="modal-dialog" style="width: 378px;top: 25%;">

        <!-- Modal content-->
        <div class="modal-content" style="min-height: 308px;">
            <div class="modal-header" style="background-color: #3e92ce;color: #ffffff;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">X</button>
                <h4 class="modal-title" style="font-size: 14px;">New Entry</h4>
            </div>

            <div class="modal-body" style="padding:0;">

                <div style="margin:20px 14px 0 14px;">

                    <div class="row" style="margin: 0;margin-bottom: 15px;">

                        <div class="form-inline">

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding: 0;">

                                <label for="cat_id">カテゴリーID</label>
                                <div class="input-group">                        
                                    <input type="text" id="cat_id" class="form-control cat_id" placeholder="000" style="border-top-left-radius: 4px;border-bottom-left-radius: 4px;" disabled>
                                    <span class="input-group-addon" style="border-bottom-right-radius: 4px;border-top-right-radius: 4px;"><i class="fa fa-pencil"></i></span>
                                </div>
                                
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding: 0;margin-left: 10px;">

                                <label for="cat_type">カテゴリータイプ</label>
                                <div class="form-group">                        
                                    <select class="form-control cat_type" id="cat_type" style="max-width: 103px;min-width: 87px;border-radius: 4px;">
                                        <option value="0" selected="">フード</option>
                                        <option value="1" >サービス</option>
                                    </select>
                                </div>
                                
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" style="padding: 0;margin-left: 10px;">

                                <label for="cat_seq">表示順</label>
                                <div class="input-group">                        
                                    <input type="text" id="cat_seq" class="form-control cat_seq" placeholder="00" style="border-top-left-radius: 4px;border-bottom-left-radius: 4px;" disabled>
                                    <span class="input-group-addon" style="border-bottom-right-radius: 4px;border-top-right-radius: 4px;"><i class="fa fa-pencil"></i></span>
                                </div>
                                
                            </div>

                        </div>
                        
                    </div>

                    <div class="row" style="margin: 0;">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
                            <div class="form-group">
                                <label for="cat_name">カテゴリー名</label>
                                <input type="text" id="cat_name" class="form-control cat_name nulled" style="border-radius: 4px;">
                            </div>
                        </div>

                    </div>

                    <div class="row form-cat-row" style="margin: 0;">
                    
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding: 0;">
                            <div class="form-group">
                                <label for="cat_sub">フードの場合「はい」にして下さい</label>
                                <select id="cat_sub" class="form-control cat_sub" style="border-radius: 4px;">
                                    <option value="1" selected="">はい</option>
                                    <option value="0">いいえ</option>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding: 0;margin-top: 25px;min-width: 223px;margin-left: 10px;max-width: 223px;">
                            <div class="form-group">
                                <select id="cat_parent" class="form-control" style="border-radius: 4px;">
                                    <option value="" selected disabled>-- Select Category --</option>
                                </select>
                            </div>
                        </div> -->

                    </div>

                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0px 14px 0 14px;">
                            <button class="btn btn-primary pull-left submit_shop" style="min-width: 125px;max-width: 125px;" data-action="">Create</button>
                            <button class="btn btn-danger pull-right close_modal" style="min-width: 125px;max-width: 125px;">キャンセル</button>
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
    <div class="modal-dialog" style="width: 305px;top: 23%;">

        <!-- Modal content-->
        <div class="modal-content" style="min-height: 105px;">
            <div class="modal-header" style="background-color: #3e92ce;color: #ffffff;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">x</button>
                <h4 class="modal-title" style="font-size: 14px;">Delete</h4>
            </div>

            <div class="modal-body">
                
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p style="text-align: center;margin-bottom: 30px;font-size: 24px;"><span class="data-msg"></span></p>
                    </div>
                </div>

                <div class="row yes-cancel">
                    
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
    var create_items = {};
    $(document).ready(function() {
        $('.categories').addClass('active');

        // $.ajax({
        //     url:'fs/back/action/get/parentcategory',
        //     type:'post',
        //     dataType:'json',
        //     success:function (res) {
        //         drawParentCategoryOption(res);
        //     }
        // });

        var current_page = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        var dt = $('#example1').DataTable({
            language:{
                paginate:{
                    next:'<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                    previous:'<i class="fa fa-chevron-left" aria-hidden="true"></i>'
                },
                search:'検索',
                lengthMenu:"表示件数 _MENU_ 件"
            },
            processing:true,
            stateSave:true,
            ajax:{
                'url':"fs/back/get/categorieslist",
                'type':'post',
                'dataType':'json'
            },
            columns: [
                {"data":"CATEGORY_ID","width": "89px"},
                {"data":"SEQ","width": "43px"},
                {"data":"CATEGORY_NM"},
                {"data":"PARENT_ID","width": "119px"},
                {"data":"buttons","width": "126px"}
            ],
            dom: '<"top"Bf>t<"bottom"lp><"clear">',
            buttons: [
                {
                    text: '新規作成',
                }
            ],
            initComplete: initData = function(s,j) {
                dt.page(current_page).draw('page');
            }
        });

        $('.submit_shop').click(function () {
            var action = $(this).data('action');

            if(!assignValidate($)) {
                return false;
            }

            if(action == 'create') {
                if(setData()) {
                    $.ajax({
                        url:'fs/back/create/category',
                        type:'post',
                        data:create_items,
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
                create_items['shop_category_id'] = $('#cat_id').val();
                create_items['shop_category_name'] = $('#cat_name').val();
                $.ajax({
                    url:'fs/back/update/category',
                    type:'post',
                    data:create_items,
                    dataType:'json',
                    success: function(res) {
                        if(res.error == 0) {
                            $('#myModal').modal('hide');
                            dt.ajax.reload(initData);
                        }
                    }
                });
            }
        });
        

        /* Create */
        $('.dt-buttons').click(function () {
            current_page = dt.page.info().pages-1;
            createMod($);
            $('#myModal').modal();
        });

        /* Edit */
        $('table.example1').on('click', '.edit-cat-btn', function () {
            current_page = dt.page();
            editMod($);
            $('#myModal').modal();
            disableInput();
            id = $(this).data('id');

            $.ajax({
                url:'fs/back/action/get/parentcategoryinfo',
                type:'post',
                data:{shop_category_id:id},
                dataType:'json',
                success: function(res) {
                    $('.cat_id').val(res.CATEGORY_ID);
                    $('.cat_name').val(res.CATEGORY_NM);
                    $('.cat_seq').val(res.SEQ);
                    $('.cat_type').val(res.TYPE_FLG);
                }
            });
        });
        
        $('table.example1').on('click', '.view-cat-btn', function () {
            var id = $(this).data('id');
            current_page = dt.page();
            $.ajax({
                url:'fs/back/update/category/view',
                type:'post',
                data:{category_id:id},
                dataType:'json',
                success: function(res) {
                    if(res.error == 0) {
                        dt.ajax.reload(initData);
                    }
                }
            });
        });

        var delete_id = 0, delete_name;
        /* Delete */
        $('table.example1').on('click', '.delete-cat-btn', function () {
            current_page = dt.page();
            var id = $(this).data('id'), 
            name = $(this).data('name');
            $.ajax({
                url:'fs/back/action/get/checkitems',
                type:'post',
                data:{cat_id:id},
                dataType:'json',
                success:function(res) {
                    var parent = $('.deleteModal');
                    delete_id = 0;
                    delete_name = '';
                    yesCancel($,res.error);
                    if(res.error == 0) {
                        parent.find('span.data-msg').html(res.data);
                    } else {
                        delete_id = id;
                        delete_name = name;
                        var message = '削除してもよろしいですか？';
                        // 'Do you want to delete (<mark>'+name+' ID: '+id+'</mark>)';
                        parent.find('span.data-msg').html(message);
                    }
                    
                }
            });

            $('#deleteModal').modal();
        });

        $('.delete-yes').click(function() {
            $.ajax({
                url:'fs/back/delete/category',
                type:'post',
                data:{cat_id:delete_id,cat_name:delete_name},
                dataType:'json',
                success:function(res) {
                    if(res.error == 0) {
                        $('#deleteModal').modal('hide');
                        dt.ajax.reload(initData);
                    }
                }
            });

            console.log(delete_id,delete_name);
        });

        $('.delete-cancel').click(function() {
            $('#deleteModal').modal('hide');
        });

        $('.cat_type').change(function () {
            var type = $(this).val();
            triggerForSubCat($('.form-cat-row'),type);
        });

        $('#myModal').on('hidden.bs.modal', function () {
            resetForm();
            runtime = 0;
        });

        $('.close_modal').click(function () {
            $('#myModal').modal('hide');
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

    function resetForm() {
        if($('.nulled').parent().hasClass('has-error')) {
            $('.nulled').parent().removeClass('has-error');
        }
        $('.cat_id').val('');
        $('.cat_name').val('');
        $('.cat_seq').val('');
        enableInput();

        // $('.cat_type').val(res.TYPE_FLG);
    }

    function enableInput() {
        $('.cat_id').removeAttr('disabled');
        $('.cat_seq').removeAttr('disabled');
        $('.cat_type').removeAttr('disabled');
    }

    function disableInput() {
        document.getElementById('cat_id').setAttribute('disabled','disabled');
        document.getElementById('cat_seq').setAttribute('disabled','disabled');
        document.getElementById('cat_type').setAttribute('disabled','disabled');
    }

    function createMod($) {
        $('.parent-modal').find('.modal-title').text('New Entry'); // title
        $('.parent-modal').find('.submit_shop').text('新規作成'); // btn name
        $('.parent-modal').find('.submit_shop').data('action', 'create'); // action
        // $('.parent-modal').find('.ip-first').show();
    }

    function editMod($) {
        $('.parent-modal').find('.modal-title').text('カテゴリー作成/修正'); // title
        $('.parent-modal').find('.submit_shop').text('作成/更新'); // btn name
        $('.parent-modal').find('.submit_shop').data('action', 'update'); // action
        // $('.parent-modal').find('.ip-first').hide();
    }

    function drawParentCategoryOption(d) {
        var sel = document.getElementById('cat_parent');
        for(i in d) {
            o = d[i];
            var opt = document.createElement('option');
            opt.value = o.CATEGORY_ID;
            opt.text = o.CATEGORY_NM;
            sel.add(opt);
        }
    }

    function triggerForSubCat(el,type) {
        switch(type) {
            case '0':
                el.show();
                break;
            case '1':
                el.hide();
                break;
        }
    }

    function setData() {
        create_items = {};
        var type = document.getElementById('cat_type').value;
        if(type == 0) {
            var sub_cat_ask = document.getElementById('cat_sub').value;
            create_items['shop_category_type'] = type;
            create_items['shop_category_name'] = document.getElementById('cat_name').value;
            if(sub_cat_ask == 1) {
                create_items['shop_category_subask'] = sub_cat_ask;
            }
            return true;
        } else if(type == 1) {
            create_items['shop_category_type'] = type;
            create_items['shop_category_name'] = document.getElementById('cat_name').value;
            return true;
        }
        return false;
    }

    function yesCancel($,action) {
        if(action == 0) {
            $('.yes-cancel').hide();
        } else {
            $('.yes-cancel').show();
        }
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