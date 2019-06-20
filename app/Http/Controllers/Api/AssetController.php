<?php

namespace App\Http\Controllers\Api;

use App\Configs\AssetConfig;
use App\Exceptions\Placement\TypeNotFoundException;
use App\Http\Controllers\Api;
use App\Http\Requests\Asset\ApiAssetUpdate;
use App\Http\Requests\Asset\ApiAttributeUpdate;
use App\Models\Cms\Asset;

/**
 * Class AssetController
 */
class AssetController extends Api
{

    /**
     * Get assets config
     *
     * @param string $type Assets type (furniture|clothes)
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws TypeNotFoundException Asset type not found
     */
    public function all(string $type)
    {
        $assetAliases = array_flip(Asset::ASSET_TYPE_ALIASES);
        if (empty($assetAliases[$type])) {
            throw new TypeNotFoundException;
        }

        $asset = new AssetConfig();
        $asset->setPerPage(0);
        $asset->setAssetType($assetAliases[$type]);

        return $this->success($asset->generate()->current());
    }

    /**
     * Get asset config by ID
     *
     * @param integer $id Asset ID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function one(int $id)
    {
        $result = [
            'asset' => null,
            'type'  => null,
        ];

        $asset = Asset::find($id);
        if (!empty($asset)) {
            $assetsConfig = new AssetConfig();
            $assetsConfig->setPerPage(0);
            $assetsConfig->setAssetId($id);

            $config = $assetsConfig->generate()->current();

            $result['type']  = $asset->type;
            $result['asset'] = !empty($config[0]) ? $config[0] : null;
        }

        return $this->success([$result]);
    }

    /**
     * Save asset price
     *
     * @param integer        $id      Asset ID
     * @param ApiAssetUpdate $request Request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(int $id, ApiAssetUpdate $request)
    {
        $assetData = [
            'cash_price'  => (int) $request->get('cash_price', 0),
            'coins_price' => (int) $request->get('coins_price', 0),
        ];

        if (!empty($request->get('name'))) {
            $assetData['name'] = $request->get('name');
        }

        $asset = Asset::findOrFail($id);
        $asset->update($assetData);

        return $this->success();
    }

    /**
     * Update attribute
     *
     * @param integer            $id      Asset ID
     * @param ApiAttributeUpdate $request Request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function attribute(int $id, ApiAttributeUpdate $request)
    {
        Asset::attributeUpdate($id, $request->getAttributeId(), $request->getAttributeValue());

        return $this->success();
    }
}
