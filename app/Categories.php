<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model {
    protected $table = 'categories';
    protected $fillable = ['name'];

    public static function getColumnList(){
        $list = array(
            'name',
            'id' 
        );
        return $list;
    }
}
