<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IndexController extends Controller
{
    public function index(Request $request){

        $searchWord = $request->input('searchWord');
        $category_id = $request->input('category_id');

        $articleObj = Article::with('user');
        $categories = Category::all();
        if (!empty($searchWord)) {
            $articleObj->articleSearch($searchWord);
        }
        if (!empty($category_id)) {
            $articleObj->where('category_id', $category_id);
        }
        $articles = $articleObj->orderBy('id', 'DESC')->paginate(20);

        if(Auth::check()){
            if (Gate::allows('Admin_ability')) {
                $separate = '<li><a href="/admin">관리자 페이지</a></li><li><a href="/logout" id="logout">로그아웃</a></li>';
            }else{
                $separate = '<a href="" id="logout">로그아웃</a>';

            }
        }else{
            $separate = '<li><a href="/login">로그인</a></li><li><a href="/register">회원가입</a></li>';
        }

        return view('front.index', compact('articles', 'categories','separate'));
    }

}
