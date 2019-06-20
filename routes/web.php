<?php
/**
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Auth::routes();

Route::get('/forbidden', 'IndexController@forbidden')->name('forbidden');

Route::get('/', 'Nla\NlaAssetController@publicIndex')->name('nla');
Route::get('/admin', 'MenuController@index')->name('menu')->middleware('auth');

Route::middleware(['auth', 'roles'])->group(function () {
    Route::get('menu/edit', 'MenuController@edit')->name('menu.edit');
    Route::patch('menu/update', 'MenuController@update')->name('menu.update');

    Route::resource('cms-users', 'CmsUser\CmsUserController', ['names' => 'cms-users']);
    Route::post('cms-users/sync', 'CmsUser\CmsUserController@sync')
        ->name('cms-users.sync');
    Route::get('cms-user-actions', 'CmsUser\CmsUserActionsController@index')->name('cms-user-actions.index');
    Route::resource('cms-roles', 'CmsUser\CmsRoleController', ['names' => 'cms-roles']);

    Route::resource('assets', 'Asset\AssetController')->except(['create', 'store', 'destroy']);
    Route::put('assets/{asset}', 'Asset\AssetController@inlineUpdate')->name('assets.inline_update');
    Route::get('assets-collection', 'Asset\AssetController@getLastCollectionNumber')->name('assets.collection');
    Route::get('asset-info', 'Asset\AssetController@getAssetInfo')->name('asset.info');

    /**
     * Users
     */
    Route::get('users', 'User\IndexController@index')->name('users.index');
    Route::get('users/{user}/edit', 'User\IndexController@edit')->name('users.edit');
    Route::put('users/{user}/update/{part}', 'User\IndexController@update')->name('users.update');
    Route::get('users/{user}/{part}', 'User\IndexController@getPart')->name('users.get_part');

    /**
     * Page Info
     */
    Route::get('page-info/{route}', 'PageInfoController@edit')->name('page-info.edit');
    Route::patch('page-info/{route}', 'PageInfoController@update')->name('page-info.update');

    /**
     * Group Trophies
     */
    Route::get('trophies', 'Trophy\TrophiesController@index')->name('trophies.index');
    Route::post('trophies-find', 'Trophy\TrophiesController@findUser')->name('trophies.find');
    Route::post('trophies-send', 'Trophy\TrophiesController@send')->name('trophies.send');

    Route::get('trophy-cup-users', 'Trophy\TrophyCupUsersController@index')->name('trophy-cup-users.index');
    Route::put('trophy-cup-users', 'Trophy\TrophyCupUsersController@update')->name('trophy-cup-users.update');

    Route::get('trophy-history', 'Trophy\TrophyHistoryController@index')->name('trophy-history.index');

    /**
     * Certificates
     */
    Route::get('cert-setup', 'Certs\CertificateSetupController@index')->name('cert-setup.index');
    Route::post('cert-setup', 'Certs\CertificateSetupController@update')->name('cert-setup.update');

    Route::get('cert-users', 'Certs\CertificateUsersController@index')->name('cert-users.index');
    Route::put('cert-users', 'Certs\CertificateUsersController@update')->name('cert-users.update');

    Route::get('cert', 'Certs\CertificateController@index')->name('cert.index');
    Route::post('cert-find', 'Certs\CertificateController@findUser')->name('cert.find');
    Route::post('cert-send', 'Certs\CertificateController@send')->name('cert.send');

    Route::get('cert-history', 'Certs\CertificateHistoryController@index')->name('cert-history.index');

    /**
     * Group admins
     */
    Route::get('group', 'Groups\GroupController@index')->name('group.index');
    Route::get('group-edit', 'Groups\GroupController@edit')->name('group.edit');
    Route::put('group-edit', 'Groups\GroupController@update')->name('group.update');
    Route::post('group-find', 'Groups\GroupController@findUser')->name('group.find');
    Route::post('group-store', 'Groups\GroupController@store')->name('group.store');
    Route::delete('group-destroy/{id}', 'Groups\GroupController@destroy')->name('group.destroy');

    /**
     * Group events
     */
    Route::get('group-event', 'Groups\GroupEventController@index')->name('group-event.index');
    Route::post('group-event', 'Groups\GroupEventController@update')->name('group-event.update');
    Route::delete('group-event/{id}', 'Groups\GroupEventController@destroy')->name('group-event.destroy');

    /**
     * Send Special Prizes
     */
    Route::get('special-prizes', 'SpecialPrize\SpecialPrizeController@index')->name('special-prizes.index');
    Route::get('special-prizes-form/{id}', 'SpecialPrize\SpecialPrizeController@form')->name('special-prizes.form');
    Route::post('special-prizes', 'SpecialPrize\SpecialPrizeController@send')->name('special-prizes.send');
    Route::get('special-prizes-history/{user?}', 'SpecialPrize\SpecialPrizeHistoryController@index')->name('special-prizes-history.index');

    /**
     * NLA section
     */
    Route::get('nla-section', 'Nla\NlaSectionController@index')->name('nla-section.index');
    Route::post('nla-section', 'Nla\NlaSectionController@update')->name('nla-section.update');
    Route::delete('nla-section/{id}', 'Nla\NlaSectionController@destroy')->name('nla-section.destroy');

    /**
     * NLA category
     */
    Route::get('nla-category', 'Nla\NlaCategoryController@index')->name('nla-category.index');
    Route::post('nla-category', 'Nla\NlaCategoryController@update')->name('nla-category.update');
    Route::delete('nla-category/{id}', 'Nla\NlaCategoryController@destroy')->name('nla-category.destroy');

    /**
     * NLA assets
     */
    Route::get('nla-asset', 'Nla\NlaAssetController@index')->name('nla-asset.index');
    Route::post('nla-import', 'Nla\NlaAssetController@import')->name('nla-asset.import');
    Route::post('nla-assign', 'Nla\NlaAssetController@assign')->name('nla-asset.assign');
    Route::post('nla-update', 'Nla\NlaAssetController@update')->name('nla-asset.update');
    Route::post('change-order', 'Nla\NlaAssetController@order');
    Route::post('change-per-page', 'Nla\NlaAssetController@perPage');

});
