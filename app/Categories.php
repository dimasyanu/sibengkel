<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model {
    public static function getColumnList(){
        $list = array(
            'name',
            'id' 
        );
        return $list;
    }
}
