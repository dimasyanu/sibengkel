<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bengkel extends Model {
	protected $table = 'bengkels';
	
    public static function getColumnList(){
        $list = array(
            'name', 
            'categories',
            'pictures',
            'id'
        );
        return $list;
    }
}
