@extends('back.backtemp.main')
@section('title', 'Food and Item')
@section('title_name', '商品管理')
@section('content')

<style>
	.btn-primary {
		border-color: inherit;
	}
	.panel-heading .accordion-toggle:after {
		/* symbol for "opening" panels */
		font-family: 'Glyphicons Halflings';  /* essential for enabling glyphicon */
		content: "\e114";    /* adjust as needed, taken from bootstrap.css */
		float: right;        /* adjust as needed */
		color: grey;         /* adjust as needed */
	}
	.panel-heading .accordion-toggle.collapsed:after {
		/* symbol for "collapsed" panels */
		content: "\e080";    /* adjust as needed, taken from bootstrap.css */
	}

</style>

<div class="row">


	<div class="col-md-12">
	 
		<div class="panel panel-default">
			<div class="panel-body" style="padding: 10px;"> 
				<div class="box-body" style="padding: 0px;">
					<button class="btn btn-primary btn-primary create-item">新規作成</button>
				</div>
			</div>
		</div>
		
	<div id="items-content" class="items-content">
	</div>	
		<!-- <div class="panel panel-default">
			<div class="panel-heading">
			 Messages
			</div>        
					  
			<div class="panel-body" style="min-height: 660px;max-height: 660px;overflow-y: scroll;"> 
				<div class="box-body">
					<div class="row coupon_gallery" style="margin-right: 0px;margin-left: 0px;width: 100%;margin: 0 auto;padding: 0;">
						<ul id="main_seq_coupon" class="main_seq_coupon ui-sortable" style="list-style-type: none;">
							@for($i = 0;$i <= 10; $i++)
							<li id="coupon_" data-seq="" class="coupon_list">
								<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 thumb item-dtl" style="cursor: move;">
								
									<div class="panel panel-primary" style="border-radius: 0px; margin-right: 0px; width: 146px; ">
										<div class="panel-heading" style="text-align: right; border-radius: 0px;">
											<span class="item_nm">	<i class="fa fa-fw fa-th-list"></i> </span>
										</div>
										<div class="panel-body" style="padding: 6px 10px 10px;">
											<div class="item-img">
												<img class="img" src="image/food/pizza-sliced.png" alt="" style="width: 126px;height: 100px;">
											</div>
											<div class="item-nm">
												<p>Pizza </p>
												<p>Pizza </p>
											</div>
											<div class="row">
												<div class="col-md-6" style="padding-left: 10px;padding-right: 0px;">
													<button class="btn btn-xs btn-primary" style="width: 60px;height: 34px;background-color: #276ba7"> 99,999 </button>
												</div>
												<div class="col-md-6" style="padding-left: 5px;padding-right: 0px;">
													<button class="btn btn-xs btn-primary" style="width: 60px;height: 34px;background-color: hsla(321, 82%, 59%, 0.98);"> 99,999 </button>
												</div>
											</div>
											<div class="row" style="padding-top: 16px;">
												<div class="col-md-4" style="padding-left: 10px;padding-right: 0px;">
													<button class="btn btn-sm btn-primary"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button>
												</div>
												<div class="col-md-4" style="padding-left: 12px;padding-right: 0px;">
													<button class="btn btn-sm  btn-warning" style="margin-right: 15px;"><i class="fa fa-lock" aria-hidden="true"></i></button>
												</div>
												<div class="col-md-4" style="padding-left: 10px;padding-right: 0px;">
													<button class="btn btn-sm btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
							@endfor	
						</ul>
					</div>
				</div>
			</div>
		</div> -->
		
		
		<!--  <div class="panel panel-default">
			<div class="panel-heading">
			 Messages
			</div>        
					  
			<div class="panel-body" style="min-height: 660px;max-height: 660px;overflow-y: scroll;"> 
				<div class="box-body">
					<div class="row coupon_gallery" style="margin-right: 0px;margin-left: 0px;width: 100%;margin: 0 auto;padding: 0;">
						<ul id="main_seq_coupon" class="main_seq_coupon ui-sortable" style="list-style-type: none;">
							@for($i = 0;$i <= 10; $i++)
							<li id="coupon_" data-seq="" class="coupon_list">
								<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 thumb item-dtl" style="cursor: move;">
								
									<div class="panel panel-primary" style="border-radius: 0px; margin-right: 0px; width: 146px; ">
										<div class="panel-heading" style="text-align: right; border-radius: 0px;">
											<span class="item_nm">	<i class="fa fa-fw fa-th-list"></i> </span>
										</div>
										<div class="panel-body" style="padding: 6px 10px 10px;">
											<div class="item-img">
												<img class="img" src="image/food/pizza-sliced.png" alt="" style="width: 126px;height: 100px;">
											</div>
											<div class="item-nm">
												<p>Pizza </p>
												<p>Pizza </p>
											</div>
											<div class="row">
												<div class="col-md-6" style="padding-left: 10px;padding-right: 0px;">
													<button class="btn btn-xs btn-primary" style="width: 60px;height: 34px;background-color: #276ba7"> 99,999 </button>
												</div>
												<div class="col-md-6" style="padding-left: 5px;padding-right: 0px;">
													<button class="btn btn-xs btn-primary" style="width: 60px;height: 34px;background-color: hsla(321, 82%, 59%, 0.98);"> 99,999 </button>
												</div>
											</div>
											<div class="row" style="padding-top: 16px;">
												<div class="col-md-4" style="padding-left: 10px;padding-right: 0px;">
													<button class="btn btn-sm btn-primary"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button>
												</div>
												<div class="col-md-4" style="padding-left: 12px;padding-right: 0px;">
													<button class="btn btn-sm  btn-warning" style="margin-right: 15px;"><i class="fa fa-lock" aria-hidden="true"></i></button>
												</div>
												<div class="col-md-4" style="padding-left: 10px;padding-right: 0px;">
													<button class="btn btn-sm btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
							@endfor	
						</ul>
					</div>
				</div>
			</div>
		</div>  -->
	</div>
</div>

<div id="myModal" class="modal parent-modal myModal in" role="dialog">
	<div class="modal-dialog" style="width: 430px;top: 5%;">

		<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header" style="background-color: #3e92ce;color: #ffffff;">
			<button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">X</button>
			<h4 class="modal-title" style="font-size: 14px;">New Entry</h4>
		</div>
		
		<div class="modal-body" style="padding:0px 0px 20px 0px;">
		<form method="POST" id="createItem" class="createItem" role="form" enctype="multipart/form-data">
			<div style="margin:20px 14px 0 14px;">

				<div class="row" style="margin: 0;">
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="padding-left: 0;">
						<label for="group_id">グループID</label>
						<div class="input-group">                        
							<input readonly type="text" id="group_id" name="group_id" class="form-control group_id" placeholder="000000000000" style="border-top-left-radius: 4px;border-bottom-left-radius: 4px;">
							<span class="input-group-addon" style="border-bottom-right-radius: 4px;border-top-right-radius: 4px;"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding: 0;">
						<div class="form-group">
							<label for="seq">表示順</label>
							<input readonly type="text" id="seq" name="seq" class="form-control seq" style="border-radius: 4px;">
						</div>
					</div>
				</div>
				
				<div class="row" style="margin: 0;">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
						<div class="form-group" data-req="item_nm">
							<label for="item_nm">商品名</label>
							<input type="text" id="item_nm" name="item_nm" data-container="body" data-placement="bottom" class="form-control item_nm" style="border-radius: 4px;">
						</div>
					</div>
				</div>
				
				<div class="row" style="margin: 0;">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
						<div class="form-group" data-req="item_description">
							<label for="item_description">商品説明</label>
							<textarea id="item_description" name="item_description" class="form-control item_description" rows="3" style="border-radius: 4px;resize: none;"></textarea>
						</div>
					</div>
				</div>
				
				<div class="row" style="margin: 0;">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
						<div class="form-group" data-req="category">
						<label for="category">カテゴリー</label>
							<select class="form-control category" id="category" name="category">
								<option value="" selected disabled hidden></option>
							</select>
						</div>
					</div>
				</div>
				
				<div class="sub-cat-container row" style="margin: 0;display: none;">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
						<div class="form-group" data-req="sub_category">
						<label for="sub-category">サブカテゴリー</label>
							<select class="form-control sub-category" id="sub-category" name="sub_category">
								<option value="" selected disabled hidden></option>
							</select>
						</div>
					</div>
				</div>
				
				<div class="row" style="margin: 0;">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
						<table>
							<tr>
								<td>
									<div class="row" style="margin: 12px 0px;">
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding: 5px;">
											<div class="form-group" data-req="male_id">
												<label for="male_id">男性用ID</label>
												<div class="input-group">                        
													<input type="text" id="male_id" name="male_id" onpaste="return false" onkeypress="return isNumeric(event)" class="form-control male_id item_dtl_id" placeholder="000000000000" maxlength="12" style="border-top-left-radius: 4px;border-bottom-left-radius: 4px;">
													<span class="input-group-addon" style="border-bottom-right-radius: 4px;border-top-right-radius: 4px;"><i class="fa fa-pencil"></i></span>
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding: 5px;">
											<div class="form-group" data-req="male_price">
												<label for="male_price">男性価格</label>
												<input type="text" id="male_price" name="male_price" onpaste="return false" onkeypress="return isNumeric(event)" class="form-control male_price" style="border-radius: 4px; border-color: #276ba7">
											</div>
										</div>
									</div>
								</td>
								<td rowspan="2">
									<div style="margin-left: 10px;">
										<div class="form-group" data-req="item_img">
											<label for="item_img">商品画像</label>
											<div class="show-image image">
												<img id="item-img" class="item-img" src="/image/no_image_startup.png" style="width: 120px;height: 120px;margin: 0px"/>
												<!-- <input class="update" type="button" value="Update" /> -->
												<div class="browse-wrap">
													<div class="title-image overlay">Upload Picture</div>
													<input type="file" id="item_img" name="item_img" data-status="0" class="upload upload-image item_img" title="Upload Picture" accept="image/*">
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="row" style="margin: 0;">
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding: 5px;">
											<div class="form-group" data-req="female_id">
												<label for="female_id">女性用ID</label>
												<div class="input-group">                        
													<input type="text" id="female_id" name="female_id" onpaste="return false" onkeypress="return isNumeric(event)" class="form-control female_id item_dtl_id" placeholder="000000000000" maxlength="12" style="border-top-left-radius: 4px;border-bottom-left-radius: 4px;">
													<span class="input-group-addon" style="border-bottom-right-radius: 4px;border-top-right-radius: 4px;"><i class="fa fa-pencil"></i></span>
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding: 5px;">
											<div class="form-group" data-req="female_price">
												<label for="female_price">女性価格</label>
												<input type="text" id="female_price" name="female_price" onpaste="return false" onkeypress="return isNumeric(event)" class="form-control female_price" style="border-radius: 4px; border-color: #ed43b1;">
											</div>
										</div>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>

			</div>
			
			
			<div class="row" style="margin: 20px 0px 10px;">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0px 14px 0 14px;">
					<input type="hidden" id="flg" class="flg" name="flg" value="0">
					<button id="submit_item" type="button" class="btn btn-primary pull-left submit_item" style="min-width: 125px;max-width: 125px;" data-action="">作成/更新</button>
					<button type="button" class="btn btn-danger pull-right" data-dismiss="modal" style="min-width: 125px;max-width: 125px;">キャンセル</button>
				</div>
			</div>
			
		</form>
		</div>

		<div class="modal-footer">
		</div>
	</div>

	</div>
</div>

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
                        <p style="text-align: center;margin-bottom: 30px;font-size: 24px;"><span class="serv-item-message">Are you sure you want to delete?</span></p>
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

@stop

@section('script')
    {{ Html::script('js/scripts/back/item_list.js') }}
@endsection