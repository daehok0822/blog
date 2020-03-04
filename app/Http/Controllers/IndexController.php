<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $articles = \App\Article::all();
        $categories = \App\Category::all();
        return view('index', ['articles' => $articles, 'categories' => $categories]);
    }

}
