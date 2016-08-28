<?php

namespace App\Http\Controllers;
use View;
use DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function add(Request $request){
        if (!$request->wantsJson()) {
            abort(400, 'Invalid Request');
        }
        $slug = $request->input('artist_slug');
        $name = $request->input('artist_full_name');
//        $fullName = $request->input('artist_full_name');
//        $typeName = $request->input('artist_type_name');
//        $avatar = $request->input('artist_');
//        $bodyContent = $request->getContent();
        Cart::add([
            ['id' =>  $slug, 'name' => $name, 'qty' => 1, 'price'=> 0]
        ]);
        return (new Response(['total_cart' => Cart::content()->count()], 200));
    }

    public function remove(Request $request, $slug = ''){
        if (!$request->wantsJson()) {
            abort(400, 'Invalid Request');
        }
        $id = '';
        foreach(Cart::content() as $row) {
            if($row->id == $slug){
                $id = $row->rowid;
                break;
            }
        }
        Cart::remove($id);
        return (new Response(['total_cart' => Cart::content()->count()], 200));
    }

}
