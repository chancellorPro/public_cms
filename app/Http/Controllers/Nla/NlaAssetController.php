<?php

namespace App\Http\Controllers\Nla;

use App\Http\Controllers\Controller;
use App\Http\Requests\Nla\NlaAssetRequest;
use App\Models\Cms\Asset;
use App\Models\Cms\NlaAsset;
use App\Models\Cms\NlaCategories;
use App\Models\Cms\NlaSection;
use App\Traits\FilterBuilder;
use Illuminate\Http\Request;

/**
 * Class NlaAssetController
 */
class NlaAssetController extends Controller
{

    use FilterBuilder;

    const FILTER_FIELDS = [
        'id'        => 'numbers',
        'name'      => 'equal',
        'sell_from' => 'equal',
        'sell_to'   => 'equal',
        'type'      => 'equal',
    ];

    /**
     * Public nla list.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function publicIndex(Request $request)
    {
        $type = 0;
        if ($request->get('type')) {
            $type = $request->get('type');
        } else {
            $request->request->remove('type');
        }

        $asset_types = [
            'furniture' => Asset::ASSET_TYPE_FURNITURE,
            'clothes'   => Asset::ASSET_TYPE_CLOTHES,
        ];

        $sections = NlaSection::all();
        $categories = NlaCategories::query()->orderBy('created_at', 'desc')->get()->keyBy('id');

        if ($request->get('category')) {
            $nlaData = NlaAsset::where(['category_id' => $request->get('category')])->get()->keyBy('asset_id')->toArray();
        } else {
            $nlaData = NlaAsset::get()->keyBy('asset_id')->toArray();
        }

        $order = 'default';
        $order_list = [
            'AZ'        => ['name', 'ask'],
            'ZA'        => ['name', 'desc'],
            'CashCoins' => ['cash_price', 'desc'],
            'CoinsCash' => ['coins_price', 'desc'],
            'default'   => ['created_at', 'desc'],
        ];

        if ($request->session()->has('order')) {
            $order = session('order');
        }

        $record_per_page = 100;
        if ($request->session()->has('record_per_page')) {
            $record_per_page = (int)session('record_per_page');
        }

        $rows = $this->ApplyFilter($request, Asset::with('nlaAssets')
            ->whereIn('id', array_keys($nlaData))
            ->orderBy($order_list[$order][0], $order_list[$order][1]))->paginate($record_per_page);

        $filter = $this->getFilter();

        return view('nla-public.index', compact([
            'rows',
            'categories',
            'sections',
            'type',
            'asset_types',
            'order',
            'record_per_page',
            'filter'
        ]));
    }

    /**
     * Nla asset list.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $activeTab = $request->get('activeTab') ?? 'list';
        $activeDirection = $request->get('direction', environment());
        $categories = NlaCategories::query()->orderBy('created_at', 'desc')->get()->keyBy('id');

        if ($request->get('activeTab') == 'uncategorized') {
            $nlaData = NlaAsset::where(['category_id' => null])->get()->keyBy('asset_id')->toArray();
        } elseif ($request->get('category')) {
            $nlaData = NlaAsset::where(['category_id' => $request->get('category')])->get()->keyBy('asset_id')->toArray();
        } else {
            $nlaData = NlaAsset::get()->keyBy('asset_id')->toArray();
        }

        $record_per_page = 100;
        if ($request->session()->has('record_per_page')) {
            $record_per_page = (int)session('record_per_page');
        }

        $filter = $this->getFilter();

        $nlaAssets = $this->ApplyFilter($request, Asset::with('nlaAssets')
            ->whereIn('id', array_keys($nlaData))
            ->orderBy('created_at', 'desc'))->paginate($record_per_page);
        $assets = Asset::where(['sell_status' => 2])->whereNotIn('id', array_keys($nlaData))->get();

        return view('nla-asset.index', compact([
            'nlaAssets',
            'activeDirection',
            'activeTab',
            'assets',
            'categories',
            'record_per_page',
            'filter'
        ]));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function import()
    {
        $nlaAssets = NlaAsset::pluck('asset_id')->toArray();
        $assets = Asset::where(['sell_status' => 2])->whereNotIn('id', $nlaAssets)->get();

        foreach ($assets as $asset) {
            NlaAsset::create(['asset_id' => $asset->id]);
        }

        pushNotify('success', __('NlaAsset') . ' ' . __('common.action.updated'));
    }

    /**
     * Update assets category.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function assign(Request $request)
    {
        $asset_ids = array_map('intval', explode(',', $request->get('asset_ids')));
        $nlaAssets = NlaAsset::whereIn('asset_id', $asset_ids)->get();

        $array_diff = array_diff($asset_ids, $nlaAssets->pluck('asset_id')->toArray());

        foreach ($nlaAssets as $asset) {
            $asset->update(['category_id' => $request->get('category')]);
        }

        return $this->success(['message' => __('NlaAsset') . __('common.action.updated')]);
    }

    /**
     * Update asset category.
     *
     * @param NlaAssetRequest $request Request
     *
     */
    public function update(NlaAssetRequest $request)
    {
        foreach ($request->get('asset_ids') as $asset_id) {
            $asset = NlaAsset::where(['asset_id' => $asset_id])->first();
            $asset->category_id = $request->get('category');
            $asset->update();
        }

        pushNotify('success', __('NlaAsset') . ' ' . __('common.action.updated'));
    }

    /**
     * Change order.
     *
     * @param Request $request Request
     *
     */
    public function order(Request $request)
    {
        session(['order' => $request->get('order')]);
    }

    /**
     * Change record per page.
     *
     * @param Request $request Request
     *
     */
    public function perPage(Request $request)
    {
        session(['record_per_page' => $request->get('record_per_page')]);
    }
}
