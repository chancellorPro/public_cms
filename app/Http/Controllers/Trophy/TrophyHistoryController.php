<?php

namespace App\Http\Controllers\Trophy;

use App\Http\Controllers\Controller;
use App\Models\Cms\CmsUser;
use App\Models\Cms\TrophyHistory;
use App\Traits\FilterBuilder;
use Illuminate\Http\Request;

/**
 * Class TrophyHistoryController
 */
class TrophyHistoryController extends Controller
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
     * Show the Trophy History.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = CmsUser::with('cmsRoles')->whereId(auth()->id())->first();
        if (in_array(CmsUser::ADMIN, array_column($user->cmsRoles->toArray(), 'id'))) {
            $data = $this->ApplyFilter(
                $request,
                TrophyHistory::with('sender', 'receiver')
            )->get();
        } else {
            if(empty($request->get('environment'))) {
                session()->put('environment', 'live');
            }

            $data = $this->ApplyFilter(
                $request,
                TrophyHistory::with('sender', 'receiver')->where(['cms_user' => auth()->id()])
            )->get();
        }

        return view('trophy-history.index', [
            'rows' => $data
        ]);
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
