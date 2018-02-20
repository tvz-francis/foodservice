<?php

namespace App\Http\Controllers\v2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use Config;
use App\TBL_ORDER;
use App\Http\Controllers\Controller;

class TestController extends Controller{

	public function __construct() {
        $this->return_json = array(
            'error' => 1,
            'data'  => false
        );
     }
	 
	public function checkSession(Request $request){
		$db_name = session()->get('shop_id');
         $this->configDB($db_name);
		$host_name = session()->get('host_name');
		
		$data = array();
		$data['host_name'] = $host_name;
		$data['shop_db'] = $db_name;
		
		
		$this->return_json['error'] = 0;
		$this->return_json['data'] = $data;
		$this->return_json['msg'] = 'session found';
		echo json_encode($this->return_json, JSON_PRETTY_PRINT);
		
	}
	
	public function getGenderStatus() {
		
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');
		// config db
		$this->configDB(session()->get('shop_id'));

		$seat_status = DB::select(DB::raw("
		SELECT * FROM `MST_SEAT_STATUS` `MSS` WHERE `MSS`.`HOST_NAME_1` = :seat_number AND `MSS`.`LOGIN_FLG` = 1 AND `MSS`.`SALES_NO` IS NOT NULL;
		"),[
		'seat_number' => session()->get('host_name')
		]);

		foreach($seat_status as $key) {
		$gender = $key->GENDER_FLG;
		}
		
		if($gender == ""){
			$gender = "3";
		}
		
		$data = array();
		$data['gender'] = $gender;
		// echo json_encode(['gender'=>$gender], JSON_PRETTY_PRINT);
		echo "data:" . json_encode($data) . "\n\n";
		flush();
    }
	 
	public function testServerSent(Request $request) {
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');

		// $time = date('r');
		// echo "data: The server time is: {$time}\n\n";
		// echo "data: {$time}\n\n";
		
		$db_name = session()->get('shop_id');
         $this->configDB($db_name);
		$host_name = session()->get('host_name');
		
		$seat_status = DB::table('MST_SEAT_STATUS')
			->where('HOST_NAME_1', $host_name)
			->first();
			
			    
		if( $seat_status->LOGIN_FLG != 0 && $seat_status->SALES_NO != NULL){
			echo "data: 1\n\n";
		}else{
			echo "data: 0\n\n";
		}
		
		ob_flush();
		flush();
	}
	
	 
	public function viewItem(Request $request) {
		// $db_name = session()->get('shop_id');
		$this->configDB('shop_xxxx');
		$mst_item = DB::table('MST_ITEM')->get();
		
		// $mst_item = DB::select(DB::raw("
			// SELECT * FROM MST_ITEM;
		// "));
		
		echo "<pre>";
			var_dump($mst_item);
		echo "</pre>";
		// return view('back.page.items');
	}
	 
	public function testFunction(Request $request){
		
          $db_name = session()->get('shop_id');
          $this->configDB($db_name);
		$host_name = session()->get('host_name');
		
		$seat_status = DB::table('MST_SEAT_STATUS')
			->where('HOST_NAME_1', $host_name)
			->first();
			
		$sales_no = $seat_status->SALES_NO;
		$seat_no = $seat_status->SEAT_NO;
		if(session()->exists('cart')) {
			$cartCount = count( session()->get('cart') );
			$carts = session()->get('cart');
			if( $carts != NULL || $cartCount > 0 ){
				
				$tblOrder = TBL_ORDER::where('SEAT_NO', '=', $seat_no)
					->where('SALES_NO', '=', $sales_no)
					->orderBy('SEQ', 'DESC')
					->first();
				if(count($tblOrder)){
					//insert if sales_no and seat_no is/are exist
					$sequence = $tblOrder->SEQ + 1;
					foreach($carts as $k => $v){
						$item_dtl = DB::table('MST_ITEM_DTL')
							->where('ITEM_ID', '=', $k)
							->first();
							
						$TBL_ORDER = new TBL_ORDER;
						$TBL_ORDER->SEAT_NO		= $seat_no;
						$TBL_ORDER->SALES_NO		= $sales_no;
						$TBL_ORDER->SEQ			= $sequence;
						$TBL_ORDER->ITEM_ID		= $k;
						$TBL_ORDER->ITEM_QTY		= $v;
						$TBL_ORDER->ITEM_PRICE	= $item_dtl->ITEM_PRICE;
						$TBL_ORDER->ORDER_DATE	= date('Y-m-d H:i:s');
						$TBL_ORDER->GENDER_FLG	= $item_dtl->GENDER_FLG;
						$TBL_ORDER->save();
					
					$sequence ++;
					}
				} else {
					//insert if sales_no and seat_no is/are not exist
					$sequence = 0;
					foreach($carts as $k => $v){
						$item_dtl = DB::table('MST_ITEM_DTL')
							->where('ITEM_ID', '=', $k)
							->first();
						
						$TBL_ORDER = new TBL_ORDER;
						$TBL_ORDER->SEAT_NO		= $seat_no;
						$TBL_ORDER->SALES_NO		= $sales_no;
						$TBL_ORDER->SEQ			= $sequence;
						$TBL_ORDER->ITEM_ID		= $k;
						$TBL_ORDER->ITEM_QTY		= $v;
						$TBL_ORDER->ITEM_PRICE	= $item_dtl->ITEM_PRICE;
						$TBL_ORDER->ORDER_DATE	= date('Y-m-d H:i:s');
						$TBL_ORDER->GENDER_FLG	= $item_dtl->GENDER_FLG;
						$TBL_ORDER->save();
					
					$sequence ++;
					}
				}
				
				$this->return_json['error'] = 0;
				$this->return_json['data'] = false;
				$this->return_json['msg'] = 'Successfully placed the order';
			}else{
				
				$this->return_json['error'] = 1;
				$this->return_json['data'] = false;
				$this->return_json['msg'] = 'no items in cart';
			}
			
		} else {
			$this->return_json['error'] = 2;
			$this->return_json['data'] = false;
			$this->return_json['msg'] = 'no cart found';
		}
		echo json_encode($this->return_json, JSON_PRETTY_PRINT);
		
	}
	
	public function historyCart(Request $request) {
		$db_name = session()->get('shop_id');
		$this->configDB($db_name);
		
		$host_name = session()->get('host_name'); 
		$seat_status = DB::table('MST_SEAT_STATUS')
			->where('HOST_NAME_1', $host_name)
			->first();
		
		$sales_no = $seat_status->SALES_NO;
		$seat_no = $seat_status->SEAT_NO;
		$orders = TBL_ORDER::where('SEAT_NO', '=', $seat_no)
			->where('SALES_NO', '=', $sales_no)
			->orderBy('SEQ', 'ASC')
			->get();
		if(count($orders) > 0){
			$data = array();
			foreach($orders as $order){
				
				$item = DB::table('TBL_ORDER')
					->join('MST_ITEM_DTL', 'TBL_ORDER.ITEM_ID', '=', 'MST_ITEM_DTL.ITEM_ID')
					->join('MST_ITEM', 'MST_ITEM_DTL.GROUP_ID', '=', 'MST_ITEM.ITEM_ID')
					->select(
						'TBL_ORDER.ITEM_ID',
						'MST_ITEM.ITEM_NM', 
						'MST_ITEM.ITEM_DESC', 
						'TBL_ORDER.SALES_NO', 
						'TBL_ORDER.ITEM_QTY', 
						'TBL_ORDER.ITEM_PRICE',
						'TBL_ORDER.GENDER_FLG')
					->where('MST_ITEM_DTL.ITEM_ID', '=', $order->ITEM_ID)
					->first();
				/* 	
				$item = DB::table('MST_ITEM_DTL')
					->leftJoin('MST_ITEM', 'MST_ITEM_DTL.ITEM_ID', '=', 'MST_ITEM.ITEM_ID')
					->where('MST_ITEM_DTL.ITEM_ID', '=', $order->ITEM_ID)
					->first();
				 */
				array_push($data, $item);
			}
			// var_dump( $data );
			
			$this->return_json['error'] = 0;
			$this->return_json['data'] = $data;
			$this->return_json['msg'] = 'cart items found';
			// echo json_encode($data, JSON_PRETTY_PRINT);
		}else{
			// echo "else no data";
			$this->return_json['error'] = 1;
			$this->return_json['data'] = false;
			$this->return_json['msg'] = 'no cart found';
		}
		
		echo json_encode($this->return_json, JSON_PRETTY_PRINT);
	}
	
	public function deleteCart(Request $request) {
		
		$request->session()->put('cart');
		$this->return_json['msg'] = 'Cart does not exist';
		if(session()->exists('cart')) {
			$request->session()->pull('seq');
			$request->session()->pull('cart');
			unset($this->return_json['msg']);
			$this->return_json['error'] = 0;
			$this->return_json['data'] = session()->get('cart');
		}
		
		// var_dump( session()->all() ); 
        echo json_encode($this->return_json, JSON_PRETTY_PRINT);
     }
	 
	

	public function testEncryptDecrypt() {
		echo '<pre>';var_dump(Crypt::encryptString('Hello'));echo '</pre>';
		echo '<pre>';var_dump(Crypt::decryptString('eyJpdiI6InFFNmhmdW5FYXV2d3dUckhwbnZjMkE9PSIsInZhbHVlIjoieUUweERpN3VTRG9QNE1KOXR6VUdcL1E9PSIsIm1hYyI6ImEzYTQ4MWVhMThmMDU3MGYxNzI4ZmEyYWIxMzhiM2U4YjhhMDgyMmRhYTRlYjU2OWM3OTcyNjczMzVkNjc5MTEifQ=='));echo '</pre>';
	}
	
	
	public function testSessionData(Request $request){
		// $this->configDB('shop_xxxx');
		// echo "<pre>";
			// var_dump( session()->all() );
		// echo "</pre>";
		$carts = session()->all();
		// $carts = session()->flush();
		echo "<pre>";
		var_dump($carts);
		echo "</pre>"; 
		// return view('test_summary', $data);
		// $mst_item = DB::table('MST_ITEM')->get();
		
		// echo "<pre>";
			// var_dump($mst_item);
		// echo "</pre>";
	}

	public function testActiveEvent(Request $request) {

		return response($request->all())->header('Content-Type', 'application/json');
		//->header('X-Header-One', 'Header Value')
		// ->header('X-Header-Two', 'Header Value');

		//echo '<pre>';var_dump($request->all());echo '</pre>';
	}
	
	
   /*  private function configDB($db_name) {
        Config::set("database.connections.mysql", [
            "host"     => "buster-food.com",
            "database" => 'shop_XXXX', // $db_name
            "username" => "webmaster",
            "password" => "EQB7nhgdH{DSJcb*",
            'driver'   => 'mysql',
            'charset'  => 'utf8',
            'collation' => 'utf8_unicode_ci'
        ]);
    } */
	private function configDB($db_name) {
        Config::set("database.connections.mysql", [
            "host"     => "db-food.cg4jhjqbqa96.ap-northeast-1.rds.amazonaws.com",
            "database" => 'shop_xxxx', // $db_name
            "username" => "dbmaster",
            "password" => "f04v3wBj9o",
            'driver'   => 'mysql',
            'charset'  => 'utf8',
            'collation' => 'utf8_unicode_ci'
        ]);
    }

}
