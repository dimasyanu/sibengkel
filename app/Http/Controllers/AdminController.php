<?php


namespace App\Http\Controllers;

use App\User;
use App\Admin;
use App\Bengkel;
use App\Categories;
use App\Http\Controllers\Controller;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AdminController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($menu = 'bengkel') {
        return $this->showIndex($menu);
    }
    public function showIndex($menu) {

        $items = Admin::getData($menu);

        $tables = Admin::getTableList($menu);
        
        $columnList = Admin::getColumnList($menu);

        $menuKeys = array();
        foreach ($tables as $key => $table) {
            array_push($menuKeys, strtolower($table));
        }
        
        $data = array();
        $data['items'] = $items;
        $data['tables'] = $tables;
        $data['menu'] = $menu;
        $data['menu_keys'] = $menuKeys;
        $data['column_list'] = $columnList;

    	return View::make('tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }
}