<?php

namespace App\Http\Controllers;
use View;

class ContactController extends Controller
{
    public  function  index(){
        return View::make('pages.contact');
    }
}
