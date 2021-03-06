<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class CategoryController extends Controller {

	private $menu = 'Category';
	private $url = '/sibengkel/public/admin/category';

	public function crud(Request $request, $action, $id) {
		if($action == 'create') {
			if($request->isMethod('post'))  return $this->store($request);
			else                            return $this->create($request);
		}
		else if($action == 'edit') {
			if($request->isMethod('post'))  return $this->update($request, $id);
			else                            return $this->edit($id);
		}
		else if($action == 'delete') {
			if($request->isMethod('post'))  return $this->destroy($id);
			else                            return $this->alert($id);
		}
		else                                return $this->show($id);
	}

	public function index() {
		$rules = array(
			'name',
			'alias',
			'icon',
			'id',
		);

		$items = Category::select($rules)->get();

		$results = array();
		foreach ($items as $key => $item)
			foreach ($item['original'] as $column => $value)
				$results[$item['original']['id']][$column] = $value;

		$data 					= array();
		$data['results'] 		= $results;
		$data['menu_title']		= 'Category';
		$data['columns'] 		= $rules;

		$worksheet = View::make('tasks/index', $data)->render();
		return response()->json(array('worksheet' => $worksheet), 200);
	}

	public function show($id) {
		$rules = array(
			'name',
			'alias',
			'icon',
			'id',
		);

		$item = Category::select($rules)
						->where('id', '=', $id)->get();

		$data 				= array();
		$data['item']		= $item;
		$data['columns'] 	= $rules;

		$details = View::make('tasks/category/details', $data)->render();
		return response()->json(array('details'=> $details), 200);
	}

	public function create() {
		$rules = array(
			'name',
			'alias',
			'icon',
			'id'
		);

		$data 					= array();
		$data['columns']    	= $rules;
		$data['id']             = 0;
		$data['menu']           = 'category';
		$data['categories']		= Category::select($rules)->get();


		$form   = View::make('tasks/category/create', $data)->render();
		return response()->json(array('form'=> $form), 200);
	}

	public function store(Request $request) {
		$rules = array(
			'name',
			'alias',
			'icon'
		);

		$data = array();
		foreach ($rules as $key => $column) 
			$data[$column] = $request->input($column);

		Category::insert($data);
		return $this->index();
	}

	public function edit($id) {
		$rules = array(
			'name',
			'alias',
			'icon',
			'id'
		);
		$url	= $this->url . '/edit' . '/' . $id;
		$item 	= Category::select($rules)
						->where('id', '=', $id)->get();

		$data					= array();
		$data['columns']    	= $rules;
		$data['item']			= $item;
		$data['id']             = $id;
		$data['menu']			= 'category';
		$data['url']			= $url;

		$details   = View::make('tasks/category/edit', $data)->render();
		return response()->json(array('details'=> $details), 200);
	}

	public function update(Request $request, $id) {
		$rules = array(
			'name',
			'alias',
			'icon'
		);

		$data = array();
		foreach ($rules as $key => $column) {
			if($column != 'id')
				$data[$column] = $request->input($column);
		}

		Category::where('id', '=', $id)->update($data);
		return $this->index();
	}

	public function alert($id) {

		$item 	= Category::select('name')
						->where('id', '=', $id)->get();

		$data		 	= array();
		$data['id']     = $id;
		$data['name']   = $item[0]['name'];
		$data['menu']	= 'category';
		$alert          = View::make('tasks/delete', $data)->render();
		$footer         = View::make('tasks/modal_footer/footer_delete')->render();
		return response()->json(array('alert'=> $alert, 'footer' => $footer), 200);
	}

	public function destroy($id) {
		Category::where('id', '=', $id)->delete();
		return $this->index();
	}
}