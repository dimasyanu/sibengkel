<?php

namespace App\Http\Controllers;

use App\Bengkel;
use App\Category;
use App\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

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
		$rules = array(
			'bengkels.name as name',
			'c.name as category',
			'pictures',
			'start_hour',
			'end_hour',
			'bengkels.id as id'
		);

		$columns = array(
			'name',
			'category',
			'pictures',
			'start hour',
			'end hour',
			'id'
		);

		$items = Bengkel::join('categories as c', 'cat_id', '=', 'c.id')
						->select($rules)->get();

		$results = array();
		foreach ($items as $key => $item)
			foreach ($item['original'] as $column => $value)
				$results[$item['original']['id']][$column] = $value;

		$data 					= array();
		$data['results']		= $results;
		$data['items']		= $items;
		$data['menu_title']	= 'Bengkel';
		$data['columns'] 	= $columns;

		$worksheet = View::make('tasks/index', $data)->render();
		return response()->json(array('worksheet' => $worksheet), 200);
	}

	public function show($id) {

		$rules = array(
			'bengkels.id as id',
			'bengkels.name as name',
			'c.name as category',
			'pictures',
			'description',
			'lat',
			'lng',
			'start_hour',
			'end_hour'
		);
		
		$columns = array(
			'id',
			'name',
			'category',
			'services',
			'pictures',
			'description',
			'lat',
			'lng',
			'start_hour',
			'end_hour'
		);

		$services = Service::join('bengkel_services as bs', 'services.id', '=', 'service_id')
							->select('name')
							->where('bengkel_id', '=', $id)->get();

		$item = Bengkel::join('categories as c', 'cat_id', '=', 'c.id')
						->select($rules)
						->where('bengkels.id', '=', $id)->get();

		$data 					= array();
		$data['item']			= $item;
		$data['columns'] 		= $columns;
		$data['services'] 		= $services;

		$details = View::make('tasks/bengkel/details', $data)->render();
		$footer = View::make('tasks/modal_footer/footer_details')->render();
		return response()->json(array('details'=> $details, 'footer' => $footer), 200);
	}

	public function create() {
		
		$rules = array(
			'name',
			'cat_id',
			'pictures',
			'description',
			'lat',
			'lng',
			'weekdays',
			'start_hour',
			'end_hour'
		);

		$services = Service::select('id', 'name')->get();
		$categories = Category::select('id', 'name', 'icon')->get();
		
		$data 					= array();
		$data['column_list']    = $rules;
		$data['id']             = 0;
		$data['menu']           = 'bengkel';
		$data['services']       =  $services;
		$data['categories']		= $categories;


		$form   = View::make('tasks/bengkel/create', $data)->render();
		return response()->json(array('form'=> $form, 'menu' => 'bengkel'), 200);
	}

	public function store(Request $request) {
		$data = array();
		$rules = array(
			'name',
			'cat_id',
			'pictures',
			'description',
			'lat',
			'lng',
		);

		foreach ($rules as $key => $column) 
			$data[$column] = $request->input($column);

		
		$id = Bengkel::insertGetId($data);

		if(sizeof($request->input('add_services')) > 0){
			foreach ($request->input('add_services') as $key => $serviceId) {
				$serviceData['bengkel_id'] = $id;
				$serviceData['service_id'] = $serviceId;
				DB::table('bengkel_services')->insert($serviceData);
			}
		}
		
		return $this->index();
	}

	public function edit($id) {

		$rules = array(
			'name',
			'cat_id',
			'pictures',
			'description',
			'start_hour',
			'end_hour',
			'lat',
			'lng',
		);

		$url	= $this->url . '/edit' . '/' . $id;
		$item 	= Bengkel::select($rules)
						->where('id', '=', $id)->get();

		$services = Service::select('id', 'name')->get();
		$selectedServices = Service::join('bengkel_services as bs', 'services.id', '=', 'service_id')
									->select('service_id')
									->where('bengkel_id', '=', $id)->get();
		$categories = Category::select('id', 'name', 'icon')->get();
		$cat_icon = Category::select('icon')->where('id', '=', $item[0]['original']['cat_id'])->get();

		$data					= array();
		$data['item']			= $item;
		$data['id']             = $id;
		$data['menu']			= 'bengkel';
		$data['categories']		= $categories;
		$data['services']		= $services;
		$data['services_']		= $selectedServices;
		$data['cat_icon']		= $cat_icon[0]['original']['icon'];
		$data['name']			= $item['0']['original']['name'];
		$data['url']			= $url;

		$details = View::make('tasks/bengkel/edit', $data)->render();
		return response()->json(array('details'=> $details, 'menu' => 'bengkel'), 200);
	}

	public function update(Request $request, $id) {
		$rules = array(
			'name',
			'cat_id',
			'pictures',
			'description',
			'start_hour',
			'end_hour',
			'lat',
			'lng',
		);

		$data = array();
		foreach ($rules as $key => $column) {
			$data[$column] = $request->input($column);
		}
		if(sizeof($request->input('add_services')) > 0){
			foreach ($request->input('add_services') as $key => $serviceId) {
				$serviceData['bengkel_id'] = $id;
				$serviceData['service_id'] = $serviceId;
				DB::table('bengkel_services')->insert($serviceData);
			}
		}
		if(sizeof($request->input('remove_services')) > 0){
			foreach ($request->input('remove_services') as $key => $serviceId) {
				DB::table('bengkel_services')
					->where([['bengkel_id', '=', $id], ['service_id', '=', $serviceId]])
					->delete();
			}
		}

		Bengkel::where('id', '=', $id)->update($data);
		return $this->index();
	}

	public function alert($id) {

		$result 	= Bengkel::select('name')
						->where('id', '=', $id)->get();

		$data		 	= array();
		$data['id']     = $id;
		$data['name']   = $result[0]['name'];
		$data['menu']	= 'bengkel';
		$alert          = View::make('tasks/delete', $data)->render();
		$footer         = View::make('tasks/modal_footer/footer_delete')->render();
		return response()->json(array('alert'=> $alert, 'footer' => $footer), 200);
	}

	public function destroy($id) {
		Bengkel::where('id', '=', $id)->delete();
		return $this->index();
	}
}