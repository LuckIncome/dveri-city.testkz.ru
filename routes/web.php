<?php

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


Route::get('/test','HomeController@test');

Route::post('/online/successTransaction','PaymentController@successTransaction');
Route::post('/online/failureTransaction','PaymentController@failureTransaction');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/sitemap', 'PageController@sitemap')->name('sitemap');
Route::post('/searchByInput','HomeController@search')->name('search');
Route::get('/page/partners','PageController@getPartnersPage')->name('pages.partners');
Route::get('/page/{slug}','PageController@getPage')->name('pages.show');

Route::get('/catalog', 'CategoriesController@catalog')->name('products.index');

Route::get('/sales','SalesController@index')->name('sales.index');
Route::get('/sales/{slug}','SalesController@show')->name('sales.show');

Route::get('/news','PostsController@index')->name('posts.index');
Route::get('/news/{slug}','PostsController@show')->name('posts.show');

Route::get('/catalog/{categoryId}/products','CategoriesController@getProducts');
Route::get('/catalog/aksessuary','CategoriesController@catalogAccessories')->name('catalog.accessories');
Route::get('/catalog/{catSlug}','CategoriesController@index')->name('catalog.show');
Route::get('/catalog/getCurrent/{slug}','CategoriesController@getCurrentCategory');
Route::get('/product/getCurrent/{slug}','ProductsController@getCurrentProduct');
Route::get('/catalog/{catSlug}/{productSlug}','ProductsController@show')->name('product.show');


Route::get('/cart','CartController@show')->name('cart.index');
Route::get('/cart/getCartContent','CartController@getCartContent');
Route::post('/cart/addToCart/{productId}','CartController@addToCart')->name('cart.add-to-cart');
Route::get('/cart/getCartItems','CartController@getCartItems');
Route::post('/cart/update','CartController@updateCart')->name('cart.update');
Route::post('/cart/remove','CartController@removeFromCart')->name('cart.remove');
Route::get('/cart/clear','CartController@destroyCart');
Route::get('/cart/remove/{itemId}','CartController@removeItem');
Route::get('/checkout','CartController@checkoutIndex')->name('cart.checkout');
Route::post('/checkout/submit','CartController@checkoutSubmit')->name('cart.checkout.submit');
Route::get('/checkout/{orderId}/thanks','CartController@checkoutThanks')->name('cart.checkout.thanks');
Route::get('/checkout/{orderId}/cardPay','CartController@cardPay')->name('cart.checkout.cardPay');

Route::get('/checkout/{orderId}/{paymentId}/awaiting','PaymentController@checkoutAwaiting')->name('cart.checkout.awaiting');
Route::get('/checkout/{orderId}/{paymentId}/checkPaymentStatus','PaymentController@checkOrderPaymentStatus')->name('checkPaymentStatus');

Route::get('/compare','CompareController@index')->name('compare.index');
Route::get('/compare/getCompareContent','CompareController@getCompareContent');
Route::post('/compare/add/{productId}','CompareController@addToCompare')->name('compare.add');
Route::get('/compare/getCompareItems','CompareController@getCompareItems');
Route::post('/compare/remove','CompareController@removeFromCompare');
Route::get('/compare/clear','CompareController@destroy')->name('compare.clear');

Route::get('/locale/set/{locale}', 'PageController@setLocale')->name('locale.set');

Route::post('/popup-callback','PageController@popupCallback')->name('popup.callback');

Route::group(['prefix' => 'admin'], function () {
    Route::post('products/makeVariations', 'Backend\ProductsController@makeVariations')->name('products.makeVariations');
    Route::post('orders/{orderId}/update', 'Backend\ProductsController@orderUpdate')->name('orders.update');
    Route::post('orders/export', 'Backend\ProductsController@exportToExcel')->name('orders.export');
    Route::post('products/import', 'Backend\ProductsController@importToExcel')->name('products.import');
    Route::get('products/attach', 'Backend\ProductsController@attachProductImages')->name('products.attach');
    Route::get('products/restoreMetaData', 'Backend\ProductsController@restoreMetaData')->name('products.restoreMeta');
    Voyager::routes();
});
