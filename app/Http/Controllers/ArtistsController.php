<?php

namespace App\Http\Controllers;
use View;
use DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class ArtistsController extends Controller
{
    public function index(Request $request , $category = '', $letter = ''){
        $filter = ["A", "B", "C", "D", "E", "F", "G", "H", "Y", "G", "K", "L", "M" ,"N", "O", "P", "Q", "S", "T", "U", "V", "W", "X", "Y" ,"Z"];
        $page = $request->input('page');
        $pageSize = 15;
        if(!$page) {
            $page = 0 * $pageSize;
        }else{
            $page = $page * $pageSize;
        }
        //get artist hot
        $artists = DB::select('call SP_GET_ALL_ARTIST(?, ?, ?, ?);', array(str_replace('_', ',',$category), $letter, $pageSize, $page));

        $artists = json_decode(json_encode($artists), true);
        $artistFinal = [];

        foreach($artists as $artist) {
            $artistDetail = $artist;
            $artistInformation = $artistDetail['artist_information'];
            $artistInformation = json_decode($artistInformation, true);
            $artistOptions1 = DB::select('call SP_GET_OPTIONS_BY_TYPE(?);', array('ARTIST_OPTIONS_1'));
            $artistOptions1 = json_decode(json_encode($artistOptions1), true);
            $artistExtra1 = [];
            foreach ($artistOptions1 as $option) {
                $name = $option['option_value'];
                if (isset($artistInformation[$name])) {
                    $artistData = array(
                        'title' => $option['option_title'],
                        'value' => $artistInformation[$name]
                    );

                    array_push($artistExtra1, $artistData);
                }
            }
            $artistExtra2 = [];
            $artistOptions2 = DB::select('call SP_GET_OPTIONS_BY_TYPE(?);', array('ARTIST_OPTIONS_2'));
            $artistOptions2 = json_decode(json_encode($artistOptions2), true);
            foreach ($artistOptions2 as $option) {
                $name = $option['option_value'];
                if (isset($artistInformation[$name])) {
                    $artistData = array(
                        'title' => $option['option_title'],
                        'value' => $artistInformation[$name]
                    );

                    array_push($artistExtra2, $artistData);
                }
            }
            unset($artist['artist_information']);
            $artist['artist_extra_1'] = $artistExtra1;
            $artist['artist_extra_2'] = $artistExtra2;
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

        $total = DB::select('call SP_TOTAL_ARTIST(?)', array($category));
        $total = json_decode(json_encode($total), true);
        $totalPage = round((reset($total)['total']  - 1) / $pageSize);
        if ($request->wantsJson()) {
            $response = array(
                "artists" => $artistFinal,
                "total_page" => $totalPage
            );
            return (new Response($response, 200));
        }else {

            return View::make('pages.artists', ["artistFilter" => $filter, 'artists' => $artistFinal, 'totalPage' => $totalPage]);
        }
    }

    public function detail($slug = ''){
        //get artist hot
        $artistDetail = DB::select('call SP_GETARTIST(?);', array($slug));

        $artistDetail = json_decode(json_encode($artistDetail), true);


        //get image partner
        $fileArtist = DB::select('call SP_GET_FILE_ARTIST(?);', array($slug));
        $fileArtist = json_decode(json_encode($fileArtist), true);

        $imageArtist = array_filter($fileArtist, function($value, $key){
            if(strtoupper($value['file_group_type']) == 'ARTIST_IMAGE_TYPE'){
                return $value;
            }
        }, ARRAY_FILTER_USE_BOTH);

        $videoArtist = array_filter($fileArtist, function($value, $key){
            if(strtoupper($value['file_group_type']) == 'ARTIST_VIDEO_TYPE'){
                return $value;
            }
        }, ARRAY_FILTER_USE_BOTH);
        $artistDetail = reset($artistDetail);
        $artistInformation = $artistDetail['artist_information'];
        $artistInformation = json_decode($artistInformation, true);
        $artistOptions1 =  DB::select('call SP_GET_OPTIONS_BY_TYPE(?);', array('ARTIST_OPTIONS_1'));
        $artistOptions1 = json_decode(json_encode($artistOptions1), true);
        $artistExtra1 = [];
        foreach ($artistOptions1 as $option){
            $name = $option['option_value'];
            if(isset($artistInformation[$name])){
                $artistData = array(
                    'title' => $option['option_title'],
                    'value' => $artistInformation[$name]
               );

                array_push($artistExtra1, $artistData);
            }
        }
        $artistExtra2 = [];
        $artistOptions2 =  DB::select('call SP_GET_OPTIONS_BY_TYPE(?);', array('ARTIST_OPTIONS_2'));
        $artistOptions2 = json_decode(json_encode($artistOptions2), true);
        foreach ($artistOptions2 as $option){
            $name = $option['option_value'];
            if(isset($artistInformation[$name])){
                $artistData = array(
                    'title' => $option['option_title'],
                    'value' => $artistInformation[$name]
                );

                array_push($artistExtra2, $artistData);
            }
        }
        return View::make('pages.artist', ['imageArtist' => $imageArtist, 'videoArtist' => $videoArtist, 'artistDetail' => $artistDetail,
            'artistExtra1' => $artistExtra1,
            'artistExtra2' => $artistExtra2]);
    }
}
