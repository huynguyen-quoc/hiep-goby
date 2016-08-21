<?php

namespace App\Http\Controllers;
use View;

class ArtistsController extends Controller
{
    public function index(){
        $filter = ["A", "B", "C", "D", "E", "F", "G", "H", "Y", "G", "K", "L", "M" ,"N", "O", "P", "Q", "S", "T", "U", "V", "W", "X", "Y" ,"Z"];
        return View::make('pages.artists', [ "artistFilter" => $filter ] );
    }

    public function detail($slug = ''){

        return View::make('pages.artist');
    }
}
