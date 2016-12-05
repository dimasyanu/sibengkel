<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bengkel extends Model {
    public static function getColumnList(){
        $list = array(
            'id', 
            'name', 
            'categories',
            'pictures'
        );
        return $list;
    }
}
