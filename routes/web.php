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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//the same route than the single one but with a group to handle more easy the namespace

Route::middleware('auth')->namespace('Admin\\')->group(function () {
    Route::post('admin/posts', 'PostController@store');
    Route::put('admin/posts/{post}', 'PostController@update');
});

//Route::put('admin/posts/{post}', 'Admin\PostController@update')->middleware('auth');

//good way to handle gates on middlewares with routes

// Route::put('admin/posts/{post}', function (Request $request, Post $post) {


//     //other ways less recommended to use gates

//     //with guest helper
//     // if (auth()->guest()) {
//     //     return abort(401);
//     // }

//     // //with cant helper
//     // if (auth()->user()->cant('update', $post)) {
//     //     return abort(403);
//     // }

//     // //directly from gate denies method
//     // if (Gate::denies('update', $post)) {
//     //     abort(403);
//     // }

//     //the best way to handle your gates and policies is
//     //in routes use middleware with convention can:method,class all in lowercase





//     $post->update($request->all());
//     return 'Post Updated!';
// })->middleware('can:update,post');
