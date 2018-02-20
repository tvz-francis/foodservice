<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Config;

class BACK_VerifyController extends Controller
{

    public function __construct() {
        $this->return_json = array(
            'error' => 1,
            'data'  => false
        );
        date_default_timezone_set("Asia/Tokyo");
		$this->date_now = date('Y-m-d H:i:s');
    }

    public function verifyUserShops(Request $request,$encrypt) {

        echo '<pre>';var_dump($encrypt,$request->all(),session()->all());echo '</pre>';die();

        if(session()->exists('current_shop') && session()->exists('users')) {
            $session = session()->get('users');
            $current_shop =  serialize(session()->get('current_shop'));

            if($session['user_level'] == 0) {
                return response()->json(['message'=>'System checking']);
            }

            $CHECK_CURRENT_SHOP = DB::table('MST_USER')
            ->where('id',$session['id'])
            ->where('shop_fc_no',$current_shop)->get();

        }
        return response()->json($this->return_json);

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