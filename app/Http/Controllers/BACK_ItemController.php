<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Crypt;
use DB;
use Config;
use File;
use Response;
use Illuminate\Support\Facades\Input;

class BACK_ItemController extends Controller{

	public function __construct() {
		$this->return_json = array(
			'error' => 1,
			'data'  => false
		);
		date_default_timezone_set("Asia/Tokyo");
		$this->date_now = date('Y-m-d H:i:s');
	}
	
	public function imageView(Request $request, $image_name){
	    // $path = storage_path('public/' . $filename);
		
		$path = storage_path()."/items/".$image_name;

		if (!File::exists($path)) {
			abort(404);
		}

		$file = File::get($path);
		$type = File::mimeType($path);

		$response = Response::make($file, 200);
		$response->header("Content-Type", $type);

		return $response;
	}
	
	
	public function getCategory(Request $request, $parent_flg) {

		$session_shop = session()->get('current_shop');

		$this->configDB($session_shop[0]);
		
		//$this->configDB('shop_xxxx');

		$query = DB::table('MST_CATEGORY');
		
		if($parent_flg != 3){
			$query->where('PARENT_FLG', $parent_flg);
			$query->orderBy('SEQ', 'ASC');
		}else{
			$query->orderBy('CATEGORY_ID', 'ASC');
		}
		
		$query->where('TYPE_FLG', 0);
		$result = $query->get();
		
		$this->return_json['error'] = 0;
		$this->return_json['data'] = $result;
		$this->return_json['msg'] = 'successfully listed the items';
		
		echo json_encode($this->return_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	}
	
	public function getFooditem(Request $request, $category_id, $sub_category_id){

		$session_shop = session()->get('current_shop');

		$this->configDB($session_shop[0]);
		//$this->configDB('shop_xxxx');
		$mst_item = DB::table('MST_ITEM')
			->where('CATEGORY_PARENT_ID', $category_id)
			->where('CATEGORY_SUB_ID', $sub_category_id)
			->orderBy('SEQ', 'ASC')
			->get();
		$itemsArr = $mst_item->toArray();
		foreach($itemsArr as $item){
			
			$item_id = sprintf("%012d", $item->ITEM_ID);
			
			$mst_item_dtl = DB::table('MST_ITEM_DTL')->where('GROUP_ID', $item->ITEM_ID)->get();

			foreach($mst_item_dtl as $item_dtl){
				if( $item_id == sprintf("%012d", $item_dtl->GROUP_ID) ){
					
					$item_id_dtl = sprintf("%012d", $item_dtl->ITEM_ID);
					$item_price_dtl = $item_dtl->ITEM_PRICE;
					$gender_flg_dtl = $item_dtl->GENDER_FLG;
					
					if($gender_flg_dtl != 0){
						// echo "if";
						$item->ITEM_ID_1 = $item_id_dtl;
						$item->ITEM_PRICE_1 = $item_price_dtl;
						$item->GENDER_FLG_1 = $gender_flg_dtl;
					}else{
						// echo "else";
						$item->ITEM_ID_0 = $item_id_dtl;
						$item->ITEM_PRICE_0 = $item_price_dtl;
						$item->GENDER_FLG_0 = $gender_flg_dtl;
					}
				}
			}
			
		}
		$this->return_json['error'] = 0;
		$this->return_json['sub_category_id'] = $sub_category_id;
		$this->return_json['data'] = $itemsArr;
		$this->return_json['msg'] = 'successfully listed the items';
		
		echo json_encode($this->return_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		// echo "<pre>";
			// var_dump($itemsArr);
		// echo "</pre>";
	}
	
	public function getItem(Request $request, $category_id) {
		$db_name = session()->get('shop_id');
		//$um = UserModel::select('SEAT_NO')->get();

		//$um = UserModel::select('SEAT_NO')->get();
		
		// var_dump($category_id);
		// die();
		$session_shop = session()->get('current_shop');

		$this->configDB($session_shop[0]);
		//$this->configDB($db_name);
		// $mst_item = DB::select(DB::raw("
			// SELECT * FROM `MST_ITEM`;
		// "));
		$mst_item = DB::table('MST_ITEM')
			->where('CATEGORY_PARENT_ID', $category_id)
			->orderBy('CATEGORY_SUB_ID', 'ASC')
			->orderBy('SEQ', 'ASC')
			->get();
		$itemsArr = $mst_item->toArray();
		
		foreach($itemsArr as $item){
			
			$item_id = sprintf("%012d", $item->ITEM_ID);
			
			$mst_item_dtl = DB::table('MST_ITEM_DTL')->where('GROUP_ID', $item->ITEM_ID)->get();

			foreach($mst_item_dtl as $item_dtl){
				if( $item_id == sprintf("%012d", $item_dtl->GROUP_ID) ){
					
					$item_id_dtl = sprintf("%012d", $item_dtl->ITEM_ID);
					$item_price_dtl = $item_dtl->ITEM_PRICE;
					$gender_flg_dtl = $item_dtl->GENDER_FLG;
					
					if($gender_flg_dtl != 0){
						// echo "if";
						$item->ITEM_ID_1 = $item_id_dtl;
						$item->ITEM_PRICE_1 = $item_price_dtl;
						$item->GENDER_FLG_1 = $gender_flg_dtl;
					}else{
						// echo "else";
						$item->ITEM_ID_0 = $item_id_dtl;
						$item->ITEM_PRICE_0 = $item_price_dtl;
						$item->GENDER_FLG_0 = $gender_flg_dtl;
					}
				}
			}
			
		}
		$this->return_json['error'] = 0;
		$this->return_json['category_id'] = $category_id;
		$this->return_json['data'] = $itemsArr;
		$this->return_json['msg'] = 'successfully listed the items';
		
		// echo "<pre>";
		echo json_encode($this->return_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		// echo "</pre>";
		
		
	}
	
	public function itemSequence(Request $request) {
		// $data_seq = $request->data;
		$db_name = session()->get('shop_id');
		$session_shop = session()->get('current_shop');

		$this->configDB($session_shop[0]);
		//$this->configDB($db_name);
		$data_seq = explode("&", $request->data);
		$seq = 0;
		foreach($data_seq as $id){
			$item_id = str_replace("item[]=", "", $id);
			// $orderApp = sprintf('%04d', $seq);
			
			// var_dump($item_id);
			
				$mst_item = DB::table('MST_ITEM')->where('ITEM_ID', $item_id)
					->update([
						'SEQ' => $seq
					]);
				
			$seq++;
		}
		return 1;
	}
	
	public function createItem(Request $request) {
		
		$db_name = session()->get('shop_id');
		$session_shop = session()->get('current_shop');

		$this->configDB($session_shop[0]);
		//$this->configDB($db_name);
		
		$error = 0;
		$arrReq = [
			'item_nm' => 'item_nm is required',
			// 'item_description' => 'item_description is required',
			'category' => 'category is required',
			'male_id' => 'male_id is required',
			'female_id' => 'female_id is required',
			'male_price' => 'male_price is required',
			'female_price' => 'female_price is required',
			// 'item_img' => 'item_img is required',
		];
		
		$arrErr = array();
		foreach($arrReq as $key => $val) {
			if(is_null($request->$key)) {
				$arr = array();
				$arr[$key] = $val;
				array_push($arrErr, $arr);
				// $this->return_json['msg'] = $arr;
				// $this->return_json[$key] = $val;
				$error++;
				// break;
			}
		}
		if($request->category == 1){
			if(is_null($request->sub_category)) {
				array_push($arrErr, ['sub_category' => 'sub_category is required']);
			}
		}
		// if($request->flg == 0){
			// if(is_null($request->item_img)) {
				// array_push($arrErr, ['item_img' => 'item_img is required']);
			// }
		// }
		
		
	
		if(!count($arrErr)){
			
			$item_nm = $request->item_nm;
			$item_description = $request->item_description;
			$category = $request->category;
			$sub_category = $request->sub_category;
			$male_id = sprintf('%012d', $request->male_id);
			
			$itemDtlid = DB::table('MST_ITEM_DTL')->orderBy('ITEM_ID', 'DESC')->first();
			if($male_id == "000000000000"){
				$male_id = $itemDtlid->ITEM_ID + 1;
			}
			
			$female_id = sprintf('%012d', $request->female_id);
			if($female_id == "000000000000"){
				$female_id = $itemDtlid->ITEM_ID + 2;
			}
			
			// var_dump($itemDtlid->ITEM_ID);
			// die();
			
			$male_price = $request->male_price;
			$female_price = $request->female_price;
			$item_dtl_id = array($male_id, $female_id);
			
			
			if($male_id == $female_id){
				$this->return_json['error'] = 2;
				$this->return_json['msg'] = 'gender id must be unique';
			// array_push($arrErr, ['gender_id' => 'gender id must be unique']);
			} else {
				if($request->flg == 0){
					
					$query = DB::table('MST_ITEM_DTL');
					$query->whereIn('ITEM_ID', $item_dtl_id);
					$mst_item_dtl = $query->get();
					
					if(count($mst_item_dtl)){
						
						$errData = array();
						foreach($mst_item_dtl as $item_dtl){

							if($item_dtl->GENDER_FLG == 0){
								
								// $this->return_json['error'] = 1;
								// $this->return_json['msg'] = ['male_id' => 'this male id is already used'];
								array_push($errData, ['male_id' => 'this male id is already used']);
							} else {
								
								// $this->return_json['error'] = 1;
								// $this->return_json['msg'] = ['female_id' => 'this female id is already used'];
								array_push($errData, ['female_id' => 'this female id is already used']);
							}
						}
						$this->return_json['error'] = 1;
						$this->return_json['msg']  = $errData;
					} else {
						
						$this->createItems($request, 0, $request->flg, $male_id, $female_id);
						$this->return_json['error'] = 0;
						$this->return_json['msg'] = 'Sucessfully created new items';
					}
					
				} else {
					
					$errGender = 0;
					$query = DB::table('MST_ITEM_DTL');
					$query->whereIn('ITEM_ID', $item_dtl_id);
					$mst_item_dtl = $query->get();
					
					$dataErr = array();
					if(count($mst_item_dtl)){
						foreach($mst_item_dtl as $item_dtl){
							if($item_dtl->GROUP_ID != $request->group_id){
									
								if($item_dtl->GENDER_FLG == 0){
									
									// $this->return_json['error'] = 1;
									// $this->return_json['msg'] = ['male_id' => 'this male id is already used'];
									array_push($dataErr, ['male_id' => 'this male id is already used']);
								} else {
									
									// $this->return_json['error'] = 1;
									// $this->return_json['msg'] = ['female_id' => 'this female id is already used'];
									array_push($dataErr, ['female_id' => 'this female id is already used']);
								}
								$errGender ++;
							}
						}
						$this->return_json['error'] = 1;
						$this->return_json['msg'] = $dataErr;
						
						
					}
					
					
					if(!$errGender){
						
						$this->createItems($request, 0, $request->flg, $male_id, $female_id);
						$this->return_json['error'] = 0;
						$this->return_json['msg'] = 'Sucessfully update the items';
						
					}
					
					
				}
			}
			
		} else {
			
			$this->return_json['error'] = 1;
			$this->return_json['msg'] = $arrErr;
		}
		
		echo json_encode($this->return_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		
	}
	
	public function getitemDtl(Request $request){
		
		$db_name = session()->get('shop_id');
		$session_shop = session()->get('current_shop');

		$this->configDB($session_shop[0]);
		//$this->configDB($db_name);
		
		$mst_item = DB::table('MST_ITEM')
			->orderBy('ITEM_ID', 'DESC')
			->first();
		
			$this->return_json['error'] = 0;
			$this->return_json['item_id'] = sprintf('%012d', $mst_item->ITEM_ID);
			$this->return_json['msg'] = 'listed the current id';
		echo json_encode($this->return_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	}
	
	
	public function getItemInfo(Request $request, $item_id){
		$db_name = session()->get('shop_id');
		$session_shop = session()->get('current_shop');

		$this->configDB($session_shop[0]);
		//$this->configDB($db_name);
		
		/* $mst_item = DB::table('MST_ITEM')
			->where('ITEM_ID', $item_id)
			// ->get();
			->first();
			
		if(count($mst_item)){
			$this->return_json['error'] = 0;
			$this->return_json['data'] = $mst_item;
			$this->return_json['msg'] = 'item found';
		} */
		
		$mst_item = DB::table('MST_ITEM')
			->where('ITEM_ID', $item_id)
			->get();
		$itemsArr = $mst_item->toArray();
		
		foreach($itemsArr as $item){
			
			$item_id = sprintf("%012d", $item->ITEM_ID);
			
			$mst_item_dtl = DB::table('MST_ITEM_DTL')->where('GROUP_ID', $item->ITEM_ID)->get();

			foreach($mst_item_dtl as $item_dtl){
				if( $item_id == sprintf("%012d", $item_dtl->GROUP_ID) ){
					
					$item_id_dtl = sprintf("%012d", $item_dtl->ITEM_ID);
					$item_price_dtl = $item_dtl->ITEM_PRICE;
					$gender_flg_dtl = $item_dtl->GENDER_FLG;
					
					if($gender_flg_dtl != 0){
						// echo "if";
						$item->ITEM_ID_1 = $item_id_dtl;
						$item->ITEM_PRICE_1 = $item_price_dtl;
						$item->GENDER_FLG_1 = $gender_flg_dtl;
					}else{
						// echo "else";
						$item->ITEM_ID_0 = $item_id_dtl;
						$item->ITEM_PRICE_0 = $item_price_dtl;
						$item->GENDER_FLG_0 = $gender_flg_dtl;
					}
				}
			}
			
		}
		$this->return_json['error'] = 0;
		$this->return_json['data'] = $itemsArr;
		$this->return_json['msg'] = 'successfully listed the items';
		
			
		
		echo json_encode($this->return_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		
	}

	
	public function deleteItem(Request $request){
		
		$db_name = session()->get('shop_id');
		$session_shop = session()->get('current_shop');

		$this->configDB($session_shop[0]);
		//$this->configDB($db_name);
		$item_id = $request->item_id;
		$mst_item = DB::table('MST_ITEM')
			->where('ITEM_ID', $item_id)
			->delete();
			
		$mst_item_dtl = DB::table('MST_ITEM_DTL')
			->where('GROUP_ID', $item_id)
			->delete();
		
		if($mst_item){
			$this->return_json['error'] = 0;
			$this->return_json['msg'] = 'successfully delete item';
		}
	
		echo json_encode($this->return_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		
	}
	
	
	private function createItems($request, $create_flg, $flg, $male_id, $female_id){
		$db_name = session()->get('shop_id');
		$session_shop = session()->get('current_shop');

		$this->configDB($session_shop[0]);
		//$this->configDB($db_name);
		
		$item_nm = $request->item_nm;
		$item_description = $request->item_description;
		$category = sprintf('%03d', $request->category);
		$sub_category = sprintf('%03d', $request->sub_category);
		// $male_id = sprintf('%012d', $request->male_id);
		$male_price = $request->male_price;
		if(is_null($male_price)){
			$male_price = 0;
		}
		// $female_id = sprintf('%012d', $request->female_id);
		$female_price = $request->female_price;
		if(is_null($female_price)){
			$male_price = 0;
		}
		$item_dtl_id = array($male_id, $female_id);
		
		if($request->category != 1){
			$sub_category = null;
		}

		if($flg != 0){
			$group_id = $request->group_id;
			$seq = $request->seq;
		}else{
			$mst_item = DB::table('MST_ITEM')
				->where('CATEGORY_PARENT_ID', $category)
				->where('CATEGORY_SUB_ID', $sub_category)
				->orderBy('SEQ', 'DESC')
				->first();
				
			if(count($mst_item)){
				$seq = $mst_item->SEQ + 1;
			}else{
				$seq = 0;
			}
		}
		
		
		if($create_flg == 0){
			$arr = array();
			if($item_nm != "") $arr['ITEM_NM'] = $item_nm;
			if($seq != "") $arr['SEQ'] = $seq;
			if($item_description != "") {
				$arr['ITEM_DESC'] = $item_description;
			}else{
				$arr['ITEM_DESC'] = "";
			}
			if($category != "") $arr['CATEGORY_PARENT_ID'] = $category;
			if($sub_category != "") $arr['CATEGORY_SUB_ID'] = $sub_category;
			$arr['TYPE'] = 0;
			$arr['INSERT_DATE'] = date('Y-m-d');
			
			$file = array('file' => Input::file('item_img'));
			
			
			if(!is_null($request->item_img)) {
				$path = storage_path(). "/items/";
				$extension = Input::file('item_img')->getClientOriginalExtension(); // getting image extension
				$item_img = uniqid().date("YmdHi").".".$extension; // renameing image
				Input::file('item_img')->move($path, $item_img);
				$arr['ITEM_IMG'] = $item_img;
			}else{
				
				if($flg != 0){
					
					if(!is_null($request->item_img)) {
						$path = storage_path(). "/items/";
						$extension = Input::file('item_img')->getClientOriginalExtension(); // getting image extension
						$item_img = uniqid().date("YmdHi").".".$extension; // renameing image
						Input::file('item_img')->move($path, $item_img);
						$arr['ITEM_IMG'] = $item_img;
					}
				}else{
					
					$arr['ITEM_IMG'] = "no_img.png";
				}
				
			}
			
			if($flg == 0){
				$mst_item = DB::table('MST_ITEM')->insertGetId($arr);
				
				$maleData = array();
				$maleData['ITEM_ID'] = $male_id;
				$maleData['ITEM_PRICE'] = $male_price;
				$maleData['GENDER_FLG'] = 0;
				$maleData['GROUP_ID'] = $mst_item;
				
				$femaleData = array();
				$femaleData['ITEM_ID'] = $female_id;
				$femaleData['ITEM_PRICE'] = $female_price;
				$femaleData['GENDER_FLG'] = 1;
				$femaleData['GROUP_ID'] = $mst_item;
				$arr_dtl = [$maleData, $femaleData];
				
				DB::table('MST_ITEM_DTL')->insert($arr_dtl);
				
			} else {
				
				$mst_item = DB::table('MST_ITEM')
					->where('ITEM_ID', $request->group_id)
					->update($arr);
				
				$maleData = array();
				$maleData['ITEM_ID'] = $male_id;
				$maleData['ITEM_PRICE'] = $male_price;
				$maleData['GENDER_FLG'] = 0;
				
				DB::table('MST_ITEM_DTL')
					->where('GENDER_FLG', 0)
					->where('GROUP_ID', $request->group_id)
					->update($maleData);
				
				$femaleData = array();
				$femaleData['ITEM_ID'] = $female_id;
				$femaleData['ITEM_PRICE'] = $female_price;
				$femaleData['GENDER_FLG'] = 1;
				
				DB::table('MST_ITEM_DTL')
					->where('GENDER_FLG', 1)
					->where('GROUP_ID', $request->group_id)
					->update($femaleData);
					
				
					
				$this->return_json['error'] = 0;
				$this->return_json['msg'] = 'Sucessfully Update items';
			}
			
			
		}
	}

	public function UpdateFoodAndItemFlag(Request $request) {

		if(session()->exists('current_shop')) {
            $session_shop = session()->get('current_shop');

            $this->configDB($session_shop[0]);

            $error = 0;
            $arrReq = [
                'item_id' => 'Item Id required'
            ];
    
            foreach($arrReq as $key => $val) {
                if(is_null($request->$key)) {
                    $this->return_json['msg'] = $val;
                    $error++;
                    break;
                }
            }
    
            if(!$error) {
    
                $item_id = $request->item_id;
    
                $MST_ITEM = DB::table('MST_ITEM')
                ->where('ITEM_ID',$item_id)->get();

                if($MST_ITEM->count() == 1) {
    
                    try {

                        $MST_ITEM = $MST_ITEM->first();

                        $item_id = $MST_ITEM->ITEM_ID;

                        $view_flg = 0;

                        if($MST_ITEM->VIEW_FLG == 0) {
                            $view_flg = 1;
                        }

                        $arr_list = [
                            'VIEW_FLG'       => $view_flg,
                            'UPDATE_DATE'    => $this->date_now,
                            'UPDATE_USER_ID' => session()->get('users')['id']
                        ];
                        $update_MST_ITEM = DB::table('MST_ITEM')->where('ITEM_ID',$item_id)->update($arr_list);
                        if($update_MST_ITEM == 1) {
                            unset($this->return_json['msg']);
							$this->return_json['error'] = 0;
							$this->return_json['data'] = $view_flg;
                        }
                    } catch(\Exception $e) {
                        $this->return_json['ref'] = $e;
                        return response()->json($this->return_json);
                    }
                    
                }
    
            }   

        }

        return response()->json($this->return_json);

	}
	
    
	private function configDB($db_name) {
		Config::set("database.connections.mysql", [
			"host"     => "db-food.cg4jhjqbqa96.ap-northeast-1.rds.amazonaws.com",
			"database" => 'shop_'.$db_name, // $db_name
			"username" => "dbmaster",
			"password" => "f04v3wBj9o",
			'driver'   => 'mysql',
			'charset'  => 'utf8',
			'collation' => 'utf8_unicode_ci'
		]);
	}
}