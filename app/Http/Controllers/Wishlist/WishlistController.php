<?php
namespace App\Http\Controllers\Wishlist; 
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    public function index()
    {
        return view('wishlist.wishlist'); 
    }
    // public function destroy($id)
    // {
    //     $wishlist = Wishlist::findOrFail($id);

    //     $wishlist->delete();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Product removed successfully.'
    //     ]);
    // }
}

?>