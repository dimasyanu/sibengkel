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

    public function __construct() {

    }

    public function index(Request $request, $menu = 'bengkel') {
        $items      = Admin::getData($menu);
        $tables     = Admin::getTableList($menu);
        $columnList = Admin::getColumnList($menu);
        $menuKeys   = array();

        foreach ($tables as $key => $table) {
            array_push($menuKeys, strtolower($table));
        }
        
        $data = array();
        $data['items'] = $items;
        $data['tables'] = $tables;
        $data['menu'] = $menu;
        $data['menu_lower'] = $menuKeys;
        $data['column_list'] = $columnList;

        if ($request->isMethod('get'))      return $this->loadIndex($menu, $data);
        else if($request->isMethod('post')) return $this->reloadIndex($menu, $data);
        else                                return View::make('admin', $data);
    }
    public function loadIndex($menu, $data) {
        return View::make('admin', $data);
    }

    public function reloadIndex($menu, $data) {
        $worksheet = View::make('tasks/index', $data)->render();
        return response()->json(array('worksheet' => $worksheet), 200);
    }


    public function crud(Request $request, $menu = 'bengkel', $action, $id) {
        if($action == 'create') {
            if($request->isMethod('post'))  return $this->store(); 
            else                            return $this->create($menu);
        }
        else if($action == 'edit') {
            if($request->isMethod('post'))  return $this->update(); 
            else                            return $this->edit($menu, $id);
        }
        else if($action == 'delete') {
            if($request->isMethod('post'))  return $this->destroy(); 
            else                            return $this->destroyAlert($menu, $id);
        }
        else                                return $this->show($menu, $id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($menu) {
        $tables     = Admin::getTableList($menu);
        $columnList = Admin::getColumnList($menu);
        $menuKeys   = array();

        foreach ($tables as $key => $table) 
            array_push($menuKeys, strtolower($table));

        $data = array();
        $data['menu_lower']     = $menuKeys;
        $data['column_list']    = $columnList;

        $form   = View::make('tasks/create', $data)->render();
        $footer = View::make('tasks/modal_footer/footer_create')->render();
        return response()->json(array('form'=> $form, 'footer'=>$footer), 200);
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
    public function show($menu = 'bengkel', $id) {
        $items      = Admin::getDetails($menu, $id);
        $tables     = Admin::getTableList($menu);
        $columnList = Admin::getColumnList($menu);
        $menuKeys   = array();

        foreach ($tables as $key => $table) 
            array_push($menuKeys, strtolower($table));

        $data = array();
        $data['menu_lower']     = $menuKeys;
        $data['column_list']    = $columnList;
        $data['items']          = $items;

        $details = View::make('tasks/details', $data)->render();
        $footer = View::make('tasks/modal_footer/footer_details')->render();
        return response()->json(array('details'=> $details, 'footer' => $footer), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($menu = 'bengkel', $id) {
        $items      = Admin::getDetails($menu, $id);
        $tables     = Admin::getTableList($menu);
        $columnList = Admin::getColumnList($menu);
        $menuKeys   = array();

        foreach ($tables as $key => $table) 
            array_push($menuKeys, strtolower($table));

        $data = array();
        $data['menu_lower']     = $menuKeys;
        $data['column_list']    = $columnList;
        $data['items']          = $items;

        $details = View::make('tasks/edit', $data)->render();
        $footer = View::make('tasks/modal_footer/footer_edit')->render();
        return response()->json(array('details'=> $details, 'footer' => $footer), 200);
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
    public function destroyAlert($menu, $id) {
        $items          = Admin::getDetails($menu, $id);
        $data['item']  = $items;
        $alert        = View::make('tasks/delete', $data)->render();
        $footer = View::make('tasks/modal_footer/footer_delete')->render();
        return response()->json(array('alert'=> $alert, 'footer' => $footer), 200);
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