<?php

namespace App\Http\Controllers;
use View;

class AboutController extends Controller
{
    public  function  index(){
        return View::make('pages.about');
    }
}
