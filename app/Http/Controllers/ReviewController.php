<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $review = new Review();
        $review->product_id = $productId;
        $review->user_id = auth()->id();
        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');
        $review->save();

        return redirect()->back()->with('success', 'Thêm đánh giá thành công!');
    }

    public function index($productId)
    {
        if (!is_numeric($productId)) {
            abort(404);
        }
        $productreview = Product::with('reviews.user')->findOrFail($productId);
        dd($productId);
        return view('client/detail_product', compact('productreview'));
    }
}
