<?php

namespace App\Http\Controllers;
use View;
use PulkitJalan\Google\Facades\Google;
use PulkitJalan\Google\Client;
use DB;
class ContactController extends Controller
{
    public  function  index(){

        return View::make('pages.contact');
    }


}
