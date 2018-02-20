<?php

namespace App\Http\Controllers\v2;

use Illuminate\Http\Request;
use DB;
use Config;
use App\Http\Controllers\Controller;

class BACK_ActionGetController extends Controller
{

    public function __construct() {
        $this->return_json = array(
            'error' => 1,
            'data'  => false
        );
        date_default_timezone_set("Asia/Bangkok");
		$this->date_now = date('Y-m-d H:i:s');
    }

    public function checkShopFcNo($shop_no) {
        
        $MST_SHOP = DB::select(DB::raw("
            SELECT DISTINCT(`SHOP_FC_NO`) FROM `MST_SHOP` WHERE `SHOP_FC_NO` = :shop_fc_no;
        "),[
            'shop_fc_no' => $shop_no
        ]);
        if(count($MST_SHOP) > 0) {
            $this->return_json['error'] = 0;
        }
        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
    }

    public function getShopInfo(Request $request, $shop_id) {

        $MST_SHOP = DB::select(DB::raw("
            SELECT * FROM `MST_SHOP` WHERE `SHOP_FC_NO` = :id;
        "),[
            'id' => $shop_id,
        ]);

        if(count($MST_SHOP) > 0) {
            
            foreach($MST_SHOP as $key => $val) {
                $val->GLOBAL_IP = unserialize($val->GLOBAL_IP);
            }
            $this->return_json['data'] = $MST_SHOP;
            $this->return_json['error'] = 0;
        }

        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
    }

    /* CATEGORY */
    public function getParentCategory(Request $request) {

        $session_shop = session()->get('current_shop');

        $this->configDB($session_shop[0]);

        /* CONFIG DATABASE */
        //$this->configDB('shop_xxxx');
        
        $MST_CATEGORY = DB::table('MST_CATEGORY')->select(DB::raw("CONVERT(`CATEGORY_ID`, CHAR(100)) AS `CATEGORY_ID`, `CATEGORY_NM`"))->where('PARENT_FLG', '1')->whereNotIn('CATEGORY_ID', ['001'])->get();

        echo json_encode($MST_CATEGORY->toArray(),JSON_PRETTY_PRINT);
    }

    public function getParentCategoryInfo(Request $request) {

        $session_shop = session()->get('current_shop');

        $this->configDB($session_shop[0]);

        /* CONFIG DATABASE */
        //$this->configDB('shop_xxxx');
        
        $MST_CATEGORY = DB::table('MST_CATEGORY')
        ->select(DB::raw("CONVERT(`CATEGORY_ID`,CHAR(100)) AS `CATEGORY_ID`, `SEQ`, `CATEGORY_NM`, `TYPE_FLG`"))
        ->where('CATEGORY_ID', $request->shop_category_id)->get()->first();

        echo json_encode($MST_CATEGORY,JSON_PRETTY_PRINT);
    }

    public function getCheckItems(Request $request) {

        $error = 0;
        $arrReq = [
            'cat_id' => 'Cat ID required'
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

                $check_item = DB::table('MST_ITEM')
                ->where('CATEGORY_PARENT_ID',$cat_id)
                ->orWhere('CATEGORY_SUB_ID',$cat_id)->get();

                if($check_item->count() > 0) {
                    $this->return_json['data'] = 'このカテゴリー内に登録されている商品があります。全て削除後にカテゴリーの削除が可能です。';
                    // '<mark>'.$check_item->count().' item(s) found</mark> linked to this category, Delete them first before you can delete this category';
                    $this->return_json['error'] = 0;
                }
            }

        }
        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
    }


    /* SERVICES PAGE */
    public function getServicesCategory(Request $request) {

        $session_shop = session()->get('current_shop');

        $this->configDB($session_shop[0]);

        /* CONFIG DATABASE */
        //$this->configDB('shop_xxxx');

        $MST_CATEGORY = DB::table('MST_CATEGORY')
        ->select(DB::raw("CONVERT(`CATEGORY_ID`, CHAR(100)) AS `CATEGORY_ID`, `CATEGORY_NM`"))
        ->where('PARENT_FLG', 1)
        ->where('TYPE_FLG', 1)->get()->toArray();

        echo json_encode($MST_CATEGORY,JSON_PRETTY_PRINT);
    }

    public function getInfoService(Request $request, $id) {

        $session_shop = session()->get('current_shop');

        $this->configDB($session_shop[0]);

        /* CONFIG DATABASE */
        //$this->configDB('shop_xxxx');

        $MST_ITEM = DB::select(DB::raw("
            SELECT 
                CONVERT(`ITEM_ID`, CHAR(100)) AS `GROUP_ID`, `SEQ`, `ITEM_NM`, `ITEM_DESC`, `CATEGORY_PARENT_ID`,
                (SELECT CONVERT(`ITEM_ID`, CHAR(100)) FROM `MST_ITEM_DTL` WHERE `GROUP_ID` = '".$id."' AND `GENDER_FLG` = '0') AS `MALE_ID`,
                (SELECT `ITEM_PRICE` FROM `MST_ITEM_DTL` WHERE `GROUP_ID` = '".$id."' AND `GENDER_FLG` = '0') AS `MALE_PRICE`,
                (SELECT CONVERT(`ITEM_ID`, CHAR(100)) FROM `MST_ITEM_DTL` WHERE `GROUP_ID` = '".$id."' AND `GENDER_FLG` = '1') AS `FEMALE_ID`,
                (SELECT `ITEM_PRICE` FROM `MST_ITEM_DTL` WHERE `GROUP_ID` = '".$id."' AND `GENDER_FLG` = '1') AS `FEMALE_PRICE`
            FROM 
                `MST_ITEM` `MI`
            WHERE
                `MI`.`ITEM_ID` = :group_id;
        "),[
            'group_id' => $id
        ]);
        echo json_encode($MST_ITEM[0],JSON_PRETTY_PRINT);
    }

    /* USERS PAGE */
    public function getUser(Request $request) {
        $error = 0;
        $arrReq = [
            'user_email' => 'Email address required'
        ];

        foreach($arrReq as $key => $val) {
            if(is_null($request->$key)) {
                $this->return_json['msg'] = $val;
                $error++;
                break;
            }
        }

        if(!$error) {

            $user_email = $request->user_email;

            $MST_USER = DB::table('MST_USER')
            ->select(['id AS pointer','name','email','username','user_level','shop_fc_no'])
            ->where('email',$user_email)
            ->whereNotIn('user_level',[0])->get();

            if($MST_USER->count() > 0) {
                unset($this->return_json['msg']);
                $MST_USER = $MST_USER->first();
                $MST_USER->name = explode('+',$MST_USER->name);
                $MST_USER->user_last = $MST_USER->name[1];
                $MST_USER->user_first = $MST_USER->name[0];
                $MST_USER->shop_fc_no = unserialize($MST_USER->shop_fc_no);
                unset($MST_USER->name);
                $this->return_json['data'] = $MST_USER;
                $this->return_json['error'] = 0;
            }

        }
        return response()->json($this->return_json);
    }

    // public function getUserShopList() {
    //     $MST_SHOP = DB::table('MST_SHOP')
    //     ->select(['SHOP_FC_NO AS id','SHOP_NM AS text'])
    //     ->where('SHOP_FLG', '9')->get();
    //     if($MST_SHOP->count() > 0) {
    //         $MST_SHOP = $MST_SHOP->toArray();
    //         $this->return_json['data'] = $MST_SHOP;
    //         $this->return_json['error'] = 0;
    //     }
    //     return response()->json($this->return_json);
    // }

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