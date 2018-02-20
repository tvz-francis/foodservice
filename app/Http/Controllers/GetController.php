<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Config;

class GetController extends Controller
{
    public function __construct() {
        $this->return_json = array(
            'error' => 1,
            'data'  => false
        );
    }

    public function getShop(Request $request) {

        // $request->getClientIp() '175.654.12.456'
        $HOST_NAME = $request->input('seat_no');

        $getIP = DB::table('MST_SHOP')->where('GLOBAL_IP', 'LIKE', '%'.$request->getClientIp().'%')->get();
        if($getIP->count() > 0) {
            foreach($getIP->toArray() as $key) {
                $shop_no = $key->SHOP_FC_NO;
            }

            // configure shop db
            $db_prefix = 'shop_';
            $db_name = $db_prefix.$shop_no;
            
            // store shop_id to session
            $request->session()->put('shop_id', $db_name);
            $request->session()->put('host_name', $HOST_NAME);

            $this->return_json['error'] = 0;
            $this->return_json['data']['shop_id'] = $db_name;
        }
        // echo json_encode($this->return_json, JSON_PRETTY_PRINT);
		
        return view('welcome',$this->return_json);
    }

    public function getSeat(Request $request) {

		if(session()->exists('shop_id')) {

            $db_name = session()->get('shop_id');
            // config db
            //$this->configDB($db_name);
            $this->configDB($db_name);

            // SEAT_NO
            // $request->input('seat_no');
            $HOST_NAME = session()->get('host_name'); // $request->input('seat_no');

            // verify in MST_SEAT_STATUS > HOST_NAME_1 + SALES_NO + LOGIN FLG
            $seat_status = DB::select(DB::raw("
                SELECT * FROM `MST_SEAT_STATUS` `MSS` WHERE `MSS`.`HOST_NAME_1` = :seat_number;
            "),[
                'seat_number' => $HOST_NAME
            ]);
            
            // $this->return_json['msg'] = 'This device is not yet link to AcrossPOS. Please check tablet name in AcrossPOS. Tablet Name: '.$HOST_NAME;
            $this->return_json['msg'] = 'このデバイスはPOSと接続されていません。<br />  POSのタブレット名を確認して下さい。<br />  タブレット名: '.$HOST_NAME;
            if(count($seat_status) > 0) {

                foreach($seat_status as $key) {
                    $login_flg = $key->LOGIN_FLG;
                    $sales_no = $key->SALES_NO;
                    // $this->return_json['msg'] = 'No sales number. Please login first in AcrossPOS.';
                    $this->return_json['msg'] = '未入店のため、注文できません。 <br />
					入店後、ご注文頂けます。';
                    if($login_flg == 1 && $sales_no != NULL) {
                        $this->return_json['error'] = 0;
                        unset($this->return_json['msg']);
                        break;
                    }
                }

            }

		}else{
			
			$this->return_json['msg'] = 'サーバーに接続できません。 <br />
				IPアドレスを確認して下さい。';	
		}
        echo json_encode($this->return_json, JSON_PRETTY_PRINT);
    }

    public function getCategory(Request $request) {

        $this->return_json['msg'] = 'Shop ID is not set';
        if(session()->exists('shop_id')) {

            $db_name = session()->get('shop_id');
            $category_id = $request->a;
            // config db
            $this->configDB($db_name);

            $categories = DB::select(DB::raw("
                SELECT 
                    CONVERT(`MC`.`CATEGORY_ID`, CHAR(100)) AS `CATEGORY_ID`, 
                    `MC`.`CATEGORY_NM` 
                FROM 
                    `MST_CATEGORY` `MC` 
                WHERE 
                    `MC`.`PARENT_FLG` = '1' GROUP BY `MC`.`SEQ` ASC;
            "));

            $this->return_json['msg'] = count($categories).' Results found';
            if(count($categories) > 0) {

                unset($this->return_json['msg']);
                $this->return_json['data'] = $categories;
                $this->return_json['error'] = 0;

            }

        }
        echo json_encode($this->return_json, JSON_PRETTY_PRINT);
    }

    public function getSubCategory(Request $request) {

        // echo '<pre>';var_dump(session()->all());echo '</pre>';die();

        $error = 0;
        $arrReq = ['a'=>'Data id'];

        foreach($arrReq as $key => $value) {
            if(!$request->input($key) || empty($request->input($key))) {
                $this->return_json['msg'] = $value;
                $error++;
                break;
            }
        }

        if(!$error) {

            $this->return_json['msg'] = 'SHOP IP DOES NOT EXISTS';
            if(session()->exists('shop_id')) {

                $db_name = session()->get('shop_id');
                $category_id = $request->a;
                // config db
                $this->configDB($db_name);

                $sub_category = DB::select(DB::raw("
                    SELECT 
                        CONVERT(`MC`.`CATEGORY_ID`, CHAR(100)) AS `CATEGORY_ID`, `MC`.`CATEGORY_NM`
                    FROM 
                        `MST_CATEGORY` `MC`
                    WHERE
                        `MC`.`PARENT_ID` = :category_id ORDER BY `MC`.`SEQ` ASC;
                "),[
                    'category_id' => $category_id
                ]);
                $this->return_json['msg'] = count($sub_category).' Results found';
                if(count($sub_category) > 0) {
                    unset($this->return_json['msg']);
                    $this->return_json['error'] = 0;
                    $this->return_json['data'] = $sub_category;
                }
            }

        }
        echo json_encode($this->return_json, JSON_PRETTY_PRINT);
    }

    public function getGroupCategory(Request $request) {

        $error = 0;
        $arrReq = ['a'=>'Data id'];

        foreach($arrReq as $key => $value) {
            if(!$request->input($key) || empty($request->input($key))) {
                $this->return_json['msg'] = $value;
                $error++;
                break;
            }
        }

        if(!$error) {

            $this->return_json['msg'] = 'SHOP IP DOES NOT EXISTS';
            if(session()->exists('shop_id')) {

                $db_name = session()->get('shop_id');
                $category_id = $request->a;
                // config db
                $this->configDB($db_name);

                $sub_category_group = DB::select(DB::raw("
                    SELECT 
                        CONVERT(`MI`.`ITEM_ID`, CHAR(100)) AS `ITEM_ID`, `MC`.`CATEGORY_NM`, `MI`.`CATEGORY_PARENT_ID`, `MI`.`CATEGORY_SUB_ID`
                    FROM 
                        `MST_ITEM` `MI`
                    LEFT JOIN
                        `MST_CATEGORY` `MC` ON `MC`.`CATEGORY_ID` = `MI`.`CATEGORY_SUB_ID`
                    WHERE
                        `MI`.`VIEW_FLG` = '1' AND `MI`.`CATEGORY_PARENT_ID` = :category_id GROUP BY `MI`.`CATEGORY_SUB_ID` ORDER BY `MI`.`CATEGORY_SUB_ID` ASC
                "),[
                    'category_id' => $category_id
                ]);
                // AND `MI`.`CATEGORY_SUB_ID` IS NOT NULL
                $this->return_json['msg'] = count($sub_category_group).' Results found';
                if(count($sub_category_group) > 0) {
                    unset($this->return_json['msg']);
                    $this->return_json['error'] = 0;
                    $this->return_json['data'] = $sub_category_group;
                }
            }

        }
        echo json_encode($this->return_json, JSON_PRETTY_PRINT);
    }

    public function getMenu(Request $request) {

        // echo '<pre>';var_dump(session()->all());echo '</pre>';die();

        $error = 0;
        $arrReq = ['a'=>'Data id'];

        foreach($arrReq as $key => $value) {
            if(!$request->input($key) || empty($request->input($key))) {
                $this->return_json['msg'] = $value;
                $error++;
                break;
            }
        }

        if(!$error) {
            
            $this->return_json['msg'] = 'SHOP IP DOES NOT EXISTS';
            if(session()->exists('shop_id')) {
    
                $db_name = session()->get('shop_id');
                $category_id = $request->a;
                // config db
                $this->configDB($db_name);
              
                $menu = DB::select(DB::raw("
                    SELECT 
                        CONVERT(`MI`.`ITEM_ID`, CHAR(100)) AS `ITEM_ID`, `MI`.`ITEM_NM`, `MI`.`ITEM_DESC`, `MI`.`ITEM_IMG`, CONVERT(`MI`.`CATEGORY_PARENT_ID`, CHAR(100)) AS `CATEGORY_PARENT_ID`, CONVERT(`MI`.`CATEGORY_SUB_ID`, CHAR(100)) AS `CATEGORY_SUB_ID`, `MI`.`VIEW_FLG`, CONVERT(`MI`.`TYPE`, CHAR(100)) AS `TYPE`, `MI`.`INSERT_DATE`, `MI`.`INSERT_USER_ID`, `MI`.`UPDATE_DATE`, `MI`.`UPDATE_USER_ID`, CONVERT(`MID`.`id`, CHAR(100)) AS `id`, CONVERT(`MID`.`ITEM_ID`, CHAR(100)) AS `ITEM_ID`, `MID`.`ITEM_PRICE`, `MID`.`GENDER_FLG`, CONVERT(`MID`.`GROUP_ID`, CHAR(100)) AS `GROUP_ID`
                    FROM 
                        `MST_ITEM_DTL` `MID`
                    LEFT JOIN 
                        `MST_ITEM` `MI` ON `MI`.`ITEM_ID` = `MID`.`GROUP_ID`
                    WHERE
                        `MI`.`VIEW_FLG` = '1' AND `MI`.`CATEGORY_PARENT_ID` = :id GROUP BY `MID`.`GROUP_ID` ORDER BY `MI`.`CATEGORY_PARENT_ID` ASC, `MI`.`SEQ` ASC;
                "),[
                    'id'=>$category_id
                ]);
            
                
                $this->return_json['msg'] = 'No records found';
                if(count($menu) > 0) {
                    unset($this->return_json['msg']);
                    $this->return_json['data'] = $menu;
                    $this->return_json['error'] = 0;
                }
    
            }

        }

        echo json_encode($this->return_json, JSON_PRETTY_PRINT);
    }
	
	public function getCategoryID(Request $request) {
		
        $this->return_json['msg'] = 'SHOP IP DOES NOT EXISTS';
        if(session()->exists('shop_id')) {

            $db_name = session()->get('shop_id');
            $category_id = $request->a;
            $this->configDB($db_name);
		
            $menu = DB::select(DB::raw("
                SELECT 
                    CONVERT(`MI`.`CATEGORY_ID`, CHAR(100)) AS `CATEGORY_ID`
                FROM 
                    `MST_ITEM_DTL` `MID`
                LEFT JOIN 
                    `MST_ITEM` `MI` ON `MI`.`ITEM_ID` = `MID`.`GROUP_ID`
                WHERE
                    `MI`.`VIEW_FLG` = '1' GROUP BY `MI`.`CATEGORY_ID` ORDER BY `MI`.`CATEGORY_ID` ASC, `MI`.`SEQ` ASC;
            "),[
                'id'=>$category_id
            ]);
		
			
            $this->return_json['msg'] = 'No records found';
            if(count($menu) > 0) {
                unset($this->return_json['msg']);
                $this->return_json['data'] = $menu;
                $this->return_json['error'] = 0;
            }

        }

        echo json_encode($this->return_json, JSON_PRETTY_PRINT);
    }

    public function getPriceGender(Request $request) {

        $this->return_json['msg'] = 'SHOP IP DOES NOT EXISTS';
        if(session()->exists('shop_id')) {

            $db_name = session()->get('shop_id');
            $category_id = $request->a;
            // config db
            $this->configDB($db_name);
            
            $menu = DB::select(DB::raw("
                SELECT 
                    CONVERT(`MI`.`ITEM_ID`, CHAR(100)) AS `ITEM_ID`, `MI`.`ITEM_NM`, `MI`.`ITEM_DESC`, `MI`.`ITEM_IMG`, CONVERT(`MI`.`CATEGORY_PARENT_ID`, CHAR(100)) AS `CATEGORY_PARENT_ID`, `MI`.`VIEW_FLG`, CONVERT(`MI`.`TYPE`, CHAR(100)) AS `TYPE`, `MI`.`INSERT_DATE`, `MI`.`INSERT_USER_ID`, `MI`.`UPDATE_DATE`, `MI`.`UPDATE_USER_ID`, CONVERT(`MID`.`id`, CHAR(100)) AS `id`, CONVERT(`MID`.`ITEM_ID`, CHAR(100)) AS `ITEM_ID`, `MID`.`ITEM_PRICE`, `MID`.`GENDER_FLG`, CONVERT(`MID`.`GROUP_ID`, CHAR(100)) AS `GROUP_ID`
                FROM 
                    `MST_ITEM_DTL` `MID`
                LEFT JOIN 
                    `MST_ITEM` `MI` ON `MI`.`ITEM_ID` = `MID`.`GROUP_ID`
                WHERE
                    `MI`.`VIEW_FLG` = '1' ORDER BY `MI`.`CATEGORY_PARENT_ID` ASC, `MI`.`SEQ` ASC;
            "),[
                'id'=>$category_id
            ]);
            $this->return_json['msg'] = 'No records found';
            if(count($menu) > 0) {
                unset($this->return_json['msg']);
                $this->return_json['data'] = $menu;
                $this->return_json['error'] = 0;
            }

        }

        echo json_encode($this->return_json, JSON_PRETTY_PRINT);

    }

    public function getItemName(Request $request) {

        $error = 0;
        $arrReq = ['a'=>'Data item'];

        foreach($arrReq as $key => $value) {
            if(!$request->input($key)) {
                $this->return_json['msg'] = $value;
                $error++;
                break;
            }
        }

        if(!$error) {

            $this->return_json['msg'] = 'SHOP IP DOES NOT EXISTS';
            if(session()->exists('shop_id')) {

                $db_name = session()->get('shop_id');
                $menu_name = $request->a;
                // config db
                $this->configDB($db_name);
                
                $menu = DB::select(DB::raw("
                    SELECT * FROM `MST_FOOD` `MS` WHERE `MS`.`ITEM_NM` = :item;
                "),[
                    'item'=>$menu_name
                ]);
                $this->return_json['msg'] = 'No records found';
                if(count($menu) > 0) {
                    unset($this->return_json['msg']);
                    $this->return_json['data'] = $menu;
                    $this->return_json['error'] = 0;
                    // $this->return_json['gender_flg'] = session()->get('gender_flg');
                    $this->return_json['genderVerification'] = count($menu);
                }

            }

        }

        echo json_encode($this->return_json, JSON_PRETTY_PRINT);
    }

    public function getGender() {

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

        // echo json_encode(['gender'=>$gender], JSON_PRETTY_PRINT);
        echo "data:" . json_encode(['gender'=>$gender], JSON_PRETTY_PRINT) . "\n\n";
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
	
	
	public function getStatus(Request $request){
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');
		
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
		flush();
	}
	
	
	public function getItemStatus() {
		
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');
		// config db
		$this->configDB(session()->get('shop_id'));
		
		$host_name = session()->get('host_name'); 
		$seat_status = DB::table('MST_SEAT_STATUS')
			->where('HOST_NAME_1', $host_name)
			->first();
			
			
		$orders = DB::table('TBL_ORDER')
			->where('SEAT_NO', '=', $seat_status->SEAT_NO)
			->where('SALES_NO', '=', $seat_status->SALES_NO)
			->orderBy('SEQ', 'ASC')
			->get();	
			
		if(count($orders) > 0){
			$arr = array();
			foreach($orders as $order){
				$item = DB::table('TBL_ORDER')
					->join('MST_ITEM_DTL', 'TBL_ORDER.ITEM_ID', '=', 'MST_ITEM_DTL.ITEM_ID')
					->join('MST_ITEM', 'MST_ITEM_DTL.GROUP_ID', '=', 'MST_ITEM.ITEM_ID')
					->select(
						'TBL_ORDER.SEQ',
						'TBL_ORDER.ITEM_ID',
						'MST_ITEM.ITEM_NM', 
						'MST_ITEM.ITEM_DESC', 
						'TBL_ORDER.SALES_NO', 
						'TBL_ORDER.ITEM_QTY', 
						'TBL_ORDER.ITEM_PRICE',
						'TBL_ORDER.ITEM_STATUS',
						'TBL_ORDER.GENDER_FLG')
					->where('MST_ITEM_DTL.ITEM_ID', '=', $order->ITEM_ID)
					->where('TBL_ORDER.SEQ', '=', $order->SEQ)
					->orderBy('TBL_ORDER.SEQ', 'ASC')
					->first();
				
				array_push($arr, $item);
			}
				
			$data = array();
			$data['data'] = $arr;
			
		}
		
			
		echo "<pre>";
			var_dump($orders);
			// echo json_encode($data);
		echo "</pre>";	
		die();
			
		// echo json_encode(['gender'=>$gender], JSON_PRETTY_PRINT);
		echo "data:" . json_encode($data) . "\n\n";
		flush();

    }

    private function configDB($db_name) {
        Config::set("database.connections.mysql", [
            "host"     => "db-food.cg4jhjqbqa96.ap-northeast-1.rds.amazonaws.com",
            // "database" => 'shop_xxxx',
            "database" => $db_name,
            "username" => "dbmaster",
            "password" => "f04v3wBj9o",
            'driver'   => 'mysql',
            'charset'  => 'utf8',
            'collation' => 'utf8_unicode_ci'
        ]);
    }

}
