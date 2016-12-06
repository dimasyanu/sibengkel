<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model {
	public static function getData($menu) {
		switch($menu){
            case 'categories':
                $items = Categories::all();
                break;
            case 'users':
                $items = User::select(User::getColumnList())->get();
                break;
            case 'bengkel':
                $items = Bengkel::all();
                break;
        }
        return $items;
    }

    public static function getTableList($menu) {
    	$tables = array(
            'Categories',
            'Bengkel',
            'Users'
        );
        return $tables;
	}

	public static function getColumnList($menu) {
		switch($menu){
            case 'categories':
                $columnList = Categories::getColumnList();
                break;
            case 'users':
                $columnList = User::getColumnList();
                break;
            case 'bengkel':
                $columnList = Bengkel::getColumnList();
                break;
        }
        return $columnList;
	}
}
