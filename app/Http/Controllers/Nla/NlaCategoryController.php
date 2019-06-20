<?php

namespace App\Http\Controllers\Nla;

use App\Http\Controllers\Controller;
use App\Http\Requests\Nla\NlaCategoriesRequest;
use App\Models\Cms\NlaCategories;
use App\Models\Cms\NlaSection;
use App\Traits\FilterBuilder;
use Illuminate\Http\Request;

/**
 * Class NlaCategoryController
 */
class NlaCategoryController extends Controller
{

    use FilterBuilder;

    const FILTER_FIELDS = [
        'name'       => 'equal',
        'sort'       => 'equal',
        'section_id' => 'equal',
    ];

    /**
     * Nla categories list.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $activeDirection = $request->get('direction', environment());
        $rows = $this->ApplyFilter($request, NlaCategories::query()->orderBy('created_at', 'desc'))->get();
        $sections = NlaSection::all();

        return view('nla-category.index', compact(['rows', 'activeDirection', 'sections']));
    }

    /**
     * Update categories.
     *
     * @param NlaCategoriesRequest $request NlaSectionRequest
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(NlaCategoriesRequest $request)
    {
        foreach ($request->get('nla') as $category) {
            NlaCategories::updateOrCreate(['id' => $category['id']], [
                'name'       => $category['name'],
                'sort'       => $category['sort'],
                'section_id' => $category['sort'],
            ]);
        }

        return $this->success(['message' => __('GroupEvent') . __('common.action.updated')]);
    }

    /**
     * Destroy category
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        NlaCategories::destroy($id);

        return $this->success();
    }
}
