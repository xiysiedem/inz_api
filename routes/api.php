<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(
    ['prefix' => 'v1'], function () {

    Route::group(
        ['namespace' => 'App\Auth'], function () {
        Route::resource('login', 'LoginController');
        Route::resource('register', 'RegisterController');
    });

    Route::group(
        ['namespace' => 'App\Tags', 'middleware' => 'auth:api'], function () {
        Route::resource('tags', 'TagsController');
    });
    Route::group(
        ['namespace' => 'App\Users'], function () {
        Route::resource('users', 'UsersController');
    });

    Route::group(
        ['namespace' => 'App\Entity'], function () {
        Route::resource('entity', 'EntityController');
    });

    Route::group(
        ['namespace' => 'App\Top'], function (){
            Route::resource('top', 'TopController');
    });

    Route::group(
        ['namespace' => 'App\Comments'], function(){
            Route::resource('comment', 'CommentsController');
    }
    );

    Route::group(
        ['namespace' => 'App\Messages'], function(){
        Route::resource('messages', 'MessagesController');
    }
    );

}
);
