<?php

namespace App\Http\Controllers;

use App\Bengkel;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class BengkelController extends Controller {

	private $menu = 'Bengkel';
	private $url = '/sibengkel/public/admin/bengkel';

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

		$items = Bengkel::select($this->getCollumnList())->get();

		$data 					= array();
		$data['items'] 			= $items;
		$data['menu'] 			= $this->menu;
		$data['column_list'] 	= $this->getCollumnList();

		$worksheet = View::make('tasks/index', $data)->render();
		return response()->json(array('worksheet' => $worksheet), 200);
	}

	public function show($id) {

		$item = Bengkel::select($this->getCollumnList())
						->where('id', '=', $id)->get();

		$data 					= array();
		$data['item']			= $item;
		$data['column_list'] 	= $this->getCollumnList();

		$details = View::make('tasks/details', $data)->render();
		$footer = View::make('tasks/modal_footer/footer_details')->render();
		return response()->json(array('details'=> $details, 'footer' => $footer), 200);
	}

	public function create() {

		$data 					= array();
		$data['column_list']    = $this->getCollumnList();
		$data['id']             = 0;
		$data['menu']           = 'bengkel';
		$data['bengkels']		= Bengkel::select($this->getCollumnList())->get();


		$form   = View::make('tasks/create', $data)->render();
		$footer = View::make('tasks/modal_footer/footer_create')->render();
		return response()->json(array('form'=> $form, 'footer'=>$footer), 200);
	}

	public function store(Request $request) {
		$data = array();
		foreach ($this->getCollumnList() as $key => $column) {
			if($column != 'id')
				$data[$column] = $request->input($column);
		}

		Bengkel::insert($data);
		return $this->index();
	}

	public function edit($id) {

		$url	= $this->url . '/edit' . '/' . $id;
		$item 	= Bengkel::select($this->getCollumnList())
						->where('id', '=', $id)->get();

		$categories = Category::select('id', 'name', 'icon')->get();
		$cat_icon = Category::select('icon')->where('id', '=', $id)->get();

		$data					= array();
		$data['column_list']    = $this->getCollumnList();
		$data['item']			= $item;
		$data['id']             = $id;
		$data['menu']			= 'bengkel';
		$data['categories']		= $categories;
		$data['cat_icon']		= $cat_icon[0]['original']['icon'];
		$data['action_title']	= 'Edit';
		$data['name']			= $item['0']['original']['name'];
		$data['url']			= $url;

		$details = View::make('tasks/create_bengkel', $data)->render();
		return response()->json(array('details'=> $details, 'menu' => 'bengkel'), 200);
	}

	public function update(Request $request, $id) {
		$data = array();
		foreach ($this->getCollumnList() as $key => $column) {
			if($column != 'id')
				$data[$column] = $request->input($column);
		}

		Bengkel::where('id', '=', $id)->update($data);
		return $this->index();
	}

	public function alert($id) {

		$item 	= Bengkel::select($this->getCollumnList())
						->where('id', '=', $id)->get();

		$data		 	= array();
		$data['id']     = $id;
		$data['item']   = $item;
		$alert          = View::make('tasks/delete', $data)->render();
		$footer         = View::make('tasks/modal_footer/footer_delete')->render();
		return response()->json(array('alert'=> $alert, 'footer' => $footer), 200);
	}

	public function destroy($id) {
		Bengkel::where('id', '=', $id)->delete();
		return $this->index();
	}

	public function getCollumnList() {
		$columns = array(
			'name',
			'cat_id',
			'pictures',
			'lat',
			'lng',
			'id'
		);
		return $columns;
	}
}