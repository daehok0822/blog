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

Route::get('/index', 'IndexController@index');
Route::group(['middleware' => ['auth']], function () {
    Route::resource('article', 'ArticleController');
});

Route::resource('comment', 'CommentController');

Auth::routes();



Route::get('/', 'ArticleController@frontIndex')->name('article.frontIndex');
Route::get('/view/{id}', 'ArticleController@frontShow')->name('article.frontShow');
Route::get('/article/user', 'ArticleController@userShow')->name('article.userShow');


Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');
