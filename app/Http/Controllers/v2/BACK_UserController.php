<?php

namespace App\Http\Controllers\v2;

use Illuminate\Http\Request;
// use Session;
use DB;
use Config;
use App\Http\Controllers\Controller;

class BACK_UserController extends Controller
{

    public function __construct() {
        $this->return_json = array(
            'error' => 1,
            'data'  => false
        );
        date_default_timezone_set("Asia/Tokyo");
        $this->date_now = date('Y-m-d H:i:s');
        $this->header_name = false;
    }

    public function viewDashboard() {
        $this->redirectMe();
        return view('back.page.dashboard',['header_name'=>$this->header_name]);
    }

    public function viewServices() {
        $this->header_name = true;
        $this->redirectMe();
        return view('back.page.services',['header_name'=>$this->header_name]);
    }

    public function viewShops() {
        $this->redirectMe();
        return view('back.page.shops',['header_name'=>$this->header_name]);
    }

    public function viewCategories() {
        $this->header_name = true;
        $this->redirectMe();
        return view('back.page.categories',['header_name'=>$this->header_name]);
    }

    public function viewSwitchShop() {
        $this->redirectMe();
        return view('back.page.switchshop',['header_name'=>$this->header_name]);
    }

    public function redirectMe() {
        if(!session()->exists('users')) {
            Auth::logout();
            return redirect()->route('login');
        }
    }

    public function viewUsers() {
        // select shops for modal
        $data['data'] = false;
        $data['header_name'] = $this->header_name;

        $MST_SHOP = DB::select(DB::raw("
            SELECT * FROM `MST_SHOP` WHERE `SHOP_FLG` = 9;
        "));
        if(count($MST_SHOP) > 0) {
            $data['data'] = $MST_SHOP;
        }

        return view('back.page.users', $data);
    }

    public function viewItem(Request $request) {
        $this->header_name = true;
		return view('back.page.items',['header_name'=>$this->header_name]);
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