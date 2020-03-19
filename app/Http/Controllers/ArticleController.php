<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category; //이게 추가됨
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $searchWord = $request->input('searchWord');
        $articles = Article::with('user')->articleSearch($searchWord)->orderBy('id', 'DESC')->paginate(20);
        return view('article.list', compact('articles'));
    }
    public function frontIndex(Request $request)
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
                $separate = '<li><a href="/home">관리자 페이지</a></li><li><a href="/logout" id="logout">로그아웃</a></li>';
            }else{
                $separate = '<a href="" id="logout">로그아웃</a>';

            }
        }else{
            $separate = '<li><a href="/login">로그인</a></li><li><a href="/register">회원가입</a></li>';
        }

        return view('index', compact('articles', 'categories','separate'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\Category::all();
        return view('article.create', compact('categories'));
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
        $articleInfo =[
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category'),
            'user_id' => Auth::id()
        ];
        Article::create($articleInfo);
        return Redirect::route('article.index');
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
        return view('article.detail', compact('article'));

    }
    public function frontShow($id){
        $article = Article::findOrFail($id);
        $categories = Category::all();
        $comments = Comment::where('article_id', $id)->get();
        if(Auth::check()){
            if (Gate::allows('Admin_ability')) {
                $separate = '<li><a href="/home">관리자 페이지</a></li><li><a href="/logout">로그아웃</a></li>';
            }else{
                $separate = '<li><a href="/logout">로그아웃</a></li>';
            }
        }else{
            $separate = '<li><a href="/login">로그인</a></li><li><a href="/register">회원가입</a></li>';
        }
        return view('frontShow', compact('article', 'categories', 'comments','separate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('article.edit', compact('article', 'categories'));
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
        $article = Article::find($id);
        $article->title = $request->input('title');
        $article->description = $request->input('description');
        $article->category_id = $request->input('category');
        $article->update();
        return Redirect::route('article.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();
        return Redirect::route('article.index');
        //
    }
}
