<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::resource('products', ProductController::class);

// Cart Routes (accessible without login — login enforced at checkout)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Order & Payment Routes (require login)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/order/place', [OrderController::class, 'place'])->name('order.place');
    Route::get('/payment', [OrderController::class, 'payment'])->name('payment');
    Route::post('/payment/process', [OrderController::class, 'processPayment'])->name('payment.process');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my.orders');
});

// Reviews (require login)
Route::middleware('auth')->group(function () {
    Route::get('/products/{product}/review', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'products' => \App\Models\Product::count(),
            'users'    => \App\Models\User::where('is_admin', false)->count(),
            'reviews'  => \App\Models\Review::count(),
            'orders'   => \App\Models\Order::count(),
            'pending'  => \App\Models\Review::where('is_approved', false)->count(),
        ];
        return view('admin.dashboard', compact('stats'));
    })->name('admin.dashboard');

    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('admin.reviews');
    Route::post('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('admin.reviews.approve');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('admin.reviews.delete');
});

// Dashboard redirect after login
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard');

require __DIR__.'/auth.php';
