<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Comment;
use App\Image as ModelImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;




interface CutImage
{
    public function cut(string $image);
}
class WidthBiggerThan300 implements CutImage{
    public function cut($image)
    {
        $thumbnail_img = Image::make($image)->widen(300);
        return $thumbnail_img;
    }
}
class HeightBiggerThan300 implements CutImage{
    public function cut($image)
    {
        $thumbnail_img = Image::make($image)->heighten(300);
        return $thumbnail_img;
    }
}
class WidthAndHeightBiggerThan300 implements CutImage{
    public function cut($image)
    {
        $thumbnail_img = Image::make($image)->crop(300, 300);
        return $thumbnail_img;
    }

}
class WidthBiggerThan800 implements CutImage{
    public function cut($image)
    {
        $desc_img = Image::make($image)->widen(800);
        return $desc_img;
    }
}
class ReturnOriginalImage implements CutImage
{
    public function cut($image)
    {
        $original_image = Image::make($image);
        return $original_image;
    }
}

interface CutImageFactory{
    public function howImageCut(int $width, int $height);
}
class ThumbnailImageFactory implements CutImageFactory {
    public function howImageCut($width, $height){
        if($width > 300 || $height > 300){
            if($width > 300 && $height > 300){
                return new WidthAndHeightBiggerThan300();
            }
            if($width > 300){
               return new WidthBiggerThan300();
            }
            if ($height > 300){
                return new HeightBiggerThan300();
            }
        }else{
            return new ReturnOriginalImage();
        }
    }
}
class DescriptionImageFactory implements CutImageFactory
{
    public function howImageCut($width, $height)
    {
        if($width > 800){
            return new WidthBiggerThan800();
        }else{
            return new ReturnOriginalImage();
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




        $articleObj = Article::with(['user','image']); //
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

        $articleInfo =[
            'title' => $request->input('title'),
            'description' => $contents,
            'category_id' => $request->input('category'),
            'user_id' => Auth::id()
        ];
        $article = Article::create($articleInfo);

        $article_id = $article->id;

        preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $contents, $matches);
        $app_url = config('app.url');




        foreach ($matches[1] as $image) {

            $image_path = str_replace($app_url . '/', '', $image);
            $width = Image::make($image_path)->width();
            $height = Image::make($image_path)->height();

            $factory = new DescriptionImageFactory();
            $desc_cut = $factory->howImageCut($width,$height);
            $desc_img = $desc_cut->cut($image_path);
            $desc_img_path = $desc_img->dirname . '/' . $desc_img->filename . '_800.' . $desc_img->extension;
            $desc_img->save($desc_img_path, 100);

            $image_path = str_replace($image_path, $desc_img_path, $contents);


            if($image===$matches[1][0]){
                $factory = new ThumbnailImageFactory();
                $thumbnail_cut = $factory->howImageCut($width,$height);
                $thumbnail_img = $thumbnail_cut->cut($image_path);
                $thumbnail_img_path = $thumbnail_img->dirname  . '/' . $thumbnail_img->filename . '_300x300.' . $thumbnail_img->extension;
                $thumbnail_img->save($thumbnail_img_path, 100);

                $imageInfo =[
                    'article_id' => $article_id,
                    'original_image' => $image_path,
                    'thumbnail_image' => $thumbnail_img_path,
                    'description_image' => $desc_img_path,
                ];
                ModelImage::create($imageInfo);
            }else{
                $imageInfo =[
                    'article_id' => $article_id,
                    'original_image' => $image_path,
                    'description_image' => $desc_img_path,
                ];
                ModelImage::create($imageInfo);
            }
        }

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
