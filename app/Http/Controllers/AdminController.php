<?php


namespace App\Http\Controllers;

use App\User;
use App\Admin;
use App\Bengkel;
use App\Categories;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CategoryController;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class AdminController extends Controller {

	public $url = '/sibengkel/public/admin';

	// Load data
	public function loadData($menu) {
		// CategoryController $data = CategoryController::index();
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

		return $data;
	}
	public function getModelList() {
		$models = array(
            'Category',
            'Bengkel',
            'User'
        );
        return $models;
	}

	public function getTableList() {
		$tables = array(
            'categories',
            'bengkels',
            'users'
        );
        return $tables;
	}

	// Return worksheet view 
	public function index(Request $request, $menu = 'bengkel') {
		// $data = $this->loadData($menu);
		$data = array();
		$data['curr_menu'] = $menu;
		$data['menus'] = $this->getModelList();
		$data['tables'] = $this->getTableList();
		return View::make('admin', $data);

		// if ($request->isMethod('get'))      return $this->loadIndex($menu, $data);
		// else if($request->isMethod('post')) return $this->reloadIndex($menu, $data);
		// else                                return View::make('admin', $data);
	}
	public function loadIndex($menu, $data) {
		
	}
	public function reloadIndex($menu, $data) {
		$worksheet = View::make('tasks/index', $data)->render();
		return response()->json(array('worksheet' => $worksheet), 200);
	}

	// Handle crud operation
	public function crud(Request $request, $menu = 'bengkel', $action, $id) {

		if($action == 'create') {
			if($request->isMethod('post'))  return $this->store($request, $menu);
			else                            return $this->create($menu);
		}
		else if($action == 'edit') {
			if($request->isMethod('post'))  return $this->update($request, $menu, $id);
			else                            return $this->edit($menu, $id);
		}
		else if($action == 'delete') {
			if($request->isMethod('post'))  return $this->destroy($menu, $id);
			else                            return $this->destroyAlert($menu, $id);
		}
		else                                return $this->show($menu, $id);
	}

	// Show Modal for creating new item
	public function create($menu) {
		$tables     = Admin::getTableList($menu);
		$columnList = Admin::getColumnList($menu);
		$categoryList = Categories::select(Categories::getColumnList())->get();
		$menuKeys   = array();
		$categories = array();

		foreach ($tables as $key => $table) 
			array_push($menuKeys, strtolower($table));

		foreach ($categoryList as $key => $category) {
			$categories[$category['id']] = $category['name'];
		}

		$data = array();
		$data['menu']     = $menu;
		$data['column_list']    = $columnList;
		$data['id']             = 0;
		$data['categories']		= $categories;
		$form   = View::make('tasks/create', $data)->render();
		$footer = View::make('tasks/modal_footer/footer_create')->render();
		return response()->json(array('form'=> $form, 'footer'=>$footer), 200);
	}

	// Do create item
	public function store(Request $request, $menu) {
		$columnList = Admin::getColumnList($menu);

		$insertData = array();
		foreach ($columnList as $key => $column) {
			if($column != 'id')
				$insertData[$column] = Input::get($column);
		}
		Admin::doCreate($menu, $insertData);
		
		$data = $this->loadData($menu);
		return $this->reloadIndex($menu, $data);
	}

	// Show Modal for Details
	public function show($menu = 'bengkel', $id) {
		$item      = Admin::getDetails($menu, $id);
		$tables     = Admin::getTableList($menu);
		$columnList = Admin::getColumnList($menu);
		$menuKeys   = array();

		foreach ($tables as $key => $table) 
			array_push($menuKeys, strtolower($table));

		$data = array();
		$data['menu']           = $menu;
		$data['column_list']    = $columnList;
		$data['item']          = $item;
		$data['id']             = $id;

		$details = View::make('tasks/details', $data)->render();
		$footer = View::make('tasks/modal_footer/footer_details')->render();
		return response()->json(array('details'=> $details, 'footer' => $footer), 200);
	}

	// Show Modal for editing new item
	public function edit($menu = 'bengkel', $id) {
		$items      = Admin::getDetails($menu, $id);
		$tables     = Admin::getTableList($menu);
		$columnList = Admin::getColumnList($menu);
		$menuKeys   = array();
		$url        = $this->url . '/' . $menu . '/edit' . '/' . $id;
		foreach ($tables as $key => $table) 
			array_push($menuKeys, strtolower($table));

		$data = array();
		$data['menu']     = $menu;
		$data['column_list']    = $columnList;
		$data['items']          = $items;
		$data['id']             = $id;
		$data['url']             = $url;

		$details = View::make('tasks/edit', $data)->render();
		$footer = View::make('tasks/modal_footer/footer_edit')->render();
		return response()->json(array('details'=> $details, 'footer' => $footer), 200);
	}

	// Do update item
	public function update(Request $request, $menu, $id) {
		$columnList = Admin::getColumnList($menu);

		$insertData = array();
		foreach ($columnList as $key => $column) {
			if($column != 'id')
				$insertData[$column] = Input::get($column);
		}
		Admin::doUpdate($menu, $id, $insertData);
		
		$data = $this->loadData($menu);
		return $this->reloadIndex($menu, $data);
	}

	// Show delete alert 
	public function destroyAlert($menu, $id) {
		$items          = Admin::getDetails($menu, $id);
		$data['item']   = $items;
		$data['id']     = $id;
		$alert          = View::make('tasks/delete', $data)->render();
		$footer         = View::make('tasks/modal_footer/footer_delete')->render();
		return response()->json(array('alert'=> $alert, 'footer' => $footer), 200);
	}

	// Do delete item
	public function destroy($menu, $id) {
		Admin::doDelete($menu, $id);

		$data = $this->loadData($menu);
		return $this->reloadIndex($menu, $data);
	}
}