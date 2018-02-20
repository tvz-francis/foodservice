<?php

namespace App\Http\Controllers\v2;

use Illuminate\Http\Request;
use DB;
use Config;

use Hash;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;


class BACK_CreateController extends Controller
{

    public function __construct() {
        $this->return_json = array(
            'error' => 1,
            'data'  => false
        );
        date_default_timezone_set("Asia/Tokyo");
		$this->date_now = date('Y-m-d H:i:s');
    }

    public function createUser(Request $request) {

        $error = 0;
        $arrReq = [
            'user_last'      => 'User Lastname required',
            'user_first'     => 'User Firstname required',
            'user_email'     => 'User Email address required',
            'user_shops'     => 'User Shops required',
            'user_name'      => 'Username required',
            'user_level'     => 'User Level required',
            'user_password'  => 'User Password required',
            'user_conf_pass' => 'User Confirm Password required'
        ];

        foreach($arrReq as $key => $val) {
            if(is_null($request->$key)) {
                $this->return_json['ref'] = $key;
                $this->return_json['msg'] = $val;
                $error++;
                break;
            }
        }

        if(!$error) {

            $user_last = $request->user_last;
            $user_first = $request->user_first;
            $user_email = $request->user_email;
            $user_shops = $request->user_shops;
            $user_name = $request->user_name;
            $user_level = $request->user_level;
            $user_password = $request->user_password;
            $user_conf_pass = $request->user_conf_pass;

             // value validation
            if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                $this->return_json['ref'] = 'user_email';
                $this->return_json['msg'] = 'Email address entry failed';
                return response()->json($this->return_json);
            }
 
            if(!is_array($user_shops)) {
                $this->return_json['ref'] = 'user_shops';
                $this->return_json['msg'] = 'Shops entry failed';
                return response()->json($this->return_json);
            }

            if($user_password != $user_conf_pass) {
                $this->return_json['ref'] = 'user_password';
                $this->return_json['msg'] = 'Password mismatch';
                return response()->json($this->return_json);
            }

            // check email address
            $email_MST_USER = DB::table('MST_USER')->where('email', $user_email)->get();

            $this->return_json['ref'] = 'user_email';
            $this->return_json['msg'] = 'Email is already in used';
            if($email_MST_USER->count() == 0) {

                // check username
                $username_MST_USER = DB::table('MST_USER')->where('username', $user_name)->get();

                $this->return_json['ref'] = 'user_name';
                $this->return_json['msg'] = 'Username is already in used';
                if($email_MST_USER->count() == 0) {

                    // shops authentication
                    foreach($user_shops as $key) {
                        $MST_SHOP = DB::table('MST_SHOP')->where('SHOP_FC_NO',$key)->get();
                        if($MST_SHOP->count() == 0) {
                            $this->return_json['ref'] = 'user_shops';
                            $this->return_json['msg'] = 'Shop is not yet registered';
                            return response()->json($this->return_json);
                        }
                    }

                    // success
                    unset($this->return_json['msg']);
                    unset($this->return_json['ref']);
                    $this->return_json['error'] = 0;
                    $arr_item = [
                        'name'       => ucfirst($user_first).'+'.ucfirst($user_last),
                        'email'      => $user_email,
                        'username'   => $user_name,
                        'password'   => Hash::make($user_password),
                        'user_level' => $user_level,
                        'shop_fc_no' => serialize($user_shops),
                        'created_at' => $this->date_now,
                        'LOCK_FLG'   => 0
                    ];
                    $insert_MST_USER = DB::table('MST_USER')->insert($arr_item);

                }

            }
            
        }
        return response()->json($this->return_json);
    }

    public function createShop(Request $request) {

        $error = 0;
        $arrReq = [
            'shop_fc_no' => 'Shop no required',
            'shop_ip'    => 'Shop IP\'s required',
            'shop_name'  => 'Shop name required'
        ];

        foreach($arrReq as $key => $val) {
            if(!$request->$key) {
                $this->return_json['ref'] = $key;
                $this->return_json['msg'] = $val;
                $error++;
                break;
            }
        }

        if(!$error) {

            // check for fc no
            $SHOP_FC_NO = DB::table('MST_SHOP')
            ->where('SHOP_FC_NO', $request->shop_fc_no)
            ->where('SHOP_FLG', 9)
            ->get();

            if($SHOP_FC_NO->count() > 0) {
                $error++;
            }

            $this->return_json['ref'] = 'shop_fc_no';
            $this->return_json['msg'] = 'SHOP number already exists';
            if(is_array($request->shop_ip) && !$error) {
                foreach($request->shop_ip as $key => $val) {

                    /* check empty */
                    if($val === NULL) {
                        $this->return_json['index'] = $key;
                        $this->return_json['ref'] = 'shop_ip';
                        $this->return_json['msg'] = 'Empty Ip address';
                        return json_encode($this->return_json,JSON_PRETTY_PRINT);
                        // $error++;
                        // break;
                    }

                    /* check ip address format */
                    $pattern = '/^(?:(?:[1-9]{1,2}|1[0-9]{1,2}|2[0-4][0-9]|25[0-5]|[0]|[1-9]0)\.){3}(?:[1-9]{1,2}|1[0-9]{1,2}|2[0-4][0-9]|25[0-5]|[0]|[1-9]0)$/';
                    $preg = preg_match($pattern, $val);
                    if(!$preg) {
                        $this->return_json['index'] = $key;
                        $this->return_json['ref'] = 'shop_ip';
                        $this->return_json['msg'] = 'Invalid Ip format';
                        return json_encode($this->return_json,JSON_PRETTY_PRINT);
                        // $error++;
                        // break;
                    }

                    /* check ip similarity */
                    for($i = 0; $i < count($request->shop_ip); $i++) {
                        $def = $i;
                        for($x = $def+1; $x < count($request->shop_ip); $x++) {
                            if($request->shop_ip[$i] == $request->shop_ip[$x]) {
                                $this->return_json['index'] = $key;
                                $this->return_json['ref'] = 'shop_ip';
                                $this->return_json['msg'] = 'There are similar IP';
                                return json_encode($this->return_json,JSON_PRETTY_PRINT);
                                // $error++;
                                // break;
                            }
                        }
                    }

                    /* check for ip address if already exists */
                    $MST_SHOP = DB::table('MST_SHOP')
                    ->where('GLOBAL_IP', 'LIKE', '%'.$val.'%')
                    ->where('SHOP_FLG', '9')->get();

                    if($MST_SHOP->count() > 0) {
                        $this->return_json['index'] = $key;
                        $this->return_json['ref'] = 'shop_ip';
                        $this->return_json['msg'] = 'Already in used';
                        return json_encode($this->return_json,JSON_PRETTY_PRINT);
                        // $error++;
                        // break;
                    }

                }

                // create to db
                try{
                    $arr_list = [
                        'SHOP_FC_NO' => $request->shop_fc_no,
                        'SHOP_NM'    => $request->shop_name,
                        'GLOBAL_IP'  => serialize($request->shop_ip),
                        'SHOP_FLG'   => '9',
                        'INPUT_DATE' => $this->date_now,
                        'INPUT_USER_ID' => session()->get('users')['id']
                    ];
                    
                    $last_id = DB::table('MST_SHOP')->insertGetId($arr_list);
    
                    DB::statement("
                        CREATE DATABASE `shop_".$request->shop_fc_no."`;
                    ");
    
                    session()->flash('create_shop',$request->shop_fc_no);
                    
                    unset($this->return_json['msg']);
                    $this->return_json['error'] = 0;
                    $this->return_json['data'] = $SHOP_FC_NO;
                } catch(\Exception $e) {
                    $this->return_json['ref'] = $e;
                }
            }

        }
        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
    }

    /* CATEGORY PAGE */
    public function createCategory(Request $request) {

        if(session()->exists('current_shop')) {
            $session_shop = session()->get('current_shop');

            $this->configDB($session_shop[0]);

            /* CONFIG DATABASE */
            // $this->configDB('shop_xxxx');

            $error = 0;
            $arrReq = [
                // 'shop_category_type' => 'Category type required',
                'shop_category_name' => 'Category name required'
            ];

            foreach($arrReq as $key => $val) {
                if(!$request->$key) {
                    $this->return_json['msg'] = $val;
                    $error++;
                    break;
                }
            }

            if(!$error) {

                $cat_type = $request->shop_category_type;
                $cat_name = $request->shop_category_name;

                $check_CATEGORY_NM = DB::table('MST_CATEGORY')->where('CATEGORY_NM', $cat_name)->get();

                if($check_CATEGORY_NM->count() > 0) {
                    $error++;
                }

                $this->return_json['msg'] = 'Category name exists';
                if(!$error) {

                    $arr_list = array();
                    
                    if($cat_type == 0) { // food

                        $where_PARENT_FLG = 1;

                        $arr_list['PARENT_FLG'] = 1;
                        $arr_list['TYPE_FLG'] = 0;

                        if($request->shop_category_subask) {
                            /* 
                            * YES sub cat
                            * sub cat for food only
                            */

                            $where_PARENT_FLG = 0;

                            $arr_list['PARENT_FLG'] = 0;
                            $arr_list['PARENT_ID'] = '001';
                        }

                        $MST_CATEGORY = DB::table('MST_CATEGORY')->select(DB::raw("MAX(`SEQ`) AS `SEQ`"))
                        ->where('PARENT_FLG', $where_PARENT_FLG)->first();
                        $seq_num = $MST_CATEGORY->SEQ+1;

        
                    } elseif($cat_type == 1) { // service
        
                        $MST_CATEGORY = DB::table('MST_CATEGORY')
                        ->select(DB::raw("MAX(`SEQ`) AS `SEQ`"))
                        ->where('PARENT_FLG', '1')->first();
                        $seq_num = $MST_CATEGORY->SEQ+1;
        
                        $arr_list['TYPE_FLG'] = 1;
                        $arr_list['PARENT_FLG'] = 1;
        
                    } else {
                        $this->return_json['msg'] = 'Category ID not exists';
                        $error++;
                    }

                    if(!$error) {
                        $arr_list['SEQ'] = $seq_num;
                        $arr_list['CATEGORY_NM'] = $cat_name;
                        $arr_list['VIEW_FLG'] = 1;
                        $arr_list['INPUT_DATE'] = $this->date_now;
            
                        $insert_MST_CATEGORY = DB::table('MST_CATEGORY')->insert($arr_list);

                        unset($this->return_json['msg']);
                        $this->return_json['error'] = 0;
                    }

                }

            }

        }

        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
    }

    /* SERVICES PAGE */
    public function createServicesItem(Request $request) {

        if(session()->exists('current_shop')) {
            $session_shop = session()->get('current_shop');

            $this->configDB($session_shop[0]);

            /* CONFIG DATABASE */
            //$this->configDB('shop_xxxx');
            
            $error = 0;
            $arrReq = [
                'serv_item_name'      => 'Category name required',
                'serv_item_desc'      => 'Category description required',
                'serv_cat_id'         => 'Category id required',
                'serv_male_item_id'   => 'Category male item id required',
                'serv_male_price'     => 'Category male price required',
                'serv_female_item_id' => 'Category female item id required',
                'serv_female_price'   => 'Category female price required',
            ];

            foreach($arrReq as $key => $val) {
                if(is_null($request->$key)) {
                    $this->return_json['msg'] = $val;
                    $error++;
                    break;
                }
            }

            if(!$error) {

                $max_number = 4294967295;

                $item_name = $request->serv_item_name;
                $item_desc = $request->serv_item_desc;
                $cat_id = $request->serv_cat_id;
                $male_item_id = $request->serv_male_item_id;
                $male_price = $request->serv_male_price;
                $female_item_id = $request->serv_female_item_id;
                $female_price = $request->serv_female_price;

                $male_price = 0;
                $female_price = 0;

                if($male_item_id >= $max_number || $female_item_id >= $max_number) {
                    $this->return_json['msg'] = 'Item ID must not exceed to '.$max_number;
                    return json_encode($this->return_json,JSON_PRETTY_PRINT);
                }

                if($male_item_id != 0) {

                    // check id
                    $MST_ITEM_DTL = DB::table('MST_ITEM_DTL')->where('ITEM_ID',$male_item_id)->get();

                    if($MST_ITEM_DTL->count() > 0) {
                        $this->return_json['msg'] = 'Male item id exists';
                        $error++;
                    }
                    $male_data['ITEM_ID'] = $male_item_id;
                    
                } else {
                    $MST_ITEM_DTL = DB::table('MST_ITEM_DTL')
                    ->select(DB::raw("
                        MAX(`ITEM_ID`) AS `ITEM_ID`
                    "))->first();
                    $male_data['ITEM_ID'] = $MST_ITEM_DTL->ITEM_ID + 1;
                }

                if($request->serv_male_price != 0) {
                    $male_price = $request->serv_male_price;
                }

                if($female_item_id != 0) {

                    // check id
                    $MST_ITEM_DTL = DB::table('MST_ITEM_DTL')->where('ITEM_ID',$female_item_id)->get();
                    
                    if($MST_ITEM_DTL->count() > 0) {
                        $this->return_json['msg'] = 'Female item id exists';
                        $error++;
                    }
                    $female_data['ITEM_ID'] = $female_item_id;
                } else {
                    $MST_ITEM_DTL = DB::table('MST_ITEM_DTL')
                    ->select(DB::raw("
                        MAX(`ITEM_ID`) AS `ITEM_ID`
                    "))->first();
                    $female_data['ITEM_ID'] = $MST_ITEM_DTL->ITEM_ID + 2;
                }

                if($request->serv_female_price != 0) {
                    $female_price = $request->serv_female_price;
                }

                if($male_item_id == $female_item_id) {
                    $this->return_json['msg'] = 'Item id are similar';
                    $error++;
                }

                if($male_item_id == 0 && $female_item_id == 0) {
                    $error = 0;
                }
                
                if(!$error) {

                    //check for item name
                    $ITEM_NAME = DB::table('MST_ITEM')->where('ITEM_NM',$item_name)->get();
                    if($ITEM_NAME->count() > 0) {
                        $this->return_json['msg'] = 'Item name already exists';
                        $error++;
                    }

                    if(!$error) {

                        // get SEQ number
                        $MST_ITEM = DB::table('MST_ITEM')->select(DB::raw('MAX(`SEQ`) AS `SEQ`'))->where('TYPE', 1)->first();
                        $seq_num = $MST_ITEM->SEQ + 1;

                        $parent_item = array(
                            // MST_ITEM
                            'SEQ'                => $seq_num,
                            'ITEM_NM'            => $item_name,
                            'ITEM_DESC'          => $item_desc,
                            'ITEM_IMG'           => 'IMG.JPG',
                            'CATEGORY_PARENT_ID' => $cat_id,
                            'VIEW_FLG'           => 1,
                            'TYPE'               => 1,
                            'INSERT_DATE'        => $this->date_now,
                            'INSERT_USER_ID'     => '000000000001'
                        );

                        $group_id = DB::table('MST_ITEM')->insertGetId($parent_item);

                        $male_data['ITEM_PRICE'] = $male_price;
                        $male_data['GENDER_FLG'] = 0;
                        $male_data['GROUP_ID'] = $group_id;

                        $female_data['ITEM_PRICE'] = $female_price;
                        $female_data['GENDER_FLG'] = 1;
                        $female_data['GROUP_ID'] = $group_id;

                        $arr_list = [$male_data,$female_data];

                        DB::table('MST_ITEM_DTL')->insert($arr_list);

                        unset($this->return_json['msg']);
                        $this->return_json['error'] = 0;

                    }

                }

            }

        }

        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
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