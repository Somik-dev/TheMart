<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordReset;
use App\Http\Controllers\Rolcontroller;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductControler;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\SslCommerzPaymentController;
 use App\Http\Controllers\StripePaymentController;
;


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

// Fronted
Route::get('/',[FrontendController::class, 'index'])->name('index');
Route::get('/category/products/{id}',[FrontendController::class, 'category_products'])->name('category.products');
Route::get('/subcategory/products/{id}',[FrontendController::class, 'subcategory_products'])->name('subcategory.products');
Route::get('/product/details/{slug}',[FrontendController::class, 'product_details'])->name('product.details');
Route::post('/getSize',[FrontendController::class, 'getSize']);
Route::post('/getQuantity',[FrontendController::class, 'getQuantity']);
Route::get('/shop',[FrontendController::class, 'shop'])->name('shop');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard',[HomeController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// profile update
Route::get('/user/profile', [HomeController::class, 'user_profile'])->name('user.profile');
Route::post('/user/info/update', [HomeController::class,'user_info_update'])->name('user.info.update');
Route::post('/password/update',[HomeController::class,'password_update'])->name('user.pass.update');
Route::post('/user/photo/update',[HomeController::class,'user_photo_update'])->name('user.photo.update');

// user
Route::get('/user/list',[UserController::class,'user_list'])->name('user.list');
Route::get('/user/remove/{user_id}',[UserController::class,'user_remove'])->name('user.remove');

// Category
Route::get('/category',[CategoryController::class,'category'])->name('category');
Route::post('/category/store',[CategoryController::class,'category_post'])->name('category.store');
Route::get('/category/edit/{category_id}',[CategoryController::class,'category_edit'])->name('category.edit');
Route::post('/category/update',[CategoryController::class,'category_update'])->name('category.update');
Route::get('/category/soft/delete/{category_id}',[CategoryController::class,'category_soft_delete'])->name('category.soft.delete');
Route::get('/category/trash',[CategoryController::class,'category_trash'])->name('category.trash');
Route::get('/category/restore/{id}',[CategoryController::class,'category_restore'])->name('category.restore');
Route::get('/category/hard/delete/{id}',[CategoryController::class,'category_hard_delete'])->name('category.hard.delete');
Route::post('/delete/checked',[CategoryController::class,'delete_checked'])->name('delete.checked');
Route::post('/restore/checked',[CategoryController::class,'restore_checked'])->name('restore.checked');


// subcategory
Route::get('/subcategory', [SubcategoryController::class, 'subcategory'])->name('subcategory');
Route::post('/subcategory/store', [SubcategoryController::class, 'subcategory_store'])->name('subcategory.store');
Route::get('/subcategory/edit/{id}', [SubcategoryController::class, 'subcategory_edit'])->name('subcategory.edit');
Route::post('/subcategory/update/{id}', [SubcategoryController::class, 'subcategory_update'])->name('subcategory.update');
Route::get('/subcategory/delete/{id}', [SubcategoryController::class, 'subcategory_delete'])->name('subcategory.delete');


// brand
Route::get('/brand', [BrandController::class, 'brand'])->name('brand');
Route::post('/brand/store', [BrandController::class, 'brand_store'])->name('brand.store');
Route::get('/brand/edit/{id}', [BrandController::class, 'brand_edit'])->name('brand.edit');
Route::post('/brand/update/{id}', [BrandController::class, 'brand_update'])->name('brand.update');
Route::get('/brand/delete/{id}', [BrandController::class, 'brand_delete'])->name('brand.delete');

// Product
Route::get('/product',[ProductControler::class,'product'])->name('product');
Route::post('/getSubcategory',[ProductControler::class,'getSubcategory']);
Route::post('/product/store',[ProductControler::class,'product_store'])->name('product.store');
Route::get('/product/list',[ProductControler::class,'product_list'])->name('product.list');
Route::get('/product/delete{id}',[ProductControler::class,'product_delete'])->name('product.delete');
Route::get('/product/show/{id}',[ProductControler::class,'product_show'])->name('product.show');
Route::get('/product/show/{id}',[ProductControler::class,'product_show'])->name('product.show');
Route::get('/product/inventory/{id}',[InventoryController::class,'inventory'])->name('inventory');
Route::get('/product/store/{id}',[InventoryController::class,'inventory_store'])->name('inventory.store');

// Product Variation
Route::get('/variation',[InventoryController::class,'variation'])->name('variation');
Route::post('/color/store',[InventoryController::class,'color_store'])->name('color.store');
Route::post('/size/store',[InventoryController::class,'size_store'])->name('size.store');
Route::get('/color/remove/{id}',[InventoryController::class,'color_remove'])->name('color.remove');
Route::get('/size/remove/{id}',[InventoryController::class,'size_remove'])->name('size.remove');
//
Route::post('/changeStatus',[ProductControler::class,'changeStatus']);

// Customer
Route::get('/customer/login', [CustomerAuthController::class, 'customer_login'])->name('customer.login');
Route::get('/customer/register', [CustomerAuthController::class, 'customer_register'])->name('customer.register');
Route::post('/customer/store', [CustomerAuthController::class, 'customer_store'])->name('customer.store');
Route::post('/customer/login/confirm', [CustomerAuthController::class, 'customer_login_confirm'])->name('customer.login.confirm');
Route::get('/customer/profile', [CustomerController::class, 'customer_profile'])->name('customer.profile')->middleware('customer');
Route::get('/customer/logout', [CustomerController::class, 'customer_logout'])->name('customer.logout');
Route::post('/customer/profile/update', [CustomerController::class, 'customer_profile_update'])->name('customer.profile.update');
Route::get('/customer/order', [CustomerController::class, 'customer_order'])->name('customer.order');
Route::get('/cancel/myorder/{id}', [CustomerController::class, 'cancel_myorder'])->name('cancel.myorder');


// Cart
Route::post('/cart/store', [CartController::class, 'cart_store'])->name('cart.store');
Route::get('/cart/remove/{id}', [CartController::class, 'cart_remove'])->name('cart.remove');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/update', [CartController::class, 'cart_update'])->name('cart.update');


// coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/coupon/store', [CouponController::class, 'coupon_store'])->name('coupon.store');
Route::post('/CouponchangeStatus', [CouponController::class, 'CouponchangeStatus'])->name('CouponchangeStatus');
Route::get('/coupon/delete/{id}', [CouponController::class, 'coupon_delete'])->name('coupon.delete');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/getCity', [CheckoutController::class, 'getCity']);
Route::post('/getCity2', [CheckoutController::class, 'getCity2']);
Route::post('/order/store', [CheckoutController::class, 'order_store'])->name('order.store');
Route::get('/order/success', [CheckoutController::class, 'order_success'])->name('order.success');
Route::get('/order/invoice/download/{id}', [CustomerController::class, 'order_invoice_download'])->name('order.invoice.download');

// Orders
Route::get('/order', [OrdersController::class, 'orders'])->name('orders');
Route::post('/order/status/update', [OrdersController::class, 'order_status_update'])->name('order.status.update');
Route::get('/order/cancel/req', [OrdersController::class, 'order_cancel_req'])->name('order.cancel.req');



// SSLCOMMERZ Start
Route::get('/pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ

// Stripe comerce
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe')->name('stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});

//review
Route::post('/review/store', [FrontendController::class, 'review_store'])->name('review.store');

//subscriber
Route::post('/subscriber/store', [SubscriberController::class, 'subscriber_store'])->name('subscriber.store');
Route::get('/subscriber', [SubscriberController::class, 'subscriber'])->name('subscriber');
Route::get('/send/newslater/{id}', [SubscriberController::class, 'send_newslater'])->name('send.newslater');

//passwordreset
Route::get('/password/reset', [PasswordReset::class, 'password_reset'])->name('password.reset');
Route::post('/password/sent', [PasswordReset::class, 'password_sent'])->name('password.sent');
Route::get('/password/form/{token}', [PasswordReset::class, 'password_form'])->name('password.form');
Route::post('/password/reset/confirm/{token}', [PasswordReset::class, 'password_reset_confirm'])->name('password.reset.confirm');

//Emailverify
Route::get('/customer/email/verify/{token}', [CustomerAuthController::class, 'customer_email_verify'])->name('customer.email.verify');

//role
Route::get('/role', [Rolcontroller::class, 'role'])->name('role');
Route::post('/permission/store', [Rolcontroller::class, 'permission_store'])->name('permission.store');
Route::post('/role/store', [Rolcontroller::class, 'role_store'])->name('role.store');
Route::post('/assign/role', [Rolcontroller::class, 'assign_role'])->name('assign.role');
Route::get('/role/remove/{user_id}', [Rolcontroller::class, 'remove_role'])->name('remove.role');
Route::get('/edit/user/role/permission/{user_id}', [Rolcontroller::class, 'user_role_permission'])->name('edit.user.role.permission');
Route::post('/permission/update', [Rolcontroller::class, 'permission_update'])->name('permission.update');

