<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Config;

class BACK_Redirect extends Controller
{

    public function __construct() {
        $this->return_json = array(
            'error' => 1,
            'data'  => false
        );
        date_default_timezone_set("Asia/Bangkok");
        $this->date_now = date('Y-m-d H:i:s');
        $this->configDB('shop_xxxx');
    }

    public function redirectMe() {
        

        $DB_ = DB::select(DB::raw("
            SELECT * FROM `MST_ITEM`;
        "));

        echo '<pre>';var_dump($DB_);echo '</pre>';
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