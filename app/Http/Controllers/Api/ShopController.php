<?php

namespace App\Http\Controllers\Api;

use App\Configs\ShopConfig;
use App\Configs\ShopItemConfig;
use App\Http\Controllers\Api;
use App\Http\Requests\ShopAdmin\ItemsRequest;
use App\Http\Requests\ShopAdmin\ShopDataRequest;
use App\Models\Cms\AppSettings;
use App\Models\Cms\Shop;
use App\Models\Cms\ShopItem;

/**
 * Class ShopController
 */
class ShopController extends Api
{

    /**
     * Get all shops
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return $this->success((new ShopConfig())->generate()->current());
    }

    /**
     * Get shop items
     *
     * @param integer $id Shop ID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getItems(int $id)
    {
        $config = new ShopItemConfig();
        $config->setShopId($id);

        $items = $config->generate()->current();

        /**
         * Get default assets from app settings (shop_admin_default_assets)
         */
        if (empty($items)) {
            $appSettings = AppSettings::getConfig('shop_admin_default_assets');

            if (!empty($appSettings['rows'])) {
                $items = array_values($appSettings['rows']);
                foreach ($items as &$item) {
                    if (is_array($item['data']) && !empty($item['data'][0])) {
                        $item['data'] = $item['data'][0];
                    }
                }
            }
        }

        return $this->success($items);
    }

    /**
     * Save shop items
     *
     * @param integer      $id      Shop ID
     * @param ItemsRequest $request Request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveItems(int $id, ItemsRequest $request)
    {
        $items = $request->getItems();

        ShopItem::saveItems($id, $items);

        return $this->success();
    }

    /**
     * Save shop data
     *
     * @param integer         $id      Shop ID
     * @param ShopDataRequest $request Request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveShop(int $id, ShopDataRequest $request)
    {
        $data = null;
        if (!empty($request->get('data'))) {
            $data = json_encode($request->get('data'));
        }

        Shop::where('id', $id)->update([
            'data' => $data,
        ]);

        return $this->success();
    }
}
