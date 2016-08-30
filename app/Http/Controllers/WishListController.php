<?php

namespace App\Http\Controllers;
use Log;
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

    public function create(){
        //Get all the data and store it inside Store Variable
        $data = \Input::all();

        //Validation rules
        $rules = array (
            'customer_name' => 'required',
            'event_name' => 'required',
            'email_address' => 'required|email',
            'event_time' => 'required|date_format:d/m/Y H:i A',
            'event_location' => 'required',
            'phone_number'=>'required'
        );

        //Validate data
        $validator = \Validator::make ($data, $rules);

        //If everything is correct than run passes.
        if ($validator -> passes()){
            Log::info('**************** INSERT WISH LIST  DATA ********************');
           // $eventName =  \Input::
            DB::beginTransaction();

            try {
                DB::statement("call SP_EVENTS_INSERT(?, ?, ?)" ,array( $data['event_name'], $data['event_time'], $data['extra_information']));
                $eventId = DB::select('SELECT LAST_INSERT_ID() AS ID');
                $id = reset($eventId)->ID;
                DB::statement("call S_INSERT_CUSTOMER(?, ?, ?)" ,array( $data['customer_name'], $data['phone_number'], $data['email_address']));
                $customerId = DB::select('SELECT LAST_INSERT_ID() AS ID');
                $custId = reset($customerId)->ID;
                DB::statement("call S_INSERT_EVENT_CUSTOMER(?, ?)" ,array($custId, $id));
                foreach (Cart::content() as $row) {
                    DB::statement("call S_INSERT_EVENT_ARTIST(?, ?)" ,array($id, $row->id));
                }
                DB::commit();
                Log::info(' INSERT SUCCESS WITH EVENT ID '.$id);
                Log::info('**************** END WISH LIST DATA ********************');
                return \Redirect::route('quan-tam')
                    ->with('message', 'Thông tin của bạn đã được gửi đi. Chúng tôi sẽ liên hệ trong thời gian ngắn nh');



                // all good
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('[ERROR]'. $e);
                Log::info('**************** END WISH LIST DATA ********************');
                return \Redirect::route('quan-tam')
                    ->with('errors', ['Có lỗi xảy ra vui lòng thử lại sau.']);

            }


            //return View::make('contact');
        }else{
            //return contact form with errors
            return \Redirect::route('quan-tam')
                ->with('errors', [$validator->getMessageBag()]);

        }

    }
}
