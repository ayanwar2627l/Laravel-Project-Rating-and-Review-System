<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Product $product)
    {
        // Check if user already reviewed
        $existingReview = Review::where('user_id', auth()->id())
                                ->where('product_id', $product->id)
                                ->first();

        return view('reviews.create', compact('product', 'existingReview'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|min:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Check if user already has a review
        $review = Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ],
            [
                'rating' => $request->rating,
                'title' => $request->title,
                'comment' => $request->comment,
                'is_verified' => $this->hasPurchasedProduct(auth()->user(), $product),
                'is_approved' => true,
            ]
        );

        if ($request->hasFile('image')) {
            $review->image = $request->file('image')->store('reviews', 'public');
            $review->save();
        }

        // Recalculate average rating
        $product->recalculateRating();

        return redirect()->route('products.show', $product)
                         ->with('success', 'Thank you! Your review has been submitted.');
    }

    private function hasPurchasedProduct($user, $product)
    {
        return $user->orders()
                    ->whereHas('items', function($query) use ($product) {
                        $query->where('product_id', $product->id);
                    })
                    ->exists();
    }
}