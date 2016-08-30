<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('/gioi-thieu', 'AboutController@index');
Route::get('/danh-sach-nghe-si/{category}/{letter}', 'ArtistsController@index');
Route::get('/nghe-si/{slug}', 'ArtistsController@detail');
Route::get('/quan-tam',  ['as' => 'quan-tam',
    'uses' => 'WishListController@index']);
Route::get('/lien-he', 'ContactController@index');
Route::post('/quan-tam','WishListController@create');
Route::get('/dang-ki-thanh-cong',  ['as' => 'dang-ki-thanh-cong',
    'uses' => 'WishListController@result']);

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'image'], function () {
        Route::get('preview/{slug}', "ImageController@getImagePreview");
    });
    Route::post('cart', "CartController@add");
    Route::delete('cart/{slug}', "CartController@remove");
});

