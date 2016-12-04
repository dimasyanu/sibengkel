<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

class MapController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function showMap($id){
        return Mapper::map(53.381128999999990000, -1.470085000000040000);
    }
}