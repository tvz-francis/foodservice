<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'TBL_SERVICE';
	
    public $timestamps = false;
    


    //protected $connection = 'mysql2';
    
    // public function __construct(array $attributes = array()) {
    //     parent::construct($attributes);

    //     $this->setConnection(env('DB_MODE'));
    // }

}
