<?php

namespace App\Http\Controllers;
use View;

class ContactController extends Controller
{
    public  function  index(){
        return View::make('pages.contact', ['longitude' => "21.0278" , 'latitude' => "105.8342"]);
    }
}
