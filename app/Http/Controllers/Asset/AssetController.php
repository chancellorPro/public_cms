<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\CreateUpdateAsset;
use App\Http\Requests\Asset\InlineUpdateAsset;
use App\Models\Cms\AppSettings;
use App\Models\Cms\Asset;
use App\Models\Cms\AssetActionTypeState;
use App\Models\Cms\Attribute;
use App\Models\Cms\Subtype;
use App\Models\Cms\ActionType;
use App\Models\Cms\AssetActionTypeAttribute;
use App\Services\FileService;
use App\Traits\FilterBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Services\CmsActionLogService;
use Illuminate\Support\Facades\Storage;

/**
 * Class AssetController
 */
class AssetController extends Controller
{
    use FilterBuilder;

    /**
     * Filtered fields
     */
    const FILTER_FIELDS = [
        'id'                => 'numbers',
        'name'              => 'like',
        'type'              => 'equal',
        'subtype'           => 'equal',
        'cash_price'        => 'equal',
        'coins_price'       => 'equal',
        'sell_status'       => 'equal',
        'collection_number' => 'equal',
    ];

    /**
     * Display a listing of the resource.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $assetsBuilder = Asset::with(
            'bundles',
            'assetSubtype',
            'assetAttributes',
            'updatedBy',
            'actionType.actionTypeState.actionTypeStateAttribute.actionTypeAttribute',
            'assetActionTypeAttributes',
            'assetStateAward',
            'assetStateAward.award',
            'cmsAdp'
        )->orderBy('id', 'desc');

        $assets = $this->applyFilter($request, $assetsBuilder)
            ->paginate(self::RECORDS_PER_PAGE);

        $subtypeAttributesConfig = AppSettings::getConfig('subtype-attributes');
        $attributes              = Attribute::all()->keyBy('id');

        $configurableAttributes = $subtypeAttributesConfig['configurable'];
        $attributeValues        = $subtypeAttributesConfig['values'];
        $types                  = arrayToCollection(config('presets.asset_types'));
        $subTypes               = Collection::make(Subtype::all());

        $filter = $this->getFilter();

        return view('asset.index.index', [
            'available_bundles_types' => count(config('presets.asset_file_path')),
            'assets'                  => $assets,
            'configurableAttributes'  => $configurableAttributes,
            'attributeValues'         => $attributeValues,
            'attributes'              => $attributes,
            'types'                   => $types,
            'filter'                  => $filter,
            'subTypes'                => $subTypes,
            'env'                     => environment(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id ID
     *
     * @return \Illuminate\View\View
     */
    public function show(int $id)
    {
        $asset = Asset::findOrFail($id);

        return view('asset.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param integer $id ID
     *
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        return view('asset.edit', [
            'asset'         => Asset::findOrFail($id),
            'types'         => arrayToCollection(config('presets.asset_types')),
            'subtypeGroups' => Subtype::getSubtypeGroups(),
            'actionTypes'   => ActionType::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateUpdateAsset $request Request
     * @param integer           $id      ID
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CreateUpdateAsset $request, int $id)
    {
        $requestData = $request->all();

        $asset = Asset::findOrFail($id);
        if ($request->hasFile('preview')) {
            $assetSubFolder = getSubFolder($asset->id);
            $env            = environment();
            $path           = FileService::uploadImg(
                $request->file('preview'),
                $env .'/Assets/Preview/' . $assetSubFolder . '/' . $asset->id,
                [
                    'height' => 250,
                    'width'  => 250,
                    'fill'   => true,
                ]
            );

            $requestData['preview_url'] = $path;
            if (!empty($asset->preview_url)) {
                FileService::delete($asset->preview_url);
            }
        }

        if (empty($requestData['subtype']) || $asset->subtype != $requestData['subtype']) {
            $asset->assetAttributes()->detach();
        }

        /**
         * Fill the model from request
         */
        $asset->fill($requestData);

        /**
         * Create or update asset bundle files
         */
        $asset->makeBundleFiles();

        $asset->update();

        pushNotify('success', __('Asset') . ' ' . __('common.action.updated'));

        return $this->redirect('assets');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param InlineUpdateAsset $request Request
     * @param integer           $id      ID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function inlineUpdate(InlineUpdateAsset $request, int $id)
    {
        $requestData = $request->all();

        $asset = Asset::findOrFail($id);
        
        $asset->assetAttributes()->detach();
        $attributes = $request->get('attributes');

        if (!empty($attributes)) {
            foreach ($attributes as $attributeId => $value) {
                $asset->assetAttributes()->attach($attributeId, ['value' => $value]);
            }
            CmsActionLogService::logAction('asset_attributes', 'updated', ['id' => $id]);
        }

        /**
         * Action Type
         */
        $actionTypeAttributeData = $request->get('actionTypeAttribute');
        if (!empty($actionTypeAttributeData)) {
            AssetActionTypeAttribute::where(['asset_id' => $id])->delete();

            foreach ($actionTypeAttributeData as $actionTypeStateID => $actionTypeAttributes) {
                foreach ($actionTypeAttributes as $actionTypeAttributeID => $actionTypeAttributeValue) {
                    AssetActionTypeAttribute::insert([
                        'asset_id'                 => $id,
                        'action_type_state_id'     => $actionTypeStateID,
                        'action_type_attribute_id' => $actionTypeAttributeID,
                        'value'                    => $actionTypeAttributeValue,
                    ]);
                }
            }
        }

        /**
         * Asset State Award
         */
        $assetStateAwardData = $request->get('assetStateAward');
        if (!empty($assetStateAwardData)) {
            foreach ($assetStateAwardData as $actionTypeStateID => $awardID) {
                AssetActionTypeState::insertUpdate([
                    'asset_id'             => $id,
                    'action_type_state_id' => $actionTypeStateID,
                    'award_id'             => $awardID,
                ]);
            }
        }

        $asset->update($requestData);

        return $this->success([
            'message' => __('Asset') . ' ' . $asset->id . ' ' . __('common.action.updated'),
        ]);
    }

    /**
     * Get last collection number (Collection ID)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLastCollectionNumber()
    {
        return $this->success([
            'collection_id' => Asset::getLastCollectionNumber(),
        ]);
    }


    /**
     * Get asset info
     *
     * @param  Request $request Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAssetInfo(Request $request)
    {
        $id    = $request->get('id', 0);
        $data  = [];
        $asset = Asset::find($id);
        if ($asset) {
            $data                = $asset->toArray();
            $data['preview_url'] = Storage::url($data['preview_url']);
        }

        return $this->success([
            'data' => $data,
        ]);
    }
}
