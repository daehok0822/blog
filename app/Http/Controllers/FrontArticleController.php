<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;




interface CutImage
{
    public function cut(): int;
}
class WidthBiggerThan300 implements cutImage{
    public function cut($image): string{
        $thumbnail_img = Image::make($image)->widen(300);
        return $thumbnail_img;
    }
}
class HeightBiggerThan300 implements cutImage{
    public function cut($image): string{
        $thumbnail_img = Image::make($image)->heighten(300);
        return $thumbnail_img;
    }
}
//class WidthAndHeightBiggerThan300 implements cutImage{
//    public function cut($image): int{
//        $thumbnail_img = Image::make($image)->crop(300, 300);
//    }
//}
class WidthBiggerThan800 implements cutImage{
    public function cut($image): string{
        $des_img = Image::make($image)->widen(800);
        return $des_img;
    }
}

interface CutImageFactory{
    public function getImageSize();
}
class SimpleCutImageFactory{
    public function howImageCut($width, $height){
        if($width > 300 || $height > 300){
            if($width > 300){
               return new WidthBiggerThan300();
            }
            if ($height > 300){
                return new HeightBiggerThan300();
            }
        }else{
            return
        }
        if($width > 800){
            return new WidthBiggerThan800();
        }else{
            return
        }
    }
}

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



        return view('front.index', compact('articles', 'categories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('front.article.write', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contents = $request->input('description');

        preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $contents, $matches);
        $image = $matches[1];
        $width = Image::make($image)->width();
        $height = Image::make($image)->height();
        $factory = new SimpleCutImageFactory();
        $imagecut = $factory.howImageCut($width,$height);
        $imagecut.cut($image);



//        if($width > 300 || $height > 300){
//            if($width > 300){
//                $thumbnail_img = Image::make($matches[1])->widen(300);
//
//            }
//            if ($height > 300){
//                $thumbnail_img = Image::make($matches[1])->heighten(300);
//            }
//        }else{
//            $thumbnail_img = $image;
//        }
//        if($width > 800){
//            $des_img = Image::make($matches[1])->widen(800);
//        }else{
//            $des_img = $image;
//        }





        $articleInfo =[
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category'),
            'user_id' => Auth::id()
        ];
        Article::create($articleInfo);
        return Redirect::route('front.index');
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

        return view('front.article.frontShow', compact('article', 'categories', 'comments'));
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
