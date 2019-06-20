<?php

namespace App\Http\Controllers\Certs;

use App\Http\Controllers\Controller;
use App\Models\Cms\Asset;
use App\Models\Cms\Certificate;
use App\Models\Cms\CmsUser;
use App\Models\Cms\TrophyCupConfig;
use App\Traits\FilterBuilder;
use Illuminate\Http\Request;

/**
 * Class CertificateSetupController
 */
class CertificateSetupController extends Controller
{
    use FilterBuilder;

    const FILTER_FIELDS = [
        'id' => 'equal',
    ];

    /**
     * Show cert list.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $activeDirection = $request->get('direction', environment());
        $data = $this->ApplyFilter(
            $request,
            Asset::where(['subtype' => Certificate::CERT_SUBTYPE])
        )->get()->toArray();
        $certs = Certificate::with('assetId')->whereIn('asset_id', array_column($data, 'id'))->get()->keyBy('asset_id');

        return view('certificate-setup.index', [
            'rows'            => $data,
            'certs'           => $certs,
            'activeDirection' => $activeDirection,
            'is_active'       => arrayToCollection(config('presets.is_active')),
        ]);
    }

    /**
     * Update trophy cup managers list.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        foreach ($request->get('cert') as $asset_id => $status) {
            Certificate::updateOrCreate(['asset_id' => (int)$asset_id], ['status' => array_shift($status)]);
        }

        return $this->success(['message' => __('Certificate config') . __('common.action.updated')]);
    }
}
