<?php
namespace App\Http\Controllers\Cart; 
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.cart'); 
    }
    // public function updateQuantity(Request $request)
    // {
    //     $cart = Cart::findOrFail($request->cart_id);

    //     if ($request->type == 'plus') {

    //         $cart->quantity++;

    //     } else {

    //         if ($cart->quantity > 1) {

    //             $cart->quantity--;

    //         }

    //     }

    //     $cart->save();

    //     return response()->json([

    //         'status' => true,

    //         'qty' => $cart->quantity,

    //         'total' => $cart->quantity * $cart->price

    //     ]);
    // }
}

?>