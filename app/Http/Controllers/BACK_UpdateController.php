<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Config;

use Hash;

use App\MST_USER as TBL_MST_USER;

class BACK_UpdateController extends Controller
{

    public function __construct() {
        $this->return_json = array(
            'error' => 1,
            'data'  => false
        );
        date_default_timezone_set("Asia/Tokyo");
		$this->date_now = date('Y-m-d H:i:s');
    }

    /* SHOP */
    public function updateShop(Request $request) {
        
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

            $this->return_json['msg'] = 'SHOP number already exists';
            if(is_array($request->shop_ip)) {

                $ip_ads = $request->shop_ip;
                unset($ip_ads[0]);
                $ip_ads = array_values($ip_ads);

                if(count($ip_ads) == 0) {
                    $this->return_json['ref'] = 'shop_ip';
                    $this->return_json['msg'] = 'Ip address should not be empty in updating';
                    return json_encode($this->return_json,JSON_PRETTY_PRINT);
                }

                foreach($ip_ads as $key => $val) {

                    /* check empty */
                    if($val === NULL) {
                        $this->return_json['index'] = $key;
                        $this->return_json['ref'] = 'shop_ip';
                        $this->return_json['msg'] = 'Empty Ip address';
                        return json_encode($this->return_json,JSON_PRETTY_PRINT);
                    }

                    /* check ip address format */
                    $pattern = '/^(?:(?:[1-9]{1,2}|1[0-9]{1,2}|2[0-4][0-9]|25[0-5]|[0]|[1-9]0)\.){3}(?:[1-9]{1,2}|1[0-9]{1,2}|2[0-4][0-9]|25[0-5]|[0]|[1-9]0)$/';
                    $preg = preg_match($pattern, $val);
                    if(!$preg) {
                        $this->return_json['index'] = $key;
                        $this->return_json['ref'] = 'shop_ip';
                        $this->return_json['msg'] = 'Invalid Ip format';
                        return json_encode($this->return_json,JSON_PRETTY_PRINT);
                    }

                    /* check ip similarity */
                    for($i = 0; $i < count($ip_ads); $i++) {
                        $def = $i;
                        for($x = $def+1; $x < count($ip_ads); $x++) {
                            if($ip_ads[$i] == $ip_ads[$x]) {
                                $this->return_json['index'] = $key;
                                $this->return_json['ref'] = 'shop_ip';
                                $this->return_json['msg'] = 'There are similar IP';
                                return json_encode($this->return_json,JSON_PRETTY_PRINT);
                            }
                        }
                        // validate ip addresses in data bank. food service
                        // for($vi = 0; $vi <= count($ip_ads); $vi++) {

                        //     $global_ip = DB::table('MST_SHOP')
                        //     ->where('GLOBAL_IP', 'LIKE', '%'.$ip_ads[$vi].'%')
                        //     ->get();
                        //     if($global_ip->count() > 0) {
                        //         // $this->return_json['index'] = $key;
                        //         $this->return_json['ref'] = 'shop_ip';
                        //         $this->return_json['msg'] = 'There are similar IP';
                        //         return json_encode($this->return_json,JSON_PRETTY_PRINT);
                        //     }

                        // }
                    }

                }

                // update db
                $arr_list = [
                    'SHOP_FC_NO' => $request->shop_fc_no,
                    'SHOP_NM'    => $request->shop_name,
                    'GLOBAL_IP'  => serialize($ip_ads),
                    'SHOP_FLG'   => '9'
                ];
                
                $update_MST_SHOP = DB::table('MST_SHOP')
                ->where('SHOP_FC_NO',$request->shop_fc_no)
                ->update($arr_list);

                $this->return_json['msg'] = 'No data changed';
                if($update_MST_SHOP > 0) {
                    unset($this->return_json['msg']);
                    $this->return_json['error'] = 0;
                }

            }

        }
        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
    }

    public function updateShopDeleteFlag(Request $request) {

        $error = 0;
        $arrReq = [
            'shop_fc_no' => 'SHOP FC NO required'
        ];

        foreach($arrReq as $key => $val) {
            if(is_null($request->$key)) {
                $this->return_json['msg'] = $val;
                $error++;
                break;
            }
        }

        if(!$error) {

            $shop_fc_no = $request->shop_fc_no;

            $MST_SHOP = DB::table('MST_SHOP')
            ->where('SHOP_FC_NO',$shop_fc_no)->get();

            $this->return_json['msg'] = 'SHOP FC NO is not yet registered';
            if($MST_SHOP->count() == 1) {

                try {
                    $arr_list = [
                        'DELETE_FLG'     => 1,
                        'UPDATE_DATE'    => $this->date_now,
                        'UPDATE_USER_ID' => session()->get('users')['id']
                    ];
                    $update_MST_SHOP = DB::table('MST_SHOP')->where('SHOP_FC_NO',$shop_fc_no)->update($arr_list);
                    if($update_MST_SHOP == 1) {
                        unset($this->return_json['msg']);
                        $this->return_json['error'] = 0;
                    }
                } catch(\Exception $e) {
                    $this->return_json['ref'] = $e;
                    return response()->json($this->return_json);
                }
                
            }

        }

        return response()->json($this->return_json);
    }

    public function updateLockFlag(Request $request) {

        $error = 0;
        $arrReq = [
            'shop_fc_no' => 'SHOP FC NO required'
        ];

        foreach($arrReq as $key => $val) {
            if(is_null($request->$key)) {
                $this->return_json['msg'] = $val;
                $error++;
                break;
            }
        }

        if(!$error) {

            $shop_fc_no = $request->shop_fc_no;

            $MST_SHOP = DB::table('MST_SHOP')
            ->select('LOCK_FLG')
            ->where('SHOP_FC_NO',$shop_fc_no)->get();

            $this->return_json['msg'] = 'SHOP FC NO is not yet registered';
            if($MST_SHOP->count() == 1) {

                try {
                    $lock_flg = 0;
                    $MST_SHOP = $MST_SHOP->first();

                    if($MST_SHOP->LOCK_FLG == 0) {
                        $lock_flg = 1;
                    }

                    $arr_list = [
                        'LOCK_FLG'       => $lock_flg,
                        'UPDATE_DATE'    => $this->date_now,
                        'UPDATE_USER_ID' => session()->get('users')['id']
                    ];
                    $update_MST_SHOP = DB::table('MST_SHOP')->where('SHOP_FC_NO',$shop_fc_no)->update($arr_list);
                    if($update_MST_SHOP == 1) {
                        unset($this->return_json['msg']);
                        $this->return_json['error'] = 0;
                    }
                } catch(\Exception $e) {
                    $this->return_json['ref'] = $e;
                    return response()->json($this->return_json);
                }
                
            }

        }

        return response()->json($this->return_json);
    }

    /* CATEGORY PAGE */
    public function updateCategory(Request $request) {

        /* CONFIG DATABASE */
        // $this->configDB('shop_xxxx');
        if(session()->exists('current_shop')) {
            $session_shop = session()->get('current_shop');

            $this->configDB($session_shop[0]);
        
            $error = 0;
            $arrReq = [
                'shop_category_id'   => 'Category id required',
                'shop_category_name'   => 'Category name required',
            ];

            foreach($arrReq as $key => $val) {
                if(!$request->$key) {
                    $error++;
                    break;
                }
            }

            if(!$error) {

                $cat_id = $request->shop_category_id;
                $cat_name = $request->shop_category_name;

                $update_MST_CATEGORY = DB::table('MST_CATEGORY')
                ->where('CATEGORY_ID',$cat_id)
                ->update([
                    'CATEGORY_NM' => $cat_name, 
                    'UPDATE_DATE' => $this->date_now
                ]);

                $this->return_json['msg'] = 'No data changed';
                if($update_MST_CATEGORY == 1) {
                    unset($this->return_json['msg']);
                    $this->return_json['error'] = 0;
                }

            }
        }

        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
    }

    public function updateCategoryViewFlag(Request $request) {

        if(session()->exists('current_shop')) {
            $session_shop = session()->get('current_shop');

            $this->configDB($session_shop[0]);

            $error = 0;
            $arrReq = [
                'category_id'     => 'Category Id required'
            ];
    
            foreach($arrReq as $key => $val) {
                if(is_null($request->$key)) {
                    $this->return_json['msg'] = $val;
                    $error++;
                    break;
                }
            }
    
            if(!$error) {
    
                $category_id = $request->category_id;
    
                $MST_CATEGORY = DB::table('MST_CATEGORY')
                ->where('CATEGORY_ID',$category_id)->get();

                if($MST_CATEGORY->count() == 1) {
    
                    try {

                        $MST_CATEGORY = $MST_CATEGORY->first();

                        $category_id = $MST_CATEGORY->CATEGORY_ID;

                        $view_flg = 0;

                        if($MST_CATEGORY->VIEW_FLG == 0) {
                            $view_flg = 1;
                        }

                        $arr_list = [
                            'VIEW_FLG'       => $view_flg,
                            'UPDATE_DATE'    => $this->date_now,
                            'UPDATE_USER_ID' => session()->get('users')['id']
                        ];
                        $update_MST_CATEGORY = DB::table('MST_CATEGORY')->where('CATEGORY_ID',$category_id)->update($arr_list);
                        if($update_MST_CATEGORY == 1) {
                            unset($this->return_json['msg']);
                            $this->return_json['error'] = 0;
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

    /* SERVICE PAGE */
    public function updateService(Request $request) {

        /* CONFIG DATABASE */
        //$this->configDB('shop_xxxx');

        if(session()->exists('current_shop')) {
            $session_shop = session()->get('current_shop');

            $this->configDB($session_shop[0]);

            $arrReq = [
                'serv_group_id'       => 'Service group id required',
                'serv_item_name'      => 'Service name required',
                'serv_item_desc'      => 'Service description required',
                'serv_cat_id'         => 'Service id required',
                'serv_male_item_id'   => 'Service male item id required',
                'serv_male_price'     => 'Service male price required',
                'serv_female_item_id' => 'Service female item id required',
                'serv_female_price'   => 'Service female price required',
            ];

            foreach($arrReq as $key => $val) {
                if(is_null($request->$key)) {
                    $this->return_json['msg'] = $val;
                    return json_encode($this->return_json,JSON_PRETTY_PRINT);
                }
            }

            $max_number = 4294967295;

            $group_id = $request->serv_group_id;
            $item_name = $request->serv_item_name;
            $item_desc = $request->serv_item_desc;
            $cat_id = $request->serv_cat_id;
            $male_item_id = $request->serv_male_item_id;
            $male_price = $request->serv_male_price;
            $female_item_id = $request->serv_female_item_id;
            $female_price = $request->serv_female_price;

            if($male_item_id >= $max_number || $female_item_id >= $max_number) {
                $this->return_json['msg'] = 'Item ID must not exceed to '.$max_number;
                return json_encode($this->return_json,JSON_PRETTY_PRINT);
            }

            $read_data = DB::select(DB::raw("
                SELECT 
                    * 
                FROM 
                    `MST_ITEM` `MI`
                LEFT JOIN 
                    `MST_ITEM_DTL` `MID` ON `MID`.`GROUP_ID` = `MI`.`ITEM_ID`
                WHERE
                    `MI`.`ITEM_NM` = '".$item_name."' AND
                    `MI`.`ITEM_DESC` = '".$item_desc."' AND
                    `MI`.`CATEGORY_PARENT_ID` = '".$cat_id."' AND
                    (SELECT `ITEM_ID` FROM `MST_ITEM_DTL` WHERE `GROUP_ID` = '".$group_id."' AND `GENDER_FLG` = '0') = '".$male_item_id."' AND
                    (SELECT `ITEM_ID` FROM `MST_ITEM_DTL` WHERE `GROUP_ID` = '".$group_id."' AND `GENDER_FLG` = '1') = '".$female_item_id."' AND
                    (SELECT `ITEM_PRICE` FROM `MST_ITEM_DTL` WHERE `GROUP_ID` = '".$group_id."' AND `GENDER_FLG` = '0') = '".$male_price."' AND
                    (SELECT `ITEM_PRICE` FROM `MST_ITEM_DTL` WHERE `GROUP_ID` = '".$group_id."' AND `GENDER_FLG` = '1') = '".$female_price."';
            "));

            if(count($read_data) == 0) {

                $check_ITEM_NM =  DB::table('MST_ITEM')
                ->where('ITEM_ID',$group_id)
                ->where('ITEM_NM',$item_name)->get();
                if($check_ITEM_NM->count() == 0) {
                    //check for item name
                    $check_ITEM_NM = DB::table('MST_ITEM')->where('ITEM_NM',$item_name)->get();
                    if($check_ITEM_NM->count() > 0) {
                        $this->return_json['msg'] = 'Item name already exists';
                        return json_encode($this->return_json,JSON_PRETTY_PRINT);
                    }
                }

                // check for male id
                $current_MALE_ID = DB::table('MST_ITEM_DTL')
                ->where('ITEM_ID',$male_item_id)
                ->where('GROUP_ID',$group_id)->get();

                if($current_MALE_ID->count() == 0) {
                    $new_MALE_ID = DB::table('MST_ITEM_DTL')->where('ITEM_ID',$male_item_id)->get();
                    if($new_MALE_ID->count() > 0) {
                        $this->return_json['msg'] = 'Male item id already in used';
                        return json_encode($this->return_json,JSON_PRETTY_PRINT);
                    }
                }

                // check for female id
                $current_FEMALE_ID = DB::table('MST_ITEM_DTL')
                ->where('ITEM_ID',$female_item_id)
                ->where('GROUP_ID',$group_id)->get();

                if($current_FEMALE_ID->count() == 0) {
                    $new_FEMALE_ID = DB::table('MST_ITEM_DTL')->where('ITEM_ID',$female_item_id)->get();
                    if($new_FEMALE_ID->count() > 0) {
                        $this->return_json['msg'] = 'Female item id already in used';
                        return json_encode($this->return_json,JSON_PRETTY_PRINT);
                    }
                }

                if($male_item_id == $female_item_id) {
                    if($male_item_id != 0 && $female_item_id != 0) {
                        $this->return_json['msg'] = 'There are similar id';
                        return json_encode($this->return_json,JSON_PRETTY_PRINT);
                    }
                }

                $MST_ITEM_DTL = DB::table('MST_ITEM_DTL')->select(DB::raw('MAX(`ITEM_ID`) AS `ITEM_ID`'))->get();
                $MST_ITEM_DTL_ITEM_ID = $MST_ITEM_DTL->first();

                if($male_item_id == 0) {
                    $male_item_id = $MST_ITEM_DTL_ITEM_ID->ITEM_ID + 1;
                }
                if($female_item_id == 0) {
                    $female_item_id = $MST_ITEM_DTL_ITEM_ID->ITEM_ID + 2;
                }

                $MST_ITEM_data_list = array(
                    'ITEM_NM'            => $item_name,
                    'ITEM_DESC'          => $item_desc,
                    'CATEGORY_PARENT_ID' => $cat_id,
                    'UPDATE_DATE'        => $this->date_now
                );
                $male_data = array(
                    'ITEM_ID'    => $male_item_id,
                    'ITEM_PRICE' => $male_price
                );
                $female_data = array(
                    'ITEM_ID'    => $female_item_id,
                    'ITEM_PRICE' => $female_price
                );

                $update_MST_ITEM = DB::table('MST_ITEM')->where('ITEM_ID', $group_id)->update($MST_ITEM_data_list);
                DB::table('MST_ITEM_DTL')->where('GROUP_ID',$group_id)->where('GENDER_FLG',0)->update($male_data);
                DB::table('MST_ITEM_DTL')->where('GROUP_ID',$group_id)->where('GENDER_FLG',1)->update($female_data);
                $this->return_json['error'] = 0;
                return json_encode($this->return_json,JSON_PRETTY_PRINT);

            } else {
                $this->return_json['msg'] = 'No data changed';
                return json_encode($this->return_json,JSON_PRETTY_PRINT);
            }
        }

    }

    public function updateServiceViewFlag(Request $request) {

        if(session()->exists('current_shop')) {
            $session_shop = session()->get('current_shop');

            $this->configDB($session_shop[0]);

            $error = 0;
            $arrReq = [
                'service_id' => 'Service Id required'
            ];
    
            foreach($arrReq as $key => $val) {
                if(is_null($request->$key)) {
                    $this->return_json['msg'] = $val;
                    $error++;
                    break;
                }
            }
    
            if(!$error) {
    
                $service_id = $request->service_id;
    
                $MST_ITEM = DB::table('MST_ITEM')
                ->where('ITEM_ID',$service_id)->get();

                if($MST_ITEM->count() == 1) {
    
                    try {

                        $MST_ITEM = $MST_ITEM->first();

                        $service_id = $MST_ITEM->ITEM_ID;

                        $view_flg = 0;

                        if($MST_ITEM->VIEW_FLG == 0) {
                            $view_flg = 1;
                        }

                        $arr_list = [
                            'VIEW_FLG'       => $view_flg,
                            'UPDATE_DATE'    => $this->date_now,
                            'UPDATE_USER_ID' => session()->get('users')['id']
                        ];
                        $update_MST_ITEM = DB::table('MST_ITEM')->where('ITEM_ID',$service_id)->update($arr_list);
                        if($update_MST_ITEM == 1) {
                            unset($this->return_json['msg']);
                            $this->return_json['error'] = 0;
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

    /* USERS PAGE */

    public function updateUser(Request $request) {

        $error = 0;
        $arrReq = [
            'user_last'      => 'User Lastname required',
            'user_first'     => 'User Firstname required',
            'user_email'     => 'User Email address required',
            'user_shops'     => 'User Shops required',
            'user_name'      => 'Username required',
            'user_level'     => 'User Level required',
            // 'user_password'  => 'User Password required',
            // 'user_conf_pass' => 'User Confirm Password required',
            'user_pointer'   => 'User pointer required'
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

            // if(strlen($request->user_password) > 4) {
            //     $user_password = $request->user_password;
            //     $user_conf_pass = $request->user_conf_pass;

            //     if($user_password != $user_conf_pass) {
            //         $this->return_json['ref'] = 'user_password';
            //         $this->return_json['msg'] = 'Password mismatch';
            //         return response()->json($this->return_json);
            //     }
            //     $arr_item['password'] = Hash::make($user_password);
            // }

            $user_last = $request->user_last;
            $user_first = $request->user_first;
            $user_email = $request->user_email;
            $user_shops = $request->user_shops;
            $user_name = $request->user_name;
            $user_level = $request->user_level;
            // $user_password = $request->user_password;
            // $user_conf_pass = $request->user_conf_pass;
            $user_pointer = $request->user_pointer;

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

            try {
                // success
                $arr_item = [
                    'name'       => ucfirst($user_first).'+'.ucfirst($user_last),
                    'email'      => $user_email,
                    'username'   => $user_name,
                    // 'password'   => Hash::make($user_password),
                    'user_level' => $user_level,
                    'shop_fc_no' => serialize($user_shops)
                ];

                if(strlen($request->user_password) > 4) {
                    $user_password = $request->user_password;
                    $user_conf_pass = $request->user_conf_pass;
    
                    if($user_password != $user_conf_pass) {
                        $this->return_json['ref'] = 'user_password';
                        $this->return_json['msg'] = 'Password mismatch';
                        return response()->json($this->return_json);
                    }
                    $arr_item['password'] = Hash::make($user_password);
                }

                $insert_MST_USER = DB::table('MST_USER')
                ->where('id', $user_pointer)
                ->update($arr_item);

                $this->return_json['msg'] = 'No data changed';
                if($insert_MST_USER > 0) {
                    // update timestamp
                    DB::table('MST_USER')
                    ->where('id', $user_pointer)
                    ->update(['updated_at'=>$this->date_now]);

                    unset($this->return_json['msg']);
                    unset($this->return_json['ref']);
                    $this->return_json['error'] = 0;
                }
            } catch (\Exception $e) {
                $this->return_json['src'] = $e;
                $this->return_json['msg'] = 'Check email address or username, it might be in used already';
                return response()->json($this->return_json);
            }
            
        }
        return response()->json($this->return_json);

    }

    public function updateUserLockFlag(Request $request) {

        $error = 0;
        $arrReq = [
            'pointer' => 'Pointer required'
        ];

        foreach($arrReq as $key => $val) {
            if(is_null($request->$key)) {
                $this->return_json['msg'] = $val;
                $error++;
                break;
            }
        }

        if(!$error) {

            $pointer = $request->pointer;

            $MST_USER = DB::table('MST_USER')->where('id',$pointer)->get();

            $this->return_json['msg'] = 'Data not found';
            if($MST_USER->count() == 1) {

                $MST_USER = $MST_USER->first();

                $lock_num = 0;
                if($MST_USER->LOCK_FLG == 0) {
                    $lock_num = 1;
                }

                $arr_list = [
                    'LOCK_FLG'   => $lock_num,
                    'updated_at' => $this->date_now
                ];
                $update_MST_USER = DB::table('MST_USER')->where('id',$pointer)->update($arr_list);
                $this->return_json['msg'] = 'No data changed';
                if($update_MST_USER > 0) {
                    unset($this->return_json['msg']);
                    $this->return_json['error'] = 0;
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