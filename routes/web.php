<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintManageController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerManageController;
use App\Http\Controllers\GenrePostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderManageController;
use App\Http\Controllers\OrderManageServiceController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductManageController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ProductVariantManageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewManageController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockManageController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\WithdrawalController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Subcategory;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [SiteController::class, 'index'])->name('/');
Route::get('/ho-tro', [SiteController::class, 'support'])->name('support.site');
Route::get('/profile-site/{username}', [SiteController::class, 'profile'])->name('profile.name.site');
Route::get('/category/{slug}', [SiteController::class, 'showProductsByCategory'])->name('category.products');
Route::get('/product/{slug}', [SiteController::class, 'showProductDetail'])->name('product.detail');
Route::post('/ho-tro', [SiteController::class, 'storeSupport'])->name('support.site');
Route::get('/search', [SiteController::class, 'search'])->name('site.search');
Route::get('/bai-viet', [SiteController::class, 'post'])->name('post.site');
Route::get('/bai-viet/{slug}', [SiteController::class, 'postDetail'])->name('post.detail');
Route::get('/FAQs', [SiteController::class, 'faqs'])->name('faqs');
Route::get('/qui-dinh', [SiteController::class, 'notice'])->name('notice');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/customer/login', function () {
    return view('customer.login');
})->name('login.customer');

Route::post('/customer/login', [CustomerAuthController::class, 'login'])->name('login.customer');
Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])->name('logout.customer');

// Xử lý đăng ký
Route::post('/customer/register', [CustomerAuthController::class, 'register'])->name('register.customer');

// Đăng xuất

// Google Login
Route::get('/auth/google', [CustomerAuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [CustomerAuthController::class, 'handleGoogleCallback']);
// Add these routes to your existing route definitions
Route::get('/2fa/verify', [CustomerController::class, 'show2faVerify'])->name('2fa.verify');
Route::post('/2fa/verify', [CustomerController::class, 'verify2fa'])->name('2fa.verify.post');



Route::get('/get-subcategories/{category_id}', function ($category_id) {
    return response()->json(Subcategory::where('category_id', $category_id)->get());
});



Route::middleware('customer', '2fa')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::resource('wishlist', WishlistController::class);
    Route::resource('coupons', CouponController::class);

    Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::post('/complaints/store', [ComplaintController::class, 'store'])->name('complaints.store');


    Route::post('/messages/{receiverId}', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/create/{customerId}', [MessageController::class, 'create'])->name('messages.create');
    Route::resource('products', ProductController::class);
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order_key}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/order-details/update-status/{id}', [OrderController::class, 'updateStatus'])->name('order-details.updateStatus');
    Route::get('/change-password', [CustomerController::class, 'changePassword'])->name('customer.changePassword');
    Route::put('/update-password', [CustomerController::class, 'updatePassword'])->name('customer.updatePassword');
    Route::resource('product_variants', ProductVariantController::class);
    Route::resource('posts', PostController::class);
    Route::resource('order-manage', OrderManageController::class);
    Route::get('orders/{id}/detail', [OrderManageController::class, 'orderDetail'])->name('order-detail.show');
Route::post('order-manage/{id}/update-status', [OrderManageController::class, 'updateStatus'])->name('order-manage.update-status');
    Route::resource('order-service-manage', OrderManageServiceController::class);
    Route::post('order-service-manage/{id}/update-status', [OrderManageServiceController::class, 'updateStatus'])->name('order-service-manage.update-status');

    Route::get('/thanh-toan', [CustomerController::class, 'checkout'])->name('checkout');
    Route::prefix('product_variants/{variant}')->group(function () {
        Route::resource('stocks', StockController::class)->except(['show']);
    });

    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::get('/withdrawals/create', [WithdrawalController::class, 'create'])->name('withdrawals.create');
    Route::post('/withdrawals', [WithdrawalController::class, 'store'])->name('withdrawals.store');
    Route::get('/profile/{name}/products', [CustomerController::class, 'productCustomer'])->name('product.customer.site');

    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile.site');
    Route::get('/profile/edit', [CustomerController::class, 'profileEdit'])->name('profile.edit.site');
    Route::post('/profile/update', [CustomerController::class, 'profileUpdate'])->name('profile.update.site');
    Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])->name('logout.customer');
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard.site');

    Route::get('/deposit', [CustomerController::class, 'indexDeposit'])->name('deposit.index');
    Route::resource('complaints', ComplaintManageController::class);

    Route::resource('review-manage', ReviewManageController::class);

    // Thêm các route mới cho 2FA
    Route::post('/profile/2fa/generate', [CustomerController::class, 'generate2faSecret'])->name('2fa.generate');
    Route::post('/profile/2fa/enable', [CustomerController::class, 'enable2fa'])->name('2fa.enable');
    Route::post('/profile/2fa/disable', [CustomerController::class, 'disable2fa'])->name('2fa.disable');
    Route::post('/profile/ekyc', [CustomerController::class, 'editKYC'])->name('profile.ekyc');
});
Route::group(['middleware' => ['auth']], function () {
    Route::put('/admin/infos/update', [InfoController::class, 'update'])->name('infos.update');
    Route::get('/admin/info/edit', [InfoController::class, 'edit'])->name('infos.edit');
    Route::resource('supports', SupportController::class);
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubCategoryController::class);
    Route::resource('genre_posts', GenrePostController::class);
    Route::resource('customer-manage', CustomerManageController::class);
    Route::resource('product-manage', ProductManageController::class)
        ->parameters(['product-manage' => 'product'])
        ->except(['create', 'show']);
    Route::get('product/{product}/variants', [ProductVariantManageController::class, 'listByProduct'])
        ->name('product-variants.list');
    Route::resource('product-variant-manage', ProductVariantManageController::class)
        ->parameters(['product-variant-manage' => 'productVariant'])
        ->except(['create', 'show']);
    Route::post('/product-variant/update-type', [ProductVariantManageController::class, 'updateType'])
        ->name('product-variant-manage.updateType');
    Route::post('/customer-manage/deposit', [CustomerManageController::class, 'storeDeposit'])->name('customer-manage.storeDeposit');
    Route::get('/customer-manage/deposits/{customerId}', [CustomerManageController::class, 'indexDeposit'])->name('customer-manage.deposits');

    Route::get('stock-manage/{variant}', [StockManageController::class, 'index'])
        ->name('stock-manage.index');
    Route::get('stock/{stock}/uid', [StockManageController::class, 'UidIndex'])->name('stock.uid_index');
    Route::get('stock/{stock}/uid/create', [StockManageController::class, 'UidCreate'])->name('stock.uid_create');
    Route::post('stock/{stock}/uid', [StockManageController::class, 'UidStore'])->name('stock.uid_store');
    Route::post('stock/{stock}/uid-email', [StockManageController::class, 'uidEmailStore'])->name('stock.uid_email_store');
    Route::get('/stock/{stock}/uid-email', [StockManageController::class, 'uidEmailIndex'])->name('stock.uid_email_index');
    Route::get('/admin/complaints', [HomeController::class, 'indexComplaint'])->name('admin.complaints.index');
Route::get('/admin/order-details', [HomeController::class, 'indexOrderDetail'])->name('admin.order_details.index');
    Route::get('/admin/orders', [HomeController::class, 'IndexOrder'])->name('admin.orders.index');
    Route::get('/admin/order/{orderId}', [HomeController::class, 'OrderDetail'])->name('admin.order_detail.index');
});
