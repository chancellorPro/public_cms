<?php

namespace App\Http\Controllers\Certs;

use App\Http\Controllers\Controller;
use App\Models\Cms\CertHistory;
use App\Models\Cms\Certificate;
use App\Models\Cms\CmsUser;
use App\Models\Cms\TrophyCupConfig;
use App\Traits\FilterBuilder;
use Illuminate\Http\Request;

/**
 * Class CertificateHistoryController
 */
class CertificateHistoryController extends Controller
{

    use FilterBuilder;

    const FILTER_FIELDS = [
        'sender_id'   => 'equal',
        'receiver_id' => 'equal',
        'asset_id'    => 'equal',
        'cms_user'    => 'equal',
        'date_from'   => 'manual',
        'date_to'     => 'manual',
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
        $user = CmsUser::with('cmsRoles')->whereId(auth()->id())->first();
        if (in_array(CmsUser::ADMIN, array_column($user->cmsRoles->toArray(), 'id'))) {
            $data = $this->ApplyFilter(
                $request,
                CertHistory::with('sender', 'receiver')
            )->get();
        } else {
            if(empty($request->get('environment'))) {
                session()->put('environment', 'live');
            }

            $data = $this->ApplyFilter(
                $request,
                CertHistory::with('sender', 'receiver')->where(['cms_user' => auth()->id()])
            )->get();
        }


        return view('certificate-history.index', [
            'rows' => $data,
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
        foreach ($request->get('tcu') as $item) {
            TrophyCupConfig::updateOrCreate(['user_id' => (int)$item['id']], ['asset_id' => $item['asset_id'], 'limit' => $item['limit']]);
        }

        return $this->success(['message' => __('TrophyCupConfig') . __('common.action.updated')]);
    }

    /**
     * @param $request
     * @param $queryBuilder
     * @return mixed
     */
    public function applyDateFromFilter($request, $queryBuilder)
    {
        return $queryBuilder->where('created_at', '>', $request->get('date_from'));
    }

    /**
     * @param $request
     * @param $queryBuilder
     * @return mixed
     */
    public function applyDateToFilter($request, $queryBuilder)
    {
        return $queryBuilder->where('created_at', '<', $request->get('date_to'));
    }
}
