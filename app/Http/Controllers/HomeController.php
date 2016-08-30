<?php

namespace App\Http\Controllers;
use View;
use DB;
use Log;
use Gloudemans\Shoppingcart\Facades\Cart;
class HomeController extends Controller
{
    public function __construct(){
        parent::__construct();
    }
    public  function  index(){

        // get artist type
        $artistTypes  = DB::table('tbl_artist_type')
            ->select('tbl_artist_type.s_name as type_name', 'tbl_artist_type.s_slug as type_slug')
            ->orderBy('n_order', 'asc')
            ->get();
        $artistTypes = json_decode(json_encode($artistTypes), true);

        //get artist hot
        $artistHot = DB::select('call SP_HOTARTIST(?);', array(10));

        $artistHot = json_decode(json_encode($artistHot), true);

        $artist['added_cart'] = false;

        $artistFinal = [];

        foreach($artistHot as $artist) {
            $artistDetail = $artist;
            $slug = $artistDetail['artist_slug'];
            $artist['added_cart'] = false;
            foreach(Cart::content() as $row) {
                if($row->id == $slug){
                    $artist['added_cart'] = true;
                    break;
                }
            }
            array_push($artistFinal, $artist);
        }
        //get image partner
        $partner = DB::select('call SP_PARTNER_IMAGE(?);', array(20));
        $partner = json_decode(json_encode($partner), true);
        return View::make('pages.home', ['artistTypes' => $artistTypes, 'artistHot' => $artistFinal, 'partners' => $partner]);
    }
}
