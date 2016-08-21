<?php

namespace App\Http\Controllers;
use View;

class WishListController extends Controller
{
    public  function  index(){
        return View::make('pages.wishlist');
    }
}
