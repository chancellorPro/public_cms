<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\GiftWrapRequest;
use App\Models\Cms\Asset;
use App\Models\Cms\AssetGiftWrap;
use App\Traits\FilterBuilder;
use Illuminate\Http\Request;

/**
 * GiftWrap
 */
class GiftWrapController extends Controller
{
    use FilterBuilder;

    /**
     * Filtered fields
     */
    const FILTER_FIELDS = [
        'id'   => 'equal',
        'name' => 'like',
    ];

    /**
     * Gift wraps
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $assetsBuilder = AssetGiftWrap::with([
            'asset.cmsAdp'
        ])->orderBy('position');

        $assets = $this->applyFilter($request, $assetsBuilder)->paginate(0);
        $filter = $this->getFilter();

        return view('asset.gift-wrap.index', [
            'data'   => $assets,
            'filter' => $filter,
        ]);
    }

    /**
     * Update
     *
     * @param GiftWrapRequest $request Request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GiftWrapRequest $request)
    {
        $requestData = $request->getAssets();
        $assetIds    = array_filter(array_keys($requestData), function ($item) {
            return !empty($item);
        });

        foreach (Asset::with('giftWrap')->findOrFail($assetIds) as $asset) {
            if (!empty($requestData[$asset->id]['gift_wrap'])) {
                $asset->giftWrap()->updateOrCreate(
                    ['asset_id' => $asset->id],
                    $requestData[$asset->id]['gift_wrap']
                );
            }
        }

        return $this->success([
            'message' => __('Gift wraps') . ' ' . __('common.action.updated'),
        ]);
    }

    /**
     * Destroy
     *
     * @param integer $id Asset ID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        AssetGiftWrap::destroy($id);

        return $this->success();
    }
}
