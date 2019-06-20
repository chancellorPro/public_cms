<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Cms\Asset;
use App\Models\Cms\GroupAdmin;
use App\Models\Cms\GroupEvent;
use App\Traits\FilterBuilder;
use Illuminate\Http\Request;

/**
 * Class GroupEventController
 */
class GroupEventController extends Controller
{

    use FilterBuilder;

    const FILTER_FIELDS = [
        'name'      => 'equal',
        'date_from' => 'manual',
        'date_to'   => 'manual',
    ];

    /**
     * Show group admin list.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $activeDirection = $request->get('direction', environment());
        $rows = $this->ApplyFilter($request, GroupEvent::query()->orderBy('created_at', 'desc'))->get()->toArray();

        $asset_ids = [];
        foreach ($rows as $k => $item) {
            $assets_setup = json_decode($item['assets_setup'], true);
            foreach ($assets_setup as $i => $v) {
                $asset_ids[] = $v['asset_id'];
                $rows[$k]['embed_box'][$i] = $v;
            }
        }

        $assets = Asset::whereIn('id', $asset_ids)->get()->keyBy('id')->toArray();

        return view('group-event.index', compact(['rows', 'activeDirection', 'assets']));
    }

    /**
     * @param $request
     * @param $queryBuilder
     * @return mixed
     */
    public function applyDateFromFilter($request, $queryBuilder)
    {
        return $queryBuilder->where('date_from', '>=', $request->get('date_from'));
    }

    /**
     * @param $request
     * @param $queryBuilder
     * @return mixed
     */
    public function applyDateToFilter($request, $queryBuilder)
    {
        return $queryBuilder->where('date_to', '<=', $request->get('date_to'));
    }

    /**
     * Change main admin.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        foreach ($request->get('ge') as $event) {
            GroupEvent::updateOrCreate(['id' => $event['id']], [
                'name'         => $event['name'],
                'date_from'    => $event['date_from'],
                'date_to'      => $event['date_to'],
                'assets_setup' => json_encode($event['embed_box'])
            ]);
        }

        return $this->success(['message' => __('GroupEvent') . __('common.action.updated')]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        GroupEvent::destroy($id);

        return $this->success();
    }
}
