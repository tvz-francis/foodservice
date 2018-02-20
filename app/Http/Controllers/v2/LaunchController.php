<?php

namespace App\Http\Controllers\v2;

use Illuminate\Http\Request;
use DB;
use Config;
use Session;
use App\Http\Controllers\Controller;

class LaunchController extends Controller
{

    public function __construct() {
        $this->return_json = array(
            'error' => 0,
            'data'  => false
        );
    }

    public function verifyIP(Request $request) {

        // echo '<pre>';var_dump($request->input('seat_no'));echo '</pre>';die();

        $error = 0;
        $data = [
            'error' => 1
        ];
        
        $data['msg'] = 'Shop number is not set.';
        if($request->session()->exists('shop_id')) {

            $db_name = $request->session()->get('shop_id');

            // config db
            $this->configDB($db_name);
            // $this->configDB('shop_XXXX');

            // SEAT_NO
            // $request->input('seat_no');
            $HOST_NAME = $request->input('seat_no');

            // verify in MST_SEAT_STATUS > HOST_NAME_1 + SALES_NO + LOGIN FLG
            $seat_status = DB::select(DB::raw("
                SELECT * FROM `MST_SEAT_STATUS` `MSS` WHERE `MSS`.`HOST_NAME_1` = :seat_number;
            "),[
                'seat_number' => $HOST_NAME
            ]);

            // $data['msg'] = 'This device is not yet link to AcrossPOS. Please check tablet name in AcrossPOS. Tablet Name: '.$HOST_NAME;
            $data['msg'] = 'このデバイスはPOSと接続されていません。 <br /> POSのタブレット名を確認して下さい。 <br /> タブレット名: '.$HOST_NAME;
            if(count($seat_status) > 0) {

                foreach($seat_status as $key) {
                    $login_flg = $key->LOGIN_FLG;
                    $sales_no = $key->SALES_NO;
                    // $data['msg'] = 'No sales number. Please login first in AcrossPOS.';
                    $data['msg'] = '未入店のため、注文できません。 <br />
				入店後、ご注文頂けます。';
                    if($login_flg == 1 && $sales_no != NULL) {
                        $data['error'] = 0;
                        unset($data['msg']);
                        session()->put('host_name', $HOST_NAME);
                        // return view('welcome',$data);
                        break;
                    }
                }


                // $sales_no = DB::select(DB::raw("
                //     SELECT * FROM `MST_SEAT_STATUS` `MSS`
                //     WHERE 
                //         `MSS`.`HOST_NAME_1` = :seat_number AND 
                //         `MSS`.`SALES_NO` IS NOT NULL;
                // "),[
                //     'seat_number' => $HOST_NAME
                // ]);

                // $login_flg = DB::select(DB::raw("
                //     SELECT * FROM `MST_SEAT_STATUS` `MSS`
                //     WHERE 
                //         `MSS`.`HOST_NAME_1` = :seat_number AND 
                //         `MSS`.`LOGIN_FLG` = 1;
                // "),[
                //     'seat_number' => $HOST_NAME
                // ]);

            }
			// else{
				
			// $data['msg'] = 'Unable to connect to any database server. <br />
				// Please check your global ip address. host';
		  // }

        }
        // session()->forget('gender_flg');
        // Session::forget('gender_flg');
        // echo '<pre>';var_dump(session()->all());echo '</pre>';die();
        return view('welcome',$data);
    }

    private function configDB($db_name) {
        Config::set("database.connections.mysql", [
            "host"     => "buster-food.com",
            "database" => $db_name,
            "username" => "webmaster",
            "password" => "EQB7nhgdH{DSJcb*",
            'driver'   => 'mysql',
            'charset'  => 'utf8',
            'collation' => 'utf8_unicode_ci'
        ]);
    }
    
}
