<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Config;

class BACK_DBSchema extends Controller
{
    public function __construct() {
        $this->return_json = array(
            'error' => 1,
            'data'  => false
        );
        date_default_timezone_set("Asia/Tokyo");
		$this->date_now = date('Y-m-d H:i:s');
    }

    public function createDBSchema() {

        $this->return_json['msg'] = 'SHOP FC NO is not set';
        if(session()->exists('create_shop')) {

            $this->configDB(session()->get('create_shop'));

            try {
                DB::statement("
                    CREATE TABLE `MST_CATEGORY` (
                        `CATEGORY_ID` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
                        `SEQ` int(3) NOT NULL DEFAULT '0',
                        `CATEGORY_NM` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                        `PARENT_FLG` int(1) NOT NULL DEFAULT '0' COMMENT '0 = No, 1 = Yes',
                        `PARENT_ID` int(3) unsigned zerofill DEFAULT NULL,
                        `VIEW_FLG` int(1) NOT NULL DEFAULT '1' COMMENT '0 = No, 1 = Yes',
                        `TYPE_FLG` int(1) NOT NULL DEFAULT '0' COMMENT '0 = Food, 1 = Service',
                        `INPUT_DATE` datetime DEFAULT NULL,
                        `INPUT_USER_ID` varchar(12) DEFAULT NULL,
                        `UPDATE_DATE` datetime DEFAULT NULL,
                        `UPDATE_USER_ID` varchar(12) DEFAULT NULL,
                        PRIMARY KEY (`CATEGORY_ID`),
                        UNIQUE KEY `IX_CATEGORY_01` (`CATEGORY_NM`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
                ");

                DB::statement("
                    CREATE TABLE `MST_ITEM` (
                        `ITEM_ID` int(12) unsigned zerofill NOT NULL AUTO_INCREMENT,
                        `SEQ` int(11) NOT NULL,
                        `ITEM_NM` varchar(30) NOT NULL,
                        `ITEM_DESC` varchar(100) DEFAULT NULL,
                        `ITEM_IMG` varchar(255) NOT NULL,
                        `CATEGORY_PARENT_ID` varchar(3) NOT NULL COMMENT 'Parent Category Id',
                        `CATEGORY_SUB_ID` varchar(3) DEFAULT NULL COMMENT 'Sub Category Id',
                        `VIEW_FLG` varchar(1) NOT NULL DEFAULT '1' COMMENT 'Display Item Flag 0 = Hide, 1 = Show',
                        `TYPE` varchar(1) DEFAULT '0' COMMENT '0 = Food 1 = Service',
                        `INSERT_DATE` datetime NOT NULL,
                        `INSERT_USER_ID` varchar(12) NOT NULL,
                        `UPDATE_DATE` datetime DEFAULT NULL,
                        `UPDATE_USER_ID` varchar(12) DEFAULT NULL,
                        PRIMARY KEY (`ITEM_ID`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
                ");

                DB::statement("
                    CREATE TABLE `MST_ITEM_DTL` (
                        `id` int(12) unsigned zerofill NOT NULL AUTO_INCREMENT,
                        `ITEM_ID` int(12) unsigned zerofill NOT NULL,
                        `ITEM_PRICE` double NOT NULL,
                        `GENDER_FLG` varchar(1) NOT NULL COMMENT '0 = Male, 1 = Female, 3 = All',
                        `GROUP_ID` int(12) unsigned zerofill NOT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `IX_MST_FOOD_01` (`ITEM_ID`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
                ");

                DB::statement("
                    CREATE TABLE `MST_SEAT_STATUS` (
                        `id` int(10) NOT NULL AUTO_INCREMENT,
                        `SEAT_NO` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                        `SALES_NO` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                        `LOGIN_FLG` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
                        `HOST_NAME_1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                        `NYUTEN_DATE` datetime DEFAULT NULL,
                        `GENDER_FLG` varchar(1) DEFAULT NULL COMMENT '0 = Male, 1 = Female, 3 = All',
                        PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
                ");

                DB::statement("
                    CREATE TABLE `TBL_ORDER` (
                        `id` int(10) NOT NULL AUTO_INCREMENT,
                        `SEAT_NO` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                        `SALES_NO` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                        `SEQ` int(3) NOT NULL,
                        `ITEM_ID` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                        `ITEM_NM` varchar(30) NOT NULL,
                        `ITEM_QTY` int(11) NOT NULL,
                        `ITEM_PRICE` double NOT NULL,
                        `ORDER_DATE` datetime NOT NULL,
                        `GENDER_FLG` varchar(1) NOT NULL COMMENT '0 = Male, 1 = Female, 3 = All',
                        `SYNC_FLG` varchar(1) NOT NULL DEFAULT '0' COMMENT '0 = Not, 1 = Done',
                        `SYNC_DATE` datetime DEFAULT NULL,
                        `PRINT_FLG` int(1) NOT NULL DEFAULT '0' COMMENT '0 = Not, 1 = Already',
                        `PRINT_DATE` datetime DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `IX_TBL_FOOD_ORDER_01` (`SEAT_NO`,`SALES_NO`,`SEQ`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
                ");

                DB::statement("
                    CREATE TABLE `TBL_SERVICE` (
                        `id` int(10) NOT NULL AUTO_INCREMENT,
                        `SEAT_NO` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                        `SALES_NO` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                        `SEQ` int(3) NOT NULL,
                        `ITEM_ID` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                        `ITEM_NM` varchar(30) NOT NULL,
                        `ITEM_QTY` int(11) NOT NULL,
                        `ITEM_PRICE` double NOT NULL,
                        `ORDER_DATE` datetime NOT NULL,
                        `GENDER_FLG` varchar(1) NOT NULL COMMENT '0 = Male, 1 = Female, 3 = All',
                        `CHECK_FLG` varchar(1) NOT NULL DEFAULT '0' COMMENT '0 = No, 1 = Yes',
                        `CHECK_DATE` datetime DEFAULT NULL COMMENT 'Date check',
                        `NOTIFY_FLG` varchar(1) NOT NULL DEFAULT '0' COMMENT 'Notify Display',
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `IX_TBL_SERVICE_01` (`SEAT_NO`,`SALES_NO`,`SEQ`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
                ");
            } catch(\Exception $e) {
                $this->return_json['ref'] = $e;
                return response()->json($this->return_json);
            }
            unset($this->return_json['msg']);
            $this->return_json['error'] = 0;
        }
        return response()->json($this->return_json);
    }

    public function deleteDBSchema() {
        return;
        $this->return_json['msg'] = 'SHOP FC NO is not set';
        if(session()->exists('delete_shop')) {

            $this->configDB(session()->get('delete_shop'));

            try{
                DB::statement('DROP DATABASE IF EXISTS `shop_'.session()->get('delete_shop').'`');
            } catch(\Exception $e) {
                $this->return_json['ref'] = $e;
                return response()->json($this->return_json);
            }
            unset($this->return_json['msg']);
            $this->return_json['error'] = 0;
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
