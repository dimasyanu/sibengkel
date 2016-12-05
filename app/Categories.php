<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model {
    public static function getColumnList(){
        $list = array(
            'id', 
            'name'
        );
        return $list;
    }
}
