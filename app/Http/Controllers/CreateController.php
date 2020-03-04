<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateController extends Controller
{
    //
    public function create(){
        $categories1 = \App\Category::all();
        return view('create', ['categories1' => $categories1]);
    }
}
