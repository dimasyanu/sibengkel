<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ServiceController extends Controller {

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
		
		$rules = array(
			'name',
			'description',
			'icon',
			'id'
		);

		$items = Service::select($rules)->get();

		$results = array();
		foreach ($items as $key => $item)
			foreach ($item['original'] as $column => $value)
				$results[$item['original']['id']][$column] = $value;

		$data 					= array();
		$data['results'] 		= $results;
		$data['items'] 		= $items;
		$data['menu_title']		= 'Service';
		$data['columns']		= $rules;

		$worksheet = View::make('tasks/index', $data)->render();
		return response()->json(array('worksheet' => $worksheet), 200);
	}

	public function show($id) {
		
		$rules = array(
			'name',
			'description',
			'icon',
			'id'
		);

		$item = Service::select($rules)
						->where('id', '=', $id)->get();

		$data 					= array();
		$data['item']			= $item;
		$data['columns'] 	= $rules;

		$details = View::make('tasks/service/details', $data)->render();
		return response()->json(array('details'=> $details), 200);
	}

	public function create() {

		$rules = array(
			'name',
			'description',
			'icon',
			'id'
		);

		$data 					= array();
		$data['columns']    	= $rules;
		$data['id']             = 0;
		$data['menu']           = 'category';
		$data['categories']		= Service::select($rules)->get();


		$form   = View::make('tasks/service/create', $data)->render();
		return response()->json(array('form'=> $form), 200);
	}

	public function store(Request $request) {

		$rules = array(
			'name',
			'description',
			'icon'
		);

		$data = array();
		foreach ($rules as $key => $column) {
			$data[$column] = $request->input($column);
		}

		Service::insert($data);

		return $this->index();
	}

	public function edit($id) {
		$rules = array(
			'name',
			'description',
			'icon'
		);

		$url	= $this->url . '/edit' . '/' . $id;
		$item 	= Service::select($rules)
						->where('id', '=', $id)->get();

		$data					= array();
		$data['columns']    	= $rules;
		$data['item']			= $item;
		$data['id']             = $id;
		$data['url']			= $url;

		$details   = View::make('tasks/service/edit', $data)->render();
		return response()->json(array('details'=> $details), 200);
	}

	public function update(Request $request, $id) {
		$rules = array(
			'name',
			'description',
			'icon'
		);

		$data = array();
		foreach ($rules as $key => $column) {
			$data[$column] = $request->input($column);
		}

		Service::where('id', '=', $id)->update($data);
		return $this->index();
	}

	public function alert($id) {

		$item 	= Service::select('name')
						->where('id', '=', $id)->get();

		$data		 	= array();
		$data['id']     = $id;
		$data['name']   = $item[0]['name'];
		$data['menu']	= 'service';
		$alert          = View::make('tasks/delete', $data)->render();
		return response()->json(array('alert'=> $alert), 200);
	}

	public function destroy($id) {
		Service::where('id', '=', $id)->delete();
		return $this->index();
	}
}