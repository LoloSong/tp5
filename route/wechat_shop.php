<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/24
 * Time: 9:49
 */

Route::get('api/wechat_shop/banner', 'wechat_shop/Banner/getBanner');

Route::get('api/wechat_shop/theme', 'wechat_shop/Theme/getTheme');
Route::get('api/wechat_shop/theme/:id', 'wechat_shop/Theme/getThemeWithProducts');


Route::get('api/wechat_shop/product/by_category', 'wechat_shop/Product/getAllInCategory');
Route::get('api/wechat_shop/product/:id', 'wechat_shop/Product/getOne', [], ['id' => '\d+']);
Route::get('api/wechat_shop/product/recent', 'wechat_shop/Product/getRecent');

Route::get('api/wechat_shop/category/all', 'wechat_shop/Category/getCategories');

Route::post('api/wechat_shop/token/user', 'wechat_shop/Token/getToken');
Route::post('api/wechat_shop/token/verify', 'wechat_shop/Token/verifyToken');

Route::post('api/wechat_shop/address', 'wechat_shop/Address/createOrUpdateAddress');
Route::get('api/wechat_shop/address', 'wechat_shop/Address/getUserAddress');

Route::post('api/wechat_shop/order', 'wechat_shop/Order/placeOrder');

Route::post('api/wechat_shop/pay/pre_order', 'wechat_shop/Pay/getPreOrder');