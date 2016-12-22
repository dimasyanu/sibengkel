<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model {
	public static function getData($menu) {
		switch($menu){
            case 'categories':
                $items = Categories::select(Categories::getColumnList())->get();
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

    public static function doCreate($menu = 'bengkel', $data) {
        if($menu == 'bengkel') $menu = 'bengkels';
        DB::table($menu)->insert($data);
    }

    public static function doUpdate($menu = 'bengkel', $id, $data) {
        if($menu == 'bengkel') $menu = 'bengkels';
        DB::table($menu)->where('id', $id)->update($data);
    }

    public static function doDelete($menu = 'bengkel', $id) {
        if($menu == 'bengkel') $menu = 'bengkels';
        DB::table($menu)->where('id', $id)->delete();
    }

    public static function getDetails($menu = 'bengkel', $id) {
        switch($menu){
            case 'categories':
                $items = Categories::select(Categories::getColumnList())->where('id', '=', $id)->get();
                break;
            case 'users':
                $items = User::select(User::getColumnList())->where('id', '=', $id)->get();
                break;
            case 'bengkel':
                $items = Bengkel::select(Bengkel::getColumnList())->where('id', '=', $id)->get();
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
