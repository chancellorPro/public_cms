<?php
/**
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// phpcs:disable
// TODO: add auth
Route::middleware([
    'json.api',
// TODO: turn on auth
//    'auth:api'
])->group(function () {

    /**
     * Shop
     */
    Route::get('shops', 'Api\ShopController@all');
    Route::post('shop/{id}', 'Api\ShopController@saveShop');

    /**
     * Shop Items
     */
    Route::get('shop/{id}/items', 'Api\ShopController@getItems');
    Route::post('shop/{id}/items', 'Api\ShopController@saveItems');

    /**
     * Assets
     */
    Route::get('assets/{type}', 'Api\AssetController@all');
    Route::get('asset/{id}', 'Api\AssetController@one');
    Route::post('asset/{id}', 'Api\AssetController@save');
    Route::post('asset/{id}/attribute', 'Api\AssetController@attribute');

    /**
     * Action Types
     */
    Route::get('action-types', 'Api\ActionTypeController@all');

    /**
     * Sub Types
     */
    Route::get('sub-types', 'Api\SubTypeController@all');
});
