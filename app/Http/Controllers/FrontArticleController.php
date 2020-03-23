<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FrontArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        $comments = Comment::where('article_id', $id)->get();
        if(Auth::check()){
            if (Gate::allows('Admin_ability')) {
                $separate = '<li><a href="/admin">관리자 페이지</a></li><li><a href="" id="logout">로그아웃</a></li>';
            }else{
                $separate = '<li><a href="" id="logout">로그아웃</a></li>';
            }
        }else{
            $separate = '<li><a href="/login">로그인</a></li><li><a href="/register">회원가입</a></li>';
        }
        return view('front.article.frontShow', compact('article', 'categories', 'comments','separate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
