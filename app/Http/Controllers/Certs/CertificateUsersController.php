<?php

namespace App\Http\Controllers\Certs;

use App\Http\Controllers\Controller;
use App\Models\Cms\CertificateConfig;
use App\Models\Cms\CmsUser;
use App\Models\Cms\TrophyCupConfig;
use App\Traits\FilterBuilder;
use Illuminate\Http\Request;

/**
 * Class CertificateUsersController
 */
class CertificateUsersController extends Controller
{
    use FilterBuilder;

    const FILTER_FIELDS = [
        'id'       => 'equal',
        'name'     => 'equal',
        'limit'    => 'manual',
    ];

    /**
     * Show certificate managers list.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $activeDirection = $request->get('direction', environment());
        $rows = $this->ApplyFilter($request, CmsUser::where(['cms_user_role.cms_role_id' => CmsUser::TROPHY_ASSET_MANAGER_WEB])
            ->leftJoin('cert_config', 'cms_users.id', '=', 'cert_config.user_id')
            ->leftJoin('cms_user_role', 'cms_users.id', '=', 'cms_user_role.cms_user_id'))->get();

        return view('certificate-users.index', compact(['rows', 'activeDirection']));
    }

    /**
     * Manual filter by limit
     *
     * @param  $request
     * @param  $builder
     * @return mixed
     */
    public function applyLimitFilter($request, $builder)
    {
        return $builder->where(['cert_config.limit' => $request->get('limit')]);
    }

    /**
     * Update certificate managers list.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        foreach ($request->get('cu') as $item) {
            CertificateConfig::updateOrCreate(['user_id' => (int)$item['id']], ['limit' => $item['limit']]);
        }

        return $this->success(['message' => __('CertificateConfig') . __('common.action.updated')]);
    }
}
