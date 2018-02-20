@extends('back.backtemp.main')
@section('title', 'Users')
@section('title_name', 'ユーザー管理')

@section('style')
{{ Html::style('theme/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

<!-- Select2 -->
{{ Html::style('theme/bower_components/select2/dist/css/select2.min.css') }}

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
    /* select 2 */
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #3c8dbc;
        border-color: #367fa9;
        padding: 1px 10px;
        color: #fff;
    }
    .form-control {
        border-radius:4px;
    }
    #example1 > tbody > tr > td:nth-child(5){
        padding: 2px !important;
    }
    #example1 > tbody > tr > td{
        white-space: nowrap;
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
        <h3 class="box-title" style="font-weight: bold;font-size: 14px;">ユーザー一覧</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped example1" style="width:100%; height:100%;">
        <thead>
        <tr>
            <th>ユーザー名</th>
            <th>担当者名</th>
            <th>店舗名</th>
            <th>権限</th>
            <th>修正/ロック/削除</th>
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
<div id="myModal" class="modal myModal parent-modal" role="dialog">
    <div class="modal-dialog" style="width: 328px;top: 16%;">

        <!-- Modal content-->
        <div class="modal-content" style="min-height: 615px;">
            <div class="modal-header" style="background-color: #3e92ce;color: #ffffff;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">X</button>
                <h4 class="modal-title" style="font-size: 14px;">New Entry</h4>
            </div>

            <div class="modal-body">
                
                <div class="row">
                
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">         
                            <label for="user_last">担当者(姓)</label>
                            <input type="text" id="user_last" class="form-control nulled" placeholder="Oreta">
                        </div>
                    </div>
                        
                </div>

                <div class="row">
                
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">         
                            <label for="user_first">担当者(名)</label>
                            <input type="text" id="user_first" class="form-control nulled" placeholder="Gary">
                        </div>
                    </div>
                        
                </div>

                <div class="row">
                
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">         
                            <label for="user_email">Eメールアドレス</label>
                            <input type="text" id="user_email" class="form-control nulled" placeholder="abcdef@domain.com">
                        </div>
                    </div>
                        
                </div>

                <div class="row">
                
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">         
                            <label for="user_shops">店舗名</label>
                            <select class="form-control select2 nulled" id="user_shops" multiple="multiple" data-placeholder="Select shops" style="width: 100%;">
                                @if($data)
                                    @foreach($data as $key => $val)
                                    <option value="{{$val->SHOP_FC_NO}}">{{$val->SHOP_NM}}</option>
                                    @endforeach
                                @else
                                <option>Problem Occured</option>
                                @endif
                            </select>
                        </div>
                    </div>
                        
                </div>

                <div class="row">
                
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7" style="padding-right: 0;">
                        <div class="form-group">         
                            <label for="user_name">ユーザー名</label>
                            <input type="text" id="user_name" class="form-control nulled" placeholder="Gary">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                        <div class="form-group">         
                            <label for="user_level">ユーザー権限</label>
                            <select class="form-control nulled" id="user_level">
                                <option value="" selected disabled>システム</option>
                                <option value="1">オーナー</option>
                            </select>
                        </div>
                    </div>
                        
                </div>

                <div class="row">
                
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">         
                            <label for="user_password">パスワード</label>
                            <input type="password" id="user_password" class="form-control nulled">
                        </div>
                    </div>
                        
                </div>

                <div class="row">
                
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">         
                            <label for="user_conf_pass">パスワード(確認)</label>
                            <input type="password" id="user_conf_pass" class="form-control nulled">
                        </div>
                    </div>
                        
                </div>

                

                <div class="row">
                    
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                        <div class="form-group">                        
                            <button class="btn btn-primary form-control btn-submit" data-action="">Create</button>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 pull-right">
                        <div class="form-group">                        
                            <button class="btn btn-danger form-control btn-exit">キャンセル</button>
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
<!-- Select2 -->
{{ Html::script('theme/bower_components/select2/dist/js/select2.full.min.js') }}
<script>
    $(document).ready(function() {
        
        $('.users').addClass('active');
        $('.select2').select2();
        var current_page = 0;
        var dt = $('#example1').DataTable({
            // scrollY:'500px',
            language:{
                paginate:{
                    next:'<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                    previous:'<i class="fa fa-chevron-left" aria-hidden="true"></i>'
                },
                search:'検索',
                lengthMenu:"表示件数 _MENU_ 件"
            },
            ajax:{
                'url':'fs/back/get/userslist',
                type:'post',
                dataType:'json',
            },
            dom: '<"top"Bf>t<"bottom"lp><"clear">',
            buttons: [
                {
                    text: '新規作成'
                }
            ],
            columnDefs:[
                {"width":"77px","targets":0},
                {"width":"35px","targets":3},
                {"width":"111px","targets":4},
            ],
            columns:[
                {'data':'username'},
                {'data':'name'},
                {'data':'shop_fc_no'},
                {'data':'user_level'},
                {'data':'buttons'},
            ],
            initComplete: initData = function(s,j) {
                dt.page(current_page).draw('page');
            }
        });

        // var s_data;
        // select2
        // var select_input = $('.select2').select2({
        //     placeholder:'Select shops',
        //     ajax:{
        //         url:'fs/back/action/get/usershoplist',
        //         type:'post',
        //         dataType:'json',
        //         processResults: function(data) {
        //             return { 
        //                 data:data.data,
        //                 results: data.data 
        //             }
        //         },
        //         cache: true
        //     },
        //     multiple:true,
        //     closeOnSelect:false
        // });
        
        $('.dt-buttons').click(function() {
            createMod($);
            $('#myModal').modal();
        });

        var pointer= [];
        /* Edit */
        $('table.example1').on('click', '.edit-user-btn', function () {
            editMod($);
            $('#myModal').modal();
            var email = $(this).data('email');
            current_page = dt.page();
            $.ajax({
                url:'fs/back/action/get/user',
                type:'post',
                data:{user_email:email},
                dataType:'json',
                success: function(res) {
                    if(res.error == 0) {
                        obj = res.data;
                        drawUser(res);
                        pointer = obj.pointer;
                    }
                }
            });
        });

        var formData = new Object();

        // create update
        $('.btn-submit').click(function() {

            var action = $(this).data('action');

            if(!assignValidate($,action)) {
                return false;
            }
            if(setData(action)) {

                switch(action) {
                    case 'update':
                        $.ajax({
                            url:'fs/back/update/user',
                            type:'post',
                            data:formData,
                            dataType:'json',
                            success: function(res) {
                                if(res.error == 0) {
                                    $('#myModal').modal('hide');
                                    dt.ajax.reload(initData);
                                }
                            }
                        });
                        break;
                    case 'create':
                        $.ajax({
                            url:'fs/back/create/user',
                            type:'post',
                            data:formData,
                            dataType:'json',
                            success: function(res) {
                                if(res.error == 0) {
                                    $('#myModal').modal('hide');
                                    dt.ajax.reload(initData);
                                }
                            }
                        });
                        break;
                    default:
                        return false;
                        break;
                }
            }
            
        });

        // lock
        $('table.example1').on('click','.lock-user-btn',function() {
            var id = $(this).data('id');
            current_page = dt.page();

            $.ajax({
                url:'fs/back/update/user/lockunlock',
                type:'post',
                data:{pointer:id},
                dataType:'json',
                success:function(res) {
                    if(res.error == 0) {
                        dt.ajax.reload(initData);
                    }
                }
            });
        });

        // delete user
        $('table.example1').on('click','.delete-user-btn',function() {
            var email = $(this).data('email');
            var id = $(this).data('id');
            var _confirm = confirm('こちらのユーザーを削除しますか？');
            current_page = dt.page();
            if(_confirm) {
                $.ajax({
                    url:'fs/back/delete/user',
                    type:'post',
                    data:{email:email,id:id},
                    dataType:'json',
                    success:function(res) {
                        if(res.error == 0) {
                            $('#myModal').modal('hide');
                            dt.ajax.reload(initData);
                        }
                    }
                });
            }
        });

        // close modal
        $('.btn-exit').click(function() {
            $('#myModal').modal('hide');
        });

        $('#myModal').on('hidden.bs.modal', function () {
            pointer = [];
            resetForm($);
        });

        var createMod = function($) {
            $('.parent-modal').find('.modal-title').text('ユーザー作成/修正'); // title
            $('.parent-modal').find('.btn-submit').text('作成/更新'); // btn name
            $('.parent-modal').find('.btn-submit').data('action', 'create'); // action
            // $('.parent-modal').find('.ip-first').show();
        }

        var editMod = function($) {
            $('.parent-modal').find('.modal-title').text('ユーザー情報更新'); // title
            $('.parent-modal').find('.btn-submit').text('更新'); // btn name
            $('.parent-modal').find('.btn-submit').data('action', 'update'); // action
            // $('.parent-modal').find('.ip-first').hide();
        }

        var assignValidate = function($,a) {
            var error = 0;

            if(a == 'update') {
                $('.nulled').each(function() {
                    var current = $(this);
                    if(current.parent().hasClass('has-error')) {
                        current.parent().removeClass('has-error');
                    }
                    if(current.val() == '' || current.val() == null) {
                        if($(this)[0].id == 'user_password' || $(this)[0].id == 'user_conf_pass') {
                            return true;
                        }
                        current.parent().addClass('has-error');
                        error++;
                    }
                });
                if(!error) { return true; }
            } else if(a == 'create') {
                $('.nulled').each(function() {
                    var current = $(this);
                    if(current.parent().hasClass('has-error')) {
                        current.parent().removeClass('has-error');
                    }
                    if(current.val() == '' || current.val() == null) {
                        current.parent().addClass('has-error');
                        error++;
                    }
                });
                if(!error) { return true; }
            }
            return false;
        };

        var resetForm = function($) {
            $('.nulled').val('');
            $('#user_shops').val(null).trigger('change.select2');
            $('.select2-selection__choice').remove();
            if($('.nulled').parent().hasClass('has-error')) {
                $('.nulled').parent().removeClass('has-error');
            }
        };

        var drawUser = function(res) {
            var o = res.data;
            $('#user_last').val(o.user_last);
            $('#user_first').val(o.user_first);
            $('#user_email').val(o.email);
            $('#user_level').val(o.user_level);
            $('#user_shops').val(o.shop_fc_no).trigger('change');
            $('#user_name').val(o.username);
        };

        var setData = function(action) {
            formData = {};
            switch (action) {
                case 'update':
                    formData = {
                        'user_last':$('#user_last').val(),
                        'user_first':$('#user_first').val(),
                        'user_email':$('#user_email').val(),
                        'user_shops':$('#user_shops').val(),
                        'user_name':$('#user_name').val(),
                        'user_level':$('#user_level').val(),
                        'user_password':$('#user_password').val(),
                        'user_conf_pass':$('#user_conf_pass').val(),
                        'user_pointer':pointer
                    };
                    break;
                case 'create':
                    formData = {
                        'user_last':$('#user_last').val(),
                        'user_first':$('#user_first').val(),
                        'user_email':$('#user_email').val(),
                        'user_shops':$('#user_shops').val(),
                        'user_name':$('#user_name').val(),
                        'user_level':$('#user_level').val(),
                        'user_password':$('#user_password').val(),
                        'user_conf_pass':$('#user_conf_pass').val()
                    };
                    break;
                default:
                    return false;
                    break;
            }
            return true;
        };

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

</script>
@stop