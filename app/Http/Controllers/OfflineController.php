<?php

namespace App\Http\Controllers;

use App\Models\Offline;
use Illuminate\Http\Request;

class OfflineController extends Controller{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $partidasOffline=Offline::all();
        return $partidasOffline;
    }

    public function store(Request $request){
        $partidaOffline=Offline::create($request->all());
        return $partidaOffline;
    }
}

