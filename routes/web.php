<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function(){
    Route::resource('article', 'AdminArticleController');
    Route::resource('user', 'UserController');

    Route::get('/', function() { // 이게 blog.test/admin/ 이 되는 거여
        return view('admin.home');
    })->name('admin.index');
});

Route::resource('article', 'FrontArticleController');
Route::resource('comment', 'CommentController');

Auth::routes();

Route::get('/', function() { // 이게 blog.test/admin/ 이 되는 거여
    return view('front.index');
})->name('front.index');
//Route::get('/', 'ArticleController@frontIndex')->name('article.frontIndex');
//Route::get('/view/{id}', 'ArticleController@frontShow')->name('article.frontShow');


