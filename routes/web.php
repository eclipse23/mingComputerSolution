<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\HotDealsController;
use App\Http\Controllers\InvenoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DesclaimerController;
use App\Http\Controllers\NewArrivalController;
use App\Http\Controllers\ProductViewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\LoginRedirectController;
use App\Http\Controllers\OnlinePaymentController;
use App\Http\Controllers\RecommendationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login-redirect', [LoginRedirectController::class, 'login'])->middleware(['auth']);

Route::get('/dashboard', function () {
        return view('dashboard');
})->middleware(['auth'])->name('dashboard');

//USER
Route::get('/settings', function () {
    return view('settings');
})->middleware(['auth'])->name('settings');
Route::get('/change-password', function () {
    return view('change-password');
})->middleware(['auth'])->name('change-password');
Route::get('/my-data', [UserController::class, 'myData'])->middleware(['auth']);
Route::post('/update-data', [UserController::class, 'update'])->middleware(['auth']);
Route::post('/user-change-password', [UserController::class, 'changePassword'])->middleware(['auth']);
Route::get('/user-registration', [UserController::class, 'registration']);

//CATEGORIES
Route::get('/administrator/categories', function () {
    return view('backend.categories');
})->middleware(['auth'])->name('admin-categories');
Route::get('/category-selection', [CategoriesController::class, 'selection']);
Route::post('/category', [CategoriesController::class, 'store'])->middleware(['auth']);
Route::get('/get-categories', [CategoriesController::class, 'getCategories'])->middleware(['auth']);
Route::delete('/{category}/category', [CategoriesController::class, 'destroy'])->middleware(['auth']);
Route::put('/category/{category}', [CategoriesController::class, 'update'])->middleware(['auth']);

//PRODUCTS
Route::get('/administrator/products', function () {
    return view('backend.products');
})->middleware(['auth'])->name('admin-products');
Route::get('/get-products', [ProductController::class, 'getProducts'])->middleware(['auth']);
Route::post('/product', [ProductController::class, 'store'])->middleware(['auth']);
Route::put('/product/{product}', [ProductController::class, 'update'])->middleware(['auth']);
Route::put('/update-stock/{product}', [ProductController::class, 'updateStock'])->middleware(['auth']);

//PRODUCT VIEW
Route::get('/products/all-products', [ProductViewController::class, 'products'])->name('products');
Route::get('/products/hot-deals', [ProductViewController::class, 'hotDeals'])->name('hot-deals');
Route::get('/products/new-arrivals', [ProductViewController::class, 'newArrivals'])->name('new-arrivals');
Route::get('/products-list', [ProductViewController::class, 'list']);
Route::get('/product/{product}', [ProductViewController::class, 'show']);
Route::get('/product-stock/{product}', [ProductViewController::class, 'stock']);

//CART
Route::get('/cart-items', [CartController::class, 'list'])->middleware(['auth'])->name('cart');
Route::post('/add-to-cart', [CartController::class, 'store'])->middleware(['auth']);
Route::get('/my-cart', [CartController::class, 'myCart'])->middleware(['auth']);
Route::get('/my-cart-checkout', [CartController::class, 'myCartCheckout'])->middleware(['auth']);
Route::delete('/{cartItem}/my-cart', [CartController::class, 'destroyItem'])->middleware(['auth']);
Route::post('/update-quantity', [CartController::class, 'addQuantity'])->middleware(['auth']);

//MESSAGE
Route::get('/messages', [MessageController::class, 'list'])->middleware(['auth'])->name('messages');
Route::get('/administrator/messages', [MessageController::class, 'adminList'])->middleware(['auth'])->name('admin-messages');
Route::post('/message', [MessageController::class, 'store'])->middleware(['auth']);
Route::post('/reply-message', [MessageController::class, 'storeReply'])->middleware(['auth']);
Route::get('/admin-inquires', [MessageController::class, 'adminInquires'])->middleware(['auth']);
Route::get('/customer-inquires', [MessageController::class, 'customerInquires'])->middleware(['auth']);
Route::put('/seen-inquire/{inquire}', [MessageController::class, 'seenInquire'])->middleware(['auth']);

//PRODUCT IMAGE
Route::put('/product-image-delete/{product}', [ProductImageController::class, 'destroy'])->middleware(['auth']);
Route::post('/product-image-update', [ProductImageController::class, 'update'])->middleware(['auth']);

//LANDING PAGE
Route::get('/hot-deals', [HotDealsController::class, 'heroData']);
Route::get('/new-arrival', [NewArrivalController::class, 'heroData']);

//ORDERS
Route::get('/administrator/orders', [OrderController::class, 'list'])->middleware(['auth'])->name('admin-orders');
Route::get('/all-orders', [OrderController::class, 'allOrders'])->middleware(['auth']);
Route::get('/orders', [OrderController::class, 'customerOrdersView'])->middleware(['auth'])->name('frontend-orders');
Route::put('/cart-change-status/{cart}', [OrderController::class, 'cartChangeStatus'])->middleware(['auth']);
Route::get('/cancel-order/{cart}', [OrderController::class, 'cancelOrder'])->middleware(['auth']);
Route::get('/get-pending-orders', [OrderController::class, 'pendingOrders'])->middleware(['auth']);
Route::get('/customer-orders', [OrderController::class, 'customerOrders'])->middleware(['auth']);

//REVIEWS
Route::post('/review', [ReviewsController::class, 'store'])->middleware(['auth']);
Route::get('/has-review', [ReviewsController::class, 'checkHasReview'])->middleware(['auth']);
Route::get('/product-reviews', [ReviewsController::class, 'list']);
Route::get('/reviews/{product}', [ReviewsController::class, 'productReview']);

//CASHIER
Route::post('/cashier-checkout', [CashierController::class, 'checkout'])->middleware(['auth']);
Route::get('/receipt/{cart}', [CashierController::class, 'receipt'])->middleware(['auth']);
Route::get('/administrator/cashier', function () {
    return view('backend.cashier');
})->middleware(['auth'])->name('cashier');

//REPORTS
Route::get('/reports', function () {
    return view('backend.reports');
})->middleware(['auth'])->name('reports');
Route::get('/get-reports', [ReportsController::class, 'list'])->middleware(['auth']);

//RECOMMENDATION
Route::post('/add-recommendation', [RecommendationController::class, 'store'])->middleware(['auth']);
Route::get('/recommendations', [RecommendationController::class, 'heroData'])->middleware(['auth']);

//PRINT
Route::get('/print-daily/{date}', [PrintController::class, 'dateReport'])->middleware(['auth']);
Route::get('/print-monthly/{month}/{year}', [PrintController::class, 'monthReport'])->middleware(['auth']);
Route::get('/print-yearly/{year}', [PrintController::class, 'yearReport'])->middleware(['auth']);

//ONLINE PAYMENT
Route::get('/user/setup-intent', [OnlinePaymentController::class, 'getSetupIntent'])->middleware(['auth']);
Route::post('/my-cart-checkout-mastercard', [OnlinePaymentController::class, 'checkout'])->middleware(['auth']);

//INVENTORY REPORT
Route::get('/inventory', function () {
    return view('backend.inventory');
})->middleware(['auth'])->name('inventory');
Route::get('/inventory-products', [InvenoryController::class, 'getProducts'])->middleware(['auth']);
Route::get('/inventory-print', [InvenoryController::class, 'print'])->middleware(['auth']);

//NOTIFICATIONS
Route::get('/get-notification', [NotificationController::class, 'getNotification'])->middleware(['auth']);
Route::get('/seen-order', [NotificationController::class, 'seenOrder'])->middleware(['auth']);
Route::get('/seen-message', [NotificationController::class, 'seenMessage'])->middleware(['auth']);

//EPAYMENT LOG
Route::get('online-payment', [OnlinePaymentController::class, 'logs'])->middleware(['auth'])->name('e-payment-logs');

//LOCATION
Route::get('get-city', [LocationController::class, 'city']);
Route::get('get-barangay', [LocationController::class, 'brgy']);

//DESCLAIMER
Route::get('disclaimer', [DesclaimerController::class, 'index']);

require __DIR__.'/auth.php';
