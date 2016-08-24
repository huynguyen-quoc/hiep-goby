<?php

namespace App\Http\Controllers;
use View;
use DB;

class ArtistsController extends Controller
{
    public function index(){
        $filter = ["A", "B", "C", "D", "E", "F", "G", "H", "Y", "G", "K", "L", "M" ,"N", "O", "P", "Q", "S", "T", "U", "V", "W", "X", "Y" ,"Z"];
        return View::make('pages.artists', [ "artistFilter" => $filter ] );
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
