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
        $artistHot = DB::table('tbl_artist')
           ->join('tbl_artist_type', 'tbl_artist.n_artist_type', '=', 'tbl_artist_type.n_id')
           ->join('tbl_artist_group', 'tbl_artist.n_id', '=', 'tbl_artist_group.n_artist_id')
           ->join('tbl_group', 'tbl_artist_group.n_group_id', '=', 'tbl_group.n_id')
           ->leftJoin('tbl_artist_image', 'tbl_artist_image.n_artist_id', '=', 'tbl_artist.n_id')
           ->leftJoin('tbl_image' , function($join)
           {
               $join->on('tbl_image.n_id', '=', 'tbl_artist_image.n_image_id');
               $join->on('tbl_image.s_type','=', DB::raw("'ARTIST_AVATAR'"));
           })
           ->select('tbl_artist.s_name as artist_name', 'tbl_artist_type.s_name as artist_type_name', 'tbl_artist.s_slug as artist_folder',
               DB::raw("CONCAT(tbl_image.s_slug, '.', tbl_image.s_extension) as artist_avatar"))
           ->where([
               ['tbl_group.s_type', '=', 'ARTIST_TYPE'],
               ['tbl_group.s_name', '=', 'HOT_ARTIST']
           ])
           ->inRandomOrder()
           ->skip(0)
           ->take(10)
           ->get();

         $artistHot = json_decode(json_encode($artistHot), true);
        //get image partner
        $partner = DB::table('tbl_image')
            ->where([
                ['tbl_image.s_type', '=', 'PARTNER_IMAGE']
            ])
            ->select('tbl_image.s_original_name as partner_name', DB::raw("CONCAT(tbl_image.s_slug, '.', tbl_image.s_extension) as partner_image"))
            ->inRandomOrder()
            ->skip(0)
            ->take(10)
            ->get();
        $partner = json_decode(json_encode($partner), true);
        return View::make('pages.home', ['artistTypes' => $artistTypes, 'artistHot' => $artistHot, 'partners' => $partner]);
    }
}
