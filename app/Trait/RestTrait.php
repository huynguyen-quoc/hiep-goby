<?php
/**
 * Created by PhpStorm.
 * User: huynguyen
 * Date: 8/25/16
 * Time: 12:02 PM
 */
namespace App\Traits;

use Illuminate\Http\Request;

trait RestTrait
{

    /**
     * Determines if request is an api call.
     *
     * If the request URI contains '/api/v'.
     *
     * @param Request $request
     * @return bool
     */
    protected function isApiCall(Request $request)
    {
        return strpos($request->getUri(), '/api/v') !== false;
    }

}