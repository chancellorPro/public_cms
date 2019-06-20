<?php

namespace App\Http\Controllers\Trophy;

use App\Http\Controllers\Controller;
use App\Models\Cms\CmsUser;
use App\Models\Cms\TrophyCupConfig;
use App\Traits\FilterBuilder;
use Illuminate\Http\Request;

/**
 * Class TrophyCupUsersController
 */
class TrophyCupUsersController extends Controller
{

    use FilterBuilder;

    const FILTER_FIELDS = [
        'id'       => 'equal',
        'name'     => 'equal',
        'limit'    => 'manual',
        'asset_id' => 'manual',
    ];

    /**
     * Show trophy cup managers list.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $env = environment();
        $queryBuilder = CmsUser::where(['cms_user_role.cms_role_id' => CmsUser::TROPHY_CUP_MANAGER_WEB])
            ->leftJoin('cms_user_role', 'cms_users.id', '=', 'cms_user_role.cms_user_id')
            ->leftJoin('trophy_cup_config', 'cms_users.id', '=', 'trophy_cup_config.user_id');
        $group_admin_list = $this->ApplyFilter($request, $queryBuilder)->get();

        return view('trophy-cup-users.index', [
            'rows'            => $group_admin_list,
            'activeDirection' => $request->get('direction', $env),
        ]);
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
        return $builder->where(['trophy_cup_config.limit' => $request->get('limit')]);
    }

    /**
     * Manual filter by asset ids
     *
     * @param  $request
     * @param  $builder
     * @return mixed
     */
    public function applyAssetIdFilter($request, $builder)
    {
        return $builder->where(['trophy_cup_config.asset_id' => $request->get('asset_id')]);
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
        foreach ($request->get('tcu') as $item) {
            TrophyCupConfig::updateOrCreate(['user_id' => (int)$item['id']], ['asset_id' => (int)$item['asset_id'], 'limit' => (int)$item['limit']]);
        }

        return $this->success(['message' => __('TrophyCupConfig') . __('common.action.updated')]);
    }
}
