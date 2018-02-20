<?php

namespace App\Http\Controllers\v2;

use Illuminate\Http\Request;
use DB;
use Config;
use App\Http\Controllers\Controller;

class BACK_DeleteController extends Controller
{

    public function __construct() {
        $this->return_json = array(
            'error' => 1,
            'data'  => false
        );
        date_default_timezone_set("Asia/Tokyo");
		$this->date_now = date('Y-m-d H:i:s');
    }

    public function deleteShop(Request $request) {

        $error = 0;
        $arrReq = [
            'shop_fc_no' => 'Shop FC no required',
            'shop_ip' => 'Shop IP required'
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
            $ip_address = $request->shop_ip;
        
            $pattern = '/^(?:(?:[1-9]{1,2}|1[0-9]{1,2}|2[0-4][0-9]|25[0-5]|[0]|[1-9]0)\.){3}(?:[1-9]{1,2}|1[0-9]{1,2}|2[0-4][0-9]|25[0-5]|[0]|[1-9]0)$/';
            if(!preg_match($pattern,$ip_address)) {
                $this->return_json['msg'] = $ip_address.' is invalid format';
                return json_encode($this->return_json,JSON_PRETTY_PRINT);
            }

            // check id and ip
            $MST_SHOP = DB::table('MST_SHOP')
            ->where('SHOP_FC_NO',$shop_fc_no)
            ->where('SHOP_FLG','9')
            ->where('GLOBAL_IP', 'like', '%'.$ip_address.'%')->get();

            $this->return_json['msg'] = 'Shop details not found';
            if($MST_SHOP->count() > 0) {
                $SHOP = $MST_SHOP->first();
                $ip_array = unserialize($SHOP->GLOBAL_IP);

                foreach(unserialize($SHOP->GLOBAL_IP) as $key => $val) {
                    if($ip_address == $val) {
                        unset($ip_array[$key]);
                        break;
                    }
                }
                $ip_array = array_values($ip_array);

                if(count($ip_array) == 0) {

                    /* delete row */
                    $delete = DB::table('MST_SHOP')
                    ->where('SHOP_FC_NO',$shop_fc_no)->delete();

                    session()->flash('delete_shop', $shop_fc_no);

                    unset($this->return_json['msg']);
                    $this->return_json['error'] = 0;
                    return json_encode($this->return_json,JSON_PRETTY_PRINT);
                }

                if(count($ip_array) > 0) {

                    $data_list = [
                        'GLOBAL_IP' => serialize($ip_array)
                    ];

                    /* update row */
                    $update_row = DB::table('MST_SHOP')
                    ->where('SHOP_FC_NO',$shop_fc_no)->update($data_list);

                    unset($this->return_json['msg']);
                    $this->return_json['error'] = 0;
                    return json_encode($this->return_json,JSON_PRETTY_PRINT);
                }

            }

        }
        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
    }

    public function deleteCategory(Request $request) {
        
        $error = 0;
        $arrReq = [
            'cat_id'   => 'Cat ID required',
            'cat_name' => 'Cat name required'
        ];

        foreach($arrReq as $key => $val) {
            if(is_null($request->$key)) {
                $this->return_json['msg'] = $val;
                $error++;
                break;
            }
        }

        if(!$error) {

            if(session()->exists('current_shop')) {
                $session_shop = session()->get('current_shop');
    
                $this->configDB($session_shop[0]);

                /* CONFIG DATABASE */
                //$this->configDB('shop_xxxx');

                $cat_id = $request->cat_id;
                $cat_name = $request->cat_name;

                // check for id and name
                $check_id_name = DB::table('MST_CATEGORY')
                ->where('CATEGORY_ID',$cat_id)
                ->where('CATEGORY_NM',$cat_name)->get();

                $this->return_json['msg'] = 'Category does not exists';
                if($check_id_name->count() > 0) {

                    $check_item = DB::table('MST_ITEM')
                    ->where('CATEGORY_PARENT_ID',$cat_id)
                    ->orWhere('CATEGORY_SUB_ID',$cat_id)->get();
        
                    if($check_item->count() > 0) {
                        $this->return_json['msg'] = 'There are item linked to this category';
                        return json_encode($this->return_json,JSON_PRETTY_PRINT);
                    }
                    
                    $delete_id_name = DB::table('MST_CATEGORY')
                    ->where('CATEGORY_ID',$cat_id)
                    ->where('CATEGORY_NM',$cat_name)->delete();

                    if($delete_id_name > 0) {
                        unset($this->return_json['msg']);
                        $this->return_json['error'] = 0;
                    }

                }
            }

        }
        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
    }

    public function deleteService(Request $request) {

        $error = 0;
        $arrReq = [
            'serv_id'   => 'Service ID required',
            'serv_name' => 'Service name required'
        ];

        foreach($arrReq as $key => $val) {
            if(is_null($request->$key)) {
                $this->return_json['msg'] = $val;
                $error++;
                break;
            }
        }

        if(!$error) {

            if(session()->exists('current_shop')) {
                $session_shop = session()->get('current_shop');
    
                $this->configDB($session_shop[0]);

                /* CONFIG DATABASE */
                //$this->configDB('shop_xxxx');
                
                $serv_id = $request->serv_id;
                $serv_name = $request->serv_name;

                // check MST_ITEM and MST_ITEM_DTL
                $check_id_name = DB::table('MST_ITEM')
                ->leftJoin('MST_ITEM_DTL','MST_ITEM.ITEM_ID', '=', 'MST_ITEM_DTL.GROUP_ID')
                ->where('MST_ITEM.ITEM_ID',$serv_id)
                ->where('MST_ITEM.ITEM_NM',$serv_name)
                ->where('MST_ITEM.TYPE','1')->get();

                $this->return_json['msg'] = 'Service item does not exists';
                if($check_id_name->count() > 0) {

                    // delete from MST_ITEM
                    DB::table('MST_ITEM')->where('ITEM_ID',$serv_id)->delete();

                    // delete from MST_ITEM_DTL
                    DB::table('MST_ITEM_DTL')->where('GROUP_ID',$serv_id)->delete();
                    unset($this->return_json['msg']);
                    $this->return_json['error'] = 0;
                }
            }
        }
        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
    }

    /* USER */
    public function deleteUser(Request $request) {
        
        $error = 0;
        $arrReq = [
            'email' => 'Email address requied',
            'id'    => 'ID required'
        ];

        foreach($arrReq as $key => $val) {
            if(is_null($request->$key)) {
                $this->return_json['msg'] = $val;
                $error++;
                break;
            }
        }

        if(!$error) {

            $email = $request->email;
            $id = $request->id;

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->return_json['msg'] = 'Email address entry failed';
                return response()->json($this->return_json);
            }

            // verify email and id
            $verify_MST_USER = DB::table('MST_USER')
            ->where('id', $id)
            ->where('email', $email)->get();

            if($verify_MST_USER->count() == 1) {

                $delete_MST_USER = DB::table('MST_USER')
                ->where('id', $id)
                ->where('email', $email)->delete();

                $this->return_json['error'] = 0;
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