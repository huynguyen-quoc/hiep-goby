<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;
use DB;

class ImageController extends Controller
{
    public function getImagePreview(Request $request , $slug = ''){
       // $headers = $request->header('content-type');
        if (!$request->wantsJson() || empty($slug)) {
            abort(400, 'Invalid Request');
        }
        //get artist hot
        $images = DB::select('call SP_GET_IMAGE_PREVIEW(?);', array($slug));

        $images = json_decode(json_encode($images), true);
        return (new Response($images, 200));
    }

}
