<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;

class AdminController extends Controller {
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function create(){
        return view('tasks.create');
    }
}