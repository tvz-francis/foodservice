<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Config;
use App\UserModel;

class BACK_GetController extends Controller
{

    public function __construct() {
        $this->return_json = array(
            'error' => 1,
            'data'  => false
        );
        date_default_timezone_set("Asia/Bangkok");
		$this->date_now = date('Y-m-d H:i:s');
    }

    public function shopList(Request $request) {

        $session = session()->get('users');
        
        if($session['user_level'] == 0) {
            $MST_SHOP = DB::select(DB::raw("
                SELECT * FROM `MST_SHOP` WHERE `SHOP_FLG` = 9 AND `DELETE_FLG` = 0;
            "));
        } else {
            if(is_array($session['shop_fc_no'])) {
                foreach($session['shop_fc_no'] as $key) {
                    $MST_SHOP = DB::table('MST_SHOP')
                    ->where('SHOP_FLG', 9)
                    ->where('SHOP_FC_NO', 'LIKE', '%'.$key.'%')->get();
                    if($MST_SHOP->count() == 0) {
                        $this->return_json['msg'] = $key.' is not expected data';
                        return response()->json($this->return_json);
                    }
                    $items_MST_SHOP[] = $MST_SHOP->first();
                }
                $MST_SHOP = $items_MST_SHOP;
            }

        }

        $this->return_json['data'] = array(
            'id'         => null,
            'SHOP_FC_NO' => null,
            'SHOP_NM'    => null,
            'GLOBAL_IP'  => null,
            'SHOP_FLG'   => null,
            'buttons'    => null
        );
        
        if(count($MST_SHOP) > 0) {
            $shop_array = [];
            foreach($MST_SHOP as $key => $val) {
                $global_ip = unserialize($val->GLOBAL_IP);
                $global_n = '';

                foreach($global_ip as $ip) {
                    $global_n .= '<code>('.$ip.')</code>';
                }

                $val->buttons = '<button class="btn btn-primary edit-shop-btn" data-id="'.$val->SHOP_FC_NO.'" style="margin-right: 15px;height: 33px;width: 33px;padding: 0;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';

                $icon = '<i class="fa fa-unlock" aria-hidden="true"></i>';
                if($val->LOCK_FLG == 1) {
                    $icon = '<i class="fa fa-lock" aria-hidden="true"></i>';
                }

                $val->buttons .= '<button class="btn btn-warning lock-shop-btn" data-id="'.$val->SHOP_FC_NO.'" style="margin-right: 15px;height: 33px;width: 33px;padding: 0;">'.$icon.'</button>';
                $val->buttons .= '<button class="btn btn-danger delete-shop-btn" data-id="'.$val->SHOP_FC_NO.'" style="height: 33px;width: 33px;padding: 0;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';

                $shop_array[] = [
                    'id'         => $val->id,
                    'SHOP_FC_NO' => $val->SHOP_FC_NO,
                    'SHOP_NM'    => $val->SHOP_NM,
                    'GLOBAL_IP'  => $global_n,
                    'SHOP_FLG'   => $val->SHOP_FLG,
                    'buttons'    => $val->buttons
                ];

            }
            unset($this->return_json);
            $this->return_json['data'] = $shop_array;
        }
        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
    }

    public function categoriesList(Request $request) {

        if(session()->exists('current_shop')) {
            $session_shop = session()->get('current_shop');

            $this->configDB($session_shop[0]);
            
            $MST_CATEGORY = DB::select(DB::raw("
                SELECT 
                    CONVERT(`MC`.`CATEGORY_ID`, CHAR(100)) AS `CATEGORY_ID`, `MC`.`SEQ`,
                    `MC`.`CATEGORY_NM`, `MC`.`PARENT_FLG`, CONVERT(`MC`.`PARENT_ID`, CHAR(100)) AS `PARENT_ID`, `MC`.`VIEW_FLG`, 
                    `MC`.`TYPE_FLG`, `MC`.`INPUT_DATE`, `MC`.`INPUT_USER_ID`, `MC`.`UPDATE_DATE`, 
                    `MC`.`UPDATE_USER_ID`
                FROM `MST_CATEGORY` `MC`;
            "));
            if(count($MST_CATEGORY) > 0) {
                foreach($MST_CATEGORY as $key => $val) {
                    $val->buttons = '<button class="btn btn-primary edit-cat-btn" data-id="'.$val->CATEGORY_ID.'" style="margin-right: 15px;height: 33px;width: 33px;padding: 0;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    $view_icon = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
                    if($val->VIEW_FLG == 1) {
                        $view_icon = '<i class="fa fa-eye" aria-hidden="true"></i>';
                    }
                    $val->buttons .= '<button class="btn btn-warning view-cat-btn" data-id="'.$val->CATEGORY_ID.'" style="margin-right: 15px;height: 33px;width: 33px;padding: 0;">'.$view_icon.'</button>';
                    $val->buttons .= '<button class="btn btn-danger delete-cat-btn" data-id="'.$val->CATEGORY_ID.'" data-name="'.$val->CATEGORY_NM.'" style="height: 33px;width: 33px;padding: 0;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
                }
                unset($this->return_json);
                $this->return_json['data'] = $MST_CATEGORY;
                $this->return_json['error'] = 0;
            }
        }

        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
    }

    public function switchShopList() {

        // return session()->all();

        $session = session()->get('users');

        if($session['user_level'] == 0) {
            $MST_SHOP = DB::table('MST_SHOP')
            ->where('SHOP_FLG', 9)
            ->where('DELETE_FLG', 0)->get()->toArray();
        } else {
            if(is_array($session['shop_fc_no'])) {
                foreach($session['shop_fc_no'] as $key) {
                    $MST_SHOP = DB::table('MST_SHOP')
                    ->where('SHOP_FLG', 9)
                    ->where('SHOP_FC_NO', 'LIKE', '%'.$key.'%')->get();
                    if($MST_SHOP->count() == 0) {
                        $this->return_json['msg'] = $key.' is not expected data';
                        return response()->json($this->return_json);
                    }
                    $items_MST_SHOP[] = $MST_SHOP->first();
                }
                $MST_SHOP = $items_MST_SHOP;
            }
        }

        if(count($MST_SHOP) > 0) {

            $shop_array = [];
            foreach($MST_SHOP as $key => $val) {

                if($val->LOCK_FLG == 1) {
                    $lock_element = '<div style="text-align: center;height: 33px;padding-top: 6px;background-color: #dd4b39;"><strong style="color: white;">LOCKED</strong></div>';
                    $val->buttons = '<button class="btn btn-primary disabled" data-name="'.$val->SHOP_NM.'" style="margin-right: 15px;height: 33px;width: 100%;padding: 0;" disabled><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                } elseif($val->LOCK_FLG == 0) {
                    $lock_element = '<div style="text-align: center;height: 33px;padding-top: 6px;background-color: #00a65a;"><strong style="color: white;">UNLOCKED</strong></div>';
                    $val->buttons = '<button class="btn btn-primary switch-btn" data-id="'.$val->SHOP_FC_NO.'" data-name="'.$val->SHOP_NM.'" style="margin-right: 15px;height: 33px;width: 100%;padding: 0;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                }

                $val->lock_status = $lock_element;

                
                
                $shop_array[] = [
                    'id'         => $val->id,
                    'SHOP_FC_NO' => $val->SHOP_FC_NO,
                    'SHOP_NM'    => $val->SHOP_NM,
                    'SHOP_FLG'   => $val->SHOP_FLG,
                    'buttons'    => $val->buttons,
                    'lock_element' => $lock_element
                ];
            }
            unset($this->return_json);
            $this->return_json['data'] = $shop_array;

        }
        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
    }

    public function usersList() {

        $MST_USERS = DB::select(DB::raw("
            SELECT 
                `MU`.`id`, REPLACE(`MU`.`name`, '+',' ') AS `name`, `MU`.`email`, `MU`.`username`, 
                `MU`.`user_level`, `MU`.`shop_fc_no`, `MU`.`created_at`, `MU`.`updated_at`, `MU`.`LOCK_FLG`
            FROM `MST_USER` `MU` WHERE `MU`.`user_level` != '0';
        "));
        if(count($MST_USERS) > 0) {
            foreach($MST_USERS as $key => $val) {
                $shop_fc_no = unserialize($val->shop_fc_no);
                $shop_nm = '';

                $lock_icon = '<i class="fa fa-unlock" aria-hidden="true"></i>';
                if($val->LOCK_FLG == 1) {
                    $lock_icon = '<i class="fa fa-lock" aria-hidden="true"></i>';
                }

                foreach($shop_fc_no as $key) {
                    $MST_SHOP = DB::table('MST_SHOP')->select('SHOP_NM')->where('SHOP_FC_NO',$key)->first();
                    $shop_nm .= '<code>('.$MST_SHOP->SHOP_NM.')</code>';
                }

                $val->shop_fc_no = $shop_nm;

                $val->buttons = '<button class="btn btn-primary edit-user-btn" data-email="'.$val->email.'" style="margin-right: 15px;height: 33px;width: 33px;padding: 0;" title="EDIT"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                $val->buttons .= '<button class="btn btn-warning lock-user-btn" data-id="'.$val->id.'" style="margin-right: 15px;height: 33px;width: 33px;padding: 0;" title="LOCK-UNLOCK">'.$lock_icon.'</button>';
                $val->buttons .= '<button class="btn btn-danger delete-user-btn" data-email="'.$val->email.'" data-id="'.$val->id.'" style="height: 33px;width: 33px;padding: 0;" title="DELETE"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
            }
            unset($this->return_json);
            $this->return_json['data'] = $MST_USERS;
        }
        echo json_encode($this->return_json,JSON_PRETTY_PRINT);

    }

    /* SERVICES PAGE */
    public function servicesList() {

        if(session()->exists('current_shop')) {
            $session_shop = session()->get('current_shop');

            $this->configDB($session_shop[0]);

            $TBL_SERVICES = DB::table('MST_ITEM AS MI')->select(
                DB::raw("
                    CONVERT(`MI`.`ITEM_ID`, CHAR(100)) AS `ITEM_ID`, `MI`.`SEQ`, `MI`.`ITEM_NM`,
                    (SELECT `ITEM_PRICE` FROM `MST_ITEM_DTL` WHERE `GENDER_FLG` = 0 AND `GROUP_ID` = `MI`.`ITEM_ID`) AS `MALE_PRICE`,
                    (SELECT `ITEM_PRICE` FROM `MST_ITEM_DTL` WHERE `GENDER_FLG` = 1 AND `GROUP_ID` = `MI`.`ITEM_ID`) AS `FEMALE_PRICE`, `MI`.`VIEW_FLG`
                ")
            )->where('MI.TYPE',1)->get();
            // DB::select(DB::raw("
            //     SELECT 
            //         CONVERT(`MI`.`ITEM_ID`, CHAR(100)) AS `ITEM_ID`, `MI`.`SEQ`, `MI`.`ITEM_NM`,
            //         (SELECT `ITEM_PRICE` FROM `MST_ITEM_DTL` WHERE `GENDER_FLG` = 0 AND `GROUP_ID` = `MI`.`ITEM_ID`) AS `MALE_PRICE`,
            //         (SELECT `ITEM_PRICE` FROM `MST_ITEM_DTL` WHERE `GENDER_FLG` = 1 AND `GROUP_ID` = `MI`.`ITEM_ID`) AS `FEMALE_PRICE`
            //     FROM 
            //         `MST_ITEM` `MI` WHERE `MI`.`TYPE` = '1';
            // "));
            if($TBL_SERVICES->count() > 0) {
                foreach($TBL_SERVICES as $key => $val) {
                    $val->buttons = '<button class="btn btn-primary edit-serv-btn" data-id="'.$val->ITEM_ID.'" style="margin-right: 15px;height: 33px;width: 33px;padding: 0;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    $view_icon = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
                    if($val->VIEW_FLG == 1) {
                        $view_icon = '<i class="fa fa-eye" aria-hidden="true"></i>';
                    }
                    $val->buttons .= '<button class="btn btn-warning view-serv-btn" data-id="'.$val->ITEM_ID.'" style="margin-right: 15px;height: 33px;width: 33px;padding: 0;">'.$view_icon.'</button>';
                    $val->buttons .= '<button class="btn btn-danger delete-serv-btn" data-id="'.$val->ITEM_ID.'" data-name="'.$val->ITEM_NM.'" style="height: 33px;width: 33px;padding: 0;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
                }
                unset($this->return_json);
                $this->return_json['data'] = $TBL_SERVICES;
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