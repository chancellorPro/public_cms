<?php

namespace App\Http\Controllers\CmsUser;

use App\Http\Controllers\Controller;
use App\Models\Cms\CmsActionsHistory;
use Illuminate\Http\Request;
use App\Models\Cms\CmsUser;
use App\Traits\FilterBuilder;

/**
 * Class CmsUserActionsController
 */
class CmsUserActionsController extends Controller
{
    use FilterBuilder;
    
    /**
     * Filtered fields
     */
    const FILTER_FIELDS = [
        'cms_user_id' => 'equal',
        'source'      => 'equal',
        'action'      => 'equal',
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
        $activeDirection = $request->get('direction', environment());
        $builder = CmsActionsHistory::latest();
        $users   = CmsUser::all();

        $rows = $this->applyFilter($request, $builder)
            ->paginate(self::RECORDS_PER_PAGE);

        $filter = $this->getFilter();
        
        return view('user-actions.index', compact('activeDirection', 'rows', 'filter', 'users'));
    }
}
