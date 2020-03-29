<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CkeditorController extends Controller
{
    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function upload(Request $request)

    {

        if($request->hasFile('upload')) {

            $originName = $request->file('upload')->getClientOriginalName();

            $fileName = pathinfo($originName, PATHINFO_FILENAME);

            $extension = $request->file('upload')->getClientOriginalExtension();

            $thumbnailName = $fileName.'_300x300_'.time().'.'.$extension;
            $fileName = $fileName.'_'.time().'.'.$extension;

            $request->file('upload')->move(public_path('uploads'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');

            $url = asset('uploads/'.$fileName);

            $img = Image::make('uploads/'.$fileName)->crop(300, 300);
            $img->save('uploads/' . $thumbnailName, 90);
            $msg = 'Image uploaded successfully';

            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";



            @header('Content-type: text/html; charset=utf-8');

            echo $response;

        }

    }
}
