<?php

namespace App\Http\Controllers;
use View;
use DB;
class AboutController extends Controller
{
    public  function  index(){

        $gallery = DB::select('call S_SELECT_GALLERY();');

        return View::make('pages.about',  [ 'galleries' => $gallery ]);
    }
}
