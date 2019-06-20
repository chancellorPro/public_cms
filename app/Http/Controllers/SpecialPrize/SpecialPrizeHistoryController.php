<?php

namespace App\Http\Controllers\SpecialPrize;

use App\Http\Controllers\Controller;
use App\Models\Cms\CmsUser;
use App\Models\Cms\EventLog;
use App\Traits\FilterBuilder;
use Illuminate\Http\Request;

/**
 * Class SpecialPrizeHistoryController
 */
class SpecialPrizeHistoryController extends Controller
{

    use FilterBuilder;

    const FILTER_FIELDS = [
        'sender_id'   => 'equal',
        'receiver_id' => 'equal',
        'asset_id'    => 'equal',
        'cms_user_id' => 'equal',
        'date_from'   => 'manual',
        'date_to'     => 'manual',
    ];

    /**
     * Show trophy cup managers list.
     *
     * @param $id
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id = null, Request $request)
    {
        $user = CmsUser::with('cmsRoles')->whereId(auth()->id())->first();
        if (in_array(CmsUser::ADMIN, array_column($user->cmsRoles->toArray(), 'id'))) {
            $data = $this->ApplyFilter(
                $request,
                EventLog::with('sender', 'receiver')
            )->get();

            if(!empty($id)) {

                $data = $data->filter(function($item) use($id) {
                    if ($item['event_id'] === (int)$id) {
                        return $item;
                    }
                })->keyby('id');
            }
        } else {
            if (empty($request->get('environment'))) {
                session()->put('environment', 'live');
            }

            $data = $this->ApplyFilter(
                $request,
                EventLog::with('sender', 'receiver')->where(['cms_user_id' => auth()->id()])
            )->get();

            if(!empty($id)) {
                $data = $data->filter(function($item) use($id) {
                    if ($item['event_id'] == $id) {
                        return $item;
                    }
                })->keyby('id');
            }
        }


        return view('special-prizes-history.index', [
            'rows' => $data,
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
