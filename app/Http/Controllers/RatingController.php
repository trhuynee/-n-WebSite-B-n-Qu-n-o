<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_detail;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Cart;
use App\Models\Image;
use App\Models\Ratings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; // Import Session

class RatingController extends Controller
{
    public function getRating($product_id)
    {
        $ratings = Ratings::with('user', 'product')
            ->where('product_id', $product_id)
            ->get();

        return response()->json(['ratings' => $ratings]);
    }
    public function postRating(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'message' => 'required|string',
        ]);

        // Save the rating and comment to the database
        $rating = new Ratings();
        $rating->product_id = $request->input('product_id');
        $rating->user_id = auth()->id();
        $rating->rating = $validatedData['rating'];
        $rating->message = $validatedData['message'];
        $rating->save();

        return response()->json(['success' => true]);
    }
}
