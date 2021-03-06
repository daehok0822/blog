<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Comment;
use App\Http\Requests\StoreBlogArticle;
use App\Http\Requests\StoreBlogArticleModify;
use App\Http\Requests\StoreBlogArticleDelete;
use App\Image as ModelImage;
use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
    private $allowed_ext = ['doc', 'docx', 'png', 'pdf', 'jpg', 'jpeg', 'gif', 'hwp', 'ppt', 'pptx', 'xls', 'xlsx'];
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit']]);
    }


    public function index(Request $request)
    {
        $searchWord = $request->input('searchWord');
        $category_id = $request->input('category_id');

        $thumbnailImage = \App\Image::select('thumbnail_image', 'article_id')->where('thumbnail_image', '!=', "''");
        $articleObj = Article::with(['user'])->leftJoinSub($thumbnailImage, 'thumbnail_image', function ($join) {
            $join->on('articles.id', '=', 'thumbnail_image.article_id');
        });


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
    public function store(StoreBlogArticle $request)
    {
        $validated = $request->validated();

        $captcha = $_POST['g-recaptcha'];
        $secretKey = '6LdaW-kUAAAAAFyuUN1xfnxlThqHvml3LGXcOpno'; // 위에서 발급 받은 "비밀 키"를 넣어줍니다.
        $ip = $_SERVER['REMOTE_ADDR']; // 옵션값으로 안 넣어도 됩니다.

        $data = array(
            'secret' => $secretKey,
            'response' => $captcha,
            'remoteip' => $ip  // ip를 안 넣을거면 여기서도 빼줘야죠
        );

        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);

        $responseKeys = json_decode($response, true);

        if ($responseKeys["success"]) {
        } else {
            exit;
        }

        $contents = $request->input('description');

        //허용되는 확장자인지
        $attachments = $request->file('attachments', []);
        foreach ($attachments as $attachment) {
            $ext = $attachment->extension();
            if (!in_array($ext, $this->allowed_ext)) {
                abort(400, '허용되지 않는 파일을 업로드했습니다.');
            }
        }
        //디비에 글 저장하기
        $articleInfo = [
            'title' => $request->input('title'),
            'description' => $contents,
            'category_id' => $request->input('category'),
            'user_id' => Auth::id()
        ];
        $article = Article::create($articleInfo);
        $article_id = $article->id;
        $date = date("Y-m" );

        //디비에 파일 저장하기
        foreach ($attachments as $attachment) {
            $filename = $attachment->store('uploads/files/'.$date);
            $originName = $attachment->getClientOriginalName();
            File::create([
                'article_id' => $article_id,
                'name' => $filename,
                'original_name' => $originName,
            ]);
        }

            preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $contents, $matches);
            $app_url = config('app.url');


            if (!empty($matches[1])) {  //본문에 사진이 포함되었을 경우
                foreach ($matches[1] as $key => $image) {
                    $image_path = str_replace($app_url . '/', '', $image);
                    $width = Image::make($image_path)->width();
                    $height = Image::make($image_path)->height();


                    $factory = new DescriptionImageFactory(); //본문이미지 크기로 저장
                    $desc_cut = $factory->howImageCut($width,$height);
                    $desc_img = $desc_cut->cut($image_path);
                    $date = date("Y-m" );
                    $desc_img_path = $desc_img->dirname . '/' . $desc_img->filename . '_800.' . $desc_img->extension;
                    $desc_img->save($desc_img_path, 100);


                    $imageInfo =[
                        'article_id' => $article_id,
                        'original_image' => $image_path,
                        'description_image' => $desc_img_path,
                    ];

                    if($key === 0) {
                        $factory = new ThumbnailImageFactory(); //썸네일 이미지 저장
                        $thumbnail_cut = $factory->howImageCut($width,$height);
                        $thumbnail_img = $thumbnail_cut->cut($image_path);
                        $thumbnail_img_path = $thumbnail_img->dirname  . '/' . $thumbnail_img->filename . '_300x300.' . $thumbnail_img->extension;
                        $thumbnail_img->save($thumbnail_img_path, 100);
                        $imageInfo['thumbnail_image'] = $thumbnail_img_path;

                    }
                    ModelImage::create($imageInfo);

                    $description = str_replace($image_path, $desc_img_path, $contents); //본문 크기 이미지로 대체
                    $article->description = $description;
                    $contents = $description;
                    $article->update();


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
        $images = \App\Image::where('article_id', $id)->get();
        $files = \App\File::where('article_id', $id)->get();


        return view('front.article.frontShow', compact('article', 'categories', 'comments', 'images', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('front.article.modify', compact('article','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBlogArticleModify $request, $id)
    {

        $article = Article::find($id);
        $article->title = $request->input('title');
        $article->description = $request->input('description');
        $article->category_id = $request->input('category');
        $article->update();
        return Redirect::route('front.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoreBlogArticleDelete $request, $id)
    {
        $validated = $request->validated();
        $article = Article::find($id);
        $article->delete();
        return Redirect::route('front.index');
    }


    public function fileDownload($id)
    {
        $file = File::findOrFail($id);
        return Storage::download($file->name, $file->original_name);

    }
}
