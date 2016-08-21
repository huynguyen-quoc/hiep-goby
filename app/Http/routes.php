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
Route::get('/nghe-si', 'ArtistsController@index');
Route::get('/nghe-si/{slug}', 'ArtistsController@detail');
Route::get('/quan-tam', 'WishListController@index');
Route::get('/lien-he', 'ContactController@index');
