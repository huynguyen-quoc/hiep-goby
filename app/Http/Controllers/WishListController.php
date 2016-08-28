<?php

namespace App\Http\Controllers;
use View;
use DB;
use Gloudemans\Shoppingcart\Facades\Cart;

class WishListController extends Controller
{
    public  function  index()
    {
        $arrayId = [];
        foreach (Cart::content() as $row) {
            array_push($arrayId, $row->id);
        }
        $artistFinal = [];
        if (count($arrayId) > 0) {
            $listId = implode(",", $arrayId);
            $artists = DB::select('call SP_GET_WISHLIST_ARTIST(?);', array($listId));

            $artists = json_decode(json_encode($artists), true);

            foreach ($artists as $artist) {
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
                $artist['added_cart'] = true;
                array_push($artistFinal, $artist);
            }
        }

        return View::make('pages.wishlist', [ 'artists' => $artistFinal]);
    }
}
