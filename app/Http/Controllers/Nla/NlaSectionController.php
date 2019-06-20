<?php

namespace App\Http\Controllers\Nla;

use App\Http\Controllers\Controller;
use App\Http\Requests\Nla\NlaSectionRequest;
use App\Models\Cms\NlaSection;
use App\Traits\FilterBuilder;
use Illuminate\Http\Request;

/**
 * Class NlaController
 */
class NlaSectionController extends Controller
{

    use FilterBuilder;

    const FILTER_FIELDS = [
        'name' => 'equal',
        'sort' => 'equal',
    ];

    /**
     * Nla section list.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $activeDirection = $request->get('direction', environment());
        $rows = $this->ApplyFilter($request, NlaSection::query()->orderBy('created_at', 'desc'))->get();

        return view('nla-section.index', compact(['rows', 'activeDirection']));
    }

    /**
     * Update sections.
     *
     * @param NlaSectionRequest $request Request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(NlaSectionRequest $request)
    {
        foreach ($request->get('nla') as $section) {
            NlaSection::updateOrCreate(['id' => $section['id']], [
                'name' => $section['name'],
                'sort' => $section['sort'],
            ]);
        }

        return $this->success(['message' => __('GroupEvent') . __('common.action.updated')]);
    }
}
