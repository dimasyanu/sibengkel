<?php

namespace App\Http\Controllers;

use App\User;
use App\Bengkel;
use App\Category;
use App\Service;
use App\Http\Controllers\Controller;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Illuminate\Support\Facades\DB;

class MainController extends Controller {
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function __invoke(){
        $bengkels   = Bengkel::join('categories', 'cat_id', '=', 'categories.id')
                    ->select('bengkels.id', 'bengkels.name', 'bengkels.description','bengkels.start_hour', 'bengkels.end_hour','lat', 'lng', 'categories.name as catName','categories.alias')->get();
        $icons      = Category::select('alias', 'icon')->get();
        $service_list   = Service::select('id', 'icon')->get();

        foreach ($bengkels as $key => $bengkel) {
            $services = DB::table('bengkel_services')
                        ->select('service_id')
                        ->where('bengkel_id', '=', $bengkel['id'])
                        ->get();
            $bengkel['services'] = $services;
        }

        $data['bengkels'] = $bengkels;
        $data['categories'] = $icons;
        $data['service_list'] = $service_list;

        return view('main', $data);
    }
}