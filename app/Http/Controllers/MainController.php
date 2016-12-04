<?php

namespace App\Http\Controllers;

use App\User;
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
        Mapper::map(-7.7884403, 110.3681616);
        Mapper::marker(-7.7884403, 110.3681616, ['draggable' => true, 'eventClick' => 'console.log("left click");']);
        return view('main');
    }
}