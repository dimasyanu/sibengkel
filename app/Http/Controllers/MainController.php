<?php

namespace App\Http\Controllers;

use App\User;
use App\Bengkel;
use App\Category;
use App\Http\Controllers\Controller;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;

class MainController extends Controller {
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function __invoke(){
        // Mapper::map(-7.7884403, 110.3681616);

        // Mapper::marker(-7.8884407, 110.3681619);
        $bengkels   = Bengkel::join('categories', 'cat_id', '=', 'categories.id')
                    ->select('lat', 'lng', 'categories.alias')->get();
        $icons      = Category::select('alias', 'icon')->get();
        $data['bengkels'] = $bengkels;
        $data['categories'] = $icons;

        return view('main', $data);
    }
}