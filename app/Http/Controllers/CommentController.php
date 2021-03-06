<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreBlogComment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //
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
    public function store(StoreBlogComment $request)
    {
        $validated = $request->validated();

        $commentInfo =[
            'nickname' => $request->input('nickname'),
            'description' => $request->input('description'),
            'password' => Hash::make($request->input('password')),
            'article_id' => $request->input('article_id'),
        ];
        Comment::create($commentInfo);
        return Redirect::route('article.show',['article'=>$request->input('article_id')]);



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
        //
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
    public function update(StoreBlogComment $request, $id)
    {
        $validated = $request->validated();
        $comment = Comment::find($id);
        if (Hash::check($request->input('password'), $comment->password)) {
            $comment->description = $request->input('description');
            $comment->update();
        }else{
            return response()->json([
                'result' => '실패',

            ]);
        }
        return response()->json([
            'result' => '성공',
            'id' => $id
        ]);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $comment = Comment::find($id);
        if (Hash::check($request->input('password'), $comment->password)) {
            $comment->delete();
        }else{
            return response()->json([
                'result' => '실패',
            ]);
        }
        return response()->json([
            'result' => '성공',
            'id' => $id
        ]);
    }
}
