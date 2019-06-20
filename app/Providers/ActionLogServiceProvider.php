<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\ModelChangeObserver;

/**
 * Class ActionLogServiceProvider
 */
class ActionLogServiceProvider extends ServiceProvider
{
    const OBSERVED_MODELS = [
        '\App\Models\Cms\AppSettings',
        '\App\Models\Cms\Asset',
        '\App\Models\Cms\Attribute',
        '\App\Models\Cms\AssetActionTypeAttribute',
        '\App\Models\Cms\AssetActionTypeState',
        '\App\Models\Cms\AssetGiftWrap',
        '\App\Models\Cms\AssetLocalization',
        '\App\Models\Cms\Award',
        '\App\Models\Cms\CmsRole',
        '\App\Models\Cms\CmsRolePermission',
        '\App\Models\Cms\CmsShopRelease',
        '\App\Models\Cms\CmsUser',
        '\App\Models\Cms\Shop',
        '\App\Models\Cms\ShopDepartment',
        '\App\Models\Cms\ShopItem',
        '\App\Models\Cms\Subtype',
        '\App\Models\Cms\SystemMessage',
        '\App\Models\User\User',
        '\App\Models\User\UserAsset',
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach (self::OBSERVED_MODELS as $model) {
            $model::observe(ModelChangeObserver::class);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }
}
