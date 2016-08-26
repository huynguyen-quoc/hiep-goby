<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use DB;
use Illuminate\Support\Facades\Cache;
use View;
use Gloudemans\Shoppingcart\Facades\Cart;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        if(!Cache::has('site_options')) {
            Cache::remember('site_options', 15, function () {
                //get site options
                $options = DB::table('tbl_options')
                    ->where("s_name", "like", "%SITE%")
                    ->select('tbl_options.s_name as option_name', 'tbl_options.s_value as option_value')
                    ->orderBy('n_order', 'asc')
                    ->get();
                $jsonOption = [];
                foreach ($options as $option) {
                    $jsonOption[$option->option_name] = htmlentities($option->option_value, ENT_QUOTES, 'UTF-8', false);
                }
                return $jsonOption;
            });
            $jsonOption = Cache::get('site_options');
            View::share('siteOptions', $jsonOption);
        }else{
            $jsonOption = Cache::get('site_options');
            View::share('siteOptions', $jsonOption);
        }
//        $cartValue = Cart::content();
//        View::share('cart', $cartValue);

    }
}
