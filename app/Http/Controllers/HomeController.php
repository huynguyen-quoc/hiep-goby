<?php

namespace App\Http\Controllers;
use App\models\ArtistType;
use App\models\SiteOptions;
use View;
use DB;

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


        //get image partner
        $partner = DB::select('call SP_PARTNER_IMAGE(?);', array(20));
        $partner = json_decode(json_encode($partner), true);
        return View::make('pages.home', ['artistTypes' => $artistTypes, 'artistHot' => $artistHot, 'partners' => $partner]);
    }
}
