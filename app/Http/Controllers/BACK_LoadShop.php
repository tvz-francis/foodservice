<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Config;

class BACK_LoadShop extends Controller
{

    public function __construct() {
        $this->return_json = array(
            'error' => 1,
            'data'  => false
        );
        date_default_timezone_set("Asia/Tokyo");
		$this->date_now = date('Y-m-d H:i:s');
    }

    public function loadShop(Request $request) {

        $error = 0;
        $arrReq = [
            'shop_fc_no' => 'Shop no required',
            'shop_name'  => 'Shop name required'
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
            $shop_name = $request->shop_name;

            //check shop
            $MST_SHOP = DB::table('MST_SHOP')
            ->where('SHOP_FC_NO',$shop_fc_no)
            ->where('SHOP_NM',$shop_name)->get();

            if($MST_SHOP->count() > 0) {

                session()->put('current_shop',[$MST_SHOP->first()->SHOP_FC_NO,$MST_SHOP->first()->SHOP_NM]);

                unset($this->return_json['msg']);
                $this->return_json['error'] = 0;

            }

        }

        
        echo json_encode($this->return_json,JSON_PRETTY_PRINT);
    }

    public function unsetShop() {

        session()->pull('current_shop');

    }
    

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