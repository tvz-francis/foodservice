<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Config;
use App\TBL_ORDER;
use App\TBL_SERVICE;

class v2CartController extends Controller
{
    public function __construct() {
        $this->return_json = array(
            'error' => 1,
            'data'  => false
		);
		// date_default_timezone_set("Asia/Bangkok");
		date_default_timezone_set("Asia/Tokyo");
		$this->date_now = date('Y-m-d H:i:s');
    }

    public function addToCart(Request $request) {		
		
		$data = array();
		$data['item_id'] = $request->item_id;
		$data['quantity'] = $request->quantity;
		$data['note'] = $request->note;
		
		// $cart = session()->get('cart');
		// session()->push('cart',$data);
		// $this->return_json['error'] = 1;
		// $this->return_json['data'] = session()->get('cart');
		if(!session()->exists('cart')) {

			session()->put('cart');
			$cart = session()->get('cart');
			$cart[$request->item_id] = $data;
			session()->put('cart',$cart);
			
			$this->return_json['error'] = 0;
			$this->return_json['data'] = session()->get('cart');
		} else {
			
			$cart = session()->get('cart');
			$cart[$request->item_id] = $data;
			session()->put('cart',$cart);

			$this->return_json['error'] = 1;
			$this->return_json['data'] = session()->get('cart');
		}
         echo json_encode($this->return_json, JSON_PRETTY_PRINT);
    }

    public function deleteToCart(Request $request, $item) {

        $this->return_json['msg'] = 'Cart does not exist';
        if(session()->exists('cart')) {

            $cart = session()->get('cart');

            $this->return_json['msg'] = 'No item has been found';
            foreach($cart as $key => $value) {
                if($item == $key) {
                    unset($this->return_json['msg']);
                    unset($cart[$item]);
                    session()->put('cart',$cart);
                    $this->return_json['error'] = 0;
                    $this->return_json['data'] = session()->get('cart');
                    break;
                }
            }

        }
		
        echo json_encode($this->return_json, JSON_PRETTY_PRINT);
		
    }

    public function deleteCart(Request $request) {
		
		$request->session()->put('cart');
        $this->return_json['msg'] = 'Cart does not exist';
        if(session()->exists('cart')) {
            $request->session()->pull('cart');
            unset($this->return_json['msg']);
            $this->return_json['error'] = 0;
            $this->return_json['data'] = session()->get('cart');
        }
		
        // var_dump( session()->all() ); 
        echo json_encode($this->return_json, JSON_PRETTY_PRINT);
    }

    public function getDetails() {

        if(count(session()->get('cart')) < 1) {
            session()->forget('cart');
        }
        
        $this->return_json['msg'] = 'Cart does not exist';
        if(session()->exists('cart') && session()->exists('shop_id')) {

            $db_name = session()->get('shop_id');

            $this->configDB($db_name);

            // foreach(session()->get('cart') as $key => $val) {
            foreach(session()->get('cart') as $cart) {
				
				$item_id = $cart['item_id'];
				$quantity = $cart['quantity'];
				$note = $cart['note'];
                // $menu = DB::table('MST_ITEM_DTL')
                // ->leftjoin('MST_ITEM', 'MST_ITEM_DTL.GROUP_ID', '=', 'MST_ITEM.ITEM_ID')
                // ->where('MST_ITEM.VIEW_FLG', 1)
                // ->where('MST_ITEM_DTL.ITEM_ID', $key)->orderBy('MST_ITEM.SEQ')->get();
                
                $menu = DB::select(DB::raw("
                    SELECT 
                        CONVERT(`MI`.`ITEM_ID`, CHAR(100)) AS `ITEM_ID`, `MI`.`ITEM_NM`, `MI`.`ITEM_DESC`, `MI`.`ITEM_IMG`, CONVERT(`MI`.`CATEGORY_PARENT_ID`, CHAR(100)) AS `CATEGORY_PARENT_ID`, `MI`.`VIEW_FLG`, CONVERT(`MI`.`TYPE`, CHAR(100)) AS `TYPE`, `MI`.`INSERT_DATE`, `MI`.`INSERT_USER_ID`, `MI`.`UPDATE_DATE`, `MI`.`UPDATE_USER_ID`, CONVERT(`MID`.`id`, CHAR(100)) AS `id`, CONVERT(`MID`.`ITEM_ID`, CHAR(100)) AS `ITEM_ID`, `MID`.`ITEM_PRICE`, `MID`.`GENDER_FLG`, CONVERT(`MID`.`GROUP_ID`, CHAR(100)) AS `GROUP_ID`
                    FROM 
                        `MST_ITEM_DTL` `MID`
                    LEFT JOIN 
                        `MST_ITEM` `MI` ON `MI`.`ITEM_ID` = `MID`.`GROUP_ID`
                    WHERE
                        `MI`.`VIEW_FLG` = '1' AND `MID`.`ITEM_ID` = :item_id ORDER BY `MI`.`SEQ` ASC;
                "),[
                    'item_id' => $item_id
                ]);
                if(count($menu) > 0) {
                    $menu[0]->PCS = $quantity;
                    $this->return_json['data'][] = $menu[0];
                }
            }
            unset($this->return_json['msg']);
            $this->return_json['error'] = 0;
        }

        echo json_encode($this->return_json, JSON_PRETTY_PRINT);

    }

    public function readCartItem(Request $request, $item_id) {
        
       /*  $this->return_json['msg'] = 'Cart does not exist';
        if(session()->exists('cart') && session()->exists('shop_id')) {

            $this->return_json['msg'] = 'Cannot find item id';
            foreach(session()->get('cart') as $key => $val) {
                
                if($key == $item_id) {
                    unset($this->return_json['msg']);
                    $this->return_json['data'] = session()->get('cart')[$item_id];
                    $this->return_json['error'] = 0;
                    break;
                }
            }

        } */
		$this->return_json['msg'] = 'Shop does not exist';
		if(session()->exists('shop_id')) {
			if(session()->exists('cart')){
				
				$this->return_json['error'] = 0;
				$this->return_json['data'] = 0;
				$this->return_json['msg'] = 'Cannot find item id';
				// foreach(session()->get('cart') as $key => $val) {
				foreach(session()->get('cart') as $cart) {
					
					$iid = $cart['item_id'];
					$quantity = $cart['quantity'];
					$note = $cart['note'];
					
					if($cart['item_id'] == $item_id) {
						unset($this->return_json['msg']);
						// $this->return_json['data'] = session()->get('cart')[$item_id];
						$this->return_json['data'] = $quantity;
						$this->return_json['error'] = 0;
						break;
					}
				}
			}else{
				
				$this->return_json['error'] = 0;
				$this->return_json['data'] = 0;
				$this->return_json['msg'] = 'Cart does not exist';
			}

		}

        echo json_encode($this->return_json, JSON_PRETTY_PRINT);

    }
	
	public function checkOrder(Request $request) {
		
		
		if(session()->exists('cart')) {
			$carts = session()->get('cart');
			$cartCount = count( session()->get('cart') );
			if( $carts != NULL || $cartCount > 0 ){
				
				$this->return_json['error'] = 0;
				$this->return_json['data'] = false;
				$this->return_json['msg'] = 'items in cart found';
				
			} else {
				
				$this->return_json['error'] = 1;
				$this->return_json['data'] = false;
				$this->return_json['msg'] = 'no items in cart';
			}
			
		} else {
			
			$this->return_json['error'] = 2;
			$this->return_json['data'] = false;
			$this->return_json['msg'] = 'no cart found';
		}
		
		echo json_encode($this->return_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	}
	
	public function placeOrder(Request $request) {
		
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
					$seqOrder = $tblOrder->SEQ + 1;
				} else {
					$seqOrder = 0;
				}
				
				$tblService = TBL_SERVICE::where('SEAT_NO', '=', $seat_no)
					->where('SALES_NO', '=', $sales_no)
					->orderBy('SEQ', 'DESC')
					->first();
				if(count($tblService)){
					$seqService = $tblService->SEQ + 1;
				} else {
					$seqService = 0;
				}
				
				$data = array();
				foreach($carts as $k => $v){
						
						$items = DB::table('MST_ITEM')
							->join('MST_ITEM_DTL', 'MST_ITEM.ITEM_ID', '=', 'MST_ITEM_DTL.GROUP_ID')
							// ->select(
								// 'MST_ITEM.ITEM_NM', 
								// 'MST_ITEM.ITEM_DESC',
								// 'MST_ITEM.TYPE',
								// 'MST_ITEM_DTL.ITEM_PRICE',
								// 'MST_ITEM_DTL.GENDER_FLG')
							->select('*')
							->where('MST_ITEM_DTL.ITEM_ID', '=', $k)
							->first();
						
						if(count($items) > 0){
							
							if($items->TYPE != 0){
								
								$TBL_SERVICE = new TBL_SERVICE;
								$TBL_SERVICE->SEAT_NO		= $seat_no;
								$TBL_SERVICE->SALES_NO		= $sales_no;
								$TBL_SERVICE->SEQ			= $seqService;
								$TBL_SERVICE->ITEM_ID		= $k;
								$TBL_SERVICE->ITEM_NM		= $items->ITEM_NM;
								$TBL_SERVICE->ITEM_QTY		= $v;
								$TBL_SERVICE->ITEM_PRICE	= $items->ITEM_PRICE;
								$TBL_SERVICE->ORDER_DATE	= date('Y-m-d H:i:s');
								$TBL_SERVICE->GENDER_FLG	= $items->GENDER_FLG;
								$TBL_SERVICE->save();
								
								// var_dump( $seqService );
								$seqService ++;
							} else {
								
								$TBL_ORDER = new TBL_ORDER;
								$TBL_ORDER->SEAT_NO		= $seat_no;
								$TBL_ORDER->SALES_NO		= $sales_no;
								$TBL_ORDER->SEQ			= $seqOrder;
								$TBL_ORDER->ITEM_ID		= $k;
								$TBL_ORDER->ITEM_NM		= $items->ITEM_NM;
								$TBL_ORDER->ITEM_QTY		= $v;
								$TBL_ORDER->ITEM_PRICE	= $items->ITEM_PRICE;
								$TBL_ORDER->ORDER_DATE	= date('Y-m-d H:i:s');
								$TBL_ORDER->GENDER_FLG	= $items->GENDER_FLG;
								$TBL_ORDER->save();
								
								$arr = array();
								$arr['item_nm'] = $items->ITEM_NM;
								$arr['item_id'] = $k;
								$arr['price'] = $items->ITEM_PRICE;
								$arr['quantity'] = (int)$v;
								$arr['total'] = $items->ITEM_PRICE * $v;
								$arr['seq'] = $seqOrder;
								$arr['gender_flg'] = $items->GENDER_FLG;
								
								array_push($data, $arr);
								$seqOrder ++;
							}
							
						}
					
				}
				
				// if (empty($data)) {
					// $data = false;
				// }
				$this->return_json['error'] = 0;
				$this->return_json['host_name'] = $host_name;
				$this->return_json['seat_no'] = $seat_no;
				$this->return_json['order_date'] = date('Y/m/d H:i');
				$this->return_json['data'] = $data;
				$this->return_json['print_flg'] = 0;
				$this->return_json['msg'] = 'Successfully placed the order';
				session()->forget('cart');

			}else{
				
				$this->return_json['error'] = 1;
				$this->return_json['host_name'] = false;
				$this->return_json['seat_no'] = false;
				$this->return_json['order_date'] = false;
				$this->return_json['data'] = false;
				$this->return_json['print_flg'] = 0;
				$this->return_json['msg'] = 'no items in cart';
			}
			
		} else {
			
			$this->return_json['error'] = 2;
			$this->return_json['host_name'] = false;
			$this->return_json['seat_no'] = false;
			$this->return_json['order_date'] = false;
			$this->return_json['data'] = false;
			$this->return_json['print_flg'] = 0;
			$this->return_json['msg'] = 'no cart found';
		}
		
		echo json_encode($this->return_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	}
	
	public function placeOrderFood(Request $request){
		
		$db_name = session()->get('shop_id');
         $this->configDB($db_name);
		$json_data = $request->data;
		
		// var_dump( $json_data["data"] );
		$host_name = $json_data['host_name'];
		$seat_status = DB::table('MST_SEAT_STATUS')
			->where('HOST_NAME_1', $host_name)
			->first();
		$sales_no = $seat_status->SALES_NO;
		$seat_no = $seat_status->SEAT_NO;
		
		if(!isset($json_data['data'])){
			
			// echo "if empty";
			$this->return_json['error'] = 0;
		}else{
			// echo "else not empty";
			foreach($json_data['data'] as $data){
				
				$item_id 	= $data['item_id'];
				$item_nm 	= $data['item_nm'];
				$price 		= $data['price'];
				$quantity 	= $data['quantity'];
				$price 		= $data['price'];
				$seq 		= $data['seq'];
				$gender_flg	= $data['gender_flg'];
				$print_flg	= $json_data['print_flg'];
				if($print_flg == 1){
					$print_date = date('Y-m-d H:i:s');
				}else{
					$print_date = null;
				}
				
				$TBL_ORDER = new TBL_ORDER;
				$TBL_ORDER->SEAT_NO		= $seat_no;
				$TBL_ORDER->SALES_NO		= $sales_no;
				$TBL_ORDER->SEQ			= $seq;
				$TBL_ORDER->ITEM_ID		= $item_id;
				$TBL_ORDER->ITEM_NM		= $item_nm;
				$TBL_ORDER->ITEM_QTY		= $quantity;
				$TBL_ORDER->ITEM_PRICE		= $price;
				$TBL_ORDER->ORDER_DATE		= date('Y-m-d H:i:s');
				$TBL_ORDER->GENDER_FLG		= $gender_flg;
				$TBL_ORDER->PRINT_FLG		= $print_flg;
				$TBL_ORDER->PRINT_DATE		= $print_date;
				$TBL_ORDER->save();
			}
			
			$this->return_json['error'] = 0;
		}
		
		echo json_encode($this->return_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
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
	
	

    private function configDB($db_name) {
        Config::set("database.connections.mysql", [
            // "host"     => "buster-food.com",
            // "database" => 'shop_XXXX',// $db_name
            // "username" => "webmaster",
            // "password" => "EQB7nhgdH{DSJcb*",
            "host"     => "db-food.cg4jhjqbqa96.ap-northeast-1.rds.amazonaws.com",
            "database" => $db_name,// $db_name
            "username" => "dbmaster",
            "password" => "f04v3wBj9o",
            'driver'   => 'mysql',
            'charset'  => 'utf8',
            'collation' => 'utf8_unicode_ci'
        ]);
    }
}
