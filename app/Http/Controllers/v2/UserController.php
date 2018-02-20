<?php

namespace App\Http\Controllers\v2;

use Illuminate\Http\Request;
use DB;
use Config;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function __construct() {
        $this->return_json = array(
            'error' => 1,
            'data'  => false
        );
        date_default_timezone_set("Asia/Tokyo");
		$this->date_now = date('Y-m-d H:i:s');
    }

    public function index(Request $request) {
        // echo '<pre>';var_dump(DB::table('MST_SHOP')->get());echo '</pre>';
        
        // echo '<pre>';var_dump();echo '</pre>';

        // echo '<pre>';var_dump(DB::table('MST_SHOP')->get());echo '</pre>';

        //$request->getClientIp();

        // check ip exists.
        $getIP = DB::table('MST_SHOP')->get()->where('GLOBAL_IP', '122.52.163.67');
        if($getIP->count() > 0) {
            foreach($getIP->toArray() as $key) {
                $shop_no = $key->SHOP_FC_NO;
            }
            // configure shop db
            // $shop_no <-- shop id
            $db_prefix = 'test_shop_';

            
        }
        
    }

    public function main() {
        return view('v2welcome');
    }

    public function home(Request $request) {

        session()->forget('cart');

        $this->return_json['msg'] = 'Shop ID is not set';
        if(session()->exists('shop_id')) {

            $db_name = session()->get('shop_id');
            $category_id = $request->a;
            // config db
            $this->configDB($db_name);

            $categories = DB::select(DB::raw("
                SELECT 
                    CONVERT(`MC`.`CATEGORY_ID`, CHAR(100)) AS `CATEGORY_ID`, 
                    `MC`.`CATEGORY_NM` 
                FROM 
                    `MST_CATEGORY` `MC` 
                WHERE 
                    `MC`.`PARENT_FLG` = '1' GROUP BY `MC`.`SEQ` ASC;
            "));
            
            $this->return_json['msg'] = count($categories).' Results found';
            if(count($categories) > 0) {

                unset($this->return_json['msg']);
                $this->return_json['data'] = $categories;
                $this->return_json['error'] = 0;

            }

        }
        return view('v2home', $this->return_json);
    }

    public function summary() {

        if(session()->exists('shop_id')) {
            $db_name = session()->get('shop_id');

            // config db
            //$this->configDB($db_name);
            $this->configDB($db_name);// 'shop_XXXX'

            // select category
            // $category = DB::table('MST_CATEGORY')->get();

            $category = DB::select(DB::raw("
                SELECT `MC`.`SEQ`, CONVERT(`MC`.`CATEGORY_ID`, CHAR(100)) AS `CATEGORY_ID`, `MC`.`CATEGORY_NM` FROM `MST_CATEGORY` `MC` ORDER BY `MC`.`SEQ` ASC;
            "));
            
            if(count($category) > 0) {
                $data['category'] = $category;
            }
            return view('summary', $data);
        }
        
    }

    public function history() {
        return view('history');
    }

    public function billOut(Request $request) {

        $this->return_json['msg'] = 'Cant\' find shop id';
		if(session()->exists('shop_id')) {

            $item_insert = array();
            $item_update=array();
			$db_name = session()->get('shop_id');
			$host_name = session()->get('host_name');
			
            $this->configDB($db_name);

            // SEAT STATUS DETAILS
            $seat_status_det = DB::select(DB::raw("
                SELECT `MSS`.`SEAT_NO`, `MSS`.`SALES_NO`, `MSS`.`GENDER_FLG`
                FROM `MST_SEAT_STATUS` `MSS` 
                WHERE `MSS`.`HOST_NAME_1` = :hostname;
            "),[
                'hostname' => $host_name
            ]);

            $seat_no = $seat_status_det[0]->SEAT_NO;
            $sales_no = $seat_status_det[0]->SALES_NO;
            $ss_gender_flg = $seat_status_det[0]->GENDER_FLG;

            // SEQUENCE NUMBER
            $seq_num_last = DB::table('TBL_SERVICE')->select(DB::raw("MAX(`SEQ`) AS `SEQ`"))->first();
            // $seq_num_last = DB::select(DB::raw("
            //     SELECT MAX(`TO`.`SEQ`) AS `SEQ` FROM `TBL_SERVICE` `TO` ORDER BY `TO`.`SEQ` ASC
            // "));

            $seq_num_last = ($seq_num_last)?$seq_num_last->SEQ+1:0;

            $item_insert = [
                'SEAT_NO'    => $seat_no,
                'SALES_NO'   => $sales_no,
                'SEQ'        => $seq_num_last,
                'ITEM_ID'    => '000000000000',
                'ITEM_NM'    => 'Bill Out',
                'ITEM_QTY'   => 0,
                'ITEM_PRICE' => 0,
                'ORDER_DATE' => $this->date_now,
                'GENDER_FLG' => $request->gender_flg,
                'CHECK_FLG'  => 0,
			    'NOTIFY_FLG' => 0
            ];
            $item_update = [
                'ITEM_NM'    => 'Bill Out',
                'ITEM_QTY'   => 0,
                'ITEM_PRICE' => 0,
                'ORDER_DATE' => $this->date_now,
                'GENDER_FLG' => $request->gender_flg,
                'CHECK_FLG'  => 0,
			    'NOTIFY_FLG' => 0
            ];

            

            /* check gender flag
             * if request gender flg is equal to 0 or 1 in created gender_flg overwrite it, but 
             * if request gender flg is opposite to data gender flg then insert new row.
             */ 
            $cgf = DB::table('TBL_SERVICE')
            ->where('SEAT_NO',$seat_no)
            ->where('SALES_NO',$sales_no)
            ->get();

            if($ss_gender_flg == 0 || $ss_gender_flg == 1) {

                $item_update['GENDER_FLG'] = 3;
                $update_billout = DB::table('TBL_SERVICE')
                ->where('SEAT_NO', $seat_no)
                ->where('SALES_NO', $sales_no)
                ->where('ITEM_ID', '000000000000')->update($item_update);

                if($update_billout == 0) {
                    $item_insert['GENDER_FLG'] = 3;
                    $insert_billout = DB::table('TBL_SERVICE')->insert($item_insert);
                    
                    $this->return_json['msg'] = 'Error occured when inserting data';
                    if($insert_billout) {
                        unset($this->return_json['msg']);
                        $this->return_json['error'] = 0;
                    }
                } else {
                    unset($this->return_json['msg']);
                    $this->return_json['error'] = 0;
                }
                
            } elseif($ss_gender_flg == 3) {
                
                if($cgf->count() > 1) {

                    if($request->gender_flg == 0 || $request->gender_flg == 1) {
                        DB::table('TBL_SERVICE')
                        ->where('SEAT_NO', $seat_no)
                        ->where('SALES_NO', $sales_no)
                        ->where('GENDER_FLG', $request->gender_flg)
                        ->update($item_update);
                    } elseif($request->gender_flg == 3) {
                        DB::table('TBL_SERVICE')
                        ->where('SEAT_NO', $seat_no)
                        ->where('SALES_NO', $sales_no)
                        ->where('GENDER_FLG', 1)
                        ->orWhere('GENDER_FLG', 0)
                        ->delete();
                        DB::table('TBL_SERVICE')->insert($item_insert);
                    }

                } else {
                    DB::table('TBL_SERVICE')->insert($item_insert);
                }

            }
            
            // echo '<pre>';var_dump($insert_billout);echo '</pre>';return;

            // $update_billout = DB::table('TBL_SERVICE')
            // ->where('SEAT_NO', $seat_no)
            // ->where('SALES_NO', $sales_no)
            // ->where('ITEM_ID', '000000000000')->update($item_update);

     //        if($update_billout == 0) {

     //            

     //            $insert_billout = DB::table('TBL_SERVICE')->insert($item_insert);
                
     //            $this->return_json['msg'] = 'Error occured when inserting data';
     //            if($insert_billout) {
     //                unset($this->return_json['msg']);
     //                $this->return_json['error'] = 0;
     //            }
     //        } else {
     //            unset($this->return_json['msg']);
     //            $this->return_json['error'] = 0;
     //        }
			
		   $data = array();
		   $data['host_name'] = $host_name;
		   $this->return_json['data'] = $data;
        }
        
                        
        echo json_encode($this->return_json, JSON_PRETTY_PRINT);
    }
	
	public function billoutCancel(Request $request) {
		if(session()->exists('shop_id')) {

				$db_name = session()->get('shop_id');
				$host_name = session()->get('host_name');
				
				$this->configDB($db_name);

				// SEAT STATUS DETAILS
				$seat_status_det = DB::select(DB::raw("
					SELECT `MSS`.`SEAT_NO`, `MSS`.`SALES_NO`
					FROM `MST_SEAT_STATUS` `MSS` 
					WHERE `MSS`.`HOST_NAME_1` = :hostname;
				"),[
					'hostname' => $host_name
				]);

				$seat_no = $seat_status_det[0]->SEAT_NO;
				$sales_no = $seat_status_det[0]->SALES_NO;
				
				$insert_billout = DB::table('TBL_SERVICE')
					->where('SEAT_NO', $seat_no)
					->where('SALES_NO', $sales_no)
					->where('ITEM_ID', '000000000000')
					->delete();
				
			$this->return_json['msg'] = 'delete the bill out order';
			$this->return_json['error'] = 0;
			echo json_encode($this->return_json, JSON_PRETTY_PRINT);
		}
	}

    private function configDB($db_name) {
        Config::set("database.connections.mysql", [
            "host"     => "db-food.cg4jhjqbqa96.ap-northeast-1.rds.amazonaws.com",
            "database" => $db_name, // $db_name
            "username" => "dbmaster",
            "password" => "f04v3wBj9o",
            'driver'   => 'mysql',
            'charset'  => 'utf8',
            'collation' => 'utf8_unicode_ci'
        ]);
    }
    
}